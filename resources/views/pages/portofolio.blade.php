@extends('layouts.mst_user')
@section('title', 'Portfolios | Rabbit Media – Digital Creative Service')
@push('styles')
    <style>
        #tabs .nav-tabs .nav-item.show .nav-link, .nav-tabs .nav-link.active {
            color: #592f83 !important;
            border-color: transparent transparent #f3f3f3;
            border-bottom: 4px solid #592f83 !important;
        }

        #tabs .nav-tabs .nav-link {
            text-transform: uppercase;
            border: 1px solid transparent;
            border-top-left-radius: .25rem;
            border-top-right-radius: .25rem;
        }

        .image-wrap:before {
            position: absolute;
            content: "";
            left: 0;
            right: 0;
            bottom: 0;
            top: 0;
            z-index: 1;
            background: transparent;
            -webkit-transition: .3s all ease;
            -o-transition: .3s all ease;
            transition: .3s all ease;
        }

        .image-wrap img {
            position: relative;
            -o-object-fit: cover;
            object-fit: cover;
            width: 100%;
            height: 100%;
        }

        .image-wrap .image-info {
            text-align: center;
            position: absolute;
            top: 50%;
            left: 50%;
            z-index: 2;
            -webkit-transform: translate(-50%, -50%);
            -ms-transform: translate(-50%, -50%);
            transform: translate(-50%, -50%);
        }

        .image-wrap .image-info h2 {
            color: #fff;
        }

        .image-wrap:hover:before {
            background: rgba(0, 0, 0, 0.4);
            content: "";
        }

        .btn-outline-white {
            border-color: #fff;
            color: #fff;
            border-width: 2px;
            text-transform: uppercase;
            font-size: 11px;
            letter-spacing: .1em;
            font-weight: 900;
        }

        .btn-outline-white:hover {
            background: #fff;
            color: #000;
        }
    </style>
