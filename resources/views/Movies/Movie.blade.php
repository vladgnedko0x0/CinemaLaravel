@extends('../layouts/default')
@section('head')
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link href="/css/movie.css" rel="stylesheet">
<script src="/js/movie.js" async defer></script>
<script src="/js/commentsAnimation.js" async defer></script>
<title>{{$selectedMovie->Name}}</title>
@endSection
@section('content')
<div class="movie">
    <div class="movieInfo">
        @foreach($images as $image)
        @if($selectedMovie->ImageID==$image->id)
        <div class="movieImage animated fadeInLeft">
            <img src="/storage/images/{{$image->Name}}">
        </div>
        @endif
        @endforeach

        <div class="movieTextInfo">
            <div class="movieName animated fadeInDown">
                {{$selectedMovie->Name}}
            </div>
            <div class="headInfo">
                <div class="movieStyle animated fadeInLeft">
                    {{$selectedMovie->Style}}
                </div>
                |
                <div class="movieDirector animated fadeInUp">
                    {{$selectedMovie->Director}}
                </div>
                |
                <div class="movieAge animated fadeInRight">
                    {{$selectedMovie->Age}}+
                </div>
            </div>
            <div class="movieDescription animated fadeInRight">
                {{$selectedMovie->Description}}
            </div>

            <div class="movieButtons">
                <div></div>
                <div class="buttons">
                    <div class="buyTickets animated infinite pulse">
                        <a class="buttonsHref" href="/films/{{$selectedMovie->id}}/tickets">Buy Tickets</a>
                    </div>
                    @if($user!=null&&$user->isAdmin)
                    <div class="editForAdmin animated flipInX">
                        <a class="buttonsHref" href="/films/{{$selectedMovie->id}}/edit">Edit</a>
                    </div>
                    @endif
                </div>

            </div>
        </div>


    </div>
</div>
<div class="usersComments">
    <div class="head">Comments</div>
    @if($user!=null)
    <div class="comment-form">
        <form method="POST" action="{{url('/films/'.$selectedMovie->id.'/comment')}}">
            
        @csrf
        <input type="hidden" name="movieID" value="{{$selectedMovie->id}}">
            <div class="form">
                <div class="form-field">
                    <input class="commentInput" name="comment" type="text" placeholder="Your comment">
                </div>
                <div class="submit">
                    <input class="btnSubmit" type="submit" value="Send">
                </div>
            </div>


        </form>
    </div>
    @else
    <div class="comment-form">
        <form method="POST" action="{{url('/films/'.$selectedMovie->id.'/comment')}}">
            @csrf
            <input type="hidden" name="movieID" value="{{$selectedMovie->id}}">
            <div class="form">
                <div class="form-field">
                    <input class="commentInput" name="comment" type="text" placeholder="Login or register to write a comment" readonly>
                </div>
                <div class="submit">
                    <input class="btnSubmit" type="submit" value="Send" disabled>
                </div>
            </div>


        </form>
    </div>
    @endif
    @if($comments!=null)
    @foreach($comments as $comment)
    @if($comment->MovieID==$selectedMovie->id)
    <div class="comment animated">
        <div class="commentHead">
            <div class="userName">
                @foreach($users as $user1)
                @if($user1->id==$comment->ClientID)
                {{$user1->Name}} :
                @endif
                @endforeach
            </div>

            <div class="commentDate">
               {{$comment->Date}}
            </div>
        </div>
        <div class="commentContent">
           {{$comment->comment}}
        </div>
    </div>
    @endif
    @endforeach
    @endif
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