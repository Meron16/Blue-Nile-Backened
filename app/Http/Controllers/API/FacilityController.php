<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\FacilityResource;
use App\Models\Facility;

class FacilityController extends Controller
{
    public function index()
    {
        return FacilityResource::collection(Facility::orderBy('category')->orderBy('name')->get());
    }
}
