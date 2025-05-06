<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\ChangePasswordRequest;
use App\Http\Requests\ProfileRequest;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    
    public function profile(ProfileRequest $request)
    {
        $client = $request->user();

        if($request->except('api_token')){
        
            $client->update($request->all());
            return apiResponse(1, 'User Data Is Updated Succesfully', $client);
        }

        return apiResponse(1, 'User Data', $client);
    }

    public function changePassword(ChangePasswordRequest $request)
    {
        $user = $request->user();

        // Verify the current password
        if (!Hash::check($request->current_password, $user->password)) {
            return apiResponse(0, 'Current password is incorrect');
        }

        // Update the user's password
        $user->password = Hash::make($request->new_password);
        $user->save();

        return apiResponse(1, 'Password changed successfully');
    }
}
