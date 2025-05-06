<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;

class ContactUsController extends Controller
{
    public function sendMessage() {

        request()->validate([
            'full_name' => 'required', 
            'email' => 'required', 
            'message' => 'required', 
        ]);

        $newMessage = Contact::create(request()->all());

        return apiResponse(1, 'message has been sent succesfully');
    }
}
