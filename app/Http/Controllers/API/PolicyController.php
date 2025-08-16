<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PolicyResource;
use App\Models\Policy;

class PolicyController extends Controller
{
    public function index()
    {
        return PolicyResource::collection(Policy::all());
    }
}

