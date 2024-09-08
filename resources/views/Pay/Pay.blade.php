@extends('../layouts/default')
@section('head')
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link href="/css/pay.css" rel="stylesheet">
<script src="/js/movie.js" async defer></script>
<title>{{$movie->Name}}</title>
@endSection
@section('content')
<div class='pay-form'>
    <div class="form">
        <form method="POST" action="{{url('/films/{movieID}/pay/{sessionID}/checkData')}}">
            <label for="movieName">Movie name</label>
            <div class="form-filed">
                <input class="movieName" type="text" value="{{$movie->Name}}" readonly />
            </div>
            <label for="movieDate">Movie date</label>
            <div class="form-filed">
                <input class="movieDate" type="text" value="{{$session->DataSee}}" readonly />
            </div>
            <label for="movieBilets">How many tickets you want?</label>
            <div class="form-filed">
                <input class="movieBilets" name="countBilets" type="number" value='1' min="1" max="{{$session->CountBilets}}" placeholder="Count tickets" />
            </div>
            <input name="movieID" type="hidden" value="{{$movie->id}}" />
            <input name="sessionID" type="hidden" value="{{$session->id}}" />


            <div class="btnSubmit">
                <div></div>
                <div> <input type="submit" value="Next >>" /></div>

            </div>

        </form>
    </div>
</div>
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
@if(Session::has("errors"))
<div class="fadeInDown animated errors" id="error">
    {{Session::get('errors')->first()}}
</div>
@endif
@if(Session::has("succsess"))
<div class="fadeInDown animated errors succsess" id="error">
    {{Session::get('succsess')}}
</div>
@endif

@endSection