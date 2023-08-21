<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Jobs\VerificationJob;
use App\Models\Auditor;
use Illuminate\Support\Facades\DB;
use Throwable;

class AuditorController extends Controller
{
    public function destroy($id)
    {
        $data = ['success' => 'Auditor deleted successfully'];
        try {
            $auditor = Auditor::find(decrypt($id));
            DB::beginTransaction();
            // more logic
            DB::commit();
        } catch (Throwable $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()]);
        }
        if (!$result) {
            $data = ['error' => 'Unable to delete Auditor'];
        }
        return response()->json($data);
    }


    public function block($id)
    {
        $data = ['success' => 'Auditor blocked successfully'];
        try {
            $auditor = Auditor::find(decrypt($id));
            if ($auditor->is_blocked) {
                $result = $auditor->update(['is_blocked' => 0]);
            } else {
                $result = $auditor->update(['is_blocked' => 1]);
            }
        } catch (Throwable $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
        if (!$result) {
            $data = ['error' => 'Unable to Block Auditor'];
        }
        return response()->json($data);
    }

    public function index()
    {
        $auditor = auth()->user();
        $auditors = Auditor::with(['profile', 'confirmationRequest'])->where('company_id', $auditor->company_id)->withCount('confirmationRequest')->get();
        return view('auditors.index', compact('auditors', 'auditor'));
    }

    public function verification($id)
    {
        $data = ['success' => 'Auditor has been verified.'];
        try {
            $auditor = Auditor::with('profile')->where('id', decrypt($id))->first();
            if (!$auditor) {
                return response()->json(['error' => 'Auditor not found.']);
            }
            if ($auditor->is_verified) {
                $result = $auditor->update(['is_verified' => 0]);
                VerificationJob::dispatch('Unsuccessful', $auditor);
            } else {
                $result = $auditor->update(['is_verified' => 1]);
                VerificationJob::dispatch('Successful', $auditor);
            }
        } catch (Throwable $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
        if (!$result) {
            $data = ['error' => 'Unable to verify auditor.'];
        }
        return response()->json($data);
    }
}
