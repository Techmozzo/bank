<?php

namespace App\Http\Controllers;

use App\Http\Requests\ConfirmationRequest as RequestsConfirmationRequest;
use App\Models\Bank;
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
        $confirmation_requests = ConfirmationRequest::where('company_id', auth()->user()->comapny_id)->get();
        return view('confirmation_requests.index', compact('confirmation_requests'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $banks = Bank::select('id', 'name')->get();
        return view('confirmation_requests.create', compact('banks'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RequestsConfirmationRequest $request)
    {
        [
            'name',
            'opening_period',
            'closing_period',
            'auditor_id',
            'company_id',
            'bank_id',
            'signatory_name',
            'signatory_phone',
            'signatory_email'
        ];
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ConfirmationRequest  $confirmationRequest
     * @return \Illuminate\Http\Response
     */
    public function show(ConfirmationRequest $confirmationRequest)
    {
        //
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
