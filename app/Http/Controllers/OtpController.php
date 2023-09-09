<?php

namespace App\Http\Controllers;

use App\Models\Banker;
use App\Services\Otp;
use Symfony\Component\HttpFoundation\Response;

class OtpController extends Controller
{

    public function __invoke(?string $user_id = null)
    {
        if ($user_id) {
            $user = Banker::find($this->decrypt_helper($user_id));
        } else {
            $user = auth()->user();
        }
        Otp::sendOtp($user);
        return response()->success(Response::HTTP_OK, 'A One-Time Password (OTP) has been sent to your registered mobile number.');
    }
}
