@extends('layouts.layout')

@section('content')
    <br><br><br><br>
    <div class="col-xl-8 offset-xl-2 py-5">

        <h1 align="center"><p>Pelayanan Surat Online</p>
            <a href="/">Desa {{$profile->name}}</a>
        </h1>

        <p class="lead">Silahkan Pilih jenis Surat</p>

        <hr>

        @include("pelayanan.show",["pelayanan" => $pelayanan])
    </div>
@endsection
