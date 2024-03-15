<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Mail\ContactEmail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Models\Setting;
class ContactController extends Controller
{
    
    public function sendEmail(Request $request)
{
    try {
    
        $recipientEmail = Setting::value('email');
        if (!$recipientEmail) {
            return response()->json(['message' => 'Recipient email not found in settings'], 500);
        }
     
        $senderEmail = $request->input('Email');
        $data = $request->all();
        Mail::send('email.contact', $data, function ($message) use ($senderEmail, $recipientEmail) {
            $message->from($senderEmail);
            $message->to($recipientEmail);
       
            $message->subject('Contact Form Submission');
        });
        
        return response()->json(['message' => 'Email sent successfully']);
    } catch (\Exception $e) {
        Log::debug('Failed to send email: ' . $e);
        return response()->json(['message' => 'Failed to send email'], 500);
    }
}
}
