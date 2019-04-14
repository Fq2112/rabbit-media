@extends('layouts.mst_user')
@section('title', ''.ucwords($layanan->getJenisLayanan->nama).' Service: '.ucwords($layanan->paket).' Order | Rabbit Media – Digital Creative Service')
@push('styles')
    <link href="{{ asset('css/animate.min.css')}}" rel="stylesheet">
    <link href="{{ asset('css/myMultiStepForm.css')}}" rel="stylesheet">
    <link href="{{ asset('css/cc.css')}}" rel="stylesheet">
    <link href="{{ asset('css/myMaps.css')}}" rel="stylesheet">
    <link href="{{ asset('css/myTags.css')}}" rel="stylesheet">
    <link href="{{ asset('css/calendarEvents.css')}}" rel="stylesheet">
@endpush
@section('content')
    <div class="site-section">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-md-7">
                    <div class="row mb-5">
                        <div class="col-12 ">
                            <h3 class="site-section-heading text-center"
                                data-aos="fade-right">Order Process</h3>
                            <h5 class="text-center"
                                data-aos="fade-left">{{session('order') ? 'Untuk mengakhiri proses pemesanan ini, silahkan menyelesaikan pembayaran Anda dengan rincian berikut.' : 'Sebelum melanjutkan ke langkah berikutnya, harap isi semua kolom formulir dengan data yang valid.'}}</h5>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center" id="order-process">
                <div class="col-11">
                    <div class="msform">
                        <ul id="progressbar" class="to-animate-2 text-center">
                            <li class="active">Booking Setup</li>
                            <li>Meeting Setup</li>
                            <li>Order Summary</li>
                            <li>Payment Method</li>
                        </ul>
                        <form action="{{route('submit.order')}}" method="post" id="pm-form">
                            {{csrf_field()}}
                            <fieldset id="booking_setup">
                                <div class="row form-group text-center">
                                    <div class="col">
                                        <h2 class="fs-title">Booking Setup</h2>
                                        <h3 class="fs-subtitle">Silahkan menentukan tanggal dan waktu yang Anda
                                            inginkan!</h3>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <div class="mobile-header z-depth-1">
                                            <div class="row">
                                                <div class="col-2">
                                                    <a href="#" data-activates="sidebar" class="button-collapse"
                                                       style="">
                                                        <i class="material-icons">menu</i>
                                                    </a>
                                                </div>
                                                <div class="col">
                                                    <h4>Events</h4>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="main-wrapper">
                                            <div class="sidebar-wrapper z-depth-2 side-nav fixed" id="sidebar">
                                                <div class="sidebar-title">
                                                    <h4>Events</h4>
                                                    <h5 id="eventDayName">Date</h5>
                                                </div>
                                                <div class="sidebar-events" id="sidebarEvents">
                                                    <div class="empty-message">Sorry, no events to selected date</div>
                                                </div>
                                            </div>
                                            <div class="content-wrapper grey lighten-3">
                                                <div class="container">
                                                    <div class="calendar-wrapper z-depth-2">
                                                        <div class="header-background">
                                                            <div class="calendar-header">
                                                                <a class="prev-button" id="prev">
                                                                    <i class="material-icons">keyboard_arrow_left</i>
                                                                </a>
                                                                <a class="next-button" id="next">
                                                                    <i class="material-icons">keyboard_arrow_right</i>
                                                                </a>
                                                                <div class="row header-title">
                                                                    <div class="header-text">
                                                                        <h3 id="month-name">February</h3>
                                                                        <h5 id="todayDayName">Today is Friday 7 Feb</h5>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="calendar-content">
                                                            <div id="calendar-table" class="calendar-cells">
                                                                <div id="table-header">
                                                                    <div class="row">
                                                                        <div class="col">Mon</div>
                                                                        <div class="col">Tue</div>
                                                                        <div class="col">Wed</div>
                                                                        <div class="col">Thu</div>
                                                                        <div class="col">Fri</div>
                                                                        <div class="col">Sat</div>
                                                                        <div class="col">Sun</div>
                                                                    </div>
                                                                </div>
                                                                <div id="table-body" class="">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="calendar-footer">
                                                            <div class="emptyForm" id="emptyForm">
                                                                <h4 id="emptyFormTitle">No events now</h4>
                                                                <a class="addEvent" id="changeFormButton">Add new</a>
                                                            </div>
                                                            <div class="addForm" id="addForm">
                                                                <h4>Add new event</h4>
                                                                <div class="row">
                                                                    <div class="input-field col s6">
                                                                        <input id="eventTitleInput" type="text"
                                                                               class="validate">
                                                                        <label for="eventTitleInput">Title</label>
                                                                    </div>
                                                                    <div class="input-field col s6">
                                                                        <input id="eventDescInput" type="text"
                                                                               class="validate">
                                                                        <label for="eventDescInput">Description</label>
                                                                    </div>
                                                                </div>
                                                                <div class="addEventButtons">
                                                                    <a class="waves-effect waves-light btn blue lighten-2"
                                                                       id="addEventButton">Add</a>
                                                                    <a class="waves-effect waves-light btn grey lighten-2"
                                                                       id="cancelAdd">Cancel</a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <hr class="mt-0">
                                <input type="button" name="next" class="next action-button" value="Next"
                                       style="display: table">
                            </fieldset>
                            <fieldset id="meeting_setup">
                                <div class="row form-group text-center">
                                    <div class="col">
                                        <h2 class="fs-title">Meeting Setup</h2>
                                        <h3 class="fs-subtitle">Apabila perlu meeting dengan Rabbits, silahkan tentukan
                                            lokasinya!</h3>
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <div class="col">
                                        <div id="map" class="img-thumbnail" style="width:100%;height: 400px;"></div>
                                    </div>
                                    <div class="col">
                                        <label class="control-label" for="address_map">Meeting Location
                                            <sub>(optional)</sub></label>
                                        <textarea style="resize:vertical" name="meeting_location" id="address_map"
                                                  placeholder="Tulis lokasi meeting disini&hellip;"
                                                  class="form-control" rows="5" required></textarea>
                                    </div>
                                </div>
                                <hr class="mt-0">
                                <input type="button" name="previous" class="previous action-button" value="Previous">
                                <input type="button" name="next" class="next action-button" value="Next">
                            </fieldset>
                            <fieldset id="order_summary">
                                <h2 class="fs-title text-center">Order Summary</h2>
                                <h3 class="fs-subtitle text-center">Pastikan rincian pemesanan Anda sudah benar</h3>
                                <div class="row">
                                    <div class="col-xl-7 col-lg-7 col-md-6 col-sm-12">
                                        <strong>Order Details</strong>
                                        <hr class="mt-0 mb-2">
                                        <ul class="list-inline stats_plans">
                                            <li>
                                                <a class="tag tag-plans">
                                                    <i class="fa fa-thumbtack"></i>&ensp;
                                                    <strong style="text-transform: uppercase" class="plans_name">
                                                        {{$layanan->paket}}</strong> &ensp;|&ensp;
                                                    <i class='fa fa-money-bill-wave'></i><strong
                                                            class="plan_price ml-2">
                                                        {{'Rp'.number_format($price,2,',','.')}}</strong>
                                                </a>
                                            </li>
                                            @if($layanan->isQty == true)
                                                <li>
                                                    <a class="tag tag-plans">
                                                        <i class='fa fa-cart-plus'></i>
                                                        <strong class="ml-2">Rp{{number_format($layanan->price_per_qty,
                                                        2,',','.')}}</strong>
                                                    </a>
                                                </li>
                                            @endif
                                            @if($layanan->isHours == true)
                                                <li>
                                                    <a class="tag tag-plans">
                                                        <i class='fa fa-stopwatch'></i>
                                                        <strong class="ml-2">Rp{{number_format($layanan->price_per_hours,
                                                        2,',','.')}}</strong>
                                                    </a>
                                                </li>
                                            @endif
                                        </ul>
                                        <div id="order_data"></div>
                                    </div>
                                    <div class="col-xl-5 col-lg-5 col-md-6 col-sm-12">
                                        <strong>Billing Details</strong>
                                        <hr class="mt-0">
                                        <table id="stats-billing" style="font-size: 16px">
                                            <tr>
                                                <td>
                                                    <strong class="plans_name text-uppercase">{{$layanan->paket}}</strong>
                                                </td>
                                                <td>&emsp;</td>
                                                <td align="center"><strong>-</strong></td>
                                                <td>&emsp;</td>
                                                <td align="right">
                                                    <strong class="plan_price">Rp{{number_format($price,2,',','.')}}</strong>
                                                </td>
                                            </tr>
                                            <tr data-placement="left" data-toggle="tooltip" title="Total item">
                                                <td>Qty.</td>
                                                <td>&emsp;</td>
                                                <td align="center"><strong class="bill_qty">1</strong></td>
                                                <td>&emsp;</td>
                                                <td align="right">
                                                    <strong class="total_price_qty">Rp{{number_format(0,2,',','.')}}</strong>
                                                </td>
                                            </tr>
                                            <tr data-placement="left" data-toggle="tooltip" title="Total durasi"
                                                style="border-bottom: 1px solid #eee">
                                                <td>Hours</td>
                                                <td>&emsp;</td>
                                                <td align="center"><strong class="bill_hours">{{rand(1,3)}}</strong>
                                                </td>
                                                <td>&emsp;</td>
                                                <td align="right">
                                                    <strong class="total_price_hours">Rp{{number_format(0,2,',','.')}}</strong>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Studio</td>
                                                <td>&emsp;</td>
                                                <td align="center"><strong class="nama_studio">Adventure Studio</strong>
                                                </td>
                                                <td>&emsp;</td>
                                                <td align="right">
                                                    <strong class="harga_studio">Rp{{number_format(0,2,',','.')}}</strong>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><strong>SUBTOTAL</strong></td>
                                                <td>&emsp;</td>
                                                <td>&emsp;</td>
                                                <td>&emsp;</td>
                                                <td align="right">
                                                    <strong class="subtotal"
                                                            style="font-size: 18px;color: #592f83"></strong>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                                <input type="button" name="previous" class="previous action-button" value="Previous">
                                <input type="button" name="next" class="next action-button" value="Next">
                            </fieldset>
                            <fieldset id="payment_method">
                                <h2 class="fs-title text-center">Payment Method</h2>
                                <h3 class="fs-subtitle text-center">Sebelum menyelesaikan pembayaran, silahkan pilih
                                    salah satu metode pembayaran berikut</h3>
                                <hr class="mt-0 mb-0">
                                <div class="panel-group accordion mb-3">
                                    @foreach($paymentCategories as $row)
                                        <div class="panel">
                                            <div class="panel-heading">
                                                <h4 class="panel-title mb-0">
                                                    <a class="accordion-toggle collapsed" href="javascript:void(0)"
                                                       data-toggle="collapse" data-target="#pc-{{$row->id}}"
                                                       aria-expanded="true" aria-controls="pc-{{$row->id}}"
                                                       onclick="paymentCategory('{{$row->id}}')">&ensp;{{$row->name}}
                                                        <sub>{{$row->caption}}</sub></a>
                                                </h4>
                                            </div>
                                            <div id="pc-{{$row->id}}" class="panel-collapse collapse mt-3"
                                                 aria-labelledby="pc-{{$row->id}}" data-parent=".accordion">
                                                <div class="panel-body">
                                                    <div class="pm-selector">
                                                        @if($row->id==3)
                                                            <input type="radio" id="pm-11" name="pm_id"
                                                                   value="11" style="display: none;">
                                                            <div class="row">
                                                                <div class="col-lg-12">
                                                                    <div class="cc-wrapper"></div>
                                                                </div>
                                                            </div>
                                                            <div class="row form-group">
                                                                <div class="col-lg-6">
                                                                    <strong>Credit Card Number</strong>
                                                                    <div class="input-group">
                                                                        <div class="input-group-prepend">
                                                                            <span class="input-group-text">
                                                                                <i class="fa fa-credit-card"></i></span>
                                                                        </div>
                                                                        <input class="form-control" type="tel" required
                                                                               id="cc_number" name="number"
                                                                               placeholder="•••• •••• •••• ••••">
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-6">
                                                                    <strong>Full Name</strong>
                                                                    <div class="input-group">
                                                                        <div class="input-group-prepend">
                                                                            <span class="input-group-text">
                                                                                <i class="fa fa-user"></i></span>
                                                                        </div>
                                                                        <input class="form-control" type="text" required
                                                                               name="name" id="cc_name"
                                                                               placeholder="Nama lengkap">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row form-group">
                                                                <div class="col-lg-6">
                                                                    <strong>Expiration Date</strong>
                                                                    <div class="input-group">
                                                                        <div class="input-group-prepend">
                                                                            <span class="input-group-text">
                                                                                <i class="fa fa-calendar-minus"></i></span>
                                                                        </div>
                                                                        <input class="form-control" type="tel" required
                                                                               id="cc_expiry" name="expiry"
                                                                               placeholder="MM/YYYY">
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-6">
                                                                    <strong>Security Code</strong>
                                                                    <div class="input-group">
                                                                        <div class="input-group-prepend">
                                                                            <span class="input-group-text">
                                                                                <i class="fa fa-lock"></i></span>
                                                                        </div>
                                                                        <input class="form-control" name="cvc" required
                                                                               type="number" id="cc_cvc"
                                                                               placeholder="***">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row form-group">
                                                                <div class="col-lg-12">
                                                                    <div class="alert alert-info text-center"
                                                                         role="alert"
                                                                         style="font-size: 13px">
                                                                        Kartu kredit Anda akan dikenai biaya <strong
                                                                                class="subtotal"></strong>.
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @else
                                                            @foreach($row->paymentMethods as $pm)
                                                                @if($pm->payment_category_id != 3)
                                                                    <input class="pm-radioButton"
                                                                           id="pm-{{$pm->id}}" type="radio"
                                                                           name="pm_id" value="{{$pm->id}}">
                                                                    <label class="pm-label"
                                                                           for="pm-{{$pm->id}}"
                                                                           onclick="paymentMethod('{{$pm->id}}')"
                                                                           style="background-image: url({{asset('images/paymentMethod/'.$pm->logo)}});"></label>
                                                                @endif
                                                            @endforeach
                                                        @endif
                                                    </div>
                                                    <div id="pm-details-{{$row->id}}"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <hr class="m-0" style="margin-bottom: 0">
                                    @endforeach
                                </div>
                                <input type="button" name="previous" class="previous action-button" value="Previous">
                                <input type="button" class="submit action-button" value="Submit">
                            </fieldset>
                            <input type="hidden" id="payment_code" name="payment_code">
                            <input type="hidden" id="total_qty" name="total_qty">
                            <input type="hidden" id="total_hours" name="total_hours">
                            <input type="hidden" name="total_payment" id="total_payment">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script src="{{asset('js/jquery.easing.1.3.js')}}"></script>
    <script src="{{asset('js/jquery.cc.js')}}"></script>
    <!-- Google Map -->
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBIljHbKjgtTrpZhEiHum734tF1tolxI68&libraries=places"></script>
    <script>
        // gmaps client address
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

            // autoComplete
            var autocomplete = new google.maps.places.Autocomplete(document.getElementById('address_map'));

            autocomplete.bindTo('bounds', map);

            autocomplete.setFields(['address_components', 'geometry', 'icon', 'name']);

            autocomplete.addListener('place_changed', function () {
                infowindow.close();
                marker.setVisible(false);

                var place = autocomplete.getPlace();
                if (!place.geometry) {
                    window.alert("No details available for input: '" + place.name + "'");
                    return;
                }

                if (place.geometry.viewport) {
                    map.fitBounds(place.geometry.viewport);
                } else {
                    map.setCenter(place.geometry.location);
                    map.setZoom(17);
                }

                var markerSearch = new google.maps.Marker({
                    map: map,
                    icon: '{{asset('images/pin-rabbits.png')}}',
                    anchorPoint: new google.maps.Point(0, -29)
                });
                markerSearch.setPosition(place.geometry.location);
                markerSearch.setVisible(true);

                var address = '';
                if (place.address_components) {
                    address = [
                        (place.address_components[0] && place.address_components[0].short_name || ''),
                        (place.address_components[1] && place.address_components[1].short_name || ''),
                        (place.address_components[2] && place.address_components[2].short_name || '')
                    ].join(' ');
                }
                var contentSearch =
                    '<div id="iw-container">' +
                    '<div class="iw-title">Meeting Location</div>' +
                    '<div class="iw-content">' +
                    '<div class="iw-subTitle">' + place.name + '</div>' +
                    '<img src="{{asset('images/searchPlace.png')}}">' +
                    '<p>' + address + '</p>' +
                    '</div><div class="iw-bottom-gradient"></div></div>';

                var infowindowSearch = new google.maps.InfoWindow({
                    content: contentSearch,
                    maxWidth: 350
                });
                infowindowSearch.open(map, markerSearch);

                markerSearch.addListener('click', function () {
                    infowindowSearch.open(map, markerSearch);
                });

                google.maps.event.addListener(map, 'click', function () {
                    infowindowSearch.close();
                });

                // styling infoWindowSearch
                google.maps.event.addListener(infowindowSearch, 'domready', function () {
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
                        width: '25px',
                        height: '25px',
                        right: '20px',
                        top: '3px',
                        border: '6px solid #48b5e9',
                        'border-radius': '13px',
                        'box-shadow': '0 0 5px #3990B9'
                    });

                    if ($('.iw-content').height() < 140) {
                        $('.iw-bottom-gradient').css({display: 'none'});
                    }

                    iwCloseBtn.mouseout(function () {
                        $(this).css({opacity: '1'});
                    });
                });
            });
        }

        google.maps.event.addDomListener(window, 'load', init);

        var isQty = '{{$layanan->isQty}}', isHours = '{{$layanan->isHours}}', plan_price = '{{$price}}',
            subtotal = parseInt(plan_price), payment_code_value = 0,

            total_qty = 0,
            old_total_qty = '{{$layanan->qty}}',
            price_per_qty = '{{$layanan->price_per_qty}}',

            total_hours = 0,
            old_total_hours = '{{$layanan->hours}}',
            price_per_hours = '{{$layanan->price_per_hours}}';

        $(".subtotal").text("Rp" + thousandSeparator(subtotal) + ",00");

        function showMeetingSetup() {
            $("#order_summary .previous").click();
        }

        function paymentCategory(id) {
            var $pm_1 = $("#pm-details-1"), $pm_2 = $("#pm-details-2"), $pm_3 = $("#pm-11"),
                $pm_4 = $("#pm-details-4"), $pm_5 = $("#pm-details-5"), $payment_code = $("#payment_code");

            $pm_1.html("");
            $pm_2.html("");
            $pm_4.html("");
            $pm_5.html("");
            payment_code_value = 0;

            $(".pm-radioButton").prop("checked", false).trigger('change');
            $pm_3.prop("checked", false).trigger('change');

            $("#cc_number, #cc_name, #cc_expiry, #cc_cvc").val("");
            $(".jp-card").attr("class", "jp-card jp-card-unknown");
            $(".jp-card-number").html("•••• •••• •••• ••••");
            $(".jp-card-name").html("Your Name");
            $(".jp-card-expiry").html("MM/YYYY");
            $(".jp-card-cvc").html("•••");
            $payment_code.val(0);

            if (id == 1) {
                $pm_1.html(
                    '<div class="row">' +
                    '<div class="col-lg-12">' +
                    '<div class="alert alert-info text-center" role="alert" style="font-size: 13px">' +
                    'Anda akan segera menerima sebuah email mengenai rincian pembayaran setelah Anda menyelesaikan langkah ini.' +
                    '</div></div></div>'
                );
                payment_code_value = Math.floor(Math.random() * (999 - 100 + 1) + 100);
                $payment_code.val(payment_code_value);

            } else if (id == 3) {
                $("#pm-11").prop("checked", true).trigger('change');

            } else if (id == 4) {
                $pm_4.html(
                    '<div class="row">' +
                    '<div class="col-lg-12">' +
                    '<div class="alert alert-info text-center" role="alert" style="font-size: 13px">' +
                    'Anda akan segera menerima sebuah email mengenai rincian pembayaran setelah Anda ' +
                    'menyelesaikan langkah ini.</div></div></div>'
                );
                $payment_code.val('{{str_random(15)}}');
            }
        }

        function paymentMethod(id) {
            $.get('{{route('get.paymentMethod',['id'=>''])}}/' + id, function (data) {
                if (data.payment_category_id == 2) {
                    $("#pm-details-2").html(
                        '<div class="row">' +
                        '<div class="col-lg-12">' +
                        '<div class="alert alert-info text-center" role="alert" style="font-size: 13px">' +
                        'Anda akan segera dialihkan ke halaman <strong>' + data.name + '</strong> ' +
                        'setelah Anda menyelesaikan langkah ini.</div></div></div>'
                    );

                } else if (data.payment_category_id == 5) {
                    $("#pm-details-5").html(
                        '<div class="row">' +
                        '<div class="col-lg-12">' +
                        '<div class="alert alert-info text-center" role="alert" style="font-size: 13px">' +
                        'Anda akan segera dialihkan ke halaman <strong>' + data.name + '</strong> ' +
                        'setelah Anda menyelesaikan langkah ini.</div></div></div>'
                    );
                }
            });
        }

        $('.msform').card({
            container: '.cc-wrapper',
            placeholders: {
                number: '•••• •••• •••• ••••',
                name: 'Your Name',
                expiry: 'MM/YYYY',
                cvc: '•••'
            },
            messages: {
                validDate: 'expire\ndate',
                monthYear: 'mm/yy'
            }
        });

        var current_fs, next_fs, previous_fs;
        var left, opacity, scale;
        var animating;

        $(".next").click(function () {
            if (animating) return false;
            animating = true;

            current_fs = $(this).parent();
            next_fs = $(this).parent().next();

            $('html, body').animate({
                scrollTop: $('#order-process').offset().top
            }, 500);

            $("#progressbar li").eq($("fieldset").index(next_fs)).addClass("active");
            next_fs.show();
            current_fs.animate({opacity: 0}, {
                step: function (now, mx) {
                    scale = 1 - (1 - now) * 0.2;
                    left = (now * 50) + "%";
                    opacity = 1 - now;
                    current_fs.css({
                        'transform': 'scale(' + scale + ')',
                        'position': 'absolute'
                    });
                    next_fs.css({'left': left, 'opacity': opacity});
                },
                duration: 800,
                complete: function () {
                    current_fs.hide();
                    animating = false;
                },
                easing: 'easeInOutBack'
            });
        });

        $(".previous").click(function () {
            if (animating) return false;
            animating = true;

            current_fs = $(this).parent();
            previous_fs = $(this).parent().prev();

            $('html, body').animate({
                scrollTop: $('#order-process').offset().top
            }, 500);

            $("#progressbar li").eq($("fieldset").index(current_fs)).removeClass("active");

            previous_fs.show();
            current_fs.animate({opacity: 0}, {
                step: function (now, mx) {
                    scale = 0.8 + (1 - now) * 0.2;
                    left = ((1 - now) * 50) + "%";
                    opacity = 1 - now;
                    current_fs.css({'left': left});
                    previous_fs.css({
                        'transform': 'scale(' + scale + ')',
                        'position': 'relative', 'opacity': opacity
                    });
                },
                duration: 800,
                complete: function () {
                    current_fs.hide();
                    animating = false;
                },
                easing: 'easeInOutBack'
            });
        });

        $(".submit").on("click", function () {
            if ($(".pm-radioButton").is(":checked") || ($("#pm-11").is(":checked") && $("#cc_number,#cc_name,#cc_expiry,#cc_cvc").val())) {
                $("#total_payment").val(parseInt(subtotal) - parseInt(payment_code_value));
                $("#pm-form")[0].submit();
                $('html, body').animate({
                    scrollTop: $('#order-process').offset().top
                }, 500);
            } else {
                swal('PERHATIAN!', 'Anda belum memilih metode pembayaran!', 'warning');
            }
        });

        $(window).on('beforeunload', function () {
            return "You have attempted to leave this page. Are you sure?";
        });

        var calendar = document.getElementById("calendar-table");
        var gridTable = document.getElementById("table-body");
        var currentDate = new Date();
        var selectedDate = currentDate;
        var selectedDayBlock = null;
        var globalEventObj = {};

        var sidebar = document.getElementById("sidebar");

        function createCalendar(date, side) {
            var currentDate = date;
            var startDate = new Date(currentDate.getFullYear(), currentDate.getMonth(), 1);

            var monthTitle = document.getElementById("month-name");
            var monthName = currentDate.toLocaleString("en-US", {
                month: "long"
            });
            var yearNum = currentDate.toLocaleString("en-US", {
                year: "numeric"
            });
            monthTitle.innerHTML = `${monthName} ${yearNum}`;

            if (side == "left") {
                gridTable.className = "animated fadeOutRight";
            } else {
                gridTable.className = "animated fadeOutLeft";
            }

            setTimeout(() => {
                gridTable.innerHTML = "";

                var newTr = document.createElement("div");
                newTr.className = "row";
                var currentTr = gridTable.appendChild(newTr);

                for (let i = 1; i < startDate.getDay(); i++) {
                    let emptyDivCol = document.createElement("div");
                    emptyDivCol.className = "col empty-day";
                    currentTr.appendChild(emptyDivCol);
                }

                var lastDay = new Date(currentDate.getFullYear(), currentDate.getMonth() + 1, 0);
                lastDay = lastDay.getDate();

                for (let i = 1; i <= lastDay; i++) {
                    if (currentTr.children.length >= 7) {
                        currentTr = gridTable.appendChild(addNewRow());
                    }
                    let currentDay = document.createElement("div");
                    currentDay.className = "col";
                    if (selectedDayBlock == null && i == currentDate.getDate() || selectedDate.toDateString() == new Date(currentDate.getFullYear(), currentDate.getMonth(), i).toDateString()) {
                        selectedDate = new Date(currentDate.getFullYear(), currentDate.getMonth(), i);

                        document.getElementById("eventDayName").innerHTML = selectedDate.toLocaleString("en-US", {
                            month: "long",
                            day: "numeric",
                            year: "numeric"
                        });

                        selectedDayBlock = currentDay;
                        setTimeout(() => {
                            currentDay.classList.add("blue");
                            currentDay.classList.add("lighten-3");
                        }, 900);
                    }
                    currentDay.innerHTML = i;

                    //show marks
                    if (globalEventObj[new Date(currentDate.getFullYear(), currentDate.getMonth(), i).toDateString()]) {
                        let eventMark = document.createElement("div");
                        eventMark.className = "day-mark";
                        currentDay.appendChild(eventMark);
                    }

                    currentTr.appendChild(currentDay);
                }

                for (let i = currentTr.getElementsByTagName("div").length; i < 7; i++) {
                    let emptyDivCol = document.createElement("div");
                    emptyDivCol.className = "col empty-day";
                    currentTr.appendChild(emptyDivCol);
                }

                if (side == "left") {
                    gridTable.className = "animated fadeInLeft";
                } else {
                    gridTable.className = "animated fadeInRight";
                }

                function addNewRow() {
                    let node = document.createElement("div");
                    node.className = "row";
                    return node;
                }

            }, !side ? 0 : 270);
        }

        createCalendar(currentDate);

        var todayDayName = document.getElementById("todayDayName");
        todayDayName.innerHTML = "Today is " + currentDate.toLocaleString("en-US", {
            weekday: "long",
            day: "numeric",
            month: "short"
        });

        var prevButton = document.getElementById("prev");
        var nextButton = document.getElementById("next");

        prevButton.onclick = function changeMonthPrev() {
            currentDate = new Date(currentDate.getFullYear(), currentDate.getMonth() - 1);
            createCalendar(currentDate, "left");
        };
        nextButton.onclick = function changeMonthNext() {
            currentDate = new Date(currentDate.getFullYear(), currentDate.getMonth() + 1);
            createCalendar(currentDate, "right");
        };

        function addEvent(title, desc) {
            if (!globalEventObj[selectedDate.toDateString()]) {
                globalEventObj[selectedDate.toDateString()] = {};
            }
            globalEventObj[selectedDate.toDateString()][title] = desc;
        }

        function showEvents() {
            let sidebarEvents = document.getElementById("sidebarEvents");
            let objWithDate = globalEventObj[selectedDate.toDateString()];

            sidebarEvents.innerHTML = "";

            if (objWithDate) {
                let eventsCount = 0;
                for (key in globalEventObj[selectedDate.toDateString()]) {
                    let eventContainer = document.createElement("div");
                    eventContainer.className = "eventCard";

                    let eventHeader = document.createElement("div");
                    eventHeader.className = "eventCard-header";

                    let eventDescription = document.createElement("div");
                    eventDescription.className = "eventCard-description";

                    eventHeader.appendChild(document.createTextNode(key));
                    eventContainer.appendChild(eventHeader);

                    eventDescription.appendChild(document.createTextNode(objWithDate[key]));
                    eventContainer.appendChild(eventDescription);

                    let markWrapper = document.createElement("div");
                    markWrapper.className = "eventCard-mark-wrapper";
                    let mark = document.createElement("div");
                    mark.classList = "eventCard-mark";
                    markWrapper.appendChild(mark);
                    eventContainer.appendChild(markWrapper);

                    sidebarEvents.appendChild(eventContainer);

                    eventsCount++;
                }
                let emptyFormMessage = document.getElementById("emptyFormTitle");
                emptyFormMessage.innerHTML = `${eventsCount} events now`;
            } else {
                let emptyMessage = document.createElement("div");
                emptyMessage.className = "empty-message";
                emptyMessage.innerHTML = "Sorry, no events to selected date";
                sidebarEvents.appendChild(emptyMessage);
                let emptyFormMessage = document.getElementById("emptyFormTitle");
                emptyFormMessage.innerHTML = "No events now";
            }
        }

        gridTable.onclick = function (e) {

            if (!e.target.classList.contains("col") || e.target.classList.contains("empty-day")) {
                return;
            }

            if (selectedDayBlock) {
                if (selectedDayBlock.classList.contains("blue") && selectedDayBlock.classList.contains("lighten-3")) {
                    selectedDayBlock.classList.remove("blue");
                    selectedDayBlock.classList.remove("lighten-3");
                }
            }
            selectedDayBlock = e.target;
            selectedDayBlock.classList.add("blue");
            selectedDayBlock.classList.add("lighten-3");

            selectedDate = new Date(currentDate.getFullYear(), currentDate.getMonth(), parseInt(e.target.innerHTML));

            showEvents();

            document.getElementById("eventDayName").innerHTML = selectedDate.toLocaleString("en-US", {
                month: "long",
                day: "numeric",
                year: "numeric"
            });

        };

        var changeFormButton = document.getElementById("changeFormButton");
        var addForm = document.getElementById("addForm");
        changeFormButton.onclick = function (e) {
            addForm.style.top = 0;
        };

        var cancelAdd = document.getElementById("cancelAdd");
        cancelAdd.onclick = function (e) {
            addForm.style.top = "100%";
            let inputs = addForm.getElementsByTagName("input");
            for (let i = 0; i < inputs.length; i++) {
                inputs[i].value = "";
            }
            let labels = addForm.getElementsByTagName("label");
            for (let i = 0; i < labels.length; i++) {
                labels[i].className = "";
            }
        };

        var addEventButton = document.getElementById("addEventButton");
        addEventButton.onclick = function (e) {
            let title = document.getElementById("eventTitleInput").value.trim();
            let desc = document.getElementById("eventDescInput").value.trim();

            if (!title || !desc) {
                document.getElementById("eventTitleInput").value = "";
                document.getElementById("eventDescInput").value = "";
                let labels = addForm.getElementsByTagName("label");
                for (let i = 0; i < labels.length; i++) {
                    labels[i].className = "";
                }
                return;
            }

            addEvent(title, desc);
            showEvents();

            if (!selectedDayBlock.querySelector(".day-mark")) {
                selectedDayBlock.appendChild(document.createElement("div")).className = "day-mark";
            }

            let inputs = addForm.getElementsByTagName("input");
            for (let i = 0; i < inputs.length; i++) {
                inputs[i].value = "";
            }
            let labels = addForm.getElementsByTagName("label");
            for (let i = 0; i < labels.length; i++) {
                labels[i].className = "";
            }

        };
    </script>
@endpush