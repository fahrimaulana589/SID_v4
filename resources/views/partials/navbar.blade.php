<nav class="navbar navbar-expand-lg navbar-light bg-white">
    <div class="container">
        <a class="navbar-brand" href="/">
            <div class="d-flex">
                <img src="{{$profile->logo}}" alt="logo" height="60px">
                <div class="ml-3">
                    <p style="font-size: 20px;margin: 1px">
                        <b>
                            {{$profile->name}}
                        </b>
                    </p>
                    <p style="font-size: 15px;margin: 1px">
                        {{$profile->slogan}}
                    </p>
                </div>
            </div>
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ml-auto">

                @foreach($pages as $page)
                    <li class="nav-item">
                        <a class="nav-link" href="{{url("page/".$page->id)}}">{{$page->title}}</a>
                    </li>
                @endforeach

                <li class="nav-item">
                    <a class="nav-link" href="{{route("platform.warga.pelayanan")}}">Pelayanan</a>
                </li>

            </ul>
        </div>
    </div>
</nav>
