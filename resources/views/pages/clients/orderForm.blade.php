@extends('layouts.mst_user')
@section('title', ''.ucwords($layanan->getJenisLayanan->nama).' Service: '.ucwords($layanan->paket).' Order | Rabbit Media – Digital Creative Service')
@push('styles')
    <link href="{{asset('css/myMultiStepForm.css')}}" rel="stylesheet">
    <link href="{{asset('css/cc.css')}}" rel="stylesheet">
    <link href="{{asset('css/myMaps.css')}}" rel="stylesheet">
    <link href="{{asset('css/myTags.css')}}" rel="stylesheet">
    <link href="{{asset('admins/modules/fullcalendar/packages/core/main.css')}}" rel="stylesheet">
    <link href="{{asset('admins/modules/fullcalendar/packages/daygrid/main.css')}}" rel="stylesheet">
    <link href="{{asset('admins/modules/fullcalendar/packages/timegrid/main.css')}}" rel="stylesheet">
    <link href="{{asset('admins/modules/fullcalendar/packages/list/main.css')}}" rel="stylesheet">
    <link href="{{asset('admins/modules/fullcalendar/packages/bootstrap/main.css')}}" rel="stylesheet">
    <style>
        .fc-toolbar button {
            text-transform: capitalize;
        }
    </style>
