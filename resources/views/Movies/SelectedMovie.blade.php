@extends('../layouts/default')
@section('head')
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link href="/css/buyTickets.css" rel="stylesheet">
<script src="/js/movie.js" async defer></script>
<title>Tickets</title>
@endSection

@section('content')
<div class="tickets">
    @if($selectedMovie!=null&&count($currentSessions)>0)
    <table class="styled-table tickets-table">
        <thead>
            <th>Movie name</th>
            <th>Count tickets</th>
            <th>Time</th>
            <th></th>
        </thead>
        <tbody>
            @foreach($currentSessions as $session)
            @if($session->CountBilets!=0)
            <tr>
                <td>{{$selectedMovie->Name}}</td>
                <td>{{$session->CountBilets}}</td>
                <td>{{$session->DataSee}}</td>
                <td>
                    <div class="payButton"><a href="{{url('/films/'.$selectedMovie->id.'/pay/'.$session->id)}}">Buy</a></div>
                </td>
            </tr>
            @endif
            @endforeach

        </tbody>
    </table>
    @else
    <div class="fadeInDown animated errors" id="error">
        Sorry, but there are no screenings for the movie you selected
    </div>

    @endif
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
    {{Session::get("errors")}}
</div>
@endif
@if(Session::has("succsess"))
<div class="fadeInDown animated errors succsess" id="error">
    {{Session::get('succsess')}}
</div>
@endif
@endSection