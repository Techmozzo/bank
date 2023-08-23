<?php

namespace App\Http\Controllers;

use App\Http\Requests\ConfirmationRequest as RequestsConfirmationRequest;
use App\Jobs\ConfirmationRequestJob;
use App\Models\Bank;
use App\Models\ConfirmationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
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
        $auditor = Auth::user();
        try{
            DB::beginTransaction();
                $confirmation_request = ConfirmationRequest::create([
                    'name' => $request->name,
                    'opening_period' => $request->opening_period,
                    'closing_period' => $request->closing_period,
                    'auditor_id' => $auditor->id,
                    'company_id' => $auditor->company_id,
                    'bank_id' => $request->bank,
                ]);

                foreach ($request->account_name as $key => $account){
                    $confirmation_request->account()->create([
                        'name' => $account,
                        'number' => $request->account_number[$key],
                    ]);
                }

                foreach ($request->signatory_name as $key => $signatory){
                    $signatory = $confirmation_request->signatory()->create([
                        'name' => $signatory,
                        'email' => $request->signatory_email[$key],
                        'phone' => $request->signatory_phone[$key],
                    ]);
                    ConfirmationRequestJob::dispatch($auditor, $signatory);
                }
            DB::commit();
        }catch(Throwable $t){
            DB::rollback();
            Log::error(['Confirmtion Request' => $t->getMessage()]);
            return redirect()->back()->with(['error' => 'Unable to create request at the moment']);
        }
        return redirect()->route('home')->with(['success' => 'Confirmation Request Sent Successfully.']);
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
