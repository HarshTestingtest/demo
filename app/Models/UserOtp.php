<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Exception;
use Twilio\Rest\Client;


class UserOtp extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'otp',
        'expire_at',
    ];

    public function sendSMS($receiverNumber)
    {
        
        $message = "Login OTP is ".$this->otp;
        
        try {   
            
            $account_sid = env('TWILIO_SID');
            $auth_token = env("TWILIO_TOKEN");
            $twilio_number = env("TWILIO_FROM");
            
            $client = new Client($account_sid, $auth_token);
            
            $test = $client->messages->create('+91'.$receiverNumber, [
                'from' => $twilio_number, 
                'body' => $message]);
            
       } catch (Exception $e) {
            info("Error: ". $e->getMessage());
        }
    }

}
