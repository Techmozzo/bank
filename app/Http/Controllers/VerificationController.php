<?php

namespace App\Http\Controllers;

use App\Models\Banker;
use Illuminate\Http\Request;

class VerificationController extends Controller
{
    public function email($id)
    {
        $id = decrypt_helper($id);
        $banker = Banker::find($id);
        if (!$banker) {
            redirect()->back()->with(['error' => 'Verification Failed.']);
        }
        $banker->update([
            'email_verified_at' => now(),
            'is_verified' => 1
        ]);
        redirect()->back()->with(['success' => 'Verification Successful.']);
    }
}
