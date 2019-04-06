@extends('layouts.mst_user')
@section('title', 'Service: '.ucwords($data->nama).' Pricing | Rabbit Media – Digital Creative Service')
@push('styles')
    <style>
        .pricing .card {
            border: none;
            border-radius: 0;
            transition: all 0.2s;
            box-shadow: 0 0.5rem 1rem 0 rgba(0, 0, 0, 0.1);
        }

        .pricing hr {
            margin: 1.5rem 0;
        }

        .pricing .card-title {
            margin: 0.5rem 0;
            font-size: 0.9rem;
            letter-spacing: .1rem;
            font-weight: bold;
        }

        .pricing .card-price {
            font-size: 3rem;
            margin: 0;
        }

        .pricing .card-price .period {
            font-size: 0.8rem;
        }

        .pricing .price-before-disc {
            margin-top: 10px;
            text-decoration: line-through;
            font-size: 32px;
            color: #ddd
        }

        .pricing .discount {
            font-size: 16px;
            font-weight: 600;
            margin-top: -10px;
            margin-bottom: 10px;
            color: #592f83;
        }

        .pricing ul li {
            margin-bottom: 1rem;
        }

        .pricing .text-muted {
            opacity: 0.7;
        }

        .pricing .btn {
            font-size: 80%;
            border-radius: 0;
            letter-spacing: .1rem;
            font-weight: bold;
            padding: 1rem;
            opacity: 0.7;
            transition: all 0.2s;
        }

        /* Hover Effects on Card */

        @media (min-width: 992px) {
            .pricing .card:hover {
                margin-top: -.25rem;
                margin-bottom: .25rem;
                box-shadow: 0 0.5rem 1rem 0 rgba(0, 0, 0, 0.3);
            }

            .pricing .card:hover .btn {
                opacity: 1;
            }
        }
    </style>
@endpush
@section('content')
    <div class="site-section">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-md-7">
                    <div class="row mb-5">
                        <div class="col-12 ">
                            <h3 class="site-section-heading text-center"
                                data-aos="fade-right">{{ucwords($data->nama)}}</h3>
                            <h5 class="text-center" data-aos="fade-left">{{$data->deskripsi}}</h5>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-11">
                    <div class="row grid pricing">
                        @foreach($data->getLayanan as $row)
                            @php
                                $price = number_format($row->harga - ($row->harga * $row->diskon/100),2,',','.');
                            @endphp
                            <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 mb-3 grid-item" data-aos="zoom-in">
                                <div class="card mb-5 mb-lg-0">
                                    <div class="card-body">
                                        <h5 class="card-title text-muted text-uppercase text-center">{{$row->paket}}</h5>
                                        <div class="price-before-disc text-center">
                                            Rp{{number_format($row->harga,2,',','.')}}</div>
                                        <h6 class="card-price text-center">Rp{{$price}}</h6>
                                        <div class="discount text-center">Hemat {{$row->diskon}}%</div>
                                        <hr>
                                        <ul class="fa-ul">
                                            <li><span class="fa-li"><i class="fas fa-check"></i></span>Single User</li>
                                            <li><span class="fa-li"><i class="fas fa-check"></i></span>5GB Storage</li>
                                            <li><span class="fa-li"><i class="fas fa-check"></i></span>Unlimited Public
                                                Projects
                                            </li>
                                            <li><span class="fa-li"><i class="fas fa-check"></i></span>Community Access
                                            </li>
                                            <li class="text-muted"><span class="fa-li"><i
                                                            class="fas fa-times"></i></span>Unlimited Private Projects
                                            </li>
                                            <li class="text-muted"><span class="fa-li"><i
                                                            class="fas fa-times"></i></span>Dedicated Phone Support
                                            </li>
                                            <li class="text-muted"><span class="fa-li"><i
                                                            class="fas fa-times"></i></span>Free Subdomain
                                            </li>
                                            <li class="text-muted"><span class="fa-li"><i
                                                            class="fas fa-times"></i></span>Monthly Status Reports
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="card-footer" style="padding: 0;">
                                        <a href="#" class="btn btn-block btn-primary text-uppercase">pilih</a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection