<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\BookingResource;
use App\Models\Booking;
use App\Models\BookingRate;
use App\Models\RoomType;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BookingController extends Controller
{
        public function index()
    {
        return BookingResource::collection(Booking::all());
    }
    // GET /api/availability?room_slug=junior-suite&from=YYYY-MM-DD&to=YYYY-MM-DD
    public function availability(Request $request)
    {
        $data = $request->validate([
            'room_slug' => 'required|string',
            'from'      => 'required|date|before:to',
            'to'        => 'required|date|after:from',
            'guests'    => 'nullable|integer|min:1',
        ]);

        $room = RoomType::where('slug',$data['room_slug'])->firstOrFail();

        if (!empty($data['guests']) && $data['guests'] > $room->guest_capacity) {
            return response()->json(['available'=>false, 'reason'=>'exceeds_capacity'], 200);
        }

        $overlap = Booking::where('room_type_id',$room->id)
            ->where(function($q) use ($data) {
                $q->where('check_in','<',$data['to'])
                  ->where('check_out','>',$data['from']);
            })
            ->whereIn('status',['pending','confirmed'])
            ->exists();

        return response()->json(['available' => !$overlap], 200);
    }

    // POST /api/bookings
    public function store(Request $request)
    {
        $data = $request->validate([
            'room_slug'  => 'required|string|exists:room_types,slug',
            'first_name' => 'required|string|max:120',
            'last_name'  => 'required|string|max:120',
            'email'      => 'required|email',
            'phone'      => 'nullable|string|max:60',
            'check_in'   => 'required|date|before:check_out',
            'check_out'  => 'required|date|after:check_in',
            'guest_count'=> 'required|integer|min:1',
            'meta'       => 'nullable|array',
        ]);

        $room = RoomType::where('slug',$data['room_slug'])->firstOrFail();

        // capacity check
        if ($data['guest_count'] > $room->guest_capacity) {
            return response()->json(['message'=>'Guest count exceeds room capacity.'], 422);
        }

        // availability check (overlap)
        $overlap = Booking::where('room_type_id',$room->id)
            ->where(function($q) use ($data) {
                $q->where('check_in','<',$data['check_out'])
                  ->where('check_out','>',$data['check_in']);
            })
            ->whereIn('status',['pending','confirmed'])
            ->lockForUpdate()
            ->exists();

        if ($overlap) {
            return response()->json(['message'=>'Selected dates are not available.'], 409);
        }

        // price calculation: use BookingRate if exists; otherwise base_price
        $nights = (new \Carbon\Carbon($data['check_in']))->diffInDays(new \Carbon\Carbon($data['check_out']));
        if ($nights <= 0) return response()->json(['message'=>'Stay must be at least 1 night.'], 422);

        $period = CarbonPeriod::create($data['check_in'], $data['check_out'])->excludeEndDate();
        $dates = collect($period)->map->toDateString();

        $rates = BookingRate::where('room_type_id',$room->id)
            ->whereIn('date',$dates)->pluck('price', 'date');

        $total = 0;
        foreach ($dates as $d) {
            $total += $rates[$d] ?? $room->base_price;
        }

        $booking = DB::transaction(function() use ($room, $data, $total) {
            return Booking::create([
                'room_type_id' => $room->id,
                'first_name'   => $data['first_name'],
                'last_name'    => $data['last_name'],
                'email'        => $data['email'],
                'phone'        => $data['phone'] ?? null,
                'check_in'     => $data['check_in'],
                'check_out'    => $data['check_out'],
                'guest_count'  => $data['guest_count'],
                'status'       => 'pending',
                'total_price'  => $total,
                'meta'         => $data['meta'] ?? null,
            ]);
        });

        $booking->load('roomType');

        return (new BookingResource($booking))
            ->additional(['message'=>'Booking created, pending confirmation.'])
            ->response()
            ->setStatusCode(201);
    }
}

