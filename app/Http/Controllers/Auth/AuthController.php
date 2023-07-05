<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\PostLogin;
use App\Http\Requests\PostRegistration;
use App\Models\City;
use App\Models\Country;
use App\Models\State;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Session;
use App\Models\User;
use Hash;
use Laravel\Socialite\Facades\Socialite;
use App;

class AuthController extends Controller
{
    public function index()
    {
        return view('auth.login');
    }

    public function registration()
    {
        $data['countries'] = Country::get(["name", "id"]);

        return view('auth.registration', $data);
    }

    public function postLogin(PostLogin $request)
    {
        // dd($request->all());
        // $usernameinput = $request->input('email');
        // $password = $request->input('password');

        // $credentials = $request->only('email', 'password');
        $fieldType = filter_var($request->username, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';


        // if (Auth::attempt([$field => $usernameinput, 'password' => $password], true)) {
        //     return redirect()->intended('dashboard')
        //                 ->withSuccess('You have Successfully loggedin');
        // }


        if (auth()->attempt(array($fieldType => $request->username, 'password' => $request->password, 'status' => 'active'))) {
            return redirect()->intended('dashboard')
                ->withSuccess(__('You have Successfully loggedin'));
        }

        return redirect("login")->withDanger(__('Oppes! You have entered invalid credentials'));
    }

    public function postRegistration(PostRegistration $request)
    {

        $user = new User;
        $user->name = $request->name;
        $user->username = $request->username;
        $user->email = $request->email;
        $user->mobile_no = $request->mobile_no;
        $user->password = Hash::make($request->password);
        $user->country = $request->country;
        $user->state = $request->state;
        $user->city = $request->city;
        $user->save();

        return redirect("login")->withSuccess(__('Great! You have successfully ragister please login'));
    }

    public function getState(Request $request)
    {
        $data['states'] = State::where("country_id", $request->country_id)
            ->get(["name", "id"]);

        return response()->json($data);
    }

    public function getCity(Request $request)
    {

        $data['cities'] = City::where("state_id", $request->state_id)
            ->get(["name", "id"]);
        return response()->json($data);
    }

    public function dashboard()
    {
        return view('dashboard');
    }

    public function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'mobile_no' => $data['mobile_no'],
        ]);
    }

    public function logout()
    {
        Session::flush();
        Auth::logout();

        return Redirect('login');
    }

    public function redirectToProvider()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleProviderCallback(Request $request)
    {
        $user = Socialite::driver('google')->user();

        $finduser = User::where('email', $user->email)->first();

        if ($finduser) {

            Auth::login($finduser);

            return redirect('/dashboard')->withSuccess('You have Successfully loggedin');
        }
        // $user->token; (return as your need)
        return redirect("registration")->withDanger('Please Register Your account.');
    }

    public function refereshCapcha()
    {
        return captcha_img('flat');
    }
    
    public function change(Request $request){
        
        $data = App::setLocale($request->lang);
        session()->put('locale', $request->lang);
  
        return redirect()->back();
    }
}


