<div class="layout">
    <div class="row">

        @foreach ($agendas as $agenda)

            <div class="col-lg-3 col-md-5 col-sm-5 my-2">

                <a href="{{ route('platform.agendas.show',$agenda) }}">
                    <div class="card h-100 rounded bg-success text-white">
                        <div class="card-body">
                            <h1>{{ $agenda->dataAgendas->count() }}</h1>
                            <div>
                                {{ $agenda['title']  }}
                            </div>
                        </div>
                    </div>
                </a>
            </div>

        @endforeach

    </div>
</div>
