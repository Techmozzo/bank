<?php

namespace App\Http\Controllers;

use App\Models\Auditor;
use Illuminate\Http\Request;

class VerificationController extends Controller
{
    public function email($id)
    {
        $id = decrypt_helper($id);
        $auditor = Auditor::find($id);
        if (!$auditor) {
            redirect()->back()->with(['error' => 'Verification Failed.']);
        }
        $auditor->update([
            'email_verified_at' => now(),
            'is_verified' => 1
        ]);
        redirect()->back()->with(['success' => 'Verification Successful.']);
    }
}
