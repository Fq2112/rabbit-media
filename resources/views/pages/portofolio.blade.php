@extends('layouts.mst_user')
@section('title', 'Portfolios | Rabbit Media – Digital Creative Service')
@push('styles')
    <link rel="stylesheet" href="{{asset('css/myPagination.css')}}">
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
                            <h5 class="text-center">Kumpulan karya terbaik dari Rabbit's | Capture and bring your moment
                                with us!</h5>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center" id="tabs">
                <nav class="col-10">
                    <div class="nav nav-tabs nav-fill" id="nav-tab" role="tablist">
                        <a class="nav-item nav-link show active" style="color: #495057" id="tabList-all"
                           data-toggle="tab"
                           href="#tabContent-all" role="tab" aria-controls="nav-home" aria-selected="true">Show All</a>
                        @foreach($types as $row)
                            <a class="nav-item nav-link" onclick="filterPortfolio('{{$row->id}}')"
                               style="color: #495057"
                               id="tabList-{{$row->id}}" data-toggle="tab" href="#tabContent-{{$row->id}}"
                               role="tab" aria-controls="nav-home" aria-selected="true">{{$row->nama}}</a>
                        @endforeach
                    </div>
                </nav>
                <div class="col-11 tab-content py-3 px-3 px-sm-0" id="nav-tabContent">
                    <div class="tab-pane fade show active" role="tabpanel" id="tabContent-all"
                         aria-labelledby="nav-home-tab" style="margin-left: -1.5rem;">
                        <div class="row grid">
                            @foreach($portfolios as $row)
                                <div class="col-3 item grid-item" data-aos="fade">
                                    <article class="download-card Card">
                                        <a href="{{route('show.portfolio.gallery', ['jenis' =>
                                        strtolower($row->getJenisPortofolio->nama), 'id' => encrypt($row->id)])}}">
                                            <div class="download-card__icon-box">
                                                <img src="{{$row->cover == 'img_1.jpg' || $row->cover == 'img_2.jpg' ||
                                                $row->cover == 'img_3.jpg' || $row->cover == 'img_4.jpg' ||
                                                $row->cover == 'img_5.jpg' || $row->cover == 'img_6.jpg' ||
                                                $row->cover == 'img_7.jpg' ? asset('images/'.$row->cover) :
                                                asset('storage/portofolio/'.strtolower(str_replace
                                                (' ', '_', $row->getJenisPortofolio->nama).'/'.$row->id.'/'.$row->cover))}}"
                                                     alt="Cover" class="img-fluid">
                                            </div>
                                        </a>
                                        <div class="Card-thumbnailOverlay">
                                            <div class="text-center">
                                                <h2 class="mb-3">{{ucwords($row->nama)}}</h2>
                                                <a href="{{route('show.portfolio.gallery', ['jenis' => strtolower($row
                                                ->getJenisPortofolio->nama), 'id' => encrypt($row->id)])}}"
                                                   class="Card-Btn">
                                                    <strong>{{count($row->getGaleri) . ' footage'}}</strong>
                                                </a>
                                            </div>
                                        </div>
                                    </article>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    @foreach($types as $row)
                        <div class="tab-pane fade" role="tabpanel" id="tabContent-{{$row->id}}"
                             aria-labelledby="nav-home-tab" style="margin-left: -1.5rem;">
                            <div class="row grid">
                                @foreach($row->getPortofolio as $row)
                                    <div class="col-3 item grid-item" data-aos="fade">
                                        <article class="download-card Card">
                                            <a href="{{route('show.portfolio.gallery', ['jenis' =>
                                            strtolower($row->getJenisPortofolio->nama), 'id' => encrypt($row->id)])}}">
                                                <div class="download-card__icon-box">
                                                    <img src="{{$row->cover == 'img_1.jpg' || $row->cover == 'img_2.jpg' ||
                                                    $row->cover == 'img_3.jpg' || $row->cover == 'img_4.jpg' ||
                                                    $row->cover == 'img_5.jpg' || $row->cover == 'img_6.jpg' ||
                                                    $row->cover == 'img_7.jpg' ? asset('images/'.$row->cover) :
                                                    asset('storage/portofolio/'.strtolower(str_replace
                                                    (' ', '_', $row->getJenisPortofolio->nama).'/'.$row->id.'/'.$row->cover))}}"
                                                         alt="Cover" class="img-fluid">
                                                </div>
                                            </a>
                                            <div class="Card-thumbnailOverlay">
                                                <div class="text-center">
                                                    <h2 class="mb-3">{{ucwords($row->nama)}}</h2>
                                                    <a href="{{route('show.portfolio.gallery', ['jenis' => strtolower
                                                    ($row->getJenisPortofolio->nama), 'id' => encrypt($row->id)])}}"
                                                       class="Card-Btn">
                                                        <strong>{{count($row->getGaleri) . ' footage'}}</strong>
                                                    </a>
                                                </div>
                                            </div>
                                        </article>
                                    </div>
                                @endforeach
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
        function filterPortfolio(id) {
            $("#nav-tab a").removeClass('show active');
            $("#nav-tabContent .tab-pane").removeClass('show active');

            $("#tabList-" + id).addClass('show active');
            $("#tabContent-" + id).addClass('show active');
        }
    </script>
@endpush