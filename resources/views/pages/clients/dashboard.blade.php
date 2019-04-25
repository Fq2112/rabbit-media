@section('title', ''.$user->name.'\'s Dashboard: Order Status | Rabbit Media – Digital Creative Service')
@extends('layouts.auth.mst_client')
@section('inner-content')
    <div class="row" data-aos="fade-right">
        <div class="col">
            <h4 class="mb-1">Order Status</h4>
            <p>Inilah daftar riwayat pesanan Anda beserta statusnya!</p>
            <hr>
            <form id="form-loadOrderStats">
                <input type="hidden" name="user_id" value="{{$user->id}}">
                <input type="hidden" name="start_date" id="start_date">
                <input type="hidden" name="end_date" id="end_date">
                <input type="hidden" id="date">
            </form>
        </div>
    </div>
    <div class="row p-0">
        <div class="col">
            <div class="row" id="order-control">
                <div class="col-3" data-aos="zoom-in-right">
                    <div id="daterangepicker" class="myDateRangePicker" data-toggle="tooltip"
                         data-placement="top" title="Ordered Date Filter">
                        <i class="fa fa-calendar-alt"></i>&nbsp;
                        <span></span> <i class="fa fa-caret-down"></i>
                    </div>
                </div>
                <div class="col-9 text-right">
                    <p id="show-result"></p>
                </div>
            </div>
            <div class="text-center">
                <img src="{{asset('images/loading.gif')}}" id="image" class="img-fluid ld ld-fade">
            </div>
            <div class="row">
                <div class="col">
                    <ul class="list-unstyled" id="search-result"></ul>
                </div>
            </div>
            <div class="row">
                <div class="col myPagination">
                    <ul class="pagination justify-content-end" style="margin-right: -1em;"
                        data-aos="fade-left"></ul>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="uploadModal" tabindex="-1" role="dialog" aria-labelledby="uploadModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="invoice"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p style="font-size: 17px" align="justify">Untuk mempercepat proses verifikasinya, unggah
                        file bukti pembayaran Anda disini.</p>
                    <hr class="hr-divider">
                    <div class="row">
                        <div class="col" id="paymentProof"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        $(function () {
            @if($findOrder != "")
            @if(now() <= $findOrder->created_at->addDay())
            uploadPaymentProof('{{$findOrder->id}}', '{{$findOrder->payment_proof}}', '{{$req_invoice}}');
            @else
            swal('PERHATIAN!', '{{$req_invoice}} kadaluarsa.', 'warning');
            @endif
            @endif

            window.mobilecheck() ?
                swal({
                    title: 'PERHATIAN!',
                    text: 'Halaman ini belum sepenuhnya support untuk mobile device, silahkan mengubah orientasi ' +
                        'layar smartphone Anda menjadi landscape atau Anda dapat menggunakan komputer/laptop! ' +
                        'Mohon maaf atas ketidaknyamanannya, terimakasih.',
                    icon: 'warning',
                    closeOnEsc: false,
                    closeOnClickOutside: false,
                    buttons: {
                        cancel: 'Close'
                    }
                }) : '';

            var start = moment().startOf('month'), end = moment().endOf('month');

            $('#daterangepicker').daterangepicker({
                startDate: start,
                endDate: end,
                ranges: {
                    'Today': [moment(), moment()],
                    'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                    'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                    'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                    'This Month': [moment().startOf('month'), moment().endOf('month')],
                    'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                }
            }, searchDate);

            searchDate(start, end);

            $(".range_inputs .applyBtn").toggleClass('btn-success btn-primary');
            $(".range_inputs button").removeClass('btn-sm').addClass('py-1 px-3');
        });

        function searchDate(start, end) {
            $('#daterangepicker span').html(start.format('D MMM YYYY') + ' - ' + end.format('D MMM YYYY'));
            $("#start_date").val(start.format('YYYY-MM-D'));
            $("#end_date").val(end.format('YYYY-MM-D'));
            $("#date").val(start.format('D MMMM YYYY') + ' - ' + end.format('D MMMM YYYY'));
            loadOrderStats(start.format('D MMMM YYYY') + ' - ' + end.format('D MMMM YYYY'));
        }

        function loadOrderStats(date) {
            clearTimeout(this.delay);
            this.delay = setTimeout(function () {
                $.ajax({
                    url: "{{route('get.client.orderStatus')}}",
                    type: "GET",
                    data: $("#form-loadOrderStats").serialize(),
                    beforeSend: function () {
                        $('#image').show();
                        $('#search-result, #order-control, .myPagination').hide();
                    },
                    complete: function () {
                        $('#image').hide();
                        $('#search-result, #order-control, .myPagination').show();
                    },
                    success: function (data) {
                        successLoad(data, date);
                    },
                    error: function () {
                        swal('Order Status', 'Data tidak ditemukan!', 'error')
                    }
                });
            }.bind(this), 800);

            return false;
        }

        $('.myPagination ul').on('click', 'li', function () {
            var date = $("#date").val();

            $(window).scrollTop(0);

            page = $(this).children().text();
            active = $(this).parents("ul").find('.active').eq(0).text();
            hellip_prev = $(this).closest('.hellip_prev').next().find('a').text();
            hellip_next = $(this).closest('.hellip_next').prev().find('a').text();

            if (page > 0) {
                $url = "{{url('/account/dashboard/order-status/data')}}" + '?page=' + page;
            }
            if ($(this).hasClass('prev')) {
                $url = "{{url('/account/dashboard/order-status/data')}}" + '?page=' + parseInt(active - 1);
            }
            if ($(this).hasClass('next')) {
                $url = "{{url('/account/dashboard/order-status/data')}}" + '?page=' + parseInt(+active + +1);
            }
            if ($(this).hasClass('hellip_prev')) {
                $url = "{{url('/account/dashboard/order-status/data')}}" + '?page=' + parseInt(hellip_prev - 1);
                page = parseInt(hellip_prev - 1);
            }
            if ($(this).hasClass('hellip_next')) {
                $url = "{{url('/account/dashboard/order-status/data')}}" + '?page=' + parseInt(+hellip_next + +1);
                page = parseInt(+hellip_next + +1);
            }
            if ($(this).hasClass('first')) {
                $url = "{{url('/account/dashboard/order-status/data')}}" + '?page=1';
            }
            if ($(this).hasClass('last')) {
                $url = "{{url('/account/dashboard/order-status/data')}}" + '?page=' + last_page;
            }

            clearTimeout(this.delay);
            this.delay = setTimeout(function () {
                $.ajax({
                    url: $url,
                    type: "GET",
                    data: $("#form-loadOrderStats").serialize(),
                    beforeSend: function () {
                        $('#image').show();
                        $('#search-result, #order-control, .myPagination').hide();
                    },
                    complete: function () {
                        $('#image').hide();
                        $('#search-result, #order-control, .myPagination').show();
                    },
                    success: function (data) {
                        successLoad(data, date, page);
                    },
                    error: function () {
                        swal('Order Status', 'Data tidak ditemukan!', 'error')
                    }
                });
            }.bind(this), 800);

            return false;
        });

        function successLoad(data, date, page) {
            var title, total, $date, pagination = '', $page = '',
                $color, $display, $col, $class, $param, $param2, $label,
                $isHours, $isQty, $isStudio, $isMeeting, $isDesc,
                $isAcc, $status, $pm, $isLog, $logID, $logDesc, $admin;

            if (data.total > 0) {
                title = data.total > 1 ? 'Showing <strong>' + data.total + '</strong> order status' :
                    'Showing an order status';

                $date = date != undefined ? ' for <strong>"' + date + '"</strong>' : ' for <strong>"{{today()
                ->startOfMonth()->formatLocalized('%d %b %Y')." - ".today()
                ->endOfMonth()->formatLocalized('%d %b %Y')}}"</strong>';

                total = $.trim(data.total) ? ' (<strong>' + data.from + '</strong> - ' +
                    '<strong>' + data.to + '</strong> of <strong>' + data.total + '</strong>)' : '';

            } else {
                title = '<em>There seems to be none of the order status was found&hellip;</em>';
                total = '';
                $date = '';
            }
            $('#show-result').html(title + $date + total);

            $("#search-result").empty();
            $.each(data.data, function (i, val) {
                $color = val.status_payment > 1 ? '#592f83' : '#f23a2e';
                $display = val.status_payment <= 1 && val.expired == false ? '' : 'none';
                $col = val.status_payment <= 1 && val.expired == false ? '-11' : '';
                $class = val.status_payment > 1 ? '' : 'ld ld-breath';
                $label = val.status_payment > 1 ? "<strong>Paid</strong> on " + val.date_payment :
                    "<strong>Ordered</strong> on " + val.date_order;
                $param = val.id + ",'" + val.payment_proof + "','" + val.invoice + "'";
                $param2 = val.id + ",'" + val.invoice + "'";
                $isHours = val.plan.isHours == 1 ? 'inline-block' : 'none';
                $isQty = val.plan.isQty == 1 ? 'inline-block' : 'none';
                $isStudio = val.plan.isStudio == 1 ? 'inline-block' : 'none';
                $isMeeting = val.meeting_location != "" ? 'block' : 'none';
                $isDesc = val.deskripsi != "" ? 'block' : 'none';
                $isAcc = val.isAccept == 1 ? 'inline-block' : 'none';

                if (val.status_payment == 0) {
                    $status = 'Belum Lunas';
                } else if (val.status_payment == 1) {
                    $status = 'DP (Down Payment)';
                } else {
                    $status = 'Lunas';
                }

                $pm = val.pm != null ? '<span style="font-weight: 600">' + val.pm + '</span> (' + val.pc + ')' : '&ndash;';

                $isLog = val.log_id != null ? '' : 'none';
                $logID = val.log_id != null ? val.log_id : '';
                $logDesc = val.log_desc != null ? val.log_desc : '(Kosong)';
                $admin = val.admin_name != null ? val.admin_name : '(Kosong)';

                $("#search-result").append(
                    '<li class="media" style="border-bottom: 1px solid rgba(0, 0, 0, 0.1)">' +
                    '<img width="64" class="align-self-center" src="' + val.ava + '">' +
                    '<div class="media-body ml-2">' +
                    '<h5 class="mt-3" style="font-size: 17px">' +
                    '<a style="color: ' + $color + '" target="_blank" ' +
                    'href="{{route('invoice.order',['id'=> ''])}}/' + val.encryptID + '">' +
                    '<i class="fa fa-file-invoice-dollar"></i>&ensp;' + val.invoice + '</a>' +
                    '<cite><sub> &ndash; ' + val.created_at + '</sub></cite></h5>' +
                    '<blockquote style="color: #7f7f7f">' +
                    '<div class="row">' +
                    '<div class="col' + $col + '">' +
                    '<div class="row">' +
                    '<div class="col">' +
                    '<div class="panel-group accordion mb-3">' +

                    '<div class="panel">' +
                    '<div class="panel-heading">' +
                    '<h4 class="panel-title mb-0">' +
                    '<a class="accordion-toggle collapsed" href="javascript:void(0)" onclick="openAccordion()" ' +
                    'data-toggle="collapse" data-target="#sd-' + val.id + '" aria-expanded="true" ' +
                    'aria-controls="sd-' + val.id + '">&ensp;Service Details <sub>Rincian layanan</sub></a></h4></div>' +
                    '<div id="sd-' + val.id + '" class="panel-collapse collapse mt-2" ' +
                    'aria-labelledby="sd-' + val.id + '" data-parent=".accordion">' +
                    '<div class="panel-body">' +
                    '<ul class="list-inline">' +
                    '<li class="list-inline-item"><a class="tag tag-plans"><i class="fa fa-thumbtack mr-2"></i>' +
                    '<span class="mr-2" style="font-weight: 600">' + val.plan.paket + '</span>|' +
                    '<i class="fa fa-money-bill-wave ml-2"></i>' +
                    '<span class="ml-2" style="font-weight: 600">Rp' + val.harga + '</span></a></li>' +
                    '<li class="list-inline-item" style="display: ' + $isHours + '">' +
                    '<a class="tag tag-plans"><i class="fa fa-stopwatch mr-2"></i>Durasi max. ' +
                    '<span style="font-weight: 600">' + val.plan.hours + '</span>(over time <span style="font-weight: 600">' +
                    '+Rp' + thousandSeparator(parseInt(val.plan.price_per_hours)) + '/jam</span>)</a></li>' +
                    '<li class="list-inline-item" style="display: ' + $isQty + '"><a class="tag tag-plans">' +
                    '<i class="fa fa-users mr-2"></i>Total item (orang/produk) max. ' +
                    '<span style="font-weight: 600">' + val.plan.qty + '</span> (over item <span style="font-weight: 600">' +
                    '+Rp' + thousandSeparator(parseInt(val.plan.price_per_qty)) + '/jam</span>)</a></li>' +
                    '<li class="list-inline-item" style="display: ' + $isStudio + '"><a class="tag tag-plans">' +
                    '<i class="fa fa-door-open mr-2"></i>Studio opsional ' +
                    '(harga <span style="font-weight: 600;">belum </span> termasuk studio)</a></li></ul>' +
                    '</div></div><hr class="m-0"></div>' +

                    '<div class="panel">' +
                    '<div class="panel-heading">' +
                    '<h4 class="panel-title mb-0">' +
                    '<a class="accordion-toggle collapsed" href="javascript:void(0)" onclick="openAccordion()" ' +
                    'data-toggle="collapse" data-target="#od-' + val.id + '" aria-expanded="true" ' +
                    'aria-controls="od-' + val.id + '">&ensp;Order Details <sub>Rincian pesanan</sub></a></h4></div>' +
                    '<div id="od-' + val.id + '" class="panel-collapse collapse mt-2" ' +
                    'aria-labelledby="od-' + val.id + '" data-parent=".accordion">' +
                    '<div class="panel-body">' +
                    '<ul class="list-inline">' +
                    '<li class="list-inline-item"><a class="tag"><i class="fa fa-text-width mr-2"></i>' +
                    'Judul: <span style="font-weight: 600">' + val.judul + '</span></a></li>' +
                    '<li class="list-inline-item"><a class="tag"><i class="fa fa-calendar-alt mr-2"></i>' +
                    'Tanggal Booking: <span style="font-weight: 600">' + val.start + '</span> &mdash; ' +
                    '<span style="font-weight: 600">' + val.end + '</span></a></li>' +
                    '<li class="list-inline-item" style="display: ' + $isHours + '"><a class="tag">' +
                    '<i class="fa fa-stopwatch mr-2"></i>Total durasi ' +
                    '<span style="font-weight: 600">' + val.hours + '</span> jam</a></li>' +
                    '<li class="list-inline-item" style="display: ' + $isQty + '"><a class="tag">' +
                    '<i class="fa fa-users mr-2"></i>Total item ' +
                    '<span style="font-weight: 600">' + val.qty + '</span> item</a></li>' +
                    '<li class="list-inline-item" style="display: ' + $isStudio + '">' +
                    '<a class="tag"><i class="fa fa-door-open mr-2"></i>Studio ' + val.jenis_studio + ': ' +
                    '<span class="mr-2" style="font-weight: 600">' + val.nama_studio + '</span>|' +
                    '<i class="fa fa-money-bill-wave ml-2"></i><span class="ml-2" style="font-weight: 600">' +
                    'Rp' + thousandSeparator(parseInt(val.harga_studio)) + '/jam</span></a></li></ul>' +
                    '<table style="font-size: 14px">' +
                    '<tr style="display: ' + $isMeeting + '" data-toggle="tooltip" data-placement="left" ' +
                    'title="Lokasi Meeting"><td><i class="fa fa-map-marked-alt mr-2"></i></td>' +
                    '<td style="font-weight: 600">' + val.meeting_location + '</td></tr>' +
                    '<tr style="display: ' + $isDesc + '" data-toggle="tooltip" data-placement="left" ' +
                    'title="Informasi Tambahan"><td><i class="fa fa-comments mr-2"></i></td>' +
                    '<td>' + val.deskripsi + '</td></tr></table>' +
                    '</div></div><hr class="m-0"></div>' +

                    '<div class="panel">' +
                    '<div class="panel-heading">' +
                    '<h4 class="panel-title mb-0">' +
                    '<a class="accordion-toggle collapsed" href="javascript:void(0)" onclick="openAccordion()" ' +
                    'data-toggle="collapse" data-target="#pd-' + val.id + '" aria-expanded="true" ' +
                    'aria-controls="pd-' + val.id + '">&ensp;Payment Details <sub>Rincian pembayaran</sub></a></h4></div>' +
                    '<div id="pd-' + val.id + '" class="panel-collapse collapse mt-2" ' +
                    'aria-labelledby="pd-' + val.id + '" data-parent=".accordion">' +
                    '<div class="panel-body">' +
                    '<ul class="list-inline">' +
                    '<li class="list-inline-item"><a class="tag"><i class="fa fa-money-bill-wave mr-2"></i>' +
                    'Total tagihan: <span style="font-weight: 600">Rp' + val.total_payment + '</span></a></li>' +
                    '<li class="list-inline-item" style="display: ' + $isAcc + '"><a class="tag">' +
                    '<i class="fa fa-hand-holding-usd mr-2"></i>' +
                    'Status Pembayaran: <span style="font-weight: 600">' + $status + '</span></a></li>' +
                    '<li class="list-inline-item" style="display: ' + $isAcc + '"><a class="tag">' +
                    '<i class="fa fa-university mr-2"></i>Metode Pembayaran: ' + $pm + '</a></li></ul>' +
                    '</div></div><hr class="m-0"></div>' +

                    '<div class="panel" style="display: ' + $isLog + '">' +
                    '<div class="panel-heading">' +
                    '<h4 class="panel-title mb-0">' +
                    '<a class="accordion-toggle collapsed" href="javascript:void(0)" onclick="openAccordion()" ' +
                    'data-toggle="collapse" data-target="#ld-' + val.id + '" aria-expanded="true" ' +
                    'aria-controls="ld-' + val.id + '">&ensp;Log/Progress Details ' +
                    '<sub>Rincian kemajuan pesanan</sub></a></h4></div>' +
                    '<div id="ld-' + val.id + '" class="panel-collapse collapse mt-2" ' +
                    'aria-labelledby="ld-' + val.id + '" data-parent=".accordion">' +
                    '<div class="panel-body">' +
                    '<small>Description</small><p class="mb-2" style="font-size: 14px">' + $logDesc + '</p>' +
                    '<small>Attachments</small>' +
                    '<div id="attachments-' + $logID + '" class="mb-3" data-chocolat-title="Attachments"></div>' +
                    '<small>by <cite>' + $admin + '</cite> <img src="' + val.admin_ava + '" ' +
                    'class="img-fluid img-thumbnail mb-1" style="border-radius: 100%;width: 32px"></small>' +
                    '</div></div><hr class="m-0"></div>' +

                    '</div></div></div></div>' +

                    '<div class="col-1" style="display: ' + $display + '">' +
                    '<div class="row">' +
                    '<div class="col">' +
                    '<form id="form-paymentProof-' + val.id + '" method="post" ' +
                    'action="{{route('upload.paymentProof')}}">{{csrf_field()}}' +
                    '<div class="anim-icon anim-icon-md upload ' + $class + '" ' +
                    'onclick="uploadPaymentProof(' + $param + ')" data-toggle="tooltip" data-placement="bottom" ' +
                    'title="Payment Proof" style="font-size: 25px;">' +
                    '<input type="hidden" name="order_id" value="' + val.id + '">' +
                    '<input id="upload' + val.id + '" type="checkbox" checked>' +
                    '<label for="upload' + val.id + '"></label></div></form>' +
                    '</div></div></div></div>' +

                    '<div class="row" style="margin-top: -.5em">' +
                    '<div class="col">' +
                    '<small>' + $label + '</small><br>' +
                    '<a style="display: ' + $display + '" onclick="deleteOrder(' + $param2 + ')" ' +
                    'href="{{route('delete.order',['id'=>''])}}/' + val.encryptID + '">' +
                    '<div class="anim-icon anim-icon-md apply ld ld-heartbeat" data-toggle="tooltip" ' +
                    'data-placement="right" title="Batalkan pesanan!" style="font-size: 15px">' +
                    '<input id="apply' + val.id + '" type="checkbox" checked>' +
                    '<label for="apply' + val.id + '"></label></div></a><br>' +
                    '<small style="display: ' + $display + '">' +
                    'NB: Anda hanya dapat menyelesaikan pembayaran pesanan Anda atau membatalkannya sebelum ' +
                    '<strong>' + val.deadline + '.</strong></small></div></div>' +

                    '</blockquote></div></li>'
                );

                if (val.log_id != null) {
                    $.each(val.log_files, function (i, file) {
                        $("#attachments-" + $logID).append(
                            '<a class="chocolat-image mr-2" href="{{asset('images/big-images/nature_big_')}}' + file + '">' +
                            '<img class="img-fluid img-thumbnail" width="64" ' +
                            'src="{{asset('images/nature_small_')}}' + file + '"></a>'
                        );
                    });

                    $('#attachments-' + $logID).Chocolat();
                }
            });
            $('[data-toggle="tooltip"]').tooltip();

            if (data.last_page >= 1) {
                if (data.current_page > 4) {
                    pagination += '<li class="page-item first">' +
                        '<a class="page-link" href="' + data.first_page_url + '">' +
                        '<i class="fa fa-angle-double-left"></i></a></li>';
                }

                if ($.trim(data.prev_page_url)) {
                    pagination += '<li class="page-item prev">' +
                        '<a class="page-link" href="' + data.prev_page_url + '" rel="prev">' +
                        '<i class="fa fa-angle-left"></i></a></li>';
                } else {
                    pagination += '<li class="page-item disabled">' +
                        '<span class="page-link"><i class="fa fa-angle-left"></i></span></li>';
                }

                if (data.current_page > 4) {
                    pagination += '<li class="page-item hellip_prev">' +
                        '<a class="page-link" style="cursor: pointer">&hellip;</a></li>'
                }

                for ($i = 1; $i <= data.last_page; $i++) {
                    if ($i >= data.current_page - 3 && $i <= data.current_page + 3) {
                        if (data.current_page == $i) {
                            pagination += '<li class="page-item active"><span class="page-link">' + $i + '</span></li>'
                        } else {
                            pagination += '<li class="page-item">' +
                                '<a class="page-link" style="cursor: pointer">' + $i + '</a></li>'
                        }
                    }
                }

                if (data.current_page < data.last_page - 3) {
                    pagination += '<li class="page-item hellip_next">' +
                        '<a class="page-link" style="cursor: pointer">&hellip;</a></li>'
                }

                if ($.trim(data.next_page_url)) {
                    pagination += '<li class="page-item next">' +
                        '<a class="page-link" href="' + data.next_page_url + '" rel="next">' +
                        '<i class="fa fa-angle-right"></i></a></li>';
                } else {
                    pagination += '<li class="page-item disabled">' +
                        '<span class="page-link"><i class="fa fa-angle-right"></i></span></li>';
                }

                if (data.current_page < data.last_page - 3) {
                    pagination += '<li class="page-item last">' +
                        '<a class="page-link" href="' + data.last_page_url + '">' +
                        '<i class="fa fa-angle-double-right"></i></a></li>';
                }
            }
            $('.myPagination ul').html(pagination);

            if (page != "" && page != undefined) {
                $page = '?page=' + page;
            }
            window.history.replaceState("", "", '{{url('/account/dashboard/order-status')}}' + $page);

            setTimeout(function () {
                $('.use-nicescroll').getNiceScroll().resize()
            }, 600);
            return false;
        }

        function openAccordion() {
            setTimeout(function () {
                $('.use-nicescroll').getNiceScroll().resize()
            }, 600);
        }

        function uploadPaymentProof(id, image, invoice) {
            $("#paymentProof").html(
                '<form id="upload-form" method="post" enctype="multipart/form-data">' +
                '{{csrf_field()}} {{ method_field('put') }}' +
                '<input type="hidden" name="order_id" value="' + id + '">' +
                '<div class="uploader">' +
                '<input id="file-upload" type="file" name="payment_proof" accept="image/*">' +
                '<label for="file-upload" id="file-drag">' +
                '<img id="file-image" src="#" alt="Payment Proof" class="hidden img-responsive">' +
                '<div id="start">' +
                '<i class="fa fa-download" aria-hidden="true"></i>' +
                '<div>Select your payment proof file or drag it here</div>' +
                '<div id="notimage" class="hidden">Please select an image</div>' +
                '<span id="file-upload-btn" class="btn btn-primary"> Select a file</span></div>' +
                '<div id="response" class="hidden"><div id="messages"></div></div>' +
                '<div id="progress-upload">' +
                '<div class="progress-bar progress-bar-info progress-bar-striped active" role="progressbar" ' +
                'aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div></div></label></div></form>'
            );
            $("#invoice").html('<strong>' + invoice + '</strong> &ndash; PAYMENT PROOF');
            $("#upload" + id).prop('checked', false);
            $("#uploadModal").modal('show');
            if (image != "") {
                setImage(image);
            }
            $(document).on('hide.bs.modal', '#uploadModal', function (event) {
                $("#upload" + id).prop('checked', true);
            });
            ekUpload(id);
        }

        function ekUpload(id) {
            function Init() {
                var fileSelect = document.getElementById('file-upload'),
                    fileDrag = document.getElementById('file-drag');

                fileSelect.addEventListener('change', fileSelectHandler, false);

                var xhr = new XMLHttpRequest();
                if (xhr.upload) {
                    fileDrag.addEventListener('dragover', fileDragHover, false);
                    fileDrag.addEventListener('dragleave', fileDragHover, false);
                    fileDrag.addEventListener('drop', fileSelectHandler, false);
                }
            }

            function fileDragHover(e) {
                var fileDrag = document.getElementById('file-drag');

                e.stopPropagation();
                e.preventDefault();

                fileDrag.className = (e.type === 'dragover' ? 'hover' : 'modal-body file-upload');
            }

            function fileSelectHandler(e) {
                var files = e.target.files || e.dataTransfer.files;
                $("#file-upload").prop("files", files);

                fileDragHover(e);

                for (var i = 0, f; f = files[i]; i++) {
                    uploadPaymentProof(f);
                }
            }

            function uploadPaymentProof(file) {
                var files_size = file.size, max_file_size = 2000000, file_name = file.name,
                    allowed_file_types = (/\.(?=gif|jpg|png|jpeg)/gi).test(file_name);

                if (!window.File && window.FileReader && window.FileList && window.Blob) {
                    swal('PERHATIAN!', "Browser yang Anda gunakan tidak support! Silahkan perbarui atau gunakan browser yang lainnya.", 'warning');

                } else {
                    if (files_size > max_file_size) {
                        swal('ERROR!', "Ukuran total " + file_name + " adalah " + humanFileSize(files_size) +
                            ", ukuran file yang diperbolehkan adalah " + humanFileSize(max_file_size) +
                            ", coba unggah file yang ukurannya lebih kecil!", 'error');

                        $("#messages-" + id).html('Silahkan unggah file dengan ukuran yang lebih kecil (< ' + humanFileSize(max_file_size) + ').');
                        document.getElementById('file-image').classList.add("hidden");
                        document.getElementById('start').classList.remove("hidden");
                        document.getElementById("upload-form").reset();

                    } else {
                        if (!allowed_file_types) {
                            swal('ERROR!', "Tipe file " + file_name + " tidak support!", 'error');

                            document.getElementById('file-image').classList.add("hidden");
                            document.getElementById('notimage').classList.remove("hidden");
                            document.getElementById('start').classList.remove("hidden");
                            document.getElementById('response').classList.add("hidden");
                            document.getElementById("upload-form").reset();

                        } else {
                            $.ajax({
                                type: 'POST',
                                url: '{{route('upload.paymentProof')}}',
                                data: new FormData($("#upload-form")[0]),
                                contentType: false,
                                processData: false,
                                mimeType: "multipart/form-data",
                                xhr: function () {
                                    var xhr = $.ajaxSettings.xhr(),
                                        progress_bar_id = $("#progress-upload .progress-bar");
                                    if (xhr.upload) {
                                        xhr.upload.addEventListener('progress', function (event) {
                                            var percent = 0;
                                            var position = event.loaded || event.position;
                                            var total = event.total;
                                            if (event.lengthComputable) {
                                                percent = Math.ceil(position / total * 100);
                                            }
                                            progress_bar_id.css("display", "block");
                                            progress_bar_id.css("width", +percent + "%");
                                            progress_bar_id.text(percent + "%");
                                            if (percent == 100) {
                                                progress_bar_id.removeClass("progress-bar-info");
                                                progress_bar_id.addClass("progress-bar");
                                            } else {
                                                progress_bar_id.removeClass("progress-bar");
                                                progress_bar_id.addClass("progress-bar-info");
                                            }
                                        }, true);
                                    }
                                    return xhr;
                                },
                                success: function (data) {
                                    swal('Order Status', 'Bukti pembayaran berhasil diunggah! Untuk mengetahui status ' +
                                        'pesanan Anda, silahkan cek Order Status di halaman dashboard Anda.', 'success');

                                    setImage(data);
                                    $("#progress-upload").css("display", "none");
                                },
                                error: function () {
                                    swal('Oops...', 'Terjadi suatu kesalahan!', 'error')
                                }
                            });
                            return false;
                        }
                    }
                }
            }

            if (window.File && window.FileList && window.FileReader) {
                Init();
            } else {
                document.getElementById('file-drag').style.display = 'none';
            }
        }

        function setImage(image) {
            $("#messages").html('<strong>' + image + '</strong>');
            $('#start').addClass("hidden");
            $('#response').removeClass("hidden");
            $('#notimage').addClass("hidden");
            $('#file-image').removeClass("hidden").attr('src', '{{asset('storage/users/payment/')}}/' + image);
        }

        function humanFileSize(size) {
            var i = Math.floor(Math.log(size) / Math.log(1024));
            return (size / Math.pow(1024, i)).toFixed(2) * 1 + ' ' + ['B', 'kB', 'MB', 'GB', 'TB'][i];
        };

        function deleteJobPosting(id, invoice) {
            swal({
                title: 'Apakah Anda yakin untuk membatalkan ' + invoice + '?',
                text: "Anda tidak dapat mengembalikannya!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#592f83',
                confirmButtonText: 'Ya',
                cancelButtonText: 'Tidak',
                showLoaderOnConfirm: true,
                allowOutsideClick: false,
            }).then(function () {
                $("#apply" + id).prop('checked', false);
                window.location.href = linkURL;
            }, function (dismiss) {
                if (dismiss == 'cancel') {
                    $("#apply" + id).prop('checked', true);
                }
            });
        }
    </script>
@endpush