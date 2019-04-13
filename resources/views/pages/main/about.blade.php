@extends('layouts.mst_user')
@section('title', 'About Us | Rabbit Media – Digital Creative Service')
@push('styles')
    <link rel="stylesheet" href="{{asset('css/feedback.css')}}">
    <link rel="stylesheet" href="{{asset('css/about.css')}}">
    <link rel="stylesheet" href="{{ asset('css/myMaps.css') }}">
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
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-md-7" data-aos="fade-down">
                    <div class="row">
                        <div class="col-12">
                            <h3 class="site-section-heading text-center text-capitalize">meet the rabbits</h3>
                        </div>
                    </div>
                </div>
                <div id="customers-testimonials" class="owl-carousel" data-aos="zoom-in-up" data-aos-delay="500">
                    @foreach($crews as $crew)
                        <div class="item avatar">
                            <div class="shadow-effect">
                                <img class="img-thumbnail" alt="Avatar" src="{{$crew->ava != "" ?
                                        asset('storage/admins/ava/'.$crew->ava) : asset('images/avatar.png')}}">
                                <p class="testimonial-comment">
                                    <a href="mailto:{{$crew->email}}"><span class="icon-envelope mr-3"></span></a>
                                    <a href="https://fb.com/{{$crew->facebook}}" target="_blank">
                                        <span class="icon-facebook mr-3"></span></a>
                                    <a href="https://twitter.com/{{$crew->twitter}}" target="_blank">
                                        <span class="icon-twitter mr-3"></span></a>
                                    <a href="https://instagram.com/{{$crew->instagram}}" target="_blank">
                                        <span class="icon-instagram mr-3"></span></a>
                                    <a href="https://web.whatsapp.com/send?text=Halo, {{$crew->name}}!&phone={{$crew
                                    ->whatsapp}}&abid={{$crew->whatsapp}}" target="_blank">
                                        <span class="icon-whatsapp"></span></a>
                                    <br>{{$crew->deskripsi}}
                                </p>
                            </div>
                            <div class="testimonial-name">
                                {{$crew->name}}<br>
                                <cite>
                                    <small>{{strtoupper($crew->role)}}</small>
                                </cite>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="row justify-content-center" id="contact-us">
                <div class="col-10" data-aos="fade-down">
                    <div class="row mb-5">
                        <div class="col-12">
                            <h3 class="site-section-heading text-center text-capitalize">contact us</h3>
                            <h5 class="text-center" data-aos="fade-left">Feel free to get in touch with us!</h5>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">
                            <form method="post" action="{{route('submit.contact')}}" id="form-contact">
                                {{csrf_field()}}
                                <div class="row form-group">
                                    <div class="col">
                                        <label class="text-black" for="contact_name">Name</label>
                                        <input type="text" id="contact_name" class="form-control"
                                               name="contact_name" placeholder="Full name"
                                               value="{{Auth::check() ? Auth::user()->name : ''}}" required>
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col">
                                        <label class="text-black" for="contact_email">Email</label>
                                        <input type="email" id="contact_email" class="form-control"
                                               name="contact_email" placeholder="Email address"
                                               value="{{Auth::check() ? Auth::user()->email : ''}}" required>
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col">
                                        <label class="text-black" for="subject">Subject</label>
                                        <input type="subject" id="subject" class="form-control" name="subject"
                                               placeholder="Subject" required>
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col">
                                        <label class="text-black" for="message">Message</label>
                                        <textarea name="message" id="message" cols="30" rows="5" class="form-control"
                                                  placeholder="Write down your notes or questions here&hellip;"
                                                  required></textarea>
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col">
                                        <input type="submit" value="Send Message"
                                               class="btn btn-primary py-2 px-4 btn-block text-white">
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">
                            <div id="map" style="width:100%;height: 510px;"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <!-- Google Map -->
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBIljHbKjgtTrpZhEiHum734tF1tolxI68&libraries=places"></script>
    <script>
        var google;

        function init() {
            var myLatlng = new google.maps.LatLng(-7.2900502, 112.7201519);

            var mapOptions = {
                zoom: 15,
                center: myLatlng,
                scrollwheel: true,
                styles: [
                    {
                        "featureType": "administrative.land_parcel",
                        "elementType": "all",
                        "stylers": [{"visibility": "on"}]
                    }, {
                        "featureType": "landscape.man_made",
                        "elementType": "all",
                        "stylers": [{"visibility": "on"}]
                    }, {"featureType": "poi", "elementType": "labels", "stylers": [{"visibility": "on"}]}, {
                        "featureType": "road",
                        "elementType": "labels",
                        "stylers": [{"visibility": "simplified"}, {"lightness": 20}]
                    }, {
                        "featureType": "road.highway",
                        "elementType": "geometry",
                        "stylers": [{"hue": "#f49935"}]
                    }, {
                        "featureType": "road.highway",
                        "elementType": "labels",
                        "stylers": [{"visibility": "simplified"}]
                    }, {
                        "featureType": "road.arterial",
                        "elementType": "geometry",
                        "stylers": [{"hue": "#fad959"}]
                    }, {
                        "featureType": "road.arterial",
                        "elementType": "labels",
                        "stylers": [{"visibility": "on"}]
                    }, {
                        "featureType": "road.local",
                        "elementType": "geometry",
                        "stylers": [{"visibility": "simplified"}]
                    }, {
                        "featureType": "road.local",
                        "elementType": "labels",
                        "stylers": [{"visibility": "simplified"}]
                    }, {
                        "featureType": "transit",
                        "elementType": "all",
                        "stylers": [{"visibility": "on"}]
                    }, {
                        "featureType": "water",
                        "elementType": "all",
                        "stylers": [{"hue": "#a1cdfc"}, {"saturation": 30}, {"lightness": 49}]
                    }]
            };

            var mapElement = document.getElementById('map');

            var map = new google.maps.Map(mapElement, mapOptions);

            var contentString =
                '<div id="iw-container">' +
                '<div class="iw-title">Rabbit Media – Digital Creative Service</div>' +
                '<div class="iw-content">' +
                '<img class="img-fluid" src="{{asset('images/loading.gif')}}">' +
                '<div class="iw-subTitle">Contacts</div>' +
                '<p>JL. Dukuh Kupang Timur XX, Kav. 788, Kompleks Diponggo, Pakis, Surabaya — 60265.<br>' +
                '<br>Phone: <a href="tel:+62315667102">+62 31 566 7102</a>' +
                '<br>E-mail: <a href="mailto:{{env('MAIL_USERNAME')}}">{{env('MAIL_USERNAME')}}</a>' +
                '</p></div><div class="iw-bottom-gradient"></div></div>';

            var infowindow = new google.maps.InfoWindow({
                content: contentString,
                maxWidth: 350
            });

            var marker = new google.maps.Marker({
                position: myLatlng,
                map: map,
                icon: '{{asset('images/pin-rabbits.png')}}',
                anchorPoint: new google.maps.Point(0, -29)
            });

            marker.addListener('click', function () {
                infowindow.open(map, marker);
            });

            google.maps.event.addListener(map, 'click', function () {
                infowindow.close();
            });

            // styling infoWindow
            google.maps.event.addListener(infowindow, 'domready', function () {
                var iwOuter = $('.gm-style-iw');
                var iwBackground = iwOuter.prev();

                iwBackground.children(':nth-child(2)').css({'display': 'none'});
                iwBackground.children(':nth-child(4)').css({'display': 'none'});

                iwOuter.css({left: '22px', top: '15px'});
                iwOuter.parent().parent().css({left: '0'});

                iwBackground.children(':nth-child(1)').attr('style', function (i, s) {
                    return s + 'left: -39px !important;'
                });

                iwBackground.children(':nth-child(3)').attr('style', function (i, s) {
                    return s + 'left: -39px !important;'
                });

                iwBackground.children(':nth-child(3)').find('div').children().css({
                    'box-shadow': 'rgba(72, 181, 233, 0.6) 0 1px 6px',
                    'z-index': '1'
                });

                var iwCloseBtn = iwOuter.next();
                iwCloseBtn.css({
                    background: '#fff',
                    opacity: '1',
                    width: '30px',
                    height: '30px',
                    right: '15px',
                    top: '6px',
                    border: '6px solid #48b5e9',
                    'border-radius': '50%',
                    'box-shadow': '0 0 5px #3990B9'
                });

                if ($('.iw-content').height() < 140) {
                    $('.iw-bottom-gradient').css({display: 'none'});
                }

                iwCloseBtn.mouseout(function () {
                    $(this).css({opacity: '1'});
                });
            });
        }

        google.maps.event.addDomListener(window, 'load', init);

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

            $("#form-contact").on('submit', function (e) {
                e.preventDefault();
                @auth('admin')
                swal('PERHATIAN!', 'Fitur ini khusus untuk customer/client Rabbit Media.', 'warning');
                @else
                $(this)[0].submit();
                @endauth
            });

            $('html, body').animate({
                scrollTop: $("#" + window.location.hash).offset().top
            }, 500);
        });
    </script>
@endpush