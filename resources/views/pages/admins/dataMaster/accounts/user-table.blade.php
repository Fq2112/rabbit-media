@extends('layouts.auth.mst_admin')
@section('title', 'The Rabbits: Users Table | Rabbit Media – Digital Creative Service')
@push('styles')
    <link rel="stylesheet" href="{{asset('admins/modules/datatables/datatables.min.css')}}">
    <link rel="stylesheet"
          href="{{asset('admins/modules/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css')}}">
    <link rel="stylesheet" href="{{asset('admins/modules/datatables/Select-1.2.4/css/select.bootstrap4.min.css')}}">
    <link rel="stylesheet" href="{{asset('admins/modules/datatables/Buttons-1.5.6/css/buttons.dataTables.min.css')}}">
    <link rel="stylesheet" href="{{ asset('css/myMaps.css') }}">
    <style>
        .modal-header {
            padding: 1rem !important;
            border-bottom: 1px solid #e9ecef !important;
        }

        .modal-footer {
            padding: 1rem !important;
            border-top: 1px solid #e9ecef !important;
        }
    </style>
@endpush
@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Users Table</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{route('home-admin')}}">Dashboard</a></div>
                <div class="breadcrumb-item">Data Master</div>
                <div class="breadcrumb-item">Accounts</div>
                <div class="breadcrumb-item">Users</div>
            </div>
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped" id="dt-buttons">
                                    <thead>
                                    <tr>
                                        <th class="text-center">#</th>
                                        <th>Ava</th>
                                        <th>Contact</th>
                                        <th>Status</th>
                                        <th class="text-center">Joined at</th>
                                        <th class="text-center">Last Update</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @php $no = 1; @endphp
                                    @foreach($users as $user)
                                        @php
                                            $birthday = $user->tgl_lahir != "" ?
                                            \Carbon\Carbon::parse($user->tgl_lahir)->format('j F Y') : '&ndash;';
                                            $created_at = \Carbon\Carbon::parse($user->created_at)->format('j F Y');
                                            $updated_at = \Carbon\Carbon::parse($user->updated_at)->diffForHumans();
                                            $orders = $user->getPemesanan != null ? $user->getPemesanan->count() : 0;
                                            $contacts = \App\Models\Contact::where('email', $user->email)->count();
                                            $rate = $user->getFeedback != null ? $user->getFeedback->rate : 0;
                                            $comment = $user->getFeedback != null ? $user->getFeedback->comment : "";
                                        @endphp
                                        <tr>
                                            <td style="vertical-align: middle" align="center">{{$no++}}</td>
                                            <td style="vertical-align: middle" align="center">
                                                <img class="img-fluid" width="100" alt="avatar.png"
                                                     src="{{$user->ava == "" ? asset('images/avatar.png') :
                                                     asset('storage/users/ava/'.$user->ava)}}">
                                            </td>
                                            <td style="vertical-align: middle">
                                                <strong>{{$user->name}}</strong><br>
                                                <a href="mailto:{{$user->email}}">{{$user->email}}</a></td>
                                            <td style="vertical-align: middle;text-transform: uppercase" align="center">
                                                <span class="badge badge-{{$user->status == true ? 'success' :
                                                'warning'}}">{{$user->status == true ? 'Active' : 'Inactive'}}</span>
                                            </td>
                                            <td style="vertical-align: middle" align="center">
                                                {{\Carbon\Carbon::parse($user->created_at)->format('j F Y')}}</td>
                                            <td style="vertical-align: middle"
                                                align="center">{{$user->updated_at->diffForHumans()}}</td>
                                            <td style="vertical-align: middle" align="center">
                                                <button class="btn btn-info" data-toggle="tooltip" title="Details"
                                                        data-placement="left" onclick="openProfile('{{$user->id}}',
                                                        '{{$user->ava}}','{{$user->email}}','{{$user->name}}',
                                                        '{{$user->status}}','{{$user->jk}}','{{$birthday}}',
                                                        '{{$user->no_telp}}','{{$user->alamat}}','{{$user->lat}}',
                                                        '{{$user->long}}','{{$created_at}}','{{$updated_at}}',
                                                        '{{$orders}}','{{$contacts}}','{{$rate}}','{{$comment}}')">
                                                    <i class="fas fa-info-circle"></i>
                                                </button>
                                                @if(Auth::guard('admin')->user()->isRoot())
                                                    <hr class="mt-1 mb-1">
                                                    <a href="{{route('delete.users', ['id' => encrypt($user->id)])}}"
                                                       class="btn btn-danger delete-data" data-toggle="tooltip"
                                                       title="Delete" data-placement="left">
                                                        <i class="fas fa-trash-alt"></i></a>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="modal fade" id="profileModal" tabindex="-1" role="dialog" aria-labelledby="profileModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col">
                            <div class="card profile-widget">
                                <div class="profile-widget-header">
                                    <img id="avatar" alt="avatar" src="#" class="rounded-circle profile-widget-picture">
                                    <div class="profile-widget-items">
                                        <div class="profile-widget-item">
                                            <div class="profile-widget-item-label">Orders</div>
                                            <div class="profile-widget-item-value" id="orders" data-toggle="tooltip"
                                                 title="Order Requested" data-placement="bottom"></div>
                                        </div>
                                        <div class="profile-widget-item">
                                            <div class="profile-widget-item-label">Contacts</div>
                                            <div class="profile-widget-item-value" id="contacts" data-toggle="tooltip"
                                                 title="Questions/Critics Received" data-placement="bottom"></div>
                                        </div>
                                        <div class="profile-widget-item">
                                            <div class="profile-widget-item-label">Feedback</div>
                                            <div class="profile-widget-item-value" id="feedback" style="color: #592f83"
                                                 data-toggle="tooltip" title="Rating Given"
                                                 data-placement="bottom"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="profile-widget-description">
                                    <div class="profile-widget-name"></div>
                                    <table class="mt-0">
                                        <tr data-toggle="tooltip" data-placement="left" title="Email">
                                            <td><i class="fa fa-envelope"></i></td>
                                            <td>&nbsp;</td>
                                            <td id="email"></td>
                                        </tr>
                                        <tr data-toggle="tooltip" data-placement="left" title="Gender">
                                            <td><i class="fa fa-transgender"></i></td>
                                            <td>&nbsp;</td>
                                            <td id="jk" class="text-capitalize"></td>
                                        </tr>
                                        <tr data-toggle="tooltip" data-placement="left" title="Birthday">
                                            <td><i class="fa fa-birthday-cake"></i></td>
                                            <td>&nbsp;</td>
                                            <td id="tgl_lahir"></td>
                                        </tr>
                                        <tr data-toggle="tooltip" data-placement="left" title="Phone">
                                            <td><i class="fa fa-phone"></i></td>
                                            <td>&nbsp;</td>
                                            <td id="no_telp"></td>
                                        </tr>
                                        <tr data-toggle="tooltip" data-placement="left" title="Address">
                                            <td><i class="fa fa-map-marked-alt"></i></td>
                                            <td>&nbsp;</td>
                                            <td id="alamat"></td>
                                        </tr>
                                    </table>
                                    <hr>
                                    <table class="mt-0">
                                        <tr>
                                            <td><i class="fa fa-calendar-check"></i></td>
                                            <td>&nbsp;Member Since</td>
                                            <td id="create"></td>
                                        </tr>
                                        <tr>
                                            <td><i class="fa fa-clock"></i></td>
                                            <td>&nbsp;Last Update</td>
                                            <td id="update"></td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="card-footer pt-0">
                                    <div id="map" class="img-thumbnail" style="width:100%;height: 400px;"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push("scripts")
    <script src="{{asset('admins/modules/datatables/datatables.min.js')}}"></script>
    <script src="{{asset('admins/modules/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js')}}"></script>
    <script src="{{asset('admins/modules/datatables/Select-1.2.4/js/dataTables.select.min.js')}}"></script>
    <script src="{{asset('admins/modules/datatables/Buttons-1.5.6/js/buttons.dataTables.min.js')}}"></script>
    <script src="{{asset('admins/modules/jquery-ui/jquery-ui.min.js')}}"></script>
    <!-- Google Map -->
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBIljHbKjgtTrpZhEiHum734tF1tolxI68&libraries=places"></script>
    <script>
        var google;

        function init(lat, long, name, ava, alamat, no_telp, email) {
            var myLatlng = new google.maps.LatLng(lat, long),
                $alamat = alamat != "" ? alamat :
                    'JL. Dukuh Kupang Timur XX, Kav. 788, Kompleks Diponggo, Pakis, Surabaya — 60265.',
                $no_telp = no_telp != "" ? '<a href="tel:' + no_telp + '">' + no_telp + '</a>' :
                    '<a href="tel:+62315667102">+62 31 566 7102</a>';

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
                '<div class="iw-title">' + name + '</div>' +
                '<div class="iw-content">' +
                '<img class="img-fluid" src="' + ava + '">' +
                '<div class="iw-subTitle">Contacts</div>' +
                '<p>' + $alamat + '<br>' +
                '<br>Phone: ' + $no_telp + '<br>E-mail: <a href="mailto:' + email + '">' + email + '</a>' +
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
            var export_filename = 'Users Table ({{now()->format('j F Y')}})';
            $("#dt-buttons").DataTable({
                dom: "<'row'<'col-sm-12 col-md-3'l><'col-sm-12 col-md-5'B><'col-sm-12 col-md-4'f>>" +
                    "<'row'<'col-sm-12'tr>><'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
                columnDefs: [
                    {"sortable": false, "targets": [1, 6]}
                ],
                buttons: [
                    {
                        text: '<i class="far fa-clipboard mr-2"></i>Copy',
                        extend: 'copy',
                        className: 'btn btn-primary assets-export-btn export-copy ttip'
                    }, {
                        text: '<i class="fa fa-file-csv mr-2"></i>CSV',
                        extend: 'csv',
                        className: 'btn btn-primary assets-export-btn export-csv ttip',
                        title: export_filename,
                        extension: '.csv'
                    }, {
                        text: '<i class="far fa-file-excel mr-2"></i>Excel',
                        extend: 'excel',
                        className: 'btn btn-primary assets-export-btn export-xls ttip',
                        title: export_filename,
                        extension: '.xls'
                    }, {
                        text: '<i class="far fa-file-pdf mr-2"></i>PDF',
                        extend: 'pdf',
                        className: 'btn btn-primary assets-export-btn export-pdf ttip',
                        title: export_filename,
                        extension: '.pdf'
                    }, {
                        text: '<i class="fa fa-print mr-2"></i>Print',
                        extend: 'print',
                        className: 'btn btn-primary assets-select-btn export-print'
                    }
                ],
                fnDrawCallback: function (oSettings) {
                    $('.use-nicescroll').getNiceScroll().resize();
                    $('[data-toggle="tooltip"]').tooltip();
                },
            });
        });

        function openProfile(id, ava, email, name, status, jk, tgl_lahir, no_telp, alamat, lat, long, create, update,
                             orders, contacts, rate, comment) {
            var $path = ava == "" ? '{{asset('images/avatar.png')}}' : '{{asset('storage/users/ava/')}}/' + ava,
                $status = status == false ? 'Inactive' : 'Active',
                $lat = lat != "" ? lat : -7.2900502, $long = long != "" ? long : 112.7201519,
                $orders = orders > 999 ? '999+' : orders, $contacts = contacts > 999 ? '999+' : contacts, $rate = '',
                $comment = comment != "" ? comment : 'Rating Given';

            $("#profileModal .modal-title").text(name.split(/\s+/).slice(0, 1).join(" ") + "'s Profile");
            $("#avatar").attr('src', $path);
            $(".profile-widget-name").html(name + ' <div class="text-muted d-inline font-weight-normal">' +
                '<div class="slash"></div> ' + $status + '</div>');

            $("#orders").text($orders);
            $("#contacts").text($contacts);
            if (rate == 1) {
                $rate =
                    '<i class="fa fa-star"></i>' +
                    '<i class="far fa-star"></i>' +
                    '<i class="far fa-star"></i>' +
                    '<i class="far fa-star"></i>' +
                    '<i class="far fa-star"></i>';
            } else if (rate == 2) {
                $rate =
                    '<i class="fa fa-star"></i>' +
                    '<i class="fa fa-star"></i>' +
                    '<i class="far fa-star"></i>' +
                    '<i class="far fa-star"></i>' +
                    '<i class="far fa-star"></i>'
            } else if (rate == 3) {
                $rate =
                    '<i class="fa fa-star"></i>' +
                    '<i class="fa fa-star"></i>' +
                    '<i class="fa fa-star"></i>' +
                    '<i class="far fa-star"></i>' +
                    '<i class="far fa-star"></i>'
            } else if (rate == 4) {
                $rate =
                    '<i class="fa fa-star"></i>' +
                    '<i class="fa fa-star"></i>' +
                    '<i class="fa fa-star"></i>' +
                    '<i class="fa fa-star"></i>' +
                    '<i class="far fa-star"></i>'
            } else if (rate == 5) {
                $rate =
                    '<i class="fa fa-star"></i>' +
                    '<i class="fa fa-star"></i>' +
                    '<i class="fa fa-star"></i>' +
                    '<i class="fa fa-star"></i>' +
                    '<i class="fa fa-star"></i>'
            } else if (rate == 0.5) {
                $rate =
                    '<i class="fa fa-star-half-alt"></i>' +
                    '<i class="far fa-star"></i>' +
                    '<i class="far fa-star"></i>' +
                    '<i class="far fa-star"></i>' +
                    '<i class="far fa-star"></i>'
            } else if (rate == 1.5) {
                $rate =
                    '<i class="fa fa-star"></i>' +
                    '<i class="fa fa-star-half-alt"></i>' +
                    '<i class="far fa-star"></i>' +
                    '<i class="far fa-star"></i>' +
                    '<i class="far fa-star"></i>'
            } else if (rate == 2.5) {
                $rate =
                    '<i class="fa fa-star"></i>' +
                    '<i class="fa fa-star"></i>' +
                    '<i class="fa fa-star-half-alt"></i>' +
                    '<i class="far fa-star"></i>' +
                    '<i class="far fa-star"></i>'
            } else if (rate == 3.5) {
                $rate =
                    '<i class="fa fa-star"></i>' +
                    '<i class="fa fa-star"></i>' +
                    '<i class="fa fa-star"></i>' +
                    '<i class="fa fa-star-half-alt"></i>' +
                    '<i class="far fa-star"></i>'
            } else if (rate == 4.5) {
                $rate =
                    '<i class="fa fa-star"></i>' +
                    '<i class="fa fa-star"></i>' +
                    '<i class="fa fa-star"></i>' +
                    '<i class="fa fa-star"></i>' +
                    '<i class="fa fa-star-half-alt"></i>'
            } else {
                $rate =
                    '<i class="far fa-star"></i>' +
                    '<i class="far fa-star"></i>' +
                    '<i class="far fa-star"></i>' +
                    '<i class="far fa-star"></i>' +
                    '<i class="far fa-star"></i>'
            }
            $("#feedback").html($rate).attr('data-original-title', $comment).tooltip('show');

            $("#email").html('<a href="mailto:' + email + '">' + email + '</a>');
            $("#jk").text(jk != "" ? jk : '&ndash;');
            $("#tgl_lahir").text(tgl_lahir);
            $("#no_telp").html(no_telp != "" ? '<a href="tel:' + no_telp + '">' + no_telp + '</a>' : '&ndash;');
            $("#alamat").text(alamat != "" ? alamat : '&ndash;');
            $("#create").text(': ' + create);
            $("#update").text(': ' + update);

            init($lat, $long, name, $path, alamat, no_telp, email);
            $("#profileModal").modal('show');
        }
    </script>
@endpush