@extends('layouts.mst_user')
@section('title', 'Services | Rabbit Media – Digital Creative Service')
@push('styles')
    <style>
        .services .card {
            padding: 1rem !important;
            border: none;
            margin-bottom: 1rem;
            -webkit-transition: .5s all ease;
            -moz-transition: .5s all ease;
            transition: .5s all ease;
        }

        .services .card:hover {
            -webkit-box-shadow: 5px 7px 9px -4px rgb(158, 158, 158);
            -moz-box-shadow: 5px 7px 9px -4px rgb(158, 158, 158);
            box-shadow: 5px 7px 9px -4px rgb(158, 158, 158);
        }

        .services .card .card-block {
            padding-left: 50px;
            position: relative;
        }

        .services .card .card-block a {
            color: #592f83 !important;
            font-weight: 700;
            text-decoration: none;
        }

        .services .card .card-block a i {
            display: none;

        }

        .services .card:hover .card-block a i {
            display: inline-block;
            font-weight: 700;

        }

        .services .card .icon {
            width: 60px;
            position: absolute;
            left: -20px;
            -webkit-transition: -webkit-transform .2s ease-in-out;
            transition: transform .2s ease-in-out;
        }

        .services .card:hover .icon {
            -webkit-transform: rotate(360deg);
            transform: rotate(360deg);
            -webkit-transition: .5s all ease;
            -moz-transition: .5s all ease;
            transition: .5s all ease;
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
                            <h3 class="site-section-heading text-center" data-aos="fade-right">Services</h3>
                            <h5 class="text-center" data-aos="fade-left">Apakah Anda ingin mengabadikan momen bahagia
                                Anda secara profesional? Wujudkanlah sekarang bersama kami!</h5>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-11">
                    <div class="row grid services" id="content1">
                        @foreach($types as $type)
                            <div class="col-sm-6 col grid-item" data-aos="zoom-in"
                                 data-aos-delay="500">
                                <div class="card">
                                    <div class="card-block">
                                        <img class="icon img-fluid" src="{{asset('images/services/'.$type->icon)}}">
                                        <h3 class="card-title">{{$type->nama}}</h3>
                                        <p class="card-text">{{$type->deskripsi}}</p>
                                        <a class="read-more" href="{{route('show.service.pricing', [
                                        'jenis' => strtolower(str_replace(' ', '-', $type->nama)),
                                        'id' =>encrypt($type->id)])}}">Read more<i class="fa fa-chevron-right ml-2"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        <div class="col-sm-6 col grid-item" data-aos="zoom-in"
                             data-aos-delay="500">
                            <div class="card">
                                <div class="card-block">
                                    <img class="icon img-fluid" src="{{asset('images/services/package.png')}}">
                                    <h3 class="card-title">Package</h3>
                                    <p class="card-text">Paket wedding, paket event, paket desain, dan lainnya.</p>
                                    <a class="read-more show_pack" href="javascript:void(0)">
                                        Read more<i class="fa fa-chevron-right ml-2"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row services content2" style="display: none">
                        @foreach($packs as $type)
                            <div class="col-sm-6 col-md-4 col-lg-4 col-xl-4" data-aos="zoom-in"
                                 data-aos-delay="500">
                                <div class="card">
                                    <div class="card-block">
                                        <img class="icon img-fluid" src="{{asset('images/services/'.$type->icon)}}">
                                        <h3 class="card-title">{{$type->nama}}</h3>
                                        <p class="card-text">{{$type->deskripsi}}</p>
                                        @if($type->nama == 'Design Pack')
                                            <a class="read-more" href="javascript:void(0)" onclick="comingSoon()">Read
                                                more<i class="fa fa-chevron-right ml-2"></i>
                                            </a>
                                        @else
                                            <a class="read-more" href="{{route('show.service.pricing', [
                                            'jenis' => strtolower(str_replace(' ', '-', $type->nama)),
                                            'id' =>encrypt($type->id)])}}">Read more<i
                                                    class="fa fa-chevron-right ml-2"></i>
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="row content2" style="display: none" data-aos="fade-up" data-aos-delay="500">
                        <div class="col text-center">
                            <button class="btn btn-primary btn-sm py-2 px-4 show_pack text-white text-uppercase">
                                <i class="fa fa-chevron-left mr-2"></i>Back
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        $(".show_pack").on('click', function () {
            $("#content1").toggle(300);
            $(".content2").toggle(300);
            setTimeout(function () {
                $('.use-nicescroll').getNiceScroll().resize()
            }, 600);
        });

        function comingSoon() {
            swal('Coming Soon!', 'Layanan ini masih dalam proses pengembangan.', 'info');
        }
    </script>
@endpush
