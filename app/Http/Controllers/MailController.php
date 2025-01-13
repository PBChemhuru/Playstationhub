<?php

namespace App\Http\Controllers;

use App\Mail\ContactUs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

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
                Mail::to('kingchemz@gmail.com')->send(new ContactUs($data));
            
    
                return redirect()->route('contactus')->with('success', 'Your message has been sent successfully!');
            } catch (\Exception $e) {
                return redirect()->route('contactus')->with('error', 'Something went wrong. Please try again.');
            }

    }
}
