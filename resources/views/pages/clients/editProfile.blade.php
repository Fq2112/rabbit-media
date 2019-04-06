@section('title', ''.$user->name.'\'s Account Settings: Edit Profile | Rabbit Media – Digital Creative Service')
@extends('layouts.auth.mst_client')
@section('inner-content')
    <div class="row">
        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 text-center" data-aos="fade">
            @include('layouts.partials.auth._form_ava-client')
        </div>
        <div class="col-xl-8 col-lg-8 col-md-6 col-sm-12" data-aos="fade">
            <div class="card">
                <div class="img-card">
                    <div id="map" class="height1" style="width:100%;"></div>
                </div>
                <form action="{{route('client.update.profile')}}" method="post">
                    {{csrf_field()}}
                    {{method_field('PUT')}}
                    <input type="hidden" name="check_form" value="address">
                    <div class="card-content">
                        <div class="card-title">
                            <div class="row">
                                <div class="col">
                                    <small style="font-weight: 600">Address</small>
                                </div>
                                <div class="col text-right" id="show_address_settings"
                                     style="color: #592f83;cursor: pointer;font-size: 14px"><i
                                            class="fa fa-edit mr-2"></i>EDIT
                                </div>
                            </div>
                            <hr class="mt-0">
                            <blockquote id="stats_address" style="text-transform: none">
                                <table style="font-size: 14px; margin-top: 0">
                                    <tr>
                                        <td><i class="fa fa-map-marker-alt"></i></td>
                                        <td>
                                            &nbsp;{{$user->alamat != "" ? $user->alamat : ''}}
                                        </td>
                                    </tr>
                                </table>
                            </blockquote>
                            <div id="address_settings" style="display: none">
                                <div class="row form-group has-feedback">
                                    <div class="col">
                                        <textarea style="resize:vertical" name="alamat" id="address_map"
                                                  placeholder="Agency address" class="form-control"
                                                  required>{{$user->alamat == "" ? '' : $user->alamat}}</textarea>
                                        <span class="glyphicon glyphicon-map-marker form-control-feedback"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer" style="padding: 0;">
                        <button class="btn btn-primary btn-block" id="btn_save_address" disabled>
                            <i class="fa fa-map-marker-alt mr-2"></i>SAVE CHANGES
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@push("scripts")
    <!-- Google Map -->
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBIljHbKjgtTrpZhEiHum734tF1tolxI68&libraries=places"></script>
    <script>
        // gmaps address agency
        var google;

        function init() {
            var myLatlng = new google.maps.LatLng('{{$user->lat}}', '{{$user->long}}');

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
                '<div class="iw-title">{{$user->name}}</div>' +
                '<div class="iw-content">' +
                '<img class="img-thumbnail rounded-circle show_ava" ' +
                'src="{{$user->ava == "" ? asset('images/avatar.png') : asset('storage/users/ava/'.$user->ava)}}">' +
                '<div class="iw-subTitle">Contacts</div>' +
                '<p>{{$user->alamat == "" ? '(kosong)' : $user->alamat}}<br>' +
                '<br>Phone: <a href="tel:{{$user->no_telp == "" ? '' : $user->no_telp}}">' +
                '{{$user->no_telp == "" ? '-' : $user->no_telp}}</a>' +
                '<br>E-mail: <a href="mailto:{{$user->email}}">{{$user->email}}</a>' +
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
                    icon: '{{asset('images/pin.png')}}',
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
                    '<div class="iw-title">{{$user->name}} <sub>New Address</sub></div>' +
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

        $("#show_personal_data_settings").click(function () {
            $("#personal_data_settings").toggle(300);
            $(".stats_personal_data").toggle(300);
            if ($("#btn_save_personal_data").attr('disabled')) {
                $("#btn_save_personal_data").removeAttr('disabled');
            } else {
                $("#btn_save_personal_data").attr('disabled', 'disabled');
            }
        });

        $("#show_address_settings").click(function () {
            $("#map").toggleClass('height1 height2');
            $("#address_settings").toggle(300);
            $("#stats_address").toggle(300);
            if ($("#btn_save_address").attr('disabled')) {
                $("#btn_save_address").removeAttr('disabled');
            } else {
                $("#btn_save_address").attr('disabled', 'disabled');
            }
        });
    </script>

    @include('layouts.partials.auth._scripts_ajax-client')
@endpush
