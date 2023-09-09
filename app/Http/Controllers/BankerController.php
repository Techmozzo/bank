<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\BankerRequest;
use App\Interfaces\Types;
use App\Jobs\AddBankerJob;
use App\Jobs\EmailVerificationJob;
use App\Jobs\VerificationJob;
use App\Models\Banker;
use App\Models\Profile;
use App\Models\Role;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Throwable;
use Illuminate\Support\Str;

class BankerController extends Controller
{

    public function index()
    {
        $banker = auth()->user();
        $bankers = Banker::with(['profile', 'confirmationRequest'])->where('bank_id', $banker->bank_id)->withCount('confirmationRequest')->get();
        return view('bankers.index', compact('bankers', 'banker'));
    }

    public function create()
    {
        $roles = Role::select('name', 'id')->get();
        return view('bankers.create', compact('roles'));
    }

    public function store(BankerRequest $request)
    {
        $admin = auth()->user();
        $password = Hash::make(Str::random(8));
        try {
            DB::beginTransaction();
            $banker = Banker::create([
                'email' => $request->email,
                'password' => $password,
                'role_id' => $request->role,
                'company_id' => $admin->company_id,
                'is_verified' => 1
            ]);

            Profile::create([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'phone' => $request->phone,
                'banker_id' => $banker->id,
            ]);
            AddBankerJob::dispatch($admin, $banker, $password);
            EmailVerificationJob::dispatch($banker);
            DB::commit();
            return redirect()->route('bankers.index')->with(['success' => 'Banker Added Successfully']);
        } catch (Throwable $t) {
            DB::rollBack();
            return redirect()->route('bankers.create')->withInput()->with(['error' => 'Unable to Add Banker at the moment']);
        }
    }

    public function destroy($id)
    {
        $data = ['success' => 'Banker deleted successfully'];
        try {
            $banker = Banker::find(decrypt_helper($id));
            DB::beginTransaction();
            // more logic
            DB::commit();
        } catch (Throwable $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()]);
        }
        if (!$result) {
            $data = ['error' => 'Unable to delete Banker'];
        }
        return response()->json($data);
    }


    public function block($id)
    {
        $data = ['success' => 'Banker blocked successfully'];
        try {
            $banker = Banker::find(decrypt_helper($id));
            if ($banker->is_blocked) {
                $result = $banker->update(['is_blocked' => 0]);
            } else {
                $result = $banker->update(['is_blocked' => 1]);
            }
        } catch (Throwable $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
        if (!$result) {
            $data = ['error' => 'Unable to Block Banker'];
        }
        return response()->json($data);
    }

    public function verification($id)
    {
        $data = ['success' => 'Banker has been verified.'];
        try {
            $banker = Banker::with('profile')->where('id', decrypt_helper($id))->first();
            if (!$banker) {
                return response()->json(['error' => 'Banker not found.']);
            }
            if ($banker->is_verified) {
                $result = $banker->update(['is_verified' => 0]);
                VerificationJob::dispatch('Unsuccessful', $banker);
            } else {
                $result = $banker->update(['is_verified' => 1]);
                VerificationJob::dispatch('Successful', $banker);
            }
        } catch (Throwable $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
        if (!$result) {
            $data = ['error' => 'Unable to verify banker.'];
        }
        return response()->json($data);
    }
}
