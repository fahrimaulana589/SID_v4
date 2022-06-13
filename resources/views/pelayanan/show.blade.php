<div class="layout">

    <div class="row gap-3">

        @foreach($pelayanan as $data)

            <div class="col-sm-12 col-md-4 col-lg-3 rounded bg-black py-2">
                <a href="{{route("platform.warga.pelayanan.show",$data->id)}}" class="text-white">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3>
                                {{$data->title}}
                            </h3>
                        </div>
                        <div class="panel-body">
                            {{$data->description}}
                        </div>
                    </div>
                </a>
            </div>

        @endforeach

    </div>

</div>
