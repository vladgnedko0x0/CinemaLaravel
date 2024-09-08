@extends('../layouts/default')
@section('head')
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link href="/css/credentials.css" rel="stylesheet">
<script src="/js/movie.js" async defer></script>

<title>{{$movie->Name}}</title>
@endSection
@section('content')
<div class='pay-form'>
    <div class="form">
        <form method="POST" action="{{url('/films/{movieID}/pay/{sessionID}/complate')}}">
            <input name="movieID" type="hidden" value="{{$movie->id}}" />
            <input name="sessionID" type="hidden" value="{{$session->id}}" />
            <input name="countTickets" type="hidden" value="{{$price/$session->Price}}" />
         Movie name   <div class="form-filed"><input type="text" readonly value="{{$movie->Name}}"/> </div>
           Date show <div class="form-filed"><input type="text" readonly value="{{$session->DataSee}}"/></div>
           Count tickets <div class="form-filed"><input type="text" readonly value="{{$price/$session->Price}}"/></div>
           Price <div class="form-filed"><input type="text" readonly value="{{$price}}"/></div>
            <div class="form-filed">
                <div class="form-filed">
             Number of you card <input name="numberCard" type="text" value="1234 5678 9101 1121" placeholder="Enter card number" />
                </div>
                <div class="form-filed">
                 Mount and year you card <input name="monthYearCard" type="month" value="01" placeholder="Enter month" />
                </div>
                <div class="form-filed">
                   CVV <input name="cvvCard" type="number" value="123" placeholder="CVV" />
                </div>
            </div>
            <div class="btnSubmit">
                <div></div>
                <div>
                    <input type="submit" value="Pay" />
                </div>

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