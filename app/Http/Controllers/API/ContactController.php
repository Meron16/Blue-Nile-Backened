<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'name'=>'required|string|max:120',
            'email'=>'required|email',
            'phone'=>'nullable|string|max:60',
            'message'=>'required|string|max:5000',
        ]);

        ContactMessage::create($data);

        return response()->json(['message'=>'Thank you. We will contact you shortly.'], 201);
    }
}

