@extends('layouts.mst_user')
@section('title', 'Portfolio: '.$data->nama.' Galleries | Rabbit Media – Digital Creative Service')
@section('content')
    <div class="site-section" data-aos="fade">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-md-7">
                    <div class="row mb-5">
                        <div class="col-12 ">
                            <h3 class="site-section-heading text-center">{{$data->nama}}</h3>
                            <h5 class="text-center">{{$data->deskripsi}}</h5>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row grid" id="lightgallery">
                @foreach($data->getGaleri as $row)
                    <div class="col-3 item grid-item" data-aos="fade" data-src="{{$row->photo != "" ?
                    asset('images/big-images/'.$row->photo) : $row->video}}"
                         data-sub-html="<h4>{{$row->nama}}</h4><p>{{$row->deskripsi}}</p>">
                        <a href="#">
                            <img src="{{$row->photo != "" ? asset('images/big-images/'.$row->photo) :
                            asset('images/big-images/'.$row->thumbnail)}}" alt="Thumbnail" class="img-fluid">
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection