@extends('layouts.adm-main')

@section('content')

<div class="container">
        <div class="pull-left">
            <h2>TAMPILKAN BARANG</h2>
        </div>
        <div class="row">
            <div class="col-md-8">
                <div class="card border-0 shadow rounded">
                    <div class="card-body">
                        <table class="table">
                            <tr>
                                <td>MERK</td>
                                <td>{{ $barang->merk }}</td>
                            </tr>
                            <tr>
                                <td>SERI</td>
                                <td>{{ $barang->seri }}</td>
                            </tr>
                                <td>SPESIFIKASI</td>
                                <td>{{ $barang->spesifikasi }}</td>
                            </tr>
                            </tr>
                                <td>STOK</td>
                                <td>{{ $barang->stok }}</td>
                            </tr>
                            </tr>
                                <td>KATEGORI</td>
                                <td>{{ $barang->kategori->kategori }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>    
        <div class="row">
            <div class="col-md-12  text-center">
                <a href="{{ route('barang.index') }}" class="btn btn-md btn-primary mb-3">Back</a>
            </div>
        </div>
    </div>

@endsection