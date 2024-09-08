@extends('../layouts/default')
@section('head')
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link href="/css/addMovie.css" rel="stylesheet">
<script src="/js/movie.js" async defer></script>
<title>Add movie</title>
@endSection

@section('content')
@if($user!=null&&$user->isAdmin)
<div class="addMovie-form animated fadeInLeft">
    <div class="form">
        <form method="POST" action="{{url('/films/adminAddMovie/addM')}}" enctype="multipart/form-data">
            
        <div class="form-filed">
                <input name="movieName" type="text" placeholder="Movie name"></textarea>
            </div>
            <div class="form-filed">
                <textarea name="movieDescription" id="" cols="50" rows="2" placeholder="Movie description"></textarea>
            </div>
            <div class="form-filed">
                <input name="movieAge" type="number" placeholder="Minimum age client" />
            </div>
            <div class="form-filed">
                <input name="movieStyle" type="text" placeholder="Movie style" />
            </div>
            <div class="form-filed">
                <input name="movieDirector" type="text" placeholder="Movie director" />
            </div>
            <div class="form-filed">
                <input name="movieImage" type="file" required />
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