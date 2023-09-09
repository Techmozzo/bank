<?php

namespace App\Http\Controllers;

use App\Interfaces\Types;
use App\Models\ConfirmationRequest;
use Illuminate\Http\Request;
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

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ConfirmationRequest  $confirmationRequest
     * @return \Illuminate\Http\Response
     */
    public function edit(ConfirmationRequest $confirmationRequest)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ConfirmationRequest  $confirmationRequest
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ConfirmationRequest $confirmationRequest)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ConfirmationRequest  $confirmationRequest
     * @return \Illuminate\Http\Response
     */
    public function destroy(ConfirmationRequest $confirmationRequest)
    {
        //
    }
}
