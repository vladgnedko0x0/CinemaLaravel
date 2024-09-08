@extends('../layouts/default')
@section('head')
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link href="/css/login.css" rel="stylesheet">
<script src="/js/login.js" async defer></script>
<script src="/js/movie.js" async defer></script>
<title>Login</title>
@endSection
@section('content')
<div class="login-form animated fadeInLeft">
    <div class="form">
        <form method="POST" action="/lg">
            @csrf
            <label for="rgLogin" class='form-label'>Login</label>
            <div class="form-field">
                <input class="rgLogin" type="text" name='login' required/>
            </div>
            <label for="rgPassword" class='form-label'>Password</label>
            <div class="form-field">
                <input class="rgPassword" type="password" name='password' required/>
                <div><span class="passwordError"></span></div>
                
            </div>
            <div class="form-field submit">
                <input class="btnSubmit" type="submit" value="Login" />
            </div>
        </form>
        <div class="or">OR</div>

        <div class="anyTypeOfRegistration">
            <div class="authType google">
                <a href='/registration/auth/redirect/google'>
                    Google
                </a>
            </div>
            <div class="authType git">
                <a href='/registration/auth/redirect/git'>
                    Git Hub(Beta)
                </a>
            </div>
        </div>
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
@if(Session::has("loginError"))
    <div class="fadeInDown animated errors" id="error">
     {{Session::get('loginError')}}  
    </div>
    @endif
    @if(Session::has("succsess"))
    <div class="fadeInDown animated errors succsess" id="error">
     {{Session::get('succsess')}}  
    </div>
    @endif
{{$message}}
@endSection