<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateProfile;
use App\Models\City;
use App\Models\Country;
use App\Models\State;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function profileUpdate(Request $request)
    {
        $user = Auth::user();
        
        $countries = Country::get(["name","id"]);
        
        $states = State::where("country_id",$user->country)->get(["name","id"]);
        
        $cities = City::where("state_id",$user->state)->get(["name","id"]);
       
        return view('auth.updateprofile',compact('user','countries','states','cities'));   
    }

    public function postProfileUpdate(UpdateProfile $request)
    {
        $user =Auth::user();
        $user->name = $request->name;
        $user->username = $request->username;
        $user->mobile_no = $request->mobile_no;
        $user->email = $request->email;
        $user->country = $request->country;
        $user->state = $request->state;
        $user->city = $request->city;
        $user->update();
        return redirect("dashboard")->withSuccess(__('Your Profile Update Successfully.'));
    }
    
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
