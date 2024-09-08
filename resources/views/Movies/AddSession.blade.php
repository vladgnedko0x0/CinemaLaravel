@extends('../layouts/default')
@section('head')
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link href="/css/addSession.css" rel="stylesheet">
<script src="/js/movie.js" async defer></script>
<title>Add session</title>
@endSection
@section('content')
@if($user!=null&&$user->isAdmin)
<div class="addSession-form animated fadeInLeft">
    <div class="form">
        <form method="POST" action="{{url('/films/adminAddMovie/addS')}}" enctype="multipart/form-data">
            <div class="form-filed">
                Select movie
                <select name="selectMovie" class="select" required>
                    <option value="">-</option>
                    @foreach($movies as $movie)
                    <option value="{{$movie->id}}">{{$movie->Name}}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-filed">
                Select date for show
                <input name="sessionDate" class="dateSession" type="datetime-local" required />
            </div>
            <div class="form-filed">
                Enter count tickets
                <input name="countTickets" type="number" value="0" placeholder="Enter count tickets" required />
            </div>
            <div class="form-filed">
                Enter price of one ticket
                <input name="price" type="number" value="1" placeholder="Price for one ticket" required />
            </div>
            <div class="btnSubmit">
                <div></div>
                <div><input type="submit" value="Add" /></div>

            </div>


        </form>
    </div>
</div>
@else
<div class="fadeInDown animated errors">You dont have permisions !</div>
@endif
<div class="btnBack animated fadeInLeft">
    <i class="arrow left"></i>
</div>
<div class="btnBack menu animated fadeOutLeftBig">
    <div class="menuItems">
        <a href="/">Home</a>
        <div>|</div>
        <a href="/films">Films</a>
    </div>
</div>
@if(Session::has("errors"))
    <div class="fadeInDown animated errors" id="error">
     {{Session::get('errors')}}  
    </div>
    @endif
    @if(Session::has("succsess"))
    <div class="fadeInDown animated errors succsess" id="error">
     {{Session::get('succsess')}}  
    </div>
    @endif
@endSection