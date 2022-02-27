<div class="layout">
    <div class="row">
        <h3>Id Data Penduduk</h3>

        <div class="d-flex flex-wrap gap-2 pb-4">

            @foreach ($penduduks as $item)
                <button type="button" class="btn btn-primary w-auto">{{ $item['title']  }}</button>
            @endforeach

        </div>

        <h3>Id Data Surat</h3>

        <div class="d-flex flex-wrap gap-2">

            @foreach ($surats as $item)
                <button type="button" class="btn btn-primary w-auto">{{ $item['title']  }}</button>
            @endforeach

        </div>


    </div>
</div>
