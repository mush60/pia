@extends('layout.main')

@section('bradcrumb')
    Dashboard
@endsection

@section('boxs')
@endsection

@section('content')
    @if(Session::has('alert'))
        <div class="alert alert-{{Session::get('alert.status')}} alert-dismissible" role="alert">
            {{Session::get('alert.msg')}}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">×</span>
            </button>
        </div>
    @endif
    <div class="row">
        <div class="col-lg-12">
            <div class="card mb-4">
                <div class="card-header bg-white font-weight-bold">
                    <div class="row">
                        <div class="col-md-6 col-sm-6 col-6">
                            Tabel Stock
                        </div>
                        <div class="col-md-6 col-sm-6 col-6 text-right">
                            <a href="{{route('stock.create')}}" class="btn btn-primary">Tambah Stock</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table mb-0">
                        <thead class="thead-light">
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Nama</th>
                                <th scope="col">Stock</th>
                                <th scope="col">Type</th>
                                <th scope="col">Date</th>
                                <th scope="col">-</th>
                            </tr>
                        </thead>
                        @php
                            $n=1;
                        @endphp
                        <tbody>
                            @foreach ($data_stock as $stock)
                                <tr>
                                    <td>{{$n++}}</td>
                                    <td>{{$stock->getItem()->item_name}}</td>
                                    <td>{{$stock->item_qty}}</td>
                                    <td>
                                        @if ($stock->stock_type == 'in')
                                            <span class="badge badge-primary">    
                                        @else
                                            <span class="badge badge-danger">
                                        @endif    
                                        {{$stock->stock_type}}</span>
                                    </td>
                                    <td>{{$stock->stock_date}}</td>
                                    <td>
                                        <a href="#"><i class="fa fa-eye text-info"></i></a>
                                        <a href="#"><i class="fa fa-trash text-danger"></i></a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>   
        </div>
    </div>
@endsection