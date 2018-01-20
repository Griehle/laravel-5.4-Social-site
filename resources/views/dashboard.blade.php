
@extends('layouts.master')
@section('content')
@include('includes.message-block')

{{--Left side of screen dashboard view--}}
<h1 class="text-center">DashBoard</h1>
    <section class="row">
        <div class="col-md-1"></div>

        <div class = "col-md-5 text-center">
            <header class="dheader">
                <h3>What do you have to say?</h3>
            </header>
            <form action ='{{route('post.create')}}'>
                <div class="form-group">
                    <textarea class="form-control" name="new-post" id="new-post" cols="6" placeholder="Your Post here" ></textarea>
                    <button type="submit" class="btn btn-primary dbutton">Submit post</button>
                    <input type="hidden" value="{{Session::token()}}">
                </div>
            </form>
        </div>

{{--right side f screen on dashboard view--}}

         <div class = "col-md-5 text-center">
            <header class="dheader">
                <h3>Whats going on</h3>

                @foreach($posts as $post)
                    <article class="posts">
                        <p>
                            {{$post->body}}
                        </p>
                        <div class="info">
                            Posted by {{ $post->user->display_name }} on {{ $post->created_at->format('m/d/Y')}}﻿
                        </div>
                        <div class="interaction">
                            <a href="#">Like</a>
                            <a href="#">DisLike</a>
                            <a href="#">Edit</a>
                            <a href="#">Delete</a>

                        </div>
                    </article>
                @endforeach

                <article class="posts">
                    <p>
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
                    </p>
                    <div class="info">
                        Posted by Author
                    </div>
                    <div class="interaction">
                        <a href="#">Like</a>
                        <a href="#">DisLike</a>
                        <a href="#">Edit</a>
                        <a href="#">Delete</a>

                    </div>
                </article>
                <article class="posts">
                    <p class="new-post">
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
                    </p>
                    <div class="info">
                        Posted by Author
                    </div>
                    <div class="interaction">
                        <a href="#">Like</a>
                        <a href="#">DisLike</a>
                        <a href="#">Edit</a>
                        <a href="#">Delete</a>

                    </div>
                </article>
            </header>
         </div>
        {{--<div class="col-md-1"></div>--}}
    </section>
@endsection