<?php

namespace App\Http\Controllers;

use App\Models\Clients;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Symfony\Component\HttpFoundation\Cookie;

class LoginController extends Controller
{
   public function index(Request $request, $message=''){
    $currentUser=MoviesController::getUser($request);
    return view("Login/Login",compact('message','currentUser'));
   }

   public static function  defaultLogin(Request $request){
    $email_validation_regex = '/^\\S+@\\S+\\.\\S+$/'; 
    $login=$request->get('login');
    $password=$request->get('password');
    if($login!=null&&$password!=null){
        $loginData=$login.$password."@#sdf@";
        $loginDataHash=hash('md5',$loginData);
        $users=new Clients();
        $selectedUser=$users->where('LoginData','=',$loginDataHash)->first();
        if($selectedUser!=null){
            $token=hash('md5',$selectedUser->LoginData.$selectedUser->Email."@hack#Me@".date('d/m/y'));
            $selectedUser->Token=$token;
            $selectedUser->save();
            return redirect('/')->withCookie(cookie('tokenU',$token,60))->with('succsess',"Welcome ".$selectedUser->Name);

        }else{
            return redirect('/login')->with("loginError","Incorect login or password");
        }

    }
   }
   public static function loginWithGoogle($user){
    
        $token=hash('md5',$user->GoogleID.$user->Email."@hack#Me@".date('d/m/y'));
        $user->Token=$token;
        $user->save();
        return redirect('/')->withCookie(cookie('tokenU',$token,60))->with('succsess',"Welcome ".$user->Name);
   }
   public static function loginWithGitHub($user){
    
    $token=hash('md5',$user->GitHubID.$user->Email."@hack#Me@".date('d/m/y'));
    $user->Token=$token;
    $user->save();
    return redirect('/')->withCookie(cookie('tokenU',$token,60))->with('succsess',"Welcome ".$user->Name);
}
}
