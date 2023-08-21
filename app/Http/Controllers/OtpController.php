<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\Otp;
use App\Traits\HashId;
use Symfony\Component\HttpFoundation\Response;

class OtpController extends Controller
{
    use HashId;

    public function __invoke(?string $user_id = null)
    {
        if($user_id){
            $user = User::find($this->decrypt($user_id));
        }else{
            $user = auth()->user();
        }
        Otp::sendOtp($user);
        return response()->success(Response::HTTP_OK, 'A One-Time Password (OTP) has been sent to your registered mobile number.' );
    }
}
