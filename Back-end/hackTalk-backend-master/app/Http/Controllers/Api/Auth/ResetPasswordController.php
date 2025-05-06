<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\NewPasswordRequest;
use App\Http\Requests\ResetPasswordRequest;
use App\Http\Requests\VerficationCodeRequest;
use App\Mail\ResetPasswordEmail;
use Illuminate\Support\Facades\Mail;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;


class ResetPasswordController extends Controller
{
    public function resetPassword(ResetPasswordRequest $request)
    {
        $user = User::where('email', $request->email)->first();


        if(is_null($user)) {
            return apiResponse(0, 'There is no account with this Email');}
        else {
            
            $token = rand(11111, 99999);

            DB::table('password_reset_tokens')->updateOrInsert(
                ['email' => $user->email],
                ['token' => $token]
            );

            Mail::to($user->email)
                ->send(new ResetPasswordEmail($user, $token));

            return apiResponse(1, 'Password reset token has been sent to your email');
        }
    }

    public function verifyCode(VerficationCodeRequest $request)
    {
        $user = User::where('email', $request->email)->first();
        
        if(is_null($user)) {
            return apiResponse(0, 'There is no account with this Email');}
        else {
            
            $reset = DB::table('password_reset_tokens')->where('email', $request->email)->first();

            if (!$reset || $request->token!=$reset->token) {
                return apiResponse(0, 'Invalid or expired token');
            }

            DB::table('password_reset_tokens')->where('email', $request->email)->delete();

            return apiResponse(1, 'User can Enter A new Password');

        }
    }

    public function newPassword(NewPasswordRequest $request)
    {
        $user = User::where('email', $request->email)->first();

        $user->password = Hash::make($request->new_password);
        $user->save();

        return apiResponse(1, 'Password updated successfully');
    }
}
