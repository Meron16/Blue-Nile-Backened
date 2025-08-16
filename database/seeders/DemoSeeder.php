<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\{RoomType, Amenity, Facility, Policy, Page};

class DemoSeeder extends Seeder
{
    public function run(): void
    {
        // amenities
        $amenities = collect([
            ['name'=>'Air conditioning','category'=>'in-room'],
            ['name'=>'Flat-screen TV','category'=>'in-room'],
            ['name'=>'Minibar','category'=>'in-room'],
            ['name'=>'In-room safe','category'=>'in-room'],
            ['name'=>'Free WiFi','category'=>'in-room'],
            ['name'=>'Balcony','category'=>'in-room'],
            ['name'=>'Lake view','category'=>'in-room'],
        ])->map(fn($a)=>\App\Models\Amenity::create($a));

        // room types (examples taken from common Blue Nile listings)
        $rooms = [
            ['name'=>'Standard Room','base_price'=>90,'guest_capacity'=>2,'beds_count'=>1,'has_lake_view'=>false,'has_balcony'=>false],
            ['name'=>'Standard Twin','base_price'=>100,'guest_capacity'=>2,'beds_count'=>2,'has_lake_view'=>false,'has_balcony'=>false],
            ['name'=>'Superior Room','base_price'=>110,'guest_capacity'=>2,'beds_count'=>1,'has_lake_view'=>true,'has_balcony'=>true],
            ['name'=>'Superior Twin','base_price'=>120,'guest_capacity'=>2,'beds_count'=>2,'has_lake_view'=>true,'has_balcony'=>true],
            ['name'=>'Junior Suite','base_price'=>140,'guest_capacity'=>3,'beds_count'=>1,'has_lake_view'=>true,'has_balcony'=>true],
            ['name'=>'Duplex Suite','base_price'=>180,'guest_capacity'=>4,'beds_count'=>2,'has_lake_view'=>true,'has_balcony'=>true],
        ];

        foreach ($rooms as $r) {
            $room = RoomType::create([
                'name'=>$r['name'],
                'slug'=>Str::slug($r['name']),
                'description'=> $r['name'].' with modern amenities near Lake Tana.',
                'guest_capacity'=>$r['guest_capacity'],
                'beds_count'=>$r['beds_count'],
                'has_lake_view'=>$r['has_lake_view'],
                'has_balcony'=>$r['has_balcony'],
                'base_price'=>$r['base_price'],
                'images'=>[],
            ]);
            // attach common amenities; fine-tune later
            $room->amenities()->sync($amenities->pluck('id'));
        }

        // facilities
        foreach ([
            ['name'=>'Azur Restaurant','category'=>'dining'],
            ['name'=>'Atrim Bar','category'=>'dining'],
            ['name'=>'360 Pizzeria','category'=>'dining'],
            ['name'=>'Spa & Wellness','category'=>'wellness'],
            ['name'=>'Fitness Center','category'=>'wellness'],
            ['name'=>'Business Center','category'=>'business'],
            ['name'=>'Conference Rooms','category'=>'business'],
            ['name'=>'Airport Shuttle','category'=>'transport'],
        ] as $f) { Facility::create($f); }

        // policies (examples)
        Policy::create(['type'=>'checkin','content'=>'Check-in from 14:00 to 00:00.']);
        Policy::create(['type'=>'checkout','content'=>'Check-out until 12:00.']);
        Policy::create(['type'=>'children','content'=>'Children stay free in existing bedding. Extra beds/cribs available on request.']);
        Policy::create(['type'=>'pets','content'=>'Pets are not allowed.']);
        Policy::create(['type'=>'payments','content'=>'Major cards accepted. Government-issued ID required at check-in.']);

        // pages
        Page::create([
            'title'=>'About Us',
            'slug'=>'about-us',
            'content'=>'Blue Nile Resort, set on Lake Tana in Bahir Dar, offers comfortable rooms, dining, spa, and conference facilities.'
        ]);
        Page::create([
            'title'=>'Contact',
            'slug'=>'contact',
            'content'=>'Call us, email us, or send a message via the contact form.'
        ]);
    }

}
