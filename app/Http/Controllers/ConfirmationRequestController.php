<?php

namespace App\Http\Controllers;

use App\Http\Requests\ApproveRequest;
use App\Http\Requests\DeclineRequest;
use App\Interfaces\Types;
use App\Models\BankApprovalRequest;
use App\Models\ConfirmationRequest;
use Illuminate\Support\Facades\DB;
use Throwable;

class ConfirmationRequestController extends Controller
{

    public function __construct()
    {
        $this->middleware('admin')->only(['index', 'destroy']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $banker = auth()->user();
        $confirmation_requests = ConfirmationRequest::where([['bank_id', $banker->bank_id], ['authorization_status', Types::STATUS['APPROVED']], ['confirmation_status', 0]])->latest()->get();
        return view('confirmation_requests.index', compact('confirmation_requests'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ConfirmationRequest  $confirmationRequest
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $confirmation_request = ConfirmationRequest::find(decrypt_helper($id));
        if (!$confirmation_request) {
            return view('layouts.alert')->with(['message' => 'Confirmation Request not found.']);
        }
        $years = getYearsInStringFormat(getYearsInRange($confirmation_request->opening_period, $confirmation_request->closing_period));
        $period = getPeriodDayAndMonth($confirmation_request->opening_period) . ' ' . $years;
        return view('confirmation_requests.show', compact('confirmation_request', 'period'));
    }

    public function approveRequest(ApproveRequest $request)
    {
        $confirmation_request = ConfirmationRequest::find($request->confirmation_request);
        if($confirmation_request->confirmation_status != Types::STATUS['PENDING']){
            return redirect()->back()->with('error', 'This is not a pending request.');
        }
        try {
            $file_name = time() . $request->statement->extension();
            $request->statement->move(public_path('store/statements'), $file_name);
            DB::beginTransaction();
            $confirmation_request->update([
                'confirmation_status' => Types::STATUS['APPROVED'],
                'statement' => $file_name,
            ]);
            BankApprovalRequest::updateOrCreate(['confirmation_request_id' => $confirmation_request->id, 'bank_id' => $confirmation_request->bank_id],
                ['statement' => $request->statement, 'status' => 1, 'approved_by' => auth()->id(), 'comment' => $request->comment]);
            DB::commit();
        } catch (Throwable $t) {
            DB::rollBack();
            return redirect()->route('home')->with('error', $t->getMessage());
        }
        return redirect()->route('home')->with('success', 'Request has been approved.');
    }

    public function declineRequest(DeclineRequest $request){
        $confirmation_request = ConfirmationRequest::find($request->confirmation_request);
        if($confirmation_request->confirmation_status != Types::STATUS['PENDING']){
            return redirect()->back()->with('error', 'This is not a pending request.');
        }
        try {
            DB::beginTransaction();
            $confirmation_request->update(['confirmation_status' => Types::STATUS['DECLINED']]);
            BankApprovalRequest::updateOrCreate(['confirmation_request_id' => $confirmation_request->id, 'bank_id' => $confirmation_request->bank_id],
                ['status' => 1, 'declined_by' => auth()->id(), 'comment' => $request->comment]);
            DB::commit();
        } catch (Throwable $t) {
            DB::rollBack();
            return redirect()->route('home')->with('error', $t->getMessage());
        }
        return redirect()->route('home')->with('success', 'Request has been declined.');
    }
}
