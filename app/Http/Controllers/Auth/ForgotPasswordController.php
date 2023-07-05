<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Carbon\Carbon;
use App\Models\User;
use Mail;
use Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class ForgotPasswordController extends Controller
{
    public function showForgetPasswordForm()
    {
        return view('auth.forgetPassword');
    }

    public function submitForgetPasswordForm(Request $request)
    {
        $user = DB::table('users')->where('email',$request->email)->first();
        
        $request->validate([
            'email' => 'required|email|exists:users',
        ]);

        $token = Str::random(64);

        DB::table('password_resets')->insert([
            'email' => $request->email,
            'token' => $token,
            'created_at' => Carbon::now()
        ]);

        Mail::send('email.forgetPassword', ['token' => $token, 'user'=> $user], function ($message) use ($request) {
            $message->to($request->email);
            $message->subject('Reset Password');
        });

        return redirect("login")->withSuccess('We have e-mailed your password reset link!');
    }

    public function showResetPasswordForm(Request $request, $token)
    {
        $password_resets = DB::table('password_resets')->where('token',$token)->first();
        if($password_resets == ""){
            return redirect("login")->withDanger('Your Request has Been Expire.');
        }
        return view('auth.forgetPasswordLink', ['token' => $token, 'email' => $password_resets->email]);
    }

    public function submitResetPasswordForm(Request $request)
    {
        // harsh
        $request->validate([
            'password' => 'required|string|min:6|confirmed',
            'password_confirmation' => 'required'
        ]);

        $password = $request->password;

        $tokenData = DB::table('password_resets')->where('token', $request->token)->first();

        if (!$tokenData) {
            return back()->withInput()->withDanger('Invalid token!');
        }

        $user = User::where('email', $tokenData->email)->first();
        $user->password = Hash::make($password);
        $user->update();

        DB::table('password_resets')->where('email', $user->email)->delete();

        return redirect("login")->withSuccess('Your password has been changed!');
    }
}
