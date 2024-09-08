@extends('../layouts/default')
@section('head')
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link href="/css/registrate.css" rel="stylesheet">
<script src="/js/login.js" async defer></script>
<script src="/js/movie.js" async defer></script>
<title>Registration</title>
@endSection
@section('content')
<div class='registrate-form animated fadeInLeft'>
    <div class="form">
        <form method="POST" action="{{url('rg')}}">
            @csrf
            <div class="block">
                <div> <label for="rgName" class='form-label'>Name</label>
                    <div class="form-field">
                        <input class="rgName" type="text" name='name' />
                    </div>
                </div>
                <div>
                    <label for="rgPhoneNumber" class='form-label'>Phone number</label>
                    <div class="form-field">
                        <input class="rgPhoneNumber" type="tel" name='phoneNumber' />
                    </div>
                </div>


            </div>

            <div class="block">
                <div>
                    <label for="rgEmail" class='form-label'>Email</label>
                    <div class="form-field">
                        <input class="rgEmail" class type="email" name='email' />
                    </div>
                </div>

            </div>
            <div class="block">
                <div> <label for="rgLogin" class='form-label'>Login</label>
                    <div class="form-field">
                        <input class="rgLogin" type="text" name='login' />
                    </div>
                </div>
                <div>
                    <label for="rgPassword" class='form-label'>Password</label>
                    <div class="form-field">
                        <input class="rgPassword" type="password" name='password' />
                        <div><span class="passwordError"></span></div>
                    </div>
                </div>

            </div>
            <div class="rgButton submit">
                <input class="btnSubmit" type="submit" value="Registrate" />
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
@if(Session::has("error"))
<div class="fadeInDown animated errors" id="error">
    {{Session::get('error')}}
</div>
@endif
@endSection