@endpush
@section('content')
    <div class="site-section">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-md-7">
                    <div class="row mb-5">
                        <div class="col-12">
                            <h3 class="site-section-heading text-center" data-aos="fade-right">Order Process</h3>
                            <h5 class="text-center" data-aos="fade-left" id="order_caption">Sebelum menuju ke langkah
                                berikutnya, harap isi semua kolom formulir dengan data yang valid.</h5>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center" id="order-process">
                <div class="col-11">
                    <div class="msform">
                        <ul id="progressbar" class="text-center" data-aos="zoom-in-up">
                            <li class="active">Booking Setup</li>
                            <li>Request Setup</li>
                            <li>Order Summary</li>
                            <li>Payment Method</li>
                        </ul>
                        <form action="{{route('submit.order')}}" method="post" id="form-order" data-aos="fade-down">
                            {{csrf_field()}}
                            <fieldset id="booking_setup">
                                <div class="row form-group text-center">
                                    <div class="col">
                                        <h2 class="fs-title" data-aos="fade-right">Booking Setup</h2>
                                        <h3 class="fs-subtitle" data-aos="fade-left">Pastikan tanggal dan
                                            waktu yang Anda tentukan sudah benar!</h3>
                                    </div>
                                </div>
                                <div class="row" data-aos="zoom-out">
                                    <div class="col">
                                        <div id="calendar"></div>
                                    </div>
                                </div>
                                <hr class="mb-0" data-aos="fade-right">
                                <input type="button" name="next" class="next action-button" value="Next"
                                       style="display: table">
                            </fieldset>
                            <fieldset id="request_setup">
                                <div class="row form-group text-center">
                                    <div class="col">
                                        <h2 class="fs-title" data-aos="fade-right">Request Setup</h2>
                                        <h3 class="fs-subtitle" data-aos="fade-left">Berikan informasi yang lebih rinci
                                            mengenai permintaan Anda!<br>
                                            Apabila Anda perlu meeting dengan Rabbits, silahkan tentukan lokasinya.</h3>
                                    </div>
                                </div>
                                <div class="row" data-aos="zoom-out">
                                    <div class="col">
                                        <div class="row form-group">
                                            <div class="col">
                                                <div id="map" class="img-thumbnail"
                                                     style="width:100%;height: 525px;"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col">
                                        @if($layanan->isHours == true)
                                            <div class="row form-group">
                                                <div class="col">
                                                    <label class="control-label mb-0" for="hours">Duration (hours)
                                                    </label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text">
                                                                <i class="fa fa-stopwatch"></i></span>
                                                        </div>
                                                        <input id="hours" placeholder="Total durasi (jam)" type="number"
                                                               value="{{$layanan->hours}}" class="form-control"
                                                               name="hours" min="{{$layanan->hours}}" readonly required>
                                                        <div class="input-group-append">
                                                            <span class="input-group-text">jam</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                        @if($layanan->isQty == true)
                                            <div class="row form-group">
                                                <div class="col">
                                                    <label class="control-label mb-0" for="qty">Qty. (person/product)
                                                    </label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text">
                                                                <i class="fa fa-users"></i></span>
                                                        </div>
                                                        <input id="qty" placeholder="Total item (orang/produk)"
                                                               type="number" value="{{$layanan->qty}}" name="qty"
                                                               class="form-control" min="{{$layanan->qty}}" required>
                                                        <div class="input-group-append">
                                                            <span class="input-group-text">item</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                        @if($layanan->isStudio == true)
                                            <div class="row form-group fix-label-group" id="studio_errDiv">
                                                <div class="col">
                                                    <label class="control-label mb-0" for="studio">Studio</label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text fix-label-item">
                                                                <i class="fa fa-door-open"></i></span>
                                                        </div>
                                                        <select id="studio" class="form-control selectpicker"
                                                                title="-- Pilih Studio --" name="studio" required
                                                                data-live-search="true">
                                                            @foreach($types as $type)
                                                                <optgroup label="{{ucwords($type->nama)}}">
                                                                    @foreach($type->getStudio as $row)
                                                                        <option data-subtext="Rp{{number_format
                                                                        ($row->harga,0,',','.')}}/jam"
                                                                                value="{{$row->id}}">{{$row->nama}}
                                                                        </option>
                                                                    @endforeach
                                                                </optgroup>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <span class="invalid-feedback">
                                                        <strong id="studio_errTxt"
                                                                style="text-transform: none"></strong></span>
                                                </div>
                                            </div>
                                        @endif
                                        <div class="row form-group">
                                            <div class="col">
                                                <label class="control-label mb-0" for="address_map">Meeting Location
                                                    <sub>(optional)</sub></label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                            <span class="input-group-text">
                                                                <i class="fa fa-map-marked-alt"></i></span>
                                                    </div>
                                                    <textarea style="resize:vertical" name="meeting_location"
                                                              id="address_map" class="form-control" rows="2"
                                                              placeholder="Tulis lokasi meeting disini&hellip;"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row form-group">
                                            <div class="col">
                                                <label class="control-label mb-0" for="deskripsi">Additional Info
                                                    <sub>(optional)</sub></label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">
                                                            <i class="fa fa-comments"></i></span>
                                                    </div>
                                                    <textarea style="resize:vertical" rows="5" name="deskripsi"
                                                              id="deskripsi" class="form-control"
                                                              placeholder="Ceritakan sedikit lebih rinci mengenai permintaan Anda&hellip;"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <hr class="mt-0" data-aos="fade-left">
                                <input type="button" name="previous" class="previous action-button" value="Previous"
                                       data-aos="fade-right">
                                <input type="button" name="next" class="next action-button" value="Next"
                                       data-aos="fade-left">
                            </fieldset>
                            <fieldset id="order_summary">
                                <h2 class="fs-title text-center" data-aos="fade-right">Order Summary</h2>
                                <h3 class="fs-subtitle text-center" data-aos="fade-left">Pastikan pesanan Anda sudah
                                    benar!</h3>
                                <div class="row" data-aos="zoom-out">
                                    <div class="col-xl-7 col-lg-7 col-md-6 col-sm-12">
                                        <strong>Service Details</strong>
                                        <hr class="mt-0 mb-2">
                                        <ul class="list-inline">
                                            <li class="list-inline-item">
                                                <a class="tag tag-plans">
                                                    <i class="fa fa-thumbtack mr-2"></i>
                                                    <span class="plans_name mr-2"
                                                          style="font-weight: 600">{{$layanan->paket}}</span>|
                                                    <i class='fa fa-money-bill-wave ml-2'></i>
                                                    <span class="ml-2" style="font-weight: 600">{{'Rp'.number_format
                                                    ($price,2,',','.')}}</span></a>
                                            </li>
                                            @if($layanan->isHours == true)
                                                <li class="list-inline-item">
                                                    <a class="tag tag-plans">
                                                        <i class='fa fa-stopwatch mr-2'></i>Durasi max. <span
                                                                style="font-weight: 600">{{$layanan->hours}}</span>
                                                        (over time <span style="font-weight: 600">+Rp{{number_format
                                                        ($layanan->price_per_hours,2,',','.')}}/jam</span>)</a>
                                                </li>
                                            @endif
                                            @if($layanan->isQty == true)
                                                <li class="list-inline-item">
                                                    <a class="tag tag-plans">
                                                        <i class='fa fa-users mr-2'></i>Total item (orang/produk) max.
                                                        <span style="font-weight: 600">{{$layanan->qty}}</span> (over
                                                        item <span style="font-weight: 600">+Rp{{number_format
                                                        ($layanan->price_per_qty,2,',','.')}}/item</span>)</a>
                                                </li>
                                            @endif
                                            @if($layanan->isStudio == true)
                                                <li class="list-inline-item">
                                                    <a class="tag tag-plans"><i class='fa fa-door-open mr-2'></i>
                                                        Studio opsional (harga <span style="font-weight: 600;">belum
                                                        </span> termasuk studio)</a></li>
                                            @endif
                                        </ul>
                                    </div>
                                    <div class="col-xl-5 col-lg-5 col-md-6 col-sm-12">
                                        <strong>Billing Details</strong>
                                        <hr class="mt-0">
                                        <table id="stats-billing" style="font-size: 16px">
                                            <tr data-placement="left" data-toggle="tooltip" title="Nama paket">
                                                <td>
                                                    <strong class="plans_name">{{$layanan->paket}}</strong>
                                                </td>
                                                <td align="center"><strong class="plans_qty">1</strong></td>
                                                <td>&emsp;</td>
                                                <td colspan="2" align="right">
                                                    <strong class="plan_price">Rp{{number_format($price,2,',','.')}}
                                                    </strong>
                                                </td>
                                            </tr>
                                            @if($layanan->isHours == true)
                                                <tr data-placement="left" data-toggle="tooltip" title="Total durasi">
                                                    <td>Hours</td>
                                                    <td align="center">
                                                        <strong class="bill_hours">{{$layanan->hours}}</strong>
                                                    </td>
                                                    <td>&emsp;</td>
                                                    <td colspan="2" align="right">
                                                        <strong class="total_price_hours">Rp{{number_format(0,2,',','.')}}</strong>
                                                    </td>
                                                </tr>
                                            @endif
                                            @if($layanan->isQty == true)
                                                <tr data-placement="left" data-toggle="tooltip" title="Total item">
                                                    <td>Qty.</td>
                                                    <td align="center">
                                                        <strong class="bill_qty">{{$layanan->qty}}</strong></td>
                                                    <td>&emsp;</td>
                                                    <td colspan="2" align="right">
                                                        <strong class="total_price_qty">Rp{{number_format(0,2,',','.')}}</strong>
                                                    </td>
                                                </tr>
                                            @endif
                                            @if($layanan->isStudio == true)
                                                <tr data-placement="left" data-toggle="tooltip" title="Nama studio">
                                                    <td><strong class="nama_studio">Adventure Studio</strong></td>
                                                    <td align="center"><strong class="plans_qty">1</strong></td>
                                                    <td>&emsp;</td>
                                                    <td colspan="2" align="right">
                                                        <strong class="total_price_studio">Rp{{number_format(0,2,',','.')}}</strong>
                                                    </td>
                                                </tr>
                                            @endif
                                            <tr style="border-top: 1px solid #eee">
                                                <td><strong>TOTAL</strong></td>
                                                <td colspan="4" align="right">
                                                    <strong class="total"
                                                            style="font-size: 18px;color: #592f83">Rp{{number_format(0,2,',','.')}}</strong>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                                <div class="row" data-aos="zoom-out">
                                    <div class="col">
                                        <strong>Order Details</strong>
                                        <hr class="mt-0 mb-2">
                                        <ul class="list-inline">
                                            <li class="list-inline-item">
                                                <a class="tag"><i class="fa fa-text-width mr-2"></i>
                                                    <span id="booking_title"></span></a></li>
                                            <li class="list-inline-item">
                                                <a class="tag"><i class="fa fa-calendar-alt mr-2"></i>
                                                    <span id="booking_date"></span></a></li>
                                            @if($layanan->isHours == true)
                                                <li class="list-inline-item">
                                                    <a class="tag"><i class='fa fa-stopwatch mr-2'></i>
                                                        <span id="booking_hours"></span></a></li>
                                            @endif
                                            @if($layanan->isQty == true)
                                                <li class="list-inline-item">
                                                    <a class="tag"><i class='fa fa-users mr-2'></i>
                                                        <span id="booking_qty"></span></a></li>
                                            @endif
                                            @if($layanan->isStudio == true)
                                                <li class="list-inline-item">
                                                    <a class="tag"><i class='fa fa-door-open mr-2'></i>
                                                        <span id="booking_studio"></span></a></li>
                                            @endif
                                            <li class="list-inline-item">
                                                <a class="tag"><i class="fa fa-map-marked-alt mr-2"></i>
                                                    <span id="booking_location"></span></a></li>
                                            <li class="list-inline-item">
                                                <a class="tag"><i class="fa fa-comments mr-2"></i>
                                                    <span id="booking_desc"></span></a></li>
                                        </ul>
                                    </div>
                                </div>
                                <hr class="mt-0" data-aos="fade-right">
                                <input type="button" name="previous" class="previous action-button" value="Previous"
                                       data-aos="fade-right">
                                <input type="button" name="next" class="next action-button" value="Next"
                                       data-aos="fade-left">
                            </fieldset>
                            <fieldset id="payment_method">
                                <h2 class="fs-title text-center" data-aos="fade-right">Payment Method</h2>
                                <h3 class="fs-subtitle text-center" data-aos="fade-left">Silahkan pilih metode
                                    pembayaran yang Anda inginkan!</h3>
                                <hr class="mt-0 mb-0" data-aos="fade-down">
                                <div class="panel-group accordion mb-3">
                                    @foreach($paymentCategories as $row)
                                        <div class="panel" data-aos="zoom-out">
                                            <div class="panel-heading">
                                                <h4 class="panel-title mb-0">
                                                    @if($row->id == 1 || $row->id == 5)
                                                        <a class="accordion-toggle collapsed" href="javascript:void(0)"
                                                           data-toggle="collapse" data-target="#pc-{{$row->id}}"
                                                           aria-expanded="true" aria-controls="pc-{{$row->id}}"
                                                           onclick="paymentCategory('{{$row->id}}','{{$row->name}}')">
                                                            {{$row->name}} <sub>{{$row->caption}}</sub></a>
                                                    @else
                                                        <a class="accordion-toggle collapsed" href="javascript:void(0)"
                                                           onclick="paymentCategory('{{$row->id}}','{{$row->name}}')">
                                                            {{$row->name}} <sub>{{$row->caption}}</sub></a>
                                                    @endif
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
                                                                <div class="col">
                                                                    <div class="cc-wrapper"></div>
                                                                </div>
                                                            </div>
                                                            <div class="row form-group">
                                                                <div class="col">
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
                                                                <div class="col">
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
                                                                <div class="col">
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
                                                                <div class="col">
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
                                                                <div class="col">
                                                                    <div class="alert alert-info text-center"
                                                                         role="alert"
                                                                         style="font-size: 13px">
                                                                        Kartu kredit Anda akan dikenai biaya <strong
                                                                                class="total"></strong>.
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
                                        <hr class="m-0" data-aos="fade-down" style="margin-bottom: 0">
                                    @endforeach
                                </div>
                                <input type="button" name="previous" class="previous action-button" value="Previous"
                                       data-aos="fade-right">
                                <input type="submit" class="submit action-button" value="Submit" data-aos="fade-left">
                            </fieldset>
                            <input type="hidden" name="layanan_id" value="{{$layanan->id}}">
                            <input type="hidden" id="judul" name="judul">
                            <input type="hidden" id="start" name="start">
                            <input type="hidden" id="end" name="end">
                            <input type="hidden" id="payment_code" name="payment_code">
                            <input type="hidden" id="total_payment" name="total_payment">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="bookModal" tabindex="-1" role="dialog" aria-labelledby="bookModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="bookModalLabel">Booking Setup</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form id="form-book">
                    <div class="modal-body">
                        <div class="row form-group" id="dtp_errDiv">
                            <div class="col">
                                <label class="control-label mb-0" for="start">Start Date</label>
                                <div class="input-group date" id="dtp_start" data-target-input="nearest">
                                    <div class="input-group-prepend" data-target="#dtp_start"
                                         data-toggle="datetimepicker">
                                        <div class="input-group-text"><i class="fa fa-calendar-alt"></i></div>
                                    </div>
                                    <input type="text" class="form-control datetimepicker-input"
                                           data-target="#dtp_start" data-toggle="datetimepicker"
                                           placeholder="yyyy-mm-dd hh:mm:ss" required>
                                </div>
                            </div>
                            <div class="col" id="end_errDiv">
                                <label class="control-label mb-0" for="end">End Date</label>
                                <div class="input-group date" id="dtp_end" data-target-input="nearest">
                                    <input type="text" class="form-control datetimepicker-input" data-target="#dtp_end"
                                           data-toggle="datetimepicker" placeholder="yyyy-mm-dd hh:mm:ss" required>
                                    <div class="input-group-append" data-target="#dtp_end" data-toggle="datetimepicker">
                                        <div class="input-group-text"><i class="fa fa-calendar-check"></i></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row form-group" style="display: none">
                            <div class="col">
                                <span class="invalid-feedback"><strong id="dtp_errTxt"
                                                                       style="text-transform: none"></strong></span>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col">
                                <label class="control-label mb-0" for="judul">Title</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa fa-text-width"></i></span>
                                    </div>
                                    <input id="dtp_judul" class="form-control" type="text"
                                           placeholder="Tulis judul permintaan Anda disini&hellip;" required>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" id="btnAbort_book" style="display: none">Delete
                        </button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary add" id="btnSubmit_book">Booking</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script src="{{asset('js/jquery.easing.1.3.js')}}"></script>
    <script src="{{asset('js/jquery.cc.js')}}"></script>
    <script src="{{asset('admins/modules/fullcalendar/packages/core/main.js')}}"></script>
    <script src="{{asset('admins/modules/fullcalendar/packages/interaction/main.js')}}"></script>
    <script src="{{asset('admins/modules/fullcalendar/packages/daygrid/main.js')}}"></script>
    <script src="{{asset('admins/modules/fullcalendar/packages/timegrid/main.js')}}"></script>
    <script src="{{asset('admins/modules/fullcalendar/packages/list/main.js')}}"></script>
    <script src="{{asset('admins/modules/fullcalendar/packages/core/locales-all.js')}}"></script>
    <script src="{{asset('admins/modules/fullcalendar/packages/bootstrap/main.js')}}"></script>
    <!-- Google Map -->
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBIljHbKjgtTrpZhEiHum734tF1tolxI68&libraries=places"></script>
    <script>
        // gmaps meeting location
        var google, total_event = 0, total_plan = 0;

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

        // fullcalendar
        document.addEventListener('DOMContentLoaded', function () {
            var $div = document.getElementById('calendar'), start = $('#dtp_start'), end = $('#dtp_end'), findBook,
                fc = new FullCalendar.Calendar($div, {
                    plugins: ['dayGrid', 'timeGrid', 'list', 'interaction', 'bootstrap'],
                    themeSystem: 'bootstrap',
                    locale: 'id',
                    header: {
                        left: 'prev,next today',
                        center: 'title',
                        right: 'dayGridMonth,timeGridWeek,timeGridDay,listMonth'
                    },
                    defaultDate: '{{now()->format('Y-m-d')}}',
                    validRange: {
                        start: '{{now()->format('Y-m-d')}}',
                    },
                    defaultView: 'timeGridWeek',
                    navLinks: true,
                    displayEventTime: true,
                    displayEventEnd: true,
                    nowIndicator: true,
                    selectable: true,
                    selectMirror: true,
                    eventLimit: true,
                    businessHours: [
                        {
                            daysOfWeek: [0, 1, 2, 3, 4, 5, 6],
                            startTime: '07:00',
                            endTime: '23:00'
                        }
                    ],
                    events: [
                            @foreach($booked as $row)
                        {
                            id: '{{$row->id}}',
                            groupId: 'booked',
                            title: '{{$row->getPemesanan->judul}}',
                            start: '{{$row->getPemesanan->start}}',
                            end: '{{$row->getPemesanan->end}}',
                            description: '{{$row->getPemesanan->deskripsi}}',
                            color: '#17a2b8'
                        },
                            @endforeach
                            @foreach($holidays as $row)
                        {
                            id: '{{$row->id}}',
                            groupId: 'unavailable',
                            title: '{{$row->judul}}',
                            start: '{{$row->start}}',
                            end: '{{$row->end}}',
                            description: '{{$row->deskripsi}}',
                            color: '#f23a2e',
                        },
                        {
                            start: '{{\Carbon\Carbon::parse($row->start)->format('Y-m-d')}}',
                            end: '{{\Carbon\Carbon::parse($row->end)->format('Y-m-d')}}',
                            overlap: false,
                            rendering: 'background',
                            color: '#ff9f89',
                        },
                        @endforeach
                    ],
                    select: function (info) {
                        if (total_event < 1) {
                            $("#bookModalLabel").text('Booking Setup');
                            $('#dtp_start input').val(moment(info.start).format('YYYY-MM-DD') + ' 07:00:00');
                            $('#dtp_end input').val(moment(info.end).format('YYYY-MM-DD') + ' 07:00:00');
                            $('#dtp_judul').val('');
                            $("#btnAbort_book").hide();
                            $("#btnSubmit_book").text('Booking');
                            $('#bookModal').modal('show');
                        } else {
                            swal('PERHATIAN!', 'Anda hanya dapat mem-booking tanggal sekali dalam satu pesanan!', 'warning');
                        }
                    },
                    selectOverlap: function (event) {
                        var $end = moment(event.end).diff(moment(event.start), 'days') >= 1 ?
                            moment(event.end).format('YYYY-MM-DD') : null;

                        if (event.groupId == 'unavailable') {
                            swal('PERHATIAN!', 'Maaf tanggal yang Anda pilih tidak tersedia, ' +
                                'silahkan pilih tanggal lainnya.', 'warning');

                        } else {
                            $("#bookModalLabel").text('Booking Setup');
                            $('#dtp_start input').val(moment(event.start).format('YYYY-MM-DD') + ' 07:00:00');
                            $('#dtp_end input').val($end + ' 07:00:00');
                            $('#dtp_judul').val('');
                            $("#btnAbort_book").hide();
                            $("#btnSubmit_book").text('Booking');
                            $('#bookModal').modal('show');
                        }
                    },
                    eventClick: function (info) {
                        findBook = fc.getEventById(info.event.id);

                        if (info.event.groupId == 'booked' || info.event.groupId == 'unavailable') {
                            swal({
                                title: info.event.title,
                                text: info.event.extendedProps.description,
                                icon: 'info',
                                buttons: {
                                    cancel: 'Close'
                                }
                            });

                        } else {
                            $("#bookModalLabel").text('Booking Edit');
                            $('#dtp_start input').val($("#start").val());
                            $('#dtp_end input').val($("#end").val());
                            $('#dtp_judul').val(info.event.title);
                            $("#btnAbort_book").show();
                            $("#btnSubmit_book").text('Save Changes');
                            $('#bookModal').modal('show');
                        }
                    },
                    eventDrop: function (info) {
                        swal({
                            title: 'Booking Edit',
                            text: 'Apakah Anda sudah yakin dengan perubahan ini?',
                            icon: 'warning',
                            dangerMode: true,
                            buttons: ["Tidak", "Ya"],
                        }).then((confirm) => {
                            if (confirm) {
                                $("#start").val(moment(info.event.start).format('YYYY-MM-DD HH:mm:ss'));
                                $("#end").val(moment(info.event.end).format('YYYY-MM-DD HH:mm:ss'));
                            } else {
                                info.revert();
                            }
                        });
                    },
                    eventResize: function (info) {
                        swal({
                            title: 'Booking Edit',
                            text: 'Apakah Anda sudah yakin dengan perubahan ini?',
                            icon: 'warning',
                            dangerMode: true,
                            buttons: ["Tidak", "Ya"],
                        }).then((confirm) => {
                            if (confirm) {
                                var book_start = $("#start"), book_end = $("#end");
                                book_start.val(moment(info.event.start).format('YYYY-MM-DD HH:mm:ss'));
                                book_end.val(moment(info.event.end).format('YYYY-MM-DD HH:mm:ss'));
                                total_plan = 0;
                                total_plan += moment(book_end.val()).diff(moment(book_start.val()), 'days');
                                $("#hours").val(moment(book_end.val()).diff(moment(book_start.val()), 'hours'));
                            } else {
                                info.revert();
                            }
                        });
                    }
                });

            fc.render();

            $("#calendar .fc-header-toolbar").after(
                '<div class="row" data-aos="fade-right">' +
                '<div class="col text-uppercase">' +
                '<label class="control-label text-capitalize">Keterangan:</label>&ensp;' +
                '<a href="javascript:void(0)" class="badge badge-primary py-1 px-2" style="cursor: default">Pilihan Anda</a>&ensp;' +
                '<a href="javascript:void(0)" class="badge badge-info py-1 px-2" style="cursor: default">Telah Dipesan</a>&ensp;' +
                '<a href="javascript:void(0)" class="badge badge-danger py-1 px-2" style="cursor: default">Libur</a>' +
                '</div></div>'
            );

            $("#dtp_start, #dtp_end").datetimepicker({
                format: 'YYYY-MM-DD HH:mm:00',
                icons: {
                    time: "fa fa-clock",
                    date: "fa fa-calendar-alt",
                    up: "fa fa-chevron-up",
                    down: "fa fa-chevron-down"
                },
                minDate: moment(),
                disabledDates: [
                    @foreach($holidays as $row)
                        "{{\Carbon\Carbon::parse($row->start)->format('m/d/Y')}}",
                    "{{\Carbon\Carbon::parse($row->end)->format('m/d/Y')}}",
                    @endforeach
                ],
                disabledHours: [0, 1, 2, 3, 4, 5, 6],
            });

            start.on("change.datetimepicker", function (e) {
                start.val(e.date);
                if (end.val() != "" && start.val() > end.val()) {
                    $("#dtp_errDiv").addClass('has-danger mb-0');
                    $("#dtp_start input, #dtp_end input").addClass('is-invalid');
                    $("#dtp_errTxt")
                        .html("Nilai <u>start date</u> tidak boleh lebih besar dari nilai <u>end date</u>.")
                        .parent().show().parent().parent().show();
                    $("#btnSubmit_book").attr('disabled', 'disabled');
                } else {
                    $("#dtp_errDiv").removeClass('has-danger mb-0');
                    $("#dtp_start input, #dtp_end input").removeClass('is-invalid');
                    $("#dtp_errTxt").html("").parent().hide().parent().parent().hide();
                    $("#btnSubmit_book").removeAttr('disabled');
                }
            });

            end.on("change.datetimepicker", function (e) {
                end.val(e.date);
                if (start.val() != "" && start.val() > end.val()) {
                    $("#dtp_errDiv").addClass('has-danger mb-0');
                    $("#dtp_start input, #dtp_end input").addClass('is-invalid');
                    $("#dtp_errTxt")
                        .html("Nilai <u>start date</u> tidak boleh lebih besar dari nilai <u>end date</u>.")
                        .parent().show().parent().parent().show();
                    $("#btnSubmit_book").attr('disabled', 'disabled');
                } else {
                    $("#dtp_errDiv").removeClass('has-danger mb-0');
                    $("#dtp_start input, #dtp_end input").removeClass('is-invalid');
                    $("#dtp_errTxt").html("").parent().hide().parent().parent().hide();
                    $("#btnSubmit_book").removeAttr('disabled');
                }
            });

            $("#form-book").on("submit", function (e) {
                e.preventDefault();
                var $judul = $("#dtp_judul").val(), $start = $("#dtp_start input").val(),
                    $end = $("#dtp_end input").val(), book_start = $("#start"), book_end = $("#end");

                if (findBook) {
                    findBook.remove();
                    total_event -= total_event;
                }

                fc.addEvent({
                    id: 'selected',
                    title: $judul,
                    start: $start,
                    end: $end,
                    color: '#592f83',
                    editable: true,
                });
                total_event += 1;

                $("#judul").val($judul);
                book_start.val($start);
                book_end.val($end);

                total_plan = 0;
                total_plan += moment(book_end.val()).diff(moment(book_start.val()), 'days');
                $("#hours").val(moment(book_end.val()).diff(moment(book_start.val()), 'hours'));
                $("#bookModal").modal('hide');
            });

            $("#btnAbort_book").on("click", function () {
                swal({
                    title: 'Booking Abort',
                    text: 'Apakah Anda yakin ingin membatalkan permintaan tersebut? ' +
                        'Anda tidak dapat mengembalikannya!',
                    icon: 'warning',
                    dangerMode: true,
                    buttons: ["Tidak", "Ya"],
                }).then((confirm) => {
                    if (confirm) {
                        findBook.remove();
                        total_event -= total_event;
                        $("#bookModal").modal('hide');
                    }
                });
            });

            $('#bookModal').on('hidden.bs.modal', function () {
                fc.unselect()
            });
        });

        $("#booking_setup .next").on('click', function () {
            if (!$("#start, #end, #judul").val() || total_event < 1) {
                swal('PERHATIAN!', 'Anda belum menentukan tanggal dan waktu!', 'warning');
                $("#request_setup .previous").click();
            }

            setTimeout(function () {
                $('.use-nicescroll').getNiceScroll().resize()
            }, 600);
        });

        var isQty = '{{$layanan->isQty}}', isHours = '{{$layanan->isHours}}', isStudio = '{{$layanan->isStudio}}',
            qty = '{{$layanan->qty}}', hours = '{{$layanan->hours}}', plan_price = '{{$price}}', price_total_plan = 0,
            total = 0, payment_code_value = 0, price_per_studio = 0, price_total_studio = 0,

            total_qty = 0,
            old_total_qty = '{{$layanan->qty}}',
            price_per_qty = '{{$layanan->price_per_qty}}', price_total_qty = 0,

            total_hours = 0,
            old_total_hours = '{{$layanan->hours}}',
            price_per_hours = '{{$layanan->price_per_hours}}', price_total_hours = 0;

        $("#hours").on('blur', function () {
            if ($(this).val() < parseInt(old_total_hours)) {
                $(this).val(old_total_hours);
            }
        });

        $("#qty").on('blur', function () {
            if ($(this).val() < parseInt(old_total_qty)) {
                $(this).val(old_total_qty);
            }
        });

        $("#studio").on("change", function () {
            $.get('{{route('get.detail.studio', ['id' => ''])}}/' + $(this).val(), function (data) {
                $("#studio_errDiv").removeClass('has-danger');
                $("#studio_errTxt").text('').parent().hide();
                $("#studio").parent().find('button').css('border', '1px solid #ced4da');
                $(".nama_studio").text(data.nama);
                price_per_studio = data.harga;

                $("#booking_studio").html('Studio ' + data.jenis_id + ': ' +
                    '<span class="mr-2" style="font-weight: 600">' + data.nama + '</span>|' +
                    '<i class="fa fa-money-bill-wave ml-2"></i><span class="ml-2" style="font-weight: 600">' +
                    'Rp' + thousandSeparator(parseInt(data.harga)) + '/jam</span>');
            });
        });

        function totalPlan() {
            price_total_plan = 0;
            if (parseInt(total_plan - 1) > 0) {
                $(".plans_qty").text(1 + '(+' + parseInt(total_plan - 1) + ')');
                $(".plan_price").text('Rp' + thousandSeparator(parseInt((total_plan - 1) * plan_price) + parseInt(plan_price)) + ',00');
            } else {
                $(".plans_qty").text(1);
                $(".plan_price").text('Rp' + thousandSeparator(parseInt(plan_price) + ',00'));
            }
        }

        function totalHours() {
            price_total_hours = 0;
            total_hours = $("#hours").val();

            if (parseInt(total_hours - old_total_hours) >= 0) {
                $(".bill_hours").text(old_total_hours + '(+' + parseInt(total_hours - old_total_hours) + ')');
                $(".total_price_hours").text('Rp' +
                    thousandSeparator(parseInt((total_hours - old_total_hours) * price_per_hours)) + ',00');
            } else {
                $(".bill_hours").text(old_total_hours);
                $(".total_price_hours").text('Rp0,00');
            }
        }

        function totalQty() {
            price_total_qty = 0;
            total_qty = $("#qty").val();

            if (parseInt(total_qty - old_total_qty) >= 0) {
                $(".bill_qty").text(old_total_qty + '(+' + parseInt(total_qty - old_total_qty) + ')');
                $(".total_price_qty").text('Rp' +
                    thousandSeparator(parseInt((total_qty - old_total_qty) * price_per_qty)) + ',00');
            } else {
                $(".bill_qty").text(old_total_qty);
                $(".total_price_qty").text('Rp0,00');
            }
        }

        function totalStudio() {
            price_total_studio = 0;
            if (parseInt(total_plan - 1) > 0) {
                $(".bill_studio").text(1 + '(+' + parseInt(total_plan - 1) + ')');
                $(".total_price_studio").text('Rp' +
                    thousandSeparator(parseInt((total_plan - 1) * price_per_studio) + parseInt(price_per_studio)) + ',00');
            } else {
                $(".bill_studio").text(1);
                $(".total_price_studio").text('Rp' + thousandSeparator(parseInt(price_per_studio) + ',00'));
            }
        }

        function totalOrder() {
            total = 0;
            totalPlan();
            price_total_plan = parseInt(total_plan - 1) > 0 ?
                parseInt((total_plan - 1) * plan_price) + parseInt(plan_price) : parseInt(plan_price);

            if (isHours == 1) {
                totalHours();
                price_total_hours = parseInt(total_hours - old_total_hours) > 0 ?
                    parseInt((total_hours - old_total_hours) * price_per_hours) : 0;
            }
            if (isQty == 1) {
                totalQty();
                price_total_qty = parseInt(total_qty - old_total_qty) > 0 ?
                    parseInt((total_qty - old_total_qty) * price_per_qty) : 0;
            }
            if (isStudio == 1) {
                totalStudio();
                price_total_studio = parseInt(total_plan - 1) > 0 ?
                    parseInt((total_plan - 1) * price_per_studio) + parseInt(price_per_studio) : price_per_studio;
            }

            total += parseInt(price_total_plan + price_total_hours + price_total_qty + price_total_studio);
            $(".total").text("Rp" + thousandSeparator(total) + ",00");
        }

        $("#request_setup .next").on('click', function () {
            var studio = $("#studio");
            if (isStudio == 1 && !studio.val()) {
                $("#studio_errDiv").addClass('has-danger');
                $("#studio_errTxt").text('Anda belum memilih studio!').parent().show();
                studio.parent().find('button').css('border', '1px solid #fa5555');
                $("#order_summary .previous").click();

            } else {
                $("#studio_errDiv").removeClass('has-danger');
                $("#studio_errTxt").text('').parent().hide();
                studio.parent().find('button').css('border', '1px solid #ced4da');
                totalOrder();


                $("#booking_date").html('Tanggal Booking: <span style="font-weight: 600">' + moment($("#start").val()).format('D MMMM YYYY [at] HH:mm') + '</span> &mdash; <span style="font-weight: 600">' + moment($("#end").val()).format('D MMMM YYYY [at] HH:mm') + '</span>');

                $("#booking_title").html('Judul: <span style="font-weight: 600">' + $("#judul").val() + '</span>');
                $("#booking_hours").html('Total durasi: <span style="font-weight: 600">' + $("#hours").val() + '</span> jam');
                $("#booking_qty").html('Total item: <span style="font-weight: 600">' + $("#qty").val() + '</span> item');

                if (!$("#address_map").val()) {
                    $("#booking_location").parent().parent().hide();
                } else {
                    $("#booking_location")
                        .html('Lokasi Meeting: <span style="font-weight: 600">' + $("#address_map").val() + '</span>');
                }

                if (!$("#deskripsi").val()) {
                    $("#booking_desc").parent().parent().hide();
                } else {
                    $("#booking_desc").text('Informasi Tambahan: ' + $("#deskripsi").val());
                }
            }

            setTimeout(function () {
                $('.use-nicescroll').getNiceScroll().resize()
            }, 600);
        });

        $("#order_summary .next").on('click', function () {
            $("#order_caption").text('Mohon untuk tidak melakukan pembayaran apapun sebelum kami mengirimkan tagihannya (invoice) melalui email Anda!');
        });

        function paymentCategory(id, nama) {
            var $pm_1 = $("#pm-details-1"), $pm_2 = $("#pm-details-2"), $pm_3 = $("#pm-11"),
                $pm_4 = $("#pm-details-4"), $pm_5 = $("#pm-details-5"), $payment_code = $("#payment_code");

            $pm_1.html("");
            $pm_2.html("");
            $pm_4.html("");
            $pm_5.html("");
            payment_code_value = 0;

            $(".pm-radioButton").prop("checked", false).trigger('change');
            $pm_3.prop("checked", false).trigger('change');

            $("#cc_number, #cc_name, #cc_expiry, #cc_cvc").val("").removeAttr('required');
            $(".jp-card").attr("class", "jp-card jp-card-unknown");
            $(".jp-card-number").html("•••• •••• •••• ••••");
            $(".jp-card-name").html("Your Name");
            $(".jp-card-expiry").html("MM/YYYY");
            $(".jp-card-cvc").html("•••");
            $payment_code.val(0);

            if (id != 1 || id != 5) {
                swal('Coming Soon!', 'Metode pembayaran ' + nama + ' masih dalam proses pengembangan. ' +
                    'Mohon maaf atas ketidaknyamanannya, terimakasih.', 'warning');

            } /*else if (id == 1) {
                $pm_1.html(
                    '<div class="row">' +
                    '<div class="col">' +
                    '<div class="alert alert-info text-center" role="alert" style="font-size: 14px">' +
                    'Anda akan segera menerima sebuah email mengenai rincian pembayaran setelah Anda menyelesaikan langkah ini.' +
                    '</div></div></div>'
                );
                payment_code_value = Math.floor(Math.random() * (999 - 100 + 1) + 100);
                $payment_code.val(payment_code_value);

            } else if (id == 3) {
                $("#pm-11").prop("checked", true).trigger('change');
                $("#cc_number, #cc_name, #cc_expiry, #cc_cvc").attr("required", "required");

            } else if (id == 4) {
                $pm_4.html(
                    '<div class="row">' +
                    '<div class="col">' +
                    '<div class="alert alert-info text-center" role="alert" style="font-size: 13px">' +
                    'Anda akan segera menerima sebuah email mengenai rincian pembayaran setelah Anda ' +
                    'menyelesaikan langkah ini.</div></div></div>'
                );
                $payment_code.val('str_random(15)');
            }*/

            setTimeout(function () {
                $('.use-nicescroll').getNiceScroll().resize()
            }, 600);
        }

        function paymentMethod(id) {
            $.get('{{route('get.paymentMethod',['id'=>''])}}/' + id, function (data) {
                if (data.payment_category_id == 1) {
                    $("#pm-details-1").html(
                        '<div class="row">' +
                        '<div class="col">' +
                        '<div class="alert alert-info text-center" role="alert">' +
                        '<span style="font-weight: 600">' + data.name + '</span> account number: ' +
                        '<span style="font-weight: 600">' + data.account_number + '</span> ' +
                        '(a/n <span style="font-weight: 600;text-transform: capitalize">' + data.account_name + '</span>)' +
                        '</div></div></div>'
                    );

                } else if (data.payment_category_id == 5) {
                    $("#pm-details-5").html(
                        '<div class="row">' +
                        '<div class="col">' +
                        '<div class="alert alert-info text-center" role="alert">' +
                        'Ketika Anda melakukan pembayaran dengan metode ini maka Anda akan dialihkan ke halaman ' +
                        '<strong>' + data.name + '</strong>.</div></div></div>'
                    );
                }
            });

            setTimeout(function () {
                $('.use-nicescroll').getNiceScroll().resize()
            }, 600);
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

        $(".next").on('click', function () {
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
                complete: function () {
                    current_fs.hide();
                    animating = false;
                },
                easing: 'easeInOutBack'
            });

            setTimeout(function () {
                $('.use-nicescroll').getNiceScroll().resize()
            }, 600);
        });

        $(".previous").on('click', function () {
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
                complete: function () {
                    current_fs.hide();
                    animating = false;
                },
                easing: 'easeInOutBack'
            });

            $("#order_caption")
                .text('Sebelum menuju ke langkah berikutnya, harap isi semua kolom formulir dengan data yang valid.');
            setTimeout(function () {
                $('.use-nicescroll').getNiceScroll().resize()
            }, 600);
        });

        $("#form-order").on('submit', function (e) {
            e.preventDefault();
            if ($(".pm-radioButton").is(":checked") || ($("#pm-11").is(":checked") &&
                $("#cc_number,#cc_name,#cc_expiry,#cc_cvc").val())) {

                swal({
                    title: 'Apakah anda yakin?',
                    text: 'Kami akan segera memproses permintaan Anda sesaat setelah Anda menekan tombol "Ya" berikut. ' +
                        'Dan mohon untuk tidak melakukan pembayaran apapun sebelum Anda menerima invoice yang akan ' +
                        'kami kirimkan melalui email!',
                    icon: 'warning',
                    dangerMode: true,
                    buttons: ["Tidak", "Ya"],
                }).then((confirm) => {
                    if (confirm) {
                        $("#total_payment").val(parseInt(total) - parseInt(payment_code_value));
                        swal({icon: "success", text: 'Anda akan dialihkan ke halaman Order Status.', buttons: false});
                        $(this)[0].submit();
                    }
                });

            } else {
                swal('PERHATIAN!', 'Anda belum memilih metode pembayaran!', 'warning');
            }

            $('html, body').animate({
                scrollTop: $('#order-process').offset().top
            }, 500);
        });

        $(window).on('beforeunload', function () {
            return "You have attempted to leave this page. Are you sure?";
        });
    </script>
@endpush