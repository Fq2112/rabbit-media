@extends('layouts.mst_user')
@section('title', 'About Us | Rabbit Media – Digital Creative Service')
@push('styles')
    <link rel="stylesheet" href="{{asset('css/feedback.css')}}">
    <link rel="stylesheet" href="{{asset('css/about.css')}}">
@endpush
@section('content')
    <div class="site-section">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-md-7">
                    <div class="row mb-5">
                        <div class="col-12">
                            <h3 class="site-section-heading text-center" data-aos="fade-right">About Us</h3>
                            <h5 class="text-center" data-aos="fade-left">Rabbit Media – Digital Creative Service</h5>
                        </div>
                    </div>
                    <div class="row mb-5" data-aos="fade-down">
                        <div class="col">
                            <img src="{{asset('images/'.$about->icon)}}" alt="Our Pride" class="wrapReady">
                            <p align="justify">{{$about->deskripsi}}</p>
                            <h3>Our Vision</h3>
                            <p align="justify">{{$about->visi}}</p>
                            <div class="tagline group">
                                <div class="quote-container">
                                    <blockquote><p>{{$about->tagline}}</p></blockquote>
                                </div>
                            </div>
                            <h3>Our Mission</h3>
                            {!! $about->misi !!}
                        </div>
                    </div>
                    <div class="row" data-aos="fade-down">
                        <div class="col-12">
                            <h3 class="site-section-heading text-center text-capitalize">meet the rabbits</h3>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center" data-aos="zoom-in-up" data-aos-delay="500">
                <div id="customers-testimonials" class="owl-carousel">
                    @foreach($crews as $crew)
                        <div class="item avatar">
                            <div class="shadow-effect">
                                <img class="img-thumbnail" alt="Avatar" src="{{$crew->ava != "" ?
                                        asset('storage/admins/ava/'.$crew->ava) : asset('images/avatar.png')}}">
                                <p class="testimonial-comment">
                                    <a href="mailto:{{$crew->email}}" style="margin-right: 5px;"><span
                                                class="icon-envelope"></span></a>
                                    <a href="https://fb.com/{{$crew->facebook}}" target="_blank"
                                       style="margin-right: 5px;">
                                        <span class="icon-facebook"></span></a>
                                    <a href="https://twitter.com/{{$crew->twitter}}" target="_blank"
                                       style="margin-right: 5px;">
                                        <span class="icon-twitter"></span></a>
                                    <a href="https://instagram.com/{{$crew->instagram}}" target="_blank"
                                       style="margin-right: 5px;">
                                        <span class="icon-instagram"></span></a>
                                    <a href="https://web.whatsapp.com/send?text=Halo, {{$crew->name}}!&phone={{$crew
                                    ->whatsapp}}&abid={{$crew->whatsapp}}" target="_blank">
                                        <span class="icon-whatsapp"></span></a><br>{{$crew->deskripsi}}
                                </p>
                            </div>
                            <div class="testimonial-name">
                                {{$crew->name}}<br>
                                <cite>
                                    <small>{{ucwords($crew->role)}}</small>
                                </cite>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        $(function () {
            $('.wrapReady').slickWrap({
                cutoff: 10,
                resolution: 15,
                bloomPadding: true
            });

            "use strict";
            $('#customers-testimonials').owlCarousel({
                loop: true,
                center: true,
                items: '{{count($crews)}}',
                margin: 0,
                autoplay: true,
                dots: true,
                smartSpeed: 450,
                responsive: {
                    0: {
                        items: 1
                    },
                    768: {
                        items: 2
                    },
                    1170: {
                        items: 3
                    }
                }
            });
        });
    </script>
@endpush