<div class="layout">
    <article class="card">
        <header class="card-header">
            <h2>Status Pengajuan Surat</h2>
        </header>
        <div class="card-body">
            <div class="col mb-4">
                <strong>Kode pengajuan surat: {{$pelayanan->kode_unik}}</strong>
            </div>
            <article class="card">
                <div class="card-body row">
                    <div class="col"><strong>Tanggal Pengajuan : </strong> <br>{{$pelayanan->tanggal_masuk}}
                    </div>
                    <div class="col"><strong>Dibuat Oleh : </strong> <br> {{$pelayanan->penduduk->name}}
                    </div>
                    <div class="col"><strong>Status :</strong> <br> {{$pelayanan->status}}</div>
                    <div class="col"><strong>Nik :</strong> <br> {{$pelayanan->penduduk->NIK}}</div>
                </div>
            </article>
            <?php
            switch ($pelayanan->status) {
                case "masuk":
                    $masuk = "active";
                    $diproses = "";
                    $ditolak = "";
                    $diterima = "";
                    break;
                case "diproses":
                    $masuk = "active";
                    $diproses = "active";
                    $ditolak = "";
                    $diterima = "";
                    break;

                case "ditolak":
                    $masuk = "active";
                    $diproses = "active";
                    $ditolak = "active";
                    $diterima = "";
                    break;

                case "diterima":
                    $masuk = "active";
                    $diproses = "active";
                    $ditolak = "active";
                    $diterima = "active";
                    break;

            }
            ?>
            <div class="track">
                <div class="step {{$masuk}}">
                    <span class="icon">
                        <i class="far fa-envelope"></i>
                    </span>
                    <span class="mt-2 text-dark" style="display: block">
                        Masuk
                    </span>
                </div>
                <div class="step {{$diproses}}">
                    <span class="icon">
                        <i class="far fa-envelope-open"></i>
                    </span>
                    <span class="mt-2 text-dark" style="display: block">
                        Diproses
                    </span>
                </div>
                <div class="step {{$ditolak}}">
                    <span class="icon">
                        <i class="fas fa-trash"></i>
                    </span>
                    <span class="mt-2 text-dark" style="display: block">
                       Ditolak
                    </span>
                </div>
                <div class="step {{$diterima}}">
                    <span class="icon">
                        <i class="fas fa-save"></i>
                    </span>
                    <span class="mt-2 text-dark" style="display: block">
                         Diterima
                    </span>
                </div>
            </div>
            <hr>
            <hr>
            <div class="">
                <div class="col mb-4">
                    <strong>Gambar</strong>
                </div>

                <div class="row">

                    @foreach($pelayanan->data_image as $image)
                        <div class="col-6">
                            <img src="{{asset("storage/".$image)}}" class="w-100">
                        </div>
                    @endforeach

                </div>


            </div>
        </div>
    </article>
</div>

@push("head")
    <link rel="stylesheet" href="//use.fontawesome.com/releases/v5.0.7/css/all.css">
    <style>
        @import url('https://fonts.googleapis.com/css?family=Open+Sans&display=swap');

        body {
            background-color: #eeeeee;
            font-family: 'Open Sans', serif
        }

        .container {
            margin-top: 50px;
            margin-bottom: 50px
        }

        .card {
            position: relative;
            display: -webkit-box;
            display: -ms-flexbox;
            display: flex;
            -webkit-box-orient: vertical;
            -webkit-box-direction: normal;
            -ms-flex-direction: column;
            flex-direction: column;
            min-width: 0;
            word-wrap: break-word;
            background-color: #fff;
            background-clip: border-box;
            border: 1px solid rgba(0, 0, 0, 0.1);
            border-radius: 0.10rem
        }

        .card-header:first-child {
            border-radius: calc(0.37rem - 1px) calc(0.37rem - 1px) 0 0
        }

        .card-header {
            padding: 0.75rem 1.25rem;
            margin-bottom: 0;
            background-color: #fff;
            border-bottom: 1px solid rgba(0, 0, 0, 0.1)
        }

        .track {
            position: relative;
            background-color: #ddd;
            height: 7px;
            display: -webkit-box;
            display: -ms-flexbox;
            display: flex;
            margin-bottom: 60px;
            margin-top: 50px
        }

        .track .step {
            -webkit-box-flex: 1;
            -ms-flex-positive: 1;
            flex-grow: 1;
            width: 25%;
            margin-top: -18px;
            text-align: center;
            position: relative
        }

        .track .step.active:before {
            background: #FF5722
        }

        .track .step::before {
            height: 7px;
            position: absolute;
            content: "";
            width: 100%;
            left: 0;
            top: 18px
        }

        .track .step.active .icon {
            background: #ee5435;
            color: #fff
        }

        .track .icon {
            display: inline-block;
            width: 40px;
            height: 40px;
            line-height: 40px;
            position: relative;
            border-radius: 100%;
            background: #ddd
        }

        .track .step.active .text {
            font-weight: 400;
            color: #000
        }

        .track .text {
            display: block;
            margin-top: 7px
        }

        .itemside {
            position: relative;
            display: -webkit-box;
            display: -ms-flexbox;
            display: flex;
            width: 100%
        }

        .itemside .aside {
            position: relative;
            -ms-flex-negative: 0;
            flex-shrink: 0
        }

        .img-sm {
            width: 80px;
            height: 80px;
            padding: 7px
        }

        ul.row, ul.row-sm {
            list-style: none;
            padding: 0
        }

        .itemside .info {
            padding-left: 15px;
            padding-right: 7px
        }

        .itemside .title {
            display: block;
            margin-bottom: 5px;
            color: #212529
        }

        p {
            margin-top: 0;
            margin-bottom: 1rem
        }

        .btn-warning {
            color: #ffffff;
            background-color: #ee5435;
            border-color: #ee5435;
            border-radius: 1px
        }

        .btn-warning:hover {
            color: #ffffff;
            background-color: #ff2b00;
            border-color: #ff2b00;
            border-radius: 1px
        }

    </style>

@endpush
