@extends('layouts.mst_user')
@section('title', 'Home | Rabbit Media – Digital Creative Service')
@section('content')
    <div class="container-fluid" data-aos="fade" data-aos-delay="500">
        <div class="swiper-container images-carousel">
            <div class="swiper-wrapper">
                @foreach($portofolios as $row)
                    <div class="swiper-slide">
                        <div class="image-wrap">
                            <div class="image-info">
                                <h2 class="mb-3">{{ucwords($row->nama)}}</h2>
                                <a href="single.html" class="btn btn-outline-white py-2 px-4">
                                    @if($row->photos != "" && $row->videos != "")
                                        {{count($row->photos)}} {{count($row->photos) > 1 ? 'photos &' : 'photo &'}}
                                        {{count($row->videos)}} {{count($row->videos) > 1 ? 'videos' : 'video'}}
                                    @elseif($row->photos != "" && $row->videos == "")
                                        {{count($row->photos)}} {{count($row->photos) > 1 ? 'photos' : 'photo'}}
                                    @elseif($row->photos == "" && $row->videos != "")
                                        {{count($row->videos)}} {{count($row->videos) > 1 ? 'videos' : 'video'}}
                                    @endif
                                </a>
                            </div>
                            <img src="images/{{$row->cover}}" alt="Cover">
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