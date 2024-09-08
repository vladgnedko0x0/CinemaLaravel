@extends('../layouts/default')
@section('head')
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<script src="/js/movie.js" async defer></script>
<script src="/js/moviesAnimation.js" async defer></script>
<link href="/css/movies.css" rel="stylesheet">
<title>Movies</title>
@endSection
@section('content')
@if($user!=null&&$user->isAdmin)
<div class="adminPanel animated fadeInDown">
    <div class="menuM">
    <div class="title">Admin panel</div>
            <ul class="adminMenu">
                <li><a class="aHref" href="/films/adminAddMovie">Add movie</a> </li>
                <li><a class="aHref" href="/films/adminAddSession">Add seans</a> </li>
                <li><a class="aHref" href="/films/adminSeeUsers">See all users</a></li>
            </ul>
    </div>
   
</div>
@endif
@if($movies!=null)
<div class="categoryes">
    @foreach($categoryes as $category)
    <div class="category animated">
        <div class="categoryName">
            {{$category}}
        </div>
        <div class="categoryContent">
            <div class="movies">
                @foreach($movies as $movie)
                @if($category=="For childs")
                @if($movie->Age<=10) <div class="movie c">
                    <div class="pDiv">{{$category}}</div>
                    @foreach($images as $image)
                    @if($movie->ImageID==$image->id)
                    <div class="image">
                        <a href="{{url('films/'.$movie->id)}}">
                            <img width="200" height="250" src="/storage/images/{{$image->Name}}">
                            <div class="overblock"></div>
                            </img>
                        </a>

                    </div>
                    <div class="movieName">
                        <p class="movieNameP">{{$movie->Name}}</p>
                    </div>

                    @endif
                    @endforeach

            </div>
            @endif

            @else

            @if($movie->Style==$category)
            <div class="movie c">
                <div class="pDiv">{{$category}}</div>
                @foreach($images as $image)
                @if($movie->ImageID==$image->id)
                <div class="image">
                    <a href="{{url('films/'.$movie->id)}}">
                        <img width="200" height="250" src="/storage/images/{{$image->Name}}">
                        <div class="overblock"></div>
                        </img>
                    </a>

                </div>
                <div class="movieName">
                    <p class="movieNameP">{{$movie->Name}}</p>
                </div>

                @endif
                @endforeach

            </div>
            @endif
            @endif


            @endforeach
        </div>
    </div>
</div>
@endforeach
</div>

@endif

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


<div class="btnBack">
    <i class="arrow left"></i>
</div>
<div class="btnBack menu animated fadeOutLeftBig">
    <div class="menuItems">
        <a href="/">Home</a>
        <div>|</div>
        <a href="/films">Films</a>
    </div>
</div>
@endSection