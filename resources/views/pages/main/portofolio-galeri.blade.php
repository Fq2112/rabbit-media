@extends('layouts.mst_user')
@section('title', 'Portfolio: '.$data->nama.' Galleries | Rabbit Media – Digital Creative Service')
@section('content')
    <div class="site-section">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-md-7">
                    <div class="row mb-5">
                        <div class="col-12">
                            <h3 class="site-section-heading text-center" data-aos="fade-right">{{$data->nama}}</h3>
                            <h5 class="text-center" data-aos="fade-left">{{$data->deskripsi}}</h5>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-11">
                    <div class="row grid" id="lightgallery">
                        @foreach($data->getGaleri as $row)
                            <div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 item grid-item" data-aos="zoom-out"
                                 data-src="{{$row->photo!="" ? asset('images/big-images/'.$row->photo) : $row->video}}"
                                 data-sub-html="<h4>{{$row->nama}}</h4><p>{{$row->deskripsi}}</p>">
                                <a href="javascript:void(0)">
                                    <img src="{{$row->photo != "" ? asset('images/big-images/'.$row->photo) :
                                    asset('images/big-images/'.$row->thumbnail)}}" alt="Thumbnail" class="img-fluid">
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection