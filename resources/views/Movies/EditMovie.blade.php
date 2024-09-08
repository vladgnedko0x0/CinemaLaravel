@extends('../layouts/default')
@section('head')
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link href="/css/editMovie.css" rel="stylesheet">
<script src="/js/movie.js" async defer></script>
<title>{{$selectedMovie->Name}}</title>
<style>
    input[type=checkbox] {
        visibility: hidden;
    }

    .checkbox-example {
        width: 45px;
        height: 15px;
        background: #555;
        margin: 20px 10px;
        position: relative;
        border-radius: 5px;
    }

    .checkbox-example label {
        display: block;
        width: 18px;
        height: 18px;
        border-radius: 50%;
        transition: all .5s ease;
        cursor: pointer;
        position: absolute;
        top: -2px;
        left: -3px;
        background: #ccc;
    }

    .checkbox-example input[type=checkbox]:checked+label {
        left: 27px;
    }
</style>
@endSection
@section('content')
<div class="edit-form">
    <div class="form">
        <form action="/films/{{$selectedMovie->id}}/edit/save" method="post" enctype="multipart/form-data">
            @csrf
            <input name="movieId" type="hidden" value="{{$selectedMovie->id}}" required />

            <div class="form-filed">
                <div class="filed-header">Movie name</div>
                <input name="movieName" type="text" value="{{$selectedMovie->Name}}" placeholder="Movie name" required />
            </div>
            <div class="form-filed">
                <div class="filed-header">Movie description</div>
                <textarea name="movieDescription" id="" cols="50" rows="2" placeholder="Movie description" required>{{$selectedMovie->Description}}</textarea>
            </div>
            <div class="form-filed">
                <div class="filed-header">Minimum age for watch</div>
                <input name="movieAge" type="number" value="{{$selectedMovie->Age}}" placeholder="Minimum age client" required />
            </div>
            <div class="form-filed">
                <div class="filed-header">Style</div>
                <input name="movieStyle" type="text" value="{{$selectedMovie->Style}}" placeholder="Movie style" required />
            </div>
            <div class="form-filed">
                <div class="filed-header">Director</div>
                <input name="movieDirector" type="text" value="{{$selectedMovie->Director}}" placeholder="Movie director" required />
            </div>
            <div class="form-filed">
                <div class="filed-header">Image(Don't select anything if you don't want to change the image)</div>
                <input name="movieImage" type="file" />
            </div>

            <div class="btnSubmit">
                <div>
                    <div class="checkbox-example">
                        <input name="delete" type="checkbox" value="1" id="checkboxOneInput" />
                        <label for="checkboxOneInput">Delete</label>
                    </div>
                </div>
                <div><input type="submit" value="Save" /></div>
            </div>
        </form>
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