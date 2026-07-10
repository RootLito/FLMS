<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\TestPaymentEmail;

class TestPaymentController extends Controller
{
    public function send(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        try {
            Mail::to($request->email)->send(new TestPaymentEmail());

            return back()->with('success', 'Test payment link sent successfully!');
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'SMTP Error: ' . $e->getMessage());
        }
    }
}