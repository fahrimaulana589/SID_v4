@extends('layouts.layout')

@section('content')
    <br><br><br><br>
    <div class="col-xl-8 offset-xl-2 py-5">

        <h1 align="center"><p>Pelayanan Surat Online</p>
            <a href="/">Desa {{$profile->name}}</a>
        </h1>

        {!! $pelayanan->syarat !!}

        <p class="lead">Silahkan lengkapi semua isian sesuai dengan data yang diperlukan</p>


        <form id="contact-form" method="POST" action="{{ route('pelayanan.store') }}" role="form" novalidate="true">
            @csrf
            <div class="messages"></div>

            <div class="controls">

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="form_lastname">NIK *</label>
                            <input id="form_lastname" type="text" name="pelayanan[nik_penduduks]" class="form-control"
                                   placeholder="Silahkan masukkan NIK anda *" required="required"
                                   data-error="NIK Harus diisi!.">
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="form_lastname">File *</label>
                            <input id="form_lastname" type="file" multiple="multiple" accept="image/*" name="pelayanan[images][]"
                                   class="form-control"
                                   placeholder="Silahkan masukkan NIK anda *" required="required"
                                   data-error="NIK Harus diisi!.">
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="form_message">Keperluan *</label>
                            <textarea id="form_message" name="pelayanan[keperluan]" class="form-control"
                                      placeholder="Silahkan isi keperluan atau keterangan lainnya disini *" rows="4"
                                      required="required"
                                      data-error="Silahkan isi pesan atau keterangan anda."></textarea>
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>
                </div>

                @foreach($data_key as $item)
                    @if($data[$item]->type == 'multitext')

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="form_message">{{$item}} *</label>
                                    <textarea id="form_message" name="pelayanan[attribute][data][{{$data[$item]->key}}]"
                                              class="form-control"
                                              placeholder="Silahkan isi keperluan atau keterangan lainnya disini *"
                                              rows="4"
                                              required="required"
                                              data-error="Silahkan isi pesan atau keterangan anda."></textarea>
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>
                        </div>

                    @elseif($data[$item]->type == 'text')
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="form_lastname">{{$item}} *</label>
                                    <input id="form_lastname" type="text"
                                           name="pelayanan[attribute][data][{{$data[$item]->key}}]" class="form-control"
                                           placeholder="Silahkan masukkan NIK anda *" required="required"
                                           data-error="NIK Harus diisi!.">
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach
                <div class="row">
                    <div class="col-md-6">
                        <input type="submit" class="btn btn-success btn-send disabled" value="Kirim Permohonan">
                    </div>
                    <div class="col-md-6">
                        <input type="button" class="btn btn-primary btn-send" value="Kembali"
                               onclick="window.history.back()">
                    </div>
                </div>


                <div class="row">
                    <div class="col-md-12">
                        <p class="text-muted">
                            <strong>*</strong> Harus diisi
                        </p>
                    </div>
                </div>
            </div>

        </form>

    </div>
@endsection
