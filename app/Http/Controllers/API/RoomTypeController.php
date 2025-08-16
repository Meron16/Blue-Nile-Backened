<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\RoomTypeResource;
use App\Models\RoomType;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class RoomTypeController extends Controller
{
    // GET /api/room-types?from=YYYY-MM-DD&to=YYYY-MM-DD&guests=2
    public function index(Request $request)
    {
        $from = $request->date('from');
        $to   = $request->date('to');
        $guests = (int) $request->input('guests', 1);

        $query = RoomType::with('amenities');

        if ($guests > 0) {
            $query->where('guest_capacity', '>=', $guests);
        }

        // (optional) availability check (simple: if any booking overlaps, we still list
        // room types but you can flag availability on the FE by calling /availability)
        return RoomTypeResource::collection($query->orderBy('base_price')->get());
    }

    // GET /api/room-types/{slug}
    public function show(string $slug)
    {
        $room = RoomType::with('amenities')->where('slug', $slug)->firstOrFail();
        return new RoomTypeResource($room);
    }
}
