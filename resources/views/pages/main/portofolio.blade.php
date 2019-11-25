@extends('layouts.mst_user')
@section('title', 'Portfolios | Rabbit Media – Digital Creative Service')
@push('styles')
    <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">
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

        ul.ui-autocomplete {
            color: #592f83;
            border-radius: 0 0 1rem 1rem;
        }

        ul.ui-autocomplete .ui-menu-item .ui-state-active,
        ul.ui-autocomplete .ui-menu-item .ui-state-active:hover,
        ul.ui-autocomplete .ui-menu-item .ui-state-active:focus {
            background: #592f83;
            color: #fff;
            border: 1px solid #592f83;
        }

        ul.ui-autocomplete .ui-menu-item:last-child .ui-state-active,
        ul.ui-autocomplete .ui-menu-item:last-child .ui-state-active:hover,
        ul.ui-autocomplete .ui-menu-item:last-child .ui-state-active:focus {
            border-radius: 0 0 1rem 1rem;
        }

        .pagination > .disabled > a,
        .pagination > .disabled > a:focus,
        .pagination > .disabled > a:hover,
        .pagination > .disabled > span,
        .pagination > .disabled > span:focus,
        .pagination > .disabled > span:hover {
            pointer-events: none;
        }
    </style>
@endpush
@section('content')
    <div class="site-section">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-md-7">
                    <div class="row">
                        <div class="col-12">
                            <h3 class="site-section-heading text-center" data-aos="fade-right">Portfolios</h3>
                            <h5 class="text-center" data-aos="fade-left">Inilah cara kami mengabadikan momen bahagia
                                Anda!</h5>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center mb-3" data-aos="fade">
                <div class="col-xl-5 col-lg-5 col-md-7 col-sm-7">
                    <form id="form-loadPortfolio">
                        <input type="hidden" name="category" id="jenis">
                        <div class="row form-group has-feedback">
                            <div class="col-12">
                                <input id="keyword" type="text" name="q" class="form-control" autocomplete="off"
                                       value="{{$keyword}}" style="border-radius: 1rem" placeholder="Cari&hellip;">
                                <span class="glyphicon glyphicon-search form-control-feedback"></span>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="row justify-content-center" id="tabs">
                <div class="col-11">
                    <nav data-aos="zoom-in-up">
                        <div class="nav nav-tabs nav-fill" id="nav-tab" role="tablist">
                            <a class="nav-item nav-link" style="color: #495057" id="tabList-all"
                               data-toggle="tab" href="#tabContent-all" role="tab" aria-controls="nav-home"
                               aria-selected="true" onclick="filterPortfolio('all')">
                                <i class="fa fa-sort-alpha-up"></i>&ensp;Show All&ensp;<span
                                        class="badge badge-secondary">{{\App\Models\Portofolio::count()}}</span></a>
                            @foreach($types as $row)
                                <a class="nav-item nav-link" onclick="filterPortfolio('{{$row->id}}')"
                                   style="color: #495057"
                                   id="tabList-{{$row->id}}" data-toggle="tab" href="#tabContent-{{$row->id}}"
                                   role="tab" aria-controls="nav-home" aria-selected="true">
                                    <i class="{{$row->icon}}"></i>&ensp;{{$row->nama}}&ensp;<span
                                            class="badge badge-secondary">{{count($row->getPortofolio)}}</span></a>
                            @endforeach
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
                                    <ul class="pagination justify-content-end" style="margin-right: -1em;"
                                        data-aos="fade-left"></ul>
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
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <script>
        var last_page, $keyword = $("#keyword");

        $(function () {
            $('#image').hide();
            $('#search-result').show();
            $('.myPagination').show();
            $("#tabList-" + window.location.hash).addClass('show active');
            $("#tabContent-" + window.location.hash).addClass('show active');

            @if($category != '')
            $("#tabList-{{$category}}").click();
            $("#tabList-{{$category}} span").addClass('badge-primary').removeClass('badge-secondary');
            @else
            $("#tabList-all").click();
            $("#tabList-all span").addClass('badge-primary').removeClass('badge-secondary');
            @endif
        });

        $keyword.autocomplete({
            source: function (request, response) {
                $.getJSON('{{route('get.title.portfolios', ['title' => ''])}}/' + $keyword.val(), {
                    name: request.term,
                }, function (data) {
                    response(data);
                });
            },
            focus: function (event, ui) {
                event.preventDefault();
            },
            select: function (event, ui) {
                event.preventDefault();
                $keyword.val(ui.item.nama);
                $("#tabList-" + ui.item.jenis_id).click();
                $("#tabList-" + ui.item.jenis_id + " span").addClass('badge-primary').removeClass('badge-secondary');
            }
        });

        $keyword.on('keyup', function () {
            if (!$keyword.val()) {
                $("#tabList-all").click();
                $("#tabList-all span").addClass('badge-primary').removeClass('badge-secondary');
                loadPortfolios();
            }
        });

        $("#form-loadPortfolio").on('submit', function (e) {
            e.preventDefault();
            loadPortfolios();
        });

        function decodeHtml(html) {
            var txt = document.createElement("textarea");
            txt.innerHTML = html;
            return txt.value;
        }

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
                    '<div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 item" data-aos="zoom-out">' +
                    '<article class="download-card Card">' +
                    '<a href="{{url('/portfolios')}}/' + val.jenis + '/' + val.enc_id + '/galleries">' +
                    '<div class="download-card__icon-box">' +
                    '<img src="' + val.cover + '"' +
                    'alt="Cover" class="img-fluid"></div></a>' +
                    '<div class="Card-thumbnailOverlay">' +
                    '<div class="text-center">' +
                    '<h2 class="mb-3" style="text-transform: uppercase">' + val.nama + '</h2>' +
                    '<a href="{{url('/portfolios')}}/' + val.jenis + '/' + val.enc_id + '/galleries" class="Card-Btn">' +
                    '<strong>' + val.galleries + ' footage</strong>' +
                    '</a></div></div></article></div>';
            });
            $("#search-result").empty().append($result);

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
                $page = '&page=' + page;
            }
            window.history.replaceState("", "", '{{url('/portfolios')}}?q=' + $keyword.val() + '&category=' + $("#jenis").val() + $page);

            setTimeout(function () {
                $('.use-nicescroll').getNiceScroll().resize()
            }, 600);
            return false;
        }
    </script>
@endpush
