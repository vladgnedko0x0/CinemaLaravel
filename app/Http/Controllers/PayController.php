<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use App\Models\MovieSession;
use App\Models\SeatReservation;
use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;

class PayController extends Controller
{
    
    public function index(Request $request,$movieID,$sessionID){
        $user=MoviesController::getUser($request);
        $movie=Movie::find($movieID);
        $session=MovieSession::find($sessionID);
        if($user!=null){
            return view('Pay/Pay',compact('user','movie','session'));
        }else{
            return redirect()->back()->with("errors","Log in before buying a ticket");
        }
        
    }

    public function checkData(Request $request){  
        $movie=Movie::find($request->get('movieID'));
        $session=MovieSession::find($request->get('sessionID'));
        $countTickets=$request->get('countBilets');
        if($movie!=null&&$session!=null){
            $countTicketsInDB=$session->CountBilets;
            if($countTicketsInDB-$countTickets>=0){
                return redirect('/films/'.$movie->id.'/pay/'.$session->id.'/'.$countTickets.'/credentials');
            }else{
                return redirect('/films/'.$movie->id.'/pay/'.$session->id)->withErrors("We don't have enough tickets :( Go to another show or take fewer tickets.");
            }
        }
    }
    public function credentials(Request $request,$movieID,$sessionID,$countTickets){
        $user=MoviesController::getUser($request);
        $movie=Movie::find($movieID);
        $session=MovieSession::find($sessionID);
        $price=$session->Price*$countTickets;
        return view('Pay/Credentials',compact('user','movie','session','price'));
    }
    public function pay(Request $request){
        //Imitation of payment
        if(true){
            $user=MoviesController::getUser($request);
            $countTickets=$request->get('countTickets');
            $sessionID=$request->get(('sessionID'));
            $session=MovieSession::find($sessionID);
            $movie=Movie::find($request->get(('movieID')));
            $reservation=new SeatReservation();
            $reservation->ClientID=$user->id;
            $reservation->SessionID=$sessionID;
            $reservation->CountBilets=$countTickets;
            $reservation->save();
            $session->CountBilets-=$countTickets;
            $session->save();
            $movie->CountSoldBilets+=$countTickets;
            $movie->save();
        }
        return redirect('/films/'.$request->get('movieID'))->with("succsess","You have successfully reserved your seats. Waiting for you '".$session->DataSee."' on the '".$movie->Name."'");
    }
}
