@extends('../layouts/default')

@section('head')
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link href="/css/home.css" rel="stylesheet">
<script src="/js/homeAnimations.js" async defer></script>
<title>Kino</title>
@endSection

@section('content')
<div class="parametres">
    {{$i=1;}}
</div>
<div class="menuItem animated">
    <li class="mainElement"><a href="{{url('/')}}"><img src="/logo/logoNotBG.png"></a></li>
    <ul class="menu">

        <li class="films"><a href="/films">Films</a> </li>
        @if($currentUser!=null)
        <div class="profileHeader">
            <a class="profileName" href="{{url('/profile')}}">{{$currentUser->Name}}</a>
            <ul class="profileUl">
                <li> <a href="{{url('/profile')}}">Account</a></li>
                <li> <a href="{{url('/profile/logout')}}">Log out</a></li>
            </ul>
        </div>
        @else
        <div class="authButtons">
            Account
            <ul class="authUl">
                <li><a href="/login">Login</a></li>
                <li><a href="/registration">Sign Up!</a></li>
            </ul>

        </div>

        @endif

    </ul>
</div>

<div class="baseInformation">
    <div class="popularFilms">
        <div class="movies">

            @foreach($movies as $movie)
            <div class="movie popular animated">
                <div class="pDiv">#{{$i;}}</div>
                @foreach($images as $image)
                @if($movie->first()->ImageID==$image->id)
                <div class="image">
                    <a href="{{url('films/'.$movie->first()->id)}}">
                        <img width="200" height="250" src="/storage/images/{{$image->Name}}">
                        <div class="overblock"></div>
                        </img>
                    </a>

                </div>
                <div class="movieName">
                    <p class="movieNameP">{{$movie->first()->Name}}</p>
                </div>
                {{$i++;}}
                @endif
                @endforeach

            </div>



            @endforeach
        </div>
    </div>
    <div class="information">
        <div class="informationBlock">
            <div class="blockImage">

            </div>
            <div class="blockInfo">

            </div>
        </div>
        <div class="informationBlock">
            <div class="blockImage">

            </div>
            <div class="blockInfo">

            </div>
        </div>
        <div class="informationBlock">
            <div class="blockImage">

            </div>
            <div class="blockInfo">

            </div>
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


</div>
@endSection