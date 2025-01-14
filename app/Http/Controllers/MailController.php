<?php

namespace App\Http\Controllers;

use App\Mail\ContactUs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class MailController extends Controller
{
    public function sendquery(Request $request)
    {
        $request->validate(
            [
                'subject'=>'required',
                'email'=>'required|email',
                'message'=>'required',
                'phonenumber'=>'required',

            ]);

            $data = [
                'subject' => $request->subject,
                'messages' => $request->message,
                'email'=> $request->email,
                'phonenumber'=> $request->phonenumber,
            ];

            try {
                Mail::to('kingchemz@gmail.com')->send(new \App\Mail\ContactUs([
                    'subject' => $data['subject'],
                    'messages' => $data['messages'],
                    'email' => $data['email'],
                    'phonenumber' => $data['phonenumber'],
                ]));
                
                return redirect()->route('contactus')->with('success', 'Your message has been sent successfully!');
            } catch (\Exception $e) {
                Log::error('Mail sending failed: ' . $e->getMessage());
                return redirect()->route('contactus')->with('error', 'Something went wrong. Please try again.');
            }

    }
}
