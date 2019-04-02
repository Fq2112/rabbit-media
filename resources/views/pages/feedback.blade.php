@extends('layouts.mst_user')
@section('title', 'Feedback | Rabbit Media – Digital Creative Service')
@push('styles')
    <style>
        .carousel {
            width: 650px;
            margin: 0 auto;
            padding-bottom: 50px;
        }

        .carousel .item {
            color: #999;
            font-size: 14px;
            text-align: center;
            overflow: hidden;
            min-height: 340px;
        }

        .carousel .item a {
            color: #eb7245;
        }

        .carousel .img-box {
            width: 145px;
            height: 145px;
            margin: 0 auto;
            border-radius: 50%;
        }

        .carousel .img-box img {
            width: 100%;
            height: 100%;
            display: block;
            border-radius: 50%;
        }

        .carousel .testimonial {
            padding: 30px 0 10px;
        }

        .carousel .overview {
            text-align: center;
            padding-bottom: 5px;
        }

        .carousel .overview b {
            color: #333;
            font-size: 15px;
            text-transform: uppercase;
            display: block;
            padding-bottom: 5px;
        }

        .carousel .star-rating i {
            font-size: 18px;
            color: #ffdc12;
        }

        .carousel .carousel-control {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            background: #999;
            text-shadow: none;
            top: 4px;
        }

        .carousel-control i {
            font-size: 20px;
            margin-right: 2px;
        }

        .carousel-control.left {
            left: auto;
            right: 40px;
        }

        .carousel-control.right i {
            margin-right: -2px;
        }

        .carousel .carousel-indicators {
            bottom: 15px;
        }

        .carousel-indicators li, .carousel-indicators li.active {
            width: 11px;
            height: 11px;
            margin: 1px 5px;
            border-radius: 50%;
        }

        .carousel-indicators li {
            background: #e2e2e2;
            border-color: transparent;
        }

        .carousel-indicators li.active {
            border: none;
            background: #888;
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
                            <h3 class="site-section-heading text-center">Testimonials</h3>
                            <h5 class="text-center">See what our customers say about us!</h5>
                        </div>
                    </div>
                </div>
                <div id="myCarousel" class="carousel slide" data-ride="carousel">
                    <!-- Carousel indicators -->
                    <ol class="carousel-indicators">
                        <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
                        <li data-target="#myCarousel" data-slide-to="1"></li>
                        <li data-target="#myCarousel" data-slide-to="2"></li>
                    </ol>
                    <!-- Wrapper for carousel items -->
                    <div class="carousel-inner">
                        <div class="item carousel-item active">
                            <div class="img-box"><img src="/examples/images/clients/3.jpg" alt=""></div>
                            <p class="testimonial">Phasellus vitae suscipit justo. Mauris pharetra feugiat ante id
                                lacinia. Etiam faucibus mauris id tempor egestas. Duis luctus turpis at accumsan
                                tincidunt. Phasellus risus risus, volutpat vel tellus ac, tincidunt fringilla massa.
                                Etiam hendrerit dolor eget rutrum.</p>
                            <p class="overview"><b>Michael Holz</b>Seo Analyst at <a href="#">OsCorp Tech.</a></p>
                            <div class="star-rating">
                                <ul class="list-inline">
                                    <li class="list-inline-item"><i class="fa fa-star"></i></li>
                                    <li class="list-inline-item"><i class="fa fa-star"></i></li>
                                    <li class="list-inline-item"><i class="fa fa-star"></i></li>
                                    <li class="list-inline-item"><i class="fa fa-star"></i></li>
                                    <li class="list-inline-item"><i class="fa fa-star-o"></i></li>
                                </ul>
                            </div>
                        </div>
                        <div class="item carousel-item">
                            <div class="img-box"><img src="/examples/images/clients/1.jpg" alt=""></div>
                            <p class="testimonial">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam eu sem
                                tempor, varius quam at, luctus dui. Mauris magna metus, dapibus nec turpis vel, semper
                                malesuada ante. Vestibulum idac nisl bibendum scelerisque non non purus. Suspendisse
                                varius nibh non aliquet.</p>
                            <p class="overview"><b>Paula Wilson</b>Media Analyst at <a href="#">SkyNet Inc.</a></p>
                            <div class="star-rating">
                                <ul class="list-inline">
                                    <li class="list-inline-item"><i class="fa fa-star"></i></li>
                                    <li class="list-inline-item"><i class="fa fa-star"></i></li>
                                    <li class="list-inline-item"><i class="fa fa-star"></i></li>
                                    <li class="list-inline-item"><i class="fa fa-star"></i></li>
                                    <li class="list-inline-item"><i class="fa fa-star-o"></i></li>
                                </ul>
                            </div>
                        </div>
                        <div class="item carousel-item">
                            <div class="img-box"><img src="/examples/images/clients/2.jpg" alt=""></div>
                            <p class="testimonial">Vestibulum quis quam ut magna consequat faucibus. Pellentesque eget
                                nisi a mi suscipit tincidunt. Utmtc tempus dictum risus. Pellentesque viverra sagittis
                                quam at mattis. Suspendisse potenti. Aliquam sit amet gravida nibh, facilisis gravida
                                odio. Phasellus auctor velit.</p>
                            <p class="overview"><b>Antonio Moreno</b>Web Developer at <a href="#">Circle Ltd.</a></p>
                            <div class="star-rating">
                                <ul class="list-inline">
                                    <li class="list-inline-item"><i class="fa fa-star"></i></li>
                                    <li class="list-inline-item"><i class="fa fa-star"></i></li>
                                    <li class="list-inline-item"><i class="fa fa-star"></i></li>
                                    <li class="list-inline-item"><i class="fa fa-star"></i></li>
                                    <li class="list-inline-item"><i class="fa fa-star-half-o"></i></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <!-- Carousel controls -->
                    <a class="carousel-control left carousel-control-prev" href="#myCarousel" data-slide="prev">
                        <i class="fa fa-angle-left"></i>
                    </a>
                    <a class="carousel-control right carousel-control-next" href="#myCarousel" data-slide="next">
                        <i class="fa fa-angle-right"></i>
                    </a>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-md-7">
                    <div class="row mb-5">
                        <div class="col-12 ">
                            <h3 class="site-section-heading text-center">Review Us</h3>
                            <h5 class="text-center">Ceritakan pengalaman Anda menggunakan layanan kami!</h5>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-8 mb-5">
                            <form action="#">
                                <div class="row form-group">
                                    <div class="col-md-6 mb-3 mb-md-0">
                                        <label class="text-black" for="fname">First Name</label>
                                        <input type="text" id="fname" class="form-control">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="text-black" for="lname">Last Name</label>
                                        <input type="text" id="lname" class="form-control">
                                    </div>
                                </div>

                                <div class="row form-group">

                                    <div class="col-md-12">
                                        <label class="text-black" for="email">Email</label>
                                        <input type="email" id="email" class="form-control">
                                    </div>
                                </div>

                                <div class="row form-group">

                                    <div class="col-md-12">
                                        <label class="text-black" for="subject">Subject</label>
                                        <input type="subject" id="subject" class="form-control">
                                    </div>
                                </div>

                                <div class="row form-group">
                                    <div class="col-md-12">
                                        <label class="text-black" for="message">Message</label>
                                        <textarea name="message" id="message" cols="30" rows="7" class="form-control"
                                                  placeholder="Write your notes or questions here..."></textarea>
                                    </div>
                                </div>

                                <div class="row form-group">
                                    <div class="col-md-12">
                                        <input type="submit" value="Send Message"
                                               class="btn btn-primary py-2 px-4 text-white">
                                    </div>
                                </div>


                            </form>
                        </div>
                        <div class="col-lg-3 ml-auto">
                            <div class="mb-3 bg-white">
                                <p class="mb-0 font-weight-bold">Address</p>
                                <p class="mb-4">203 Fake St. Mountain View, San Francisco, California, USA</p>

                                <p class="mb-0 font-weight-bold">Phone</p>
                                <p class="mb-4"><a href="#">+1 232 3235 324</a></p>

                                <p class="mb-0 font-weight-bold">Email Address</p>
                                <p class="mb-0"><a href="#">youremail@domain.com</a></p>

                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection