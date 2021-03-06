@extends('layout.main1')

@section('bradcrumb')
    Data Preproduksi
@endsection
@section('onpagecss')
    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
@endsection
@section('content')
    <div class="row">
        <div class="col-12">
            @if(Session::has('alert'))
                <div class="alert alert-{{Session::get('alert.status')}} alert-dismissible" role="alert">
                    {{Session::get('alert.msg')}}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
            @endif
            <div class="card mb-4">
                <div class="card-header bg-white font-weight-bold">
                    Data Preduksi [ID : {{$prep->id}}] [{{$prep->getItem()->item_name}}]
                </div>
                <div class="card-body">
                    <form action="{{route('preproduksi.item_update', ['id' => $prep->id])}}" method="post" id="form_update_delete">
                        @csrf
                        <div class="form-group row">
                            <label for="inputPassword3" class="col-sm-2 col-form-label">Item ID</label>
                            <div class="col-sm-10 col-form-label">
                                <b>{{$prep->id}}</b>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="inputPassword3" class="col-sm-2 col-form-label">Item Type</label>
                            <div class="col-sm-10 col-form-label">
                                {{-- <b>{{$prep->getItem()->item_name}}</b> --}}
                                <select class="form-control" id="item_id" name="item_id">
                                    <option value="">Jenis Pia</option>
                                    @foreach ($data_pia as $pia)
                                        @if ($pia->id == $prep->item_id) 
                                            <option value="{{$pia->id}}" selected>{{$pia->item_name}}</option>
                                        @else
                                            <option value="{{$pia->id}}">{{$pia->item_name}}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="inputPassword3" class="col-sm-2 col-form-label">Jumlah (Biji)</label>
                            <div class="col-sm-10">
                                <input type="number" class="form-control" id="jumlah_item" name="jumlah_item" placeholder="Jumlah Item" value="{{$prep->jml_item}}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="inputPassword3" class="col-sm-2 col-form-label">Satuan</label>
                            <div class="col-sm-10 col-form-label">
                                <b>Biji</b>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="inputPassword3" class="col-sm-2 col-form-label">Tanggal Jam Input</label>
                            <div class="col-sm-10 col-form-label">
                                <b>{{$prep->date}} {{$prep->time}}</b>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="inputPassword3" class="col-sm-2 col-form-label">Update Date</label>
                            <div class="col-sm-10 col-form-label">
                                @if ($prep->created_at == $prep->updated_at)
                                    <b>-</b>
                                @else
                                    <b>{{$prep->updated_at}}</b>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="inputPassword3" class="col-sm-2 col-form-label">Alasan</label>
                            <div class="col-sm-10">
                                <textarea class="form-control" id="alasan" name="alasan" rows="2" required title="Alasan update/delete tidak boleh kosong!!" placeholder="Alasan Update atau Delete data"></textarea>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="inputPassword3" class="col-sm-2 col-form-label"></label>
                            <div class="col-sm-10 col-form-label">
                                <button type="submit" class="btn btn-primary">Update Data</button>
                                <button type="button" class="btn btn-danger btn_delete" data-btn_url="{{route('preproduksi.item_delete', ['id' => $prep->id])}}" data-red_url="{{route('preproduksi.index')}}">Hapus Data</button>
                            </div>
                            </div>
                        </div>
                    </form>
                </div>
                {{-- <div class="card-footer bg-white">
                    I am a card footer.
                </div> --}}
            </div>
        </div>
    </div>
    {{-- <div class="col-lg-12 col-md-10 col-sm-12 col-xs-12">
    </div> --}}
@endsection

@section('onpagejs')
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.1/dist/jquery.validate.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>

    <script>
        $(document).ready(function() {
            $('.btn_delete').on('click', function(){
                var form_v = $('#form_update_delete').validate({
                    debug : false
                });
                var res_val = form_v.element('#alasan');
                if(res_val == true) {
                    var del_url = $(this).data('btn_url');
                    var red_url = $(this).data('red_url');
                    var tkn = $("input[name = '_token']").val();
                    $.confirm({
                        title: 'Hapus Data',
                        content: 'Yakin hapus data?<br><strong>Data yang dihapus tidak bisa di kembalikan!!</strong>',
                        buttons: {
                            confirm: {
                                btnClass : 'btn-danger',
                                action : function() {
                                    // $.ajaxSetup({
                                    //     headers: {
                                    //         'X-CSRF-TOKEN': tkn
                                    //     }
                                    // });
                                    $.ajax({
                                        type : 'post',
                                        url : del_url,
                                        data : {
                                                    _token : tkn,
                                                },
                                        success : function(data) {
                                            $.alert({
                                                title: 'Data Deleted',
                                                content: 'ID : '+data.id+' <br>ITEM : '+data.item_name+'<br>Jumlah : '+data.jml,
                                                buttons : {
                                                    'ok' : function(){
                                                        $(location).attr('href',red_url);
                                                    }
                                                }
                                                });
                                            // $(location).attr('href',red_url);
                                        }
                                    });
                                    console.log(del_url+tkn);
                                }
                            }
                        }
                    });
                } else {
                    $('#alasan').addClass('is-invalid');
                }
            });

            $('#alasan').keyup(function(){
                if($('#alasan').hasClass('is-invalid') == true) {
                    $('#alasan').removeClass('is-invalid');
                    $('#alasan').addClass('is-valid');
                } else {
                    $('#alasan').addClass('is-valid');
                }
            });
        })
    </script>
@endsection