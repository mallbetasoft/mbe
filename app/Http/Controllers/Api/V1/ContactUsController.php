<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Mail;
use App\Http\Requests\Api\ContactUsRequest;

class ContactUsController extends Controller
{
    public function contactUs(ContactUsRequest $request){
       $user = $request->all();
       $data = [
           'email' => $request->email,
           'name' => $request->name,
           'sendMessage' => $request->sendMessage,
       ];
       try{
            Mail::send('emails/mail', $data, function($message) use ($user) {
                $message->from('bagicha.betasoft@outlook.com');
                $message->to('bagicha.betasoft@outlook.com');
                $message->subject('Welcome Mail');
            });
            return response()->json(['success' => '1','message' => 'Mail Send Successfully'],200);
        }
        catch(\Exception $e){
            return response()->json(['error' => $e->getMessage()],401);
        }
    }
}
