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
            <div class="row" id="search-result"></div>
            <div class="row">
                <div class="col-12 myPagination">
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
        });

        function searchDate(start, end) {
            $('#daterangepicker span').html(start.format('D MMM YYYY') + ' - ' + end.format('D MMM YYYY'));
            $("#start_date").val(start.format('YYYY-MM-D'));
            $("#end_date").val(end.format('YYYY-MM-D'));
            $("#date").val(start.format('D MMM YYYY') + ' - ' + end.format('D MMM YYYY'));
            loadOrderStats(start.format('D MMM YYYY') + ' - ' + end.format('D MMM YYYY'));
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
                $color, $display, $class, $param, $param2, $label;

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
                $color = val.isPaid == 1 ? '#592f83' : '#f23a2e';
                $display = val.isPaid == 0 && val.expired == false ? '' : 'none';
                $class = val.isPaid == 1 ? '' : 'ld ld-breath';
                $label = val.isPaid == 1 ? "<strong>Paid</strong> on " + val.date_payment :
                    "<strong>Ordered</strong> on " + val.date_order;
                $param = val.id + ",'" + val.payment_proof + "','" + val.invoice + "'";
                $param2 = val.id + ",'" + val.invoice + "'";

                $("#search-result").append(
                    '<div class="media">' +
                    '<div class="media-left media-middle">' +
                    '<img width="100" class="media-object" src="' + val.ava + '"></div>' +
                    '<div class="media-body">' +
                    '<small class="media-heading">' +
                    '<a style="color: ' + $color + '" target="_blank" ' +
                    'href="{{route('invoice.order',['id'=> ''])}}/' + val.encryptID + '">' +
                    '<i class="fa fa-file-invoice-dollar"></i>&ensp;' + val.invoice + '</a>' +
                    '<sub>&ndash; ' + val.created_at + '</sub></small>' +
                    '<blockquote style="font-size: 12px;color: #7f7f7f">' +
                    '<form style="display: ' + $display + '" class="pull-right" id="form-paymentProof-' + val.id + '" ' +
                    'method="post" action="{{route('upload.paymentProof')}}">{{csrf_field()}}' +
                    '<div class="anim-icon anim-icon-md upload ' + $class + '" ' +
                    'onclick="uploadPaymentProof(' + $param + ')" data-toggle="tooltip" data-placement="bottom" ' +
                    'title="Payment Proof" style="font-size: 25px">' +
                    '<input type="hidden" name="order_id" value="' + val.id + '">' +
                    '<input id="upload' + val.id + '" type="checkbox" checked>' +
                    '<label for="upload' + val.id + '"></label></div></form>' +
                    '<ul class="list-inline" id="orders' + val.id + '"></ul>' +
                    '<small>' + $label + '</small>' +
                    '<a style="display: ' + $display + '" ' +
                    'href="{{route('delete.order',['id'=>''])}}/' + val.encryptID + '" ' +
                    'onclick="deleteOrder(' + $param2 + ')">' +
                    '<div class="anim-icon anim-icon-md apply ld ld-heartbeat" data-toggle="tooltip" ' +
                    'data-placement="right" title="Click here to abort this order!" style="font-size: 15px">' +
                    '<input id="apply' + val.id + '" type="checkbox" checked>' +
                    '<label for="apply' + val.id + '"></label></div></a>' +
                    '<small style="display: ' + $display + '">P.S.: You are only permitted to COMPLETE the payment or ' +
                    'even ABORT this order before <strong>' + val.deadline + '.</strong></small>' +
                    '</blockquote></div></div><hr class="hr-divider">'
                );

                var $orders = '', $status;
                $.each(val.order_ids, function (x, nilai) {
                    $status = nilai.isPost == 1 ? 'POSTED' : 'NOT POSTED YET';
                    $orders +=
                        '<li><a target="_blank" href="#" ' +
                        'class="tag tag-plans"><i class="fa fa-briefcase"></i>&ensp;' + nilai.judul + ' &ndash; ' +
                        '<strong>' + $status + '</strong></li>';
                });
                $("#orders" + val.id).html($orders +
                    '<li><a class="tag tag-plans"><i class="fa fa-thumbtack"></i>&ensp;Plan: ' +
                    '<strong style="text-transform: uppercase">' + val.plan + '</strong> Package</a></li>' +
                    '<li><a class="tag tag-plans"><i class="fa fa-credit-card"></i>&ensp;Payment: ' + val.pc + ' &ndash; ' +
                    '<strong style="text-transform: uppercase">' + val.pm + '</strong></a></li>'
                );
            });
            $('[data-toggle="tooltip"]').tooltip();

            if (data.last_page > 1) {

                if (data.current_page > 4) {
                    pagination += '<li class="first"><a href="' + data.first_page_url + '"><i class="fa fa-angle-double-left"></i></a></li>';
                }

                if ($.trim(data.prev_page_url)) {
                    pagination += '<li class="prev"><a href="' + data.prev_page_url + '" rel="prev"><i class="fa fa-angle-left"></i></a></li>';
                } else {
                    pagination += '<li class="disabled"><span><i class="fa fa-angle-left"></i></span></li>';
                }

                if (data.current_page > 4) {
                    pagination += '<li class="hellip_prev"><a style="cursor: pointer">&hellip;</a></li>'
                }

                for ($i = 1; $i <= data.last_page; $i++) {
                    if ($i >= data.current_page - 3 && $i <= data.current_page + 3) {
                        if (data.current_page == $i) {
                            pagination += '<li class="active"><span>' + $i + '</span></li>'
                        } else {
                            pagination += '<li><a style="cursor: pointer">' + $i + '</a></li>'
                        }
                    }
                }

                if (data.current_page < data.last_page - 3) {
                    pagination += '<li class="hellip_next"><a style="cursor: pointer">&hellip;</a></li>'
                }

                if ($.trim(data.next_page_url)) {
                    pagination += '<li class="next"><a href="' + data.next_page_url + '" rel="next"><i class="fa fa-angle-right"></i></a></li>';
                } else {
                    pagination += '<li class="disabled"><span><i class="fa fa-angle-right"></i></span></li>';
                }

                if (data.current_page < data.last_page - 3) {
                    pagination += '<li class="last"><a href="' + data.last_page_url + '"><i class="fa fa-angle-double-right"></i></a></li>';
                }
            }
            $('.myPagination ul').html(pagination);

            if (page != "" && page != undefined) {
                $page = '?page=' + page;
            }
            window.history.replaceState("", "", '{{url('/account/dashboard/order-status')}}' + $page);
            return false;
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