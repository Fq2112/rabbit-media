@extends('layouts.mst_user')
@section('title', 'Home | Rabbit Media – Digital Creative Service')
@section('content')
    <div class="container-fluid" data-aos="fade" data-aos-delay="500">
        <div class="swiper-container images-carousel">
            <div class="swiper-wrapper">
                @foreach($portfolios as $row)
                    <div class="swiper-slide">
                        <div class="image-wrap">
                            <div class="image-info">
                                <h2 class="mb-3">{{ucwords($row->nama)}}</h2>
                                <a href="{{route('show.portfolio.gallery',
                                ['jenis' => strtolower($row->getJenisPortofolio->nama), 'id' => encrypt($row->id)])}}"
                                   class="btn btn-outline-white py-2 px-4">{{count($row->getGaleri) . ' footage'}}</a>
                            </div>
                            <img src="{{$row->cover == 'img_1.jpg' || $row->cover == 'img_2.jpg' ||
                            $row->cover == 'img_3.jpg' || $row->cover == 'img_4.jpg' || $row->cover == 'img_5.jpg' ||
                            $row->cover == 'img_6.jpg' || $row->cover == 'img_7.jpg' ? asset('images/'.$row->cover) :
                            asset('storage/portofolio/'.strtolower(str_replace(' ', '_', $row->getJenisPortofolio->nama).
                            '/'.$row->id.'/'.$row->cover))}}" alt="Cover">
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="swiper-pagination"></div>
            <div class="swiper-button-prev"></div>
            <div class="swiper-button-next"></div>
            <div class="swiper-scrollbar"></div>
        </div>
    </div>
@endsection