@endpush
@section('content')
    <div class="site-section" data-aos="fade">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-md-7">
                    <div class="row mb-5">
                        <div class="col-12 ">
                            <h3 class="site-section-heading text-center">Portfolios</h3>
                            <h5 class="text-center"><em><strong>Capture and Bring your Moment with Us!</strong></em>
                            </h5>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center" id="tabs">
                <div class="col-11">
                    <nav>
                        <div class="nav nav-tabs nav-fill" id="nav-tab" role="tablist">
                            <a class="nav-item nav-link" style="color: #495057" id="tabList-all"
                               data-toggle="tab" href="#tabContent-all" role="tab" aria-controls="nav-home"
                               aria-selected="true" onclick="filterPortfolio('all')">
                                Show All&ensp;<span class="badge badge-secondary">{{count($portfolios)}}</span></a>
                            @foreach($types as $row)
                                <a class="nav-item nav-link" onclick="filterPortfolio('{{$row->id}}')"
                                   style="color: #495057"
                                   id="tabList-{{$row->id}}" data-toggle="tab" href="#tabContent-{{$row->id}}"
                                   role="tab" aria-controls="nav-home" aria-selected="true">
                                    {{$row->nama}}&ensp;<span class="badge badge-secondary">{{count($row
                                    ->getPortofolio)}}</span></a>
                            @endforeach
                            <form id="form-loadPortfolio">
                                <input type="hidden" name="q" id="jenis">
                            </form>
                        </div>
                    </nav>
                    <div class="tab-content py-3 px-3 px-sm-0" id="nav-tabContent">
                        <div class="tab-pane fade" role="tabpanel" aria-labelledby="nav-home-tab"
                             style="margin-left: -1.5rem;">
                            <div class="text-center">
                                <img src="{{asset('images/loading.gif')}}" id="image" class="img-fluid ld ld-fade">
                            </div>
                            <div class="row" id="search-result"></div>
                            <div class="row">
                                <div class="col-12 myPagination">
                                    <ul class="pagination justify-content-end" style="margin-right: -1em;"></ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        var last_page;

        $(function () {
            $('#image').hide();
            $('#search-result').show();
            $('.myPagination').show();
            $("#tabList-" + window.location.hash).addClass('show active');
            $("#tabContent-" + window.location.hash).addClass('show active');

            @if($keyword != '')
            $("#tabList-{{$keyword}}").click();
            $("#tabList-{{$keyword}} span").addClass('badge-primary').removeClass('badge-secondary');
            @else
            $("#tabList-all").click();
            $("#tabList-all span").addClass('badge-primary').removeClass('badge-secondary');
            @endif
        });

        function filterPortfolio(id) {
            $("#nav-tab a").removeClass('show active');
            $("#nav-tab a span").removeClass('badge-primary').addClass('badge-secondary');
            $("#nav-tabContent .tab-pane").addClass('show active');

            $("#tabList-" + id).addClass('show active');
            $("#tabList-" + id + " span").addClass('badge-primary').removeClass('badge-secondary');

            $("#jenis").val(id);
            loadPortfolios();
        }

        function loadPortfolios() {
            clearTimeout(this.delay);
            this.delay = setTimeout(function () {
                $.ajax({
                    url: "{{route('get.portfolios')}}",
                    type: "GET",
                    data: $("#form-loadPortfolio").serialize(),
                    beforeSend: function () {
                        $('#image').show();
                        $('#search-result, .myPagination').hide();
                    },
                    complete: function () {
                        $('#image').hide();
                        $('#search-result, .myPagination').show();
                    },
                    success: function (data) {
                        successLoad(data);
                    },
                    error: function () {
                        swal({
                            title: 'Portfolios',
                            text: 'Data tidak ditemukan!',
                            type: 'error',
                            timer: '1500'
                        })
                    }
                });
            }.bind(this), 800);

            return false;
        }

        $('.myPagination ul').on('click', 'li', function () {
            $(window).scrollTop(0);

            page = $(this).children().text();
            active = $(this).parents("ul").find('.active').eq(0).text();
            hellip_prev = $(this).closest('.hellip_prev').next().find('a').text();
            hellip_next = $(this).closest('.hellip_next').prev().find('a').text();

            if (page > 0) {
                $url = "{{url('/portfolios/data')}}" + '?page=' + page;
            }
            if ($(this).hasClass('prev')) {
                $url = "{{url('/portfolios/data')}}" + '?page=' + parseInt(active - 1);
            }
            if ($(this).hasClass('next')) {
                $url = "{{url('/portfolios/data')}}" + '?page=' + parseInt(+active + +1);
            }
            if ($(this).hasClass('hellip_prev')) {
                $url = "{{url('/portfolios/data')}}" + '?page=' + parseInt(hellip_prev - 1);
                page = parseInt(hellip_prev - 1);
            }
            if ($(this).hasClass('hellip_next')) {
                $url = "{{url('/portfolios/data')}}" + '?page=' + parseInt(+hellip_next + +1);
                page = parseInt(+hellip_next + +1);
            }
            if ($(this).hasClass('first')) {
                $url = "{{url('/portfolios/data')}}" + '?page=1';
            }
            if ($(this).hasClass('last')) {
                $url = "{{url('/portfolios/data')}}" + '?page=' + last_page;
            }

            clearTimeout(this.delay);
            this.delay = setTimeout(function () {
                $.ajax({
                    url: $url,
                    type: "GET",
                    data: $("#form-loadPortfolio").serialize(),
                    beforeSend: function () {
                        $('#image').show();
                        $('#search-result, .myPagination').hide();
                    },
                    complete: function () {
                        $('#image').hide();
                        $('#search-result, .myPagination').show();
                    },
                    success: function (data) {
                        successLoad(data, page);
                    },
                    error: function () {
                        swal({
                            title: 'Portfolios',
                            text: 'Data tidak ditemukan!',
                            type: 'error',
                            timer: '1500'
                        })
                    }
                });
            }.bind(this), 800);

            return false;
        });

        function successLoad(data, page) {
            var $result = '', pagination = '', $page = '';

            $.each(data.data, function (i, val) {
                $result +=
                    '<div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 item">' +
                    '<article class="download-card Card">' +
                    '<a href="{{url('/portfolios')}}/' + val.jenis + '/' + val.enc_id + '">' +
                    '<div class="download-card__icon-box">' +
                    '<img src="' + val.cover + '"' +
                    'alt="Cover" class="img-fluid"></div></a>' +
                    '<div class="Card-thumbnailOverlay">' +
                    '<div class="text-center">' +
                    '<h2 class="mb-3" style="text-transform: uppercase">' + val.nama + '</h2>' +
                    '<a href="{{url('/portfolios')}}/' + val.jenis + '/' + val.enc_id + '" class="Card-Btn">' +
                    '<strong>' + val.galleries + ' footage</strong>' +
                    '</a></div></div></article></div>';
            });
            $("#search-result").empty().append($result);

            if (data.last_page > 1) {
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
                $page = '&page=' + page;
            }
            window.history.replaceState("", "", '{{url('/portfolios')}}?q=' + $("#jenis").val() + $page);
            return false;
        }
    </script>
@endpush