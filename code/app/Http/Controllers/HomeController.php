<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use app\Models\User;

use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index(){
        if(Auth::id()){
            $roleID=Auth()->user()->roleid;

            if($roleID==2){
                return view('dashboard');
            }
            else if($roleID==4){
                return view('adminDashboard');
            }
            else{
                return redirect()->back();
            }
        }
    }
}
