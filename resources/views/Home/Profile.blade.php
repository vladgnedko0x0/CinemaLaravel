@extends('../layouts/default')
@section('head')
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link href="/css/profile.css" rel="stylesheet">
<script src="/js/movie.js" async defer></script>
<title>Profile</title>
@endSection
@section('content')

<div class="profile">
    <div class="data">
        <div class="userData animated fadeInLeft">
            <div class="dataContainer">
                <div class="userHeader">Username</div>
                <div class="name">{{$user->Name}}</div>
            </div>
            <div class="dataContainer">
                <div class="userHeader">Email</div>
                <div class="email">{{$user->Email}}</div>
            </div>
            <div class="dataContainer">
                <div class="userHeader">Phone number</div>
                <div class="phoneNumber">{{$user->PhoneNumber}}</div>
            </div>
        </div>
        <div class="userSessions animated fadeInRight">
            @if($currentUserReservations->count()!=0)
            <div class="table-header">Buying your tickets</div>
            <table class="styled-table">
                <thead>
                    <th>Name movie</th>
                    <th>Watch time</th>
                    <th>Count tickets</th>
                </thead>
                <tbody>
                    @foreach($currentUserReservations as $reservation)
                    <tr>
                        <td>
                            @foreach($sessions as $session)
                            @if($reservation->SessionID==$session->id)
                            @foreach($movies as $movie)
                            @if($session->MovieID==$movie->id)
                            {{$movie->Name}}
                            @break;
                            @endif
                            @endforeach
                            @break;
                            @endif
                            @endforeach
                        </td>
                        <td>
                            @foreach($sessions as $session)
                            @if($reservation->SessionID==$session->id)
                            {{$session->DataSee}}
                            @break;
                            @endif
                            @endforeach
                        </td>
                        <td>{{$reservation->CountBilets}}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @endif
        </div>
    </div>
    <div class="profileFooter animated fadeInUp">
    <div class="logout"><a href="{{url('/profile/logout')}}">Log out</a></div>
        <div class="buffer"></div>
       
    </div>
</div>

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
@endSection