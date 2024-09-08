<?php

namespace App\Http\Controllers;

use App\Models\Clients;
use App\Models\Users;
use DateTime;
use Illuminate\Http\Request;
use PharIo\Manifest\Email;
use Laravel\Socialite\Facades\Socialite;

class RegistrationController extends Controller
{
    public function index(Request $request, $message = '')
    {
        $currentUser = MoviesController::getUser($request);
        return view('Registartion/Registartion', compact('message', 'currentUser'));
    }
    public function registrate(Request $request)
    {
        $message = 'Registration succsses. Please login)';
        $newUser = new Clients();
        $name = $request->get('name');
        $phoneNumber = $request->get('phoneNumber');
        $email = $request->get('email');
        $login = $request->get('login');
        $loginBuffer = $login;
        $password = $request->get('password');
        if ($name != null && $phoneNumber != null && $email != null && $login != null && $password != null) {
            $users = new Clients();
            $existUser = $users->where('Login', '=', $loginBuffer)->first();
            if ($existUser != null) {
                return redirect()->back()->with("error", "Login already exist!");
            } else {
                $existUser = $users->where('Email', '=', $email)->first();
                if ($existUser != null) {
                    return redirect()->back()->with("error", "Email already exist!");
                }
            }
            $login .= $password;
            $login .= "@#sdf@";
            $loginData = hash("md5", $login);
            $newUser->Login = $loginBuffer;
            $newUser->Name = $name;
            $newUser->PhoneNumber = $phoneNumber;
            $newUser->Email = $email;
            $newUser->LoginData = $loginData;
            $newUser->created_at = new DateTime();
            $newUser->updated_at = new DateTime();
            $newUser->save();
            return redirect("/login")->with('succsess', "Thank you for registering. Please login");
        }
    }
    public function continueWithGoogle()
    {
        return Socialite::driver("google")->stateless()->redirect();
    }
    public function registartionOrLoginWithGoogle()
    {
        $user = Socialite::driver('google')->stateless()->user();
        $userExist = Clients::where("GoogleID", "=", $user->id)->first();
        if ($userExist != null) {
            return  LoginController::loginWithGoogle($userExist);
        } else {
             $userExist = Clients::where("Email", "=", $user->email)->first();
                if ($userExist != null) {
                    return  LoginController::loginWithGoogle($userExist);
                } else {
            $newUser = new Clients();
            $newUser->Login = $user->name;
            $newUser->Name = $user->name;
            $newUser->Email = $user->email;
            $newUser->GoogleID = $user->id;
            $newUser->PhoneNumber = "Dont have";
            $newUser->save();
            return  LoginController::loginWithGoogle($newUser);
                }
        }
    }
    public function continueWithGitHub()
    {
        return Socialite::driver("github")->stateless()->redirect();
    }
    public function registartionOrLoginWithGitHub()
    {
        try {
            $user = Socialite::driver('github')->stateless()->user();
            $userExist = Clients::where("GitHubID", "=", $user->id)->first();
            if ($userExist != null) {
                return  LoginController::loginWithGitHub($userExist);
            } else {
                $userExist = Clients::where("Email", "=", $user->email)->first();
                if ($userExist != null) {
                    return  LoginController::loginWithGitHub($userExist);
                } else {
                    $newUser = new Clients();
                    $newUser->Login = $user->nickname;
                    $newUser->Name = $user->nickname;
                    $newUser->Email = $user->email;
                    $newUser->GitHubID = $user->id;
                    $newUser->PhoneNumber = "Dont have";
                    $newUser->save();
                    return  LoginController::loginWithGitHub($newUser);
                }
               
            }
        } catch (Exeption $e) {
            dd($e);
        }
    }
}
