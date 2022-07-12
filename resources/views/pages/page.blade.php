@extends('layouts.layout')

@section('title')
    {{$profile->name}} | {{ $page->title }}
@endsection

@section('content')

    <div class="jumbotron jumbotron-fluid" style="background-image: url({{ $page->image }});background-size: cover;background-position: center">
        <div class="container text-center" style="height: 300px">

        </div>
    </div>

    <div class="container text-center">
        <h1>
            {{$page->title}}
        </h1>
        <hr>
    </div>

    <div class="container">
        {!! $page->content !!}
    </div>

@endsection
