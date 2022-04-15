@extends('layouts.main-layout')
@section('content')
    {{-- form create new tweet --}}

    <form method="POST" action="{{ route('create') }}" enctype="multipart/form-data" class="form-tweet">


        {{ csrf_field() }}


        @if(count($errors))
            <div class="alert alert-danger">
                <strong>Whoops!</strong> There were some problems with your input.
                <br/>
                <ul>
                    @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif


        <div class="form-group">
            <label>Add Tweet Text: {{$current->format('Y-m-d  H:i')}}</label>
            <textarea class="form-control" name="tweet_description"></textarea>
        </div>
        <div class="form-group">
            <label>Add Multiple Images:</label>
            <input type="file" name="tweet_img" multiple class="form-control">
        </div>
        <div class="form-group">
            <label>Publication Date:</label>
            <input type="datetime-local" name="tweet_date" multiple class="form-control" value="{{$current->format('Y-m-d')}}T{{$current->format('H:i')}}" min="{{$current->format('Y-m-d')}}T{{$current->format('H:i')}}">
        </div>
        <div class="form-group">
            <button class="btn btn-success">Add New Tweet</button>
        </div>
    </form>


    {{-- my tweets --}}
    {{-- @foreach ($tweets as $tweet)
        <div class="post {{ $tweet -> tweet_date >  $current->format('Y-m-d') ? 'opacity' : ''  }}">
            <div class="post__header">
                <div class="post-meta">                    
                    <div class="post-meta__icon">
                        <img class="profile-pic" src="https://unsplash.it/300/300?image=15" >                    
                    </div>
                    <div class="post-meta__data">
                        <div class="post-meta__author">Emanuele Arconte</div>
                        <div class="post-meta__time">{{$tweet -> tweet_date}}</div>
                    </div>                    
                </div>
            </div>
            <div class="post__text">{{$tweet -> tweet_description}}</div>
            <div class="post__image">
                <img src="{{$tweet -> tweet_img}}" alt="">
            </div>
            <div class="post__footer">
                <div class="likes js-likes">
                    <div class="likes__cta">
                        <span class="like-button  js-like-button ${objArrayOgg.color}" data-postid="${i}">
                            <i class="like-button__icon fas fa-thumbs-up" aria-hidden="true"></i>
                            <span class="like-button__label">Mi Piace</span>
                        </span>
                    </div>
                    <div class="likes__counter">
                        Piace a <b id="like-counter-1" class="js-likes-counter">{{$tweet -> tweet_likes}}</b> persone
                    </div>
                </div> 
            </div>            
        </div>
    @endforeach --}}

    <my-tweets-component></my-tweets-component>
@endsection