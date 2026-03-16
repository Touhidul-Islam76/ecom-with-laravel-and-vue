<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginOtpSendRequest;
use App\Http\Requests\LoginOtpVerifyRequest;
use App\Models\User;
use Illuminate\Support\Facades\Mail;

class AuthController extends Controller
{
    public function loginOtpSend(LoginOtpSendRequest $req)
    {
        $user = User::where('email', $req->email)->first();
        $otp = rand(1000, 9999);

        if (!$user) {

            $user = User::create([
                'email' => $req->email,
                'otp' => $otp
            ]);

        } else {

            $user->update([
                'otp' => $otp
            ]);

        }

        Mail::raw('Your OTP is: ' . $otp, function ($message) use ($req) {
            $message->to($req->email)
                    ->subject('OTP for login');
        });

        return $this->success(null, 'OTP sent to your email');
    }

    public function login(LoginOtpVerifyRequest $req){
        $user = User::where('email',  $req->email)->where('otp', $req->otp)->first();
        if(!$user){
            return $this->error(['Invalid OTP or email']);
        }

         $accessToken = $user->createToken('authToken')->plainTextToken;
         return $this->success(['access_token' => $accessToken], 'Login successful');
    }
}