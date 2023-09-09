<?php

namespace App\Http\Controllers;

use App\Interfaces\Types;
use App\Models\Banker;
use App\Models\ConfirmationRequest;

class HomeController extends Controller
{
    /**
     * HomeController constructor.
     */

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $banker = auth()->user();
        if (!$banker->hasRole('admin')) {
            $confirmation_request  = ConfirmationRequest::where([['bank_id', $banker->bank_id], ['authorization_status', Types::STATUS['APPROVED']], ['confirmation_status', 0]])->orderBy('confirmation_status', 'ASC')->get();
            $number_of_pending_requests = ConfirmationRequest::where([['bank_id', $banker->bank_id], ['authorization_status', Types::STATUS['APPROVED']], ['confirmation_status', 0]])->count();
            return view('home.banker', compact('banker', 'confirmation_request', 'number_of_pending_requests'));
        }
        $number_of_bankers = Banker::where('bank_id', $banker->bank_id)->count();
        $pending_requests = ConfirmationRequest::where([['bank_id', $banker->bank_id], ['authorization_status', Types::STATUS['APPROVED']], ['confirmation_status', 0]])->latest()->get();
        return view('home.admin', compact('number_of_bankers', 'pending_requests', 'banker'));
    }
}
