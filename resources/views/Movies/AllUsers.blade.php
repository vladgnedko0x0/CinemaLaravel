@extends('../layouts/default')
@section('head')
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<script src="/js/movie.js" async defer></script>
<link href="/css/allUsers.css" rel="stylesheet">
<title>Users</title>
@endSection
@section('content')
<div class="users">
    <div class="form">
        <div class="searchPanel">
            <form method="GET">
                <div class="input animated fadeInDown">
                    <input type="text" name="searchName" placeholder="Searched login">
                </div>
                <div class="btnSubmit animated fadeInRight">
                    <div></div>
                    <div><input type="submit" value="Search"></div>
                </div>
            </form>
        </div>
        <div class="table animated fadeInUp">
            <table class="styled-table tickets-table">
                <thead>
                    <th>Login</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone number</th>
                    <th>Date of create account</th>
                    <th>Admin permisions</th>
                </thead>
                <tbody>
                    @foreach($users as $user)
                    @if($user->id!=$currentUser->id)
                    <tr>
                        <td>{{$user->Login}}</td>
                        <td>{{$user->Name}}</td>
                        <td>{{$user->Email}}</td>
                        <td>{{$user->PhoneNumber}}</td>
                        <td>{{$user->created_at}}</td>
                        @if($user->isAdmin)
                        <td><a href="/films/adminSeeUsers/{{$user->id}}">Take pernisions</a></td>
                        @else
                        <td><a href="/films/adminSeeUsers/{{$user->id}}">Give pernisions</a></td>
                        @endif

                    </tr>
                    @else
                    <tr class="active-row">
                        <td>{{$user->Login}}</td>
                        <td>{{$user->Name}}</td>
                        <td>{{$user->Email}}</td>
                        <td>{{$user->PhoneNumber}}</td>
                        <td>{{$user->created_at}}</td>
                        <td><a href="#">Its you</a></td>
                    </tr>
                    @endif
                    @endforeach

                </tbody>
            </table>
        </div>
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