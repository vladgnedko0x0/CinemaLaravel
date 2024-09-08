<?php

namespace App\Http\Controllers;

use App\Models\Clients;
use App\Models\ClientsCommentaries;
use App\Models\Images;
use App\Models\Movie;
use App\Models\MovieSession;
use App\Models\SeatReservation;
use DateTime;
use Illuminate\Http\Request;
use Image;

class MoviesController extends Controller
{
    public static function getUser(Request $request)
    {
        $user=null;
        if(isset($_COOKIE['tokenU'])){
              $token = $request->cookie('tokenU');
        $users = new Clients();
        $user = $users->where('Token', '=', $token)->first();
        }
      
        return $user;
    }
    public function index(Request $request)
    {
        $token = $request->cookie('token');
        $movies = Movie::all();
        $images = Images::all();
        $currentUser = MoviesController::getUser($request);
        $categoryes = [];
        array_push($categoryes, "For childs");
        foreach ($movies as $movie) {
            if (!in_array($movie->Style, $categoryes)) {
                array_push($categoryes, $movie->Style);
            }
        }


        $users = new Clients();
        $user = MoviesController::getUser($request);
        return view('Movies/Movies', compact('movies', 'images', 'user', 'categoryes', 'currentUser'));
    }
    public function saveMovie(Request $request)
    {
        // dd($request->movieImage);
        if ($request->movieImage != null) {
            // $path='C:\openserver\domains\phpLaravelExam\storage\app\public\images';
            $destinationPath = public_path() . '/storage/images/';
            $file = $request->movieImage;
            $image = Image::make($request->movieImage);
            $image->resize(200, 250);
            $fileName = $file->getClientOriginalName();
            $image->save($destinationPath . $fileName);
            $image = new Images();
            $image->Name = $fileName;
            $image->Path = $destinationPath;
            $image->save();


            $name = $request->get('movieName');
            $description = $request->get('movieDescription');
            $age = $request->get('movieAge');
            $style = $request->get('movieStyle');
            $director = $request->get('movieDirector');
            $movies = new Movie();
            $movies->Name = $name;
            $movies->Description = $description;
            $movies->Age = $age;
            $movies->Style = $style;
            $movies->Director = $director;
            $movies->CountSoldBilets = 0;
            $movies->ImageID = $image->id;
            $movies->save();
            return redirect('/films/' . $movies->id)->with('succsess', "Successfully added");
        }
    }
    public function addMovie_Index(Request $request)
    {
        $user = MoviesController::getUser($request);
        if ($user != null && $user->isAdmin) {
            return view('Movies/AddMovie', compact('user'));
        } else {
            return redirect()->back()->with("errors", "You dont have permisions !");
        }
    }
    public function addSession_Index(Request $request)
    {
        $user = MoviesController::getUser($request);
        if ($user != null && $user->isAdmin) {
            $movies = Movie::all();
            return view('Movies/AddSession', compact('user', 'movies'));
        } else {
            return redirect()->back()->with("errors", "You dont have permisions !");
        }
    }
    public function saveSession(Request $request)
    {
        $user = MoviesController::getUser($request);
        if ($user != null && $user->isAdmin) {
            $movieId = $request->get('selectMovie');
            $sessionDate = $request->get('sessionDate');
            $countTickets = $request->get('countTickets');
            $price = $request->get('price');
            $dateSession = new DateTime($sessionDate);
            $currentDate = new DateTime("now");
            if ($dateSession >= $currentDate) {
                if ($countTickets > 0) {
                    $selectedMovie = Movie::find($movieId);

                    $movieSession = new MovieSession();
                    $movieSession->MovieID = $selectedMovie->id;
                    $movieSession->DataSee = $sessionDate;
                    $movieSession->CountBilets = $countTickets;
                    $movieSession->Price = $price;
                    $movieSession->save();
                    return redirect("/films/" . $selectedMovie->id . "/tickets")->with("succsess", "Session updated successfully");
                } else {
                    return redirect()->back()->with("errors", "Tickets must be greater than 0");
                }
            } else {
                return redirect()->back()->with("errors", "The session date must be greater than the current one");
            }
        } else {
            return redirect()->back()->with("errors", "You dont have permisions !");
        }
    }
    public function selectedFilm(Request $request, $id)
    {
        $users = Clients::all();
        $user = MoviesController::getUser($request);
        $selectedMovie = Movie::find($id);
        $images = Images::all();
        $comments = ClientsCommentaries::where("MovieID", "=", $selectedMovie->id)->get();
        if ($selectedMovie != null) {
            $sessions = new MovieSession();
            $currentSessions = (object)$sessions->where('MovieID', '=', $selectedMovie->id)->get();
            // dd($currentSessions);
            return view('Movies/Movie', compact('selectedMovie', 'currentSessions', 'user', 'images', 'comments', 'users'));
        }
    }
    public function tickets(Request $request, $id)
    {
        $user = MoviesController::getUser($request);
        $selectedMovie = Movie::find($id);
        if ($selectedMovie != null) {
            $sessions = new MovieSession();
            $currentSessions = $sessions->where('MovieID', '=', $selectedMovie->id)->where("CountBilets", '>', 0)->get();
            if (count($currentSessions) == 0) {
                return redirect()->back()->with("errors", " Sorry, but there are no screenings for the movie you selected");
            }
            // dd($currentSessions);
            return view('Movies/SelectedMovie', compact('selectedMovie', 'currentSessions', 'user'));
        }
    }
    public function comment(Request $request)
    {
        $user = MoviesController::getUser($request);
        $movieID = $request->get("movieID");
        if ($user != null) {
            $userCommentaries = ClientsCommentaries::where("ClientID", "=", $user->id);
            if ($userCommentaries != null) {
                $userCommentariesOnThisMovie = $userCommentaries->where("MovieID", "=", $movieID);
                $lastUserComment = $userCommentariesOnThisMovie->max("Date");
                if ($lastUserComment != null) {
                    $currentDate = new DateTime("now");
                    $lastDateFixed = new DateTime($lastUserComment);
                    $lastDateFixed->modify("+5 min");
                    if ($lastDateFixed >= $currentDate) {
                        return redirect()->back()->with("errors", "One comment under one film can be left no more than once a day");
                    }
                }
            }

            $comment = $request->get('comment');
            $date = new DateTime("now");
            $userID = $user->id;
            $newcomment = new ClientsCommentaries();
            $newcomment->MovieID = $movieID;
            $newcomment->ClientID = $userID;
            $newcomment->comment = $comment;
            $newcomment->Date = $date;
            $newcomment->created_at = $date;
            $newcomment->updated_at = $date;
            $newcomment->save();
            return redirect()->back()->with("succsess", "Comment successfully posted");
        }
    }
    public function edit_index(Request $request, $movieID)
    {
        $user = MoviesController::getUser($request);

        if ($user != null && $user->isAdmin) {
            $selectedMovie = Movie::find($movieID);
            return view('Movies/EditMovie', compact('user', 'selectedMovie'));
        } else {
            return redirect()->back()->with("errors", "You dont have permisions !");
        }
    }
    public function edit_saveChanges(Request $request)
    {
        $user = MoviesController::getUser($request);

        if ($user != null && $user->isAdmin) {
            $movies = Movie::find($request->get("movieId"));
            if ($request->get("delete") == 1) {
                $currentImage = Images::find($movies->ImageID);
                $fileImage = public_path('/images/' . $currentImage->Name);
                if (file_exists($fileImage)) {
                    unlink($fileImage);
                }
                $allSessionForDeletedFilm = MovieSession::where("MovieID", "=", $movies->id)->get();
                if ($allSessionForDeletedFilm != null) {
                    foreach ($allSessionForDeletedFilm as $session) {
                        $resrvations = SeatReservation::where("SessionID", '=', $session->id)->get();
                        foreach ($resrvations as $reservation) {
                            $reservation->delete();
                        }
                        $session->delete();
                    }
                }
                $movies->delete();
                $currentImage->delete();
                return redirect('/films')->with("succsess", "Successfully deleted");;
            }
            if ($request->movieImage != null) {
                $currentImage = Images::find($movies->ImageID);
                $fileImage = public_path('/storage/images/' . $currentImage->Name);
                unlink($fileImage);

                $destinationPath = public_path() . '/storage/images/';
                $file = $request->movieImage;
                $image = Image::make($request->movieImage);
                $image->resize(200, 250);
                $fileName = $file->getClientOriginalName();
                $image->save($destinationPath . $fileName);
                $image = new Images();
                $image->Name = $fileName;
                $image->Path = $destinationPath;
                $image->save();
                $movies->ImageID = $image->id;
                $movies->save();
                $currentImage->delete();
            }

            $name = $request->get('movieName');
            $description = $request->get('movieDescription');
            $age = $request->get('movieAge');
            $style = $request->get('movieStyle');
            $director = $request->get('movieDirector');
            $movies->Name = $name;
            $movies->Description = $description;
            $movies->Age = $age;
            $movies->Style = $style;
            $movies->Director = $director;
            $movies->save();
            return redirect('/films/' . $movies->id)->with("succsess", "Successfully modified");
        } else {
            return redirect()->back()->with("errors", "You dont have permisions !");
        }
    }
    public function seeUsers_Index(Request $request)
    {
        $currentUser = MoviesController::getUser($request);
        if ($currentUser != null && $currentUser->isAdmin) {
            $searchName = $request->get("searchName");
            $users = null;
            if ($searchName != null) {
                $users = Clients::where("Login", "LIKE", "%" . $searchName . "%")->get();
            } else {
                $users = Clients::all();
            }
            return view("Movies/AllUsers", compact('currentUser', 'users'));
        } else {
            return redirect()->back()->with("errors", "You dont have permisions !");
        }
    }
    public function permisions_controller(Request $request, $userID)
    {
        $selectedUser = Clients::find($userID);
        if ($selectedUser != null) {
            if ($selectedUser->isAdmin) {
                $selectedUser->isAdmin = 0;
            } else {
                $selectedUser->isAdmin = 1;
            }
            $selectedUser->save();
            return redirect()->back()->with("succsess", "Successfully modified");
        } else {
            return redirect()->back()->with("errors", "User doesn't exist");
        }
    }
}
