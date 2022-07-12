@extends('layouts.layout')

@section('style')
  <link rel="stylesheet" href="{{ asset('css/homepage.css') }}">
  <style>
    .card img {
        height: 300px;
        object-fit: cover;
        object-position: center;
      }
  </style>
@endsection

@section('title', $profile->name)

@section('content')


<div class="jumbotron jumbotron-fluid" style="background-image: url({{$profile->background}});">
  <div class="container text-center">
    <h1 class="display-4">{{$profile->sambutan}}</h1>
    <p class="text-white">
        {{$profile->description}}
    </p>
  </div>
</div>

<div class="welcome mb-5">
  <div class="container">
    <div class="photo">
    <img src="{{ $profile->kepala_desa }}" alt="">
    </div>
    <div class="text">
      {{ $profile->sambutan_kepala_desa }}
    </div>
  </div>
</div>

@endsection
