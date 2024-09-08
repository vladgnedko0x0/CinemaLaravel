<?php

namespace App\Http\Controllers;

use App\Models\Clients;
use App\Models\Images;
use App\Models\Movie;
use App\Models\MovieSession;
use App\Models\SeatReservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class HomeController extends Controller
{
    public function index(Request $request, $message = '')
    {
        $currentUser = MoviesController::getUser($request);


        $movies1 = Movie::all();
        $maxN = -1;
        $movies = [];
        for ($i = 0; $i < 3; $i++) {
            $maxN = $movies1->max("CountSoldBilets");
            if ($maxN != 0) {
                array_push($movies, $movies1->where('CountSoldBilets', '=', $maxN));
            }

            $movies1 = $movies1->where('CountSoldBilets', '!=', $maxN);
        }
        $images = Images::all();
        return view('./Home/Home', compact('currentUser', 'movies', 'images'));
    }
    public function profile(Request $request)
    {
        $user = MoviesController::getUser($request);
        if ($user != null) {
            $reservations = new SeatReservation();
            $currentUserReservations = $reservations->where('ClientID', '=', $user->id)->get();
            $sessions = MovieSession::all();
            $movies = Movie::all();
            return view('Home/Profile', compact('user', 'currentUserReservations', 'sessions', 'movies'));
        } else {
            return redirect('/')->withErrors('Please login or registrate');
        }
    }
    public function logout(Request $request)
    {
        $user = MoviesController::getUser($request);
        Cookie::queue(Cookie::forget('token'));
        $user->Token = "";
        $user->save();
        return redirect('/')->with("succsess", "Successful log out");
    }
}
