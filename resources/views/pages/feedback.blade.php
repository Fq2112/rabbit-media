@extends('layouts.mst_user')
@section('title', 'Feedback | Rabbit Media – Digital Creative Service')
@push('styles')
    <link rel="stylesheet" href="{{asset('css/feedback.css')}}">
@endpush
@section('content')
    <div class="site-section" data-aos="fade">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-md-7">
                    <div class="row mb-4">
                        <div class="col-12">
                            <h3 class="site-section-heading text-center" data-aos="fade-right">Feedback</h3>
                            <h5 class="text-center" data-aos="fade-left">Beri kami ulasan dengan membagikan pengalaman
                                Anda tentang
                                layanan kami!</h5>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-xl-3 col-lg-3 col-md-12 col-sm-12 average text-center" data-aos="fade-right">
                            <div class="row score">
                                <div class="col">
                                    {{number_format($average, 1, '.', '')}}
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    {{count($feedback)}} ulasan
                                </div>
                            </div>
                            <div class="row rate">
                                <div class="col">
                                    @if(round($average * 2) / 2 == 1)
                                        <i class="fa fa-star"></i>
                                        <i class="far fa-star"></i>
                                        <i class="far fa-star"></i>
                                        <i class="far fa-star"></i>
                                        <i class="far fa-star"></i>
                                    @elseif(round($average * 2) / 2 == 2)
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="far fa-star"></i>
                                        <i class="far fa-star"></i>
                                        <i class="far fa-star"></i>
                                    @elseif(round($average * 2) / 2 == 3)
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="far fa-star"></i>
                                        <i class="far fa-star"></i>
                                    @elseif(round($average * 2) / 2 == 4)
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="far fa-star"></i>
                                    @elseif(round($average * 2) / 2 == 5)
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                    @elseif(round($average * 2) / 2 == 0.5)
                                        <i class="fa fa-star-half-alt"></i>
                                        <i class="far fa-star"></i>
                                        <i class="far fa-star"></i>
                                        <i class="far fa-star"></i>
                                        <i class="far fa-star"></i>
                                    @elseif(round($average * 2) / 2 == 1.5)
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star-half-alt"></i>
                                        <i class="far fa-star"></i>
                                        <i class="far fa-star"></i>
                                        <i class="far fa-star"></i>
                                    @elseif(round($average * 2) / 2 == 2.5)
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star-half-alt"></i>
                                        <i class="far fa-star"></i>
                                        <i class="far fa-star"></i>
                                    @elseif(round($average * 2) / 2 == 3.5)
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star-half-alt"></i>
                                        <i class="far fa-star"></i>
                                    @elseif(round($average * 2) / 2 == 4.5)
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star-half-alt"></i>
                                    @endif
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <button onclick="feedbackModal()" type="button"
                                            class="btn btn-outline-primary btn-block">
                                        @auth
                                            <i class="fa fa-edit"></i>&ensp;{{\App\Models\Feedback::where
                                            ('user_id', Auth::id())->count() > 0 ? 'Sunting' : 'Tulis'}} Ulasan
                                        @else
                                            <i class="fa fa-edit"></i>&ensp;Tulis Ulasan
                                        @endauth
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-9 col-lg-9 col-md-12 col-sm-12 reviews text-right" data-aos="fade-left">
                            <div class="row rate">
                                <div class="col-3">
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                </div>
                                <div class="col-9">
                                    <div class="progress-reviews">
                                        <div class="progress-bar progress-bar-striped progress-bar-animated"
                                             role="progressbar" aria-valuenow="{{$star5}}" aria-valuemin="0"
                                             aria-valuemax="100" style="width: {{$star5}}%" data-toggle="tooltip"
                                             data-placement="right" title="{{$star5}}%"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="row rate">
                                <div class="col-3">
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                </div>
                                <div class="col-9">
                                    <div class="progress-reviews">
                                        <div class="progress-bar progress-bar-striped progress-bar-animated"
                                             role="progressbar" aria-valuenow="{{$star4}}" aria-valuemin="0"
                                             aria-valuemax="100" style="width: {{$star4}}%" data-toggle="tooltip"
                                             data-placement="right" title="{{$star4}}%"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="row rate">
                                <div class="col-3">
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                </div>
                                <div class="col-9">
                                    <div class="progress-reviews">
                                        <div class="progress-bar progress-bar-striped progress-bar-animated"
                                             role="progressbar" aria-valuenow="{{$star3}}" aria-valuemin="0"
                                             aria-valuemax="100" style="width: {{$star3}}%" data-toggle="tooltip"
                                             data-placement="right" title="{{$star3}}%"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="row rate">
                                <div class="col-3">
                                    <i class="fa fa-star"></i>
                                    <i class="fa fa-star"></i>
                                </div>
                                <div class="col-9">
                                    <div class="progress-reviews">
                                        <div class="progress-bar progress-bar-striped progress-bar-animated"
                                             role="progressbar" aria-valuenow="{{$star2}}" aria-valuemin="0"
                                             aria-valuemax="100" style="width: {{$star2}}%" data-toggle="tooltip"
                                             data-placement="right" title="{{$star2}}%"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="row rate">
                                <div class="col-3">
                                    <i class="fa fa-star"></i>
                                </div>
                                <div class="col-9">
                                    <div class="progress-reviews">
                                        <div class="progress-bar progress-bar-striped progress-bar-animated"
                                             role="progressbar" aria-valuenow="{{$star1}}" aria-valuemin="0"
                                             aria-valuemax="100" style="width: {{$star1}}%" data-toggle="tooltip"
                                             data-placement="right" title="{{$star1}}%"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center" data-aos="zoom-in-up" data-aos-delay="500">
                <div id="customers-testimonials" class="owl-carousel">
                    @foreach($feedback as $row)
                        <div class="item avatar">
                            <div class="shadow-effect">
                                <img class="img-thumbnail" alt="Avatar" src="{{$row->getUser->ava != "" ?
                                asset('storage/users/ava/'.$row->getUser->ava) : asset('images/avatar.png')}}">
                                <p class="testimonial-comment">
                                    @if($row->rate == 1)
                                        <i class="fa fa-star"></i>
                                        <i class="far fa-star"></i>
                                        <i class="far fa-star"></i>
                                        <i class="far fa-star"></i>
                                        <i class="far fa-star"></i>
                                    @elseif($row->rate == 2)
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="far fa-star"></i>
                                        <i class="far fa-star"></i>
                                        <i class="far fa-star"></i>
                                    @elseif($row->rate == 3)
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="far fa-star"></i>
                                        <i class="far fa-star"></i>
                                    @elseif($row->rate == 4)
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="far fa-star"></i>
                                    @elseif($row->rate == 5)
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                    @elseif($row->rate == 0.5)
                                        <i class="fa fa-star-half-alt"></i>
                                        <i class="far fa-star"></i>
                                        <i class="far fa-star"></i>
                                        <i class="far fa-star"></i>
                                        <i class="far fa-star"></i>
                                    @elseif($row->rate == 1.5)
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star-half-alt"></i>
                                        <i class="far fa-star"></i>
                                        <i class="far fa-star"></i>
                                        <i class="far fa-star"></i>
                                    @elseif($row->rate == 2.5)
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star-half-alt"></i>
                                        <i class="far fa-star"></i>
                                        <i class="far fa-star"></i>
                                    @elseif($row->rate == 3.5)
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star-half-alt"></i>
                                        <i class="far fa-star"></i>
                                    @elseif($row->rate == 4.5)
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star"></i>
                                        <i class="fa fa-star-half-alt"></i>
                                    @endif
                                    <br><cite>&ldquo;{{$row->comment}}&rdquo;</cite>
                                </p>
                            </div>
                            <div class="testimonial-name">{{$row->getUser->name}}</div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    @auth
        @php $find = \App\Models\Feedback::where('user_id', Auth::id())->first(); @endphp
        <div class="modal fade" id="feedbackModal" tabindex="-1" role="dialog" aria-labelledby="feedbackModalLabel"
             aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title"
                            id="feedbackModalLabel">{{$find != "" ? 'Edit Review' : 'Review Us'}}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="{{route('feedback.submit')}}" method="POST">
                        {{csrf_field()}}
                        <input type="hidden" name="check_form" value="{{$find != "" ? $find->id : 'create'}}">
                        <div class="modal-body">
                            <div class="row form-group">
                                <div class="col-12">
                                    <fieldset id="rating" class="rating" aria-required="true">
                                        <label class="full" for="star5" data-toggle="tooltip" title="Best"></label>
                                        <input type="radio" id="star5" name="rating" value="5" required {{$find != "" &&
                                        $find->rate == '5' ? 'checked' : ''}}>

                                        <label class="half" for="star4half" data-toggle="tooltip"
                                               title="Awesome"></label>
                                        <input type="radio" id="star4half" name="rating" value="4.5" {{$find != "" &&
                                        $find->rate == '4.5' ? 'checked' : ''}}>

                                        <label class="full" for="star4" data-toggle="tooltip"
                                               title="Pretty good"></label>
                                        <input type="radio" id="star4" name="rating" value="4" {{$find != "" &&
                                        $find->rate == '4' ? 'checked' : ''}}>

                                        <label class="half" for="star3half" data-toggle="tooltip" title="Good"></label>
                                        <input type="radio" id="star3half" name="rating" value="3.5" {{$find != "" &&
                                        $find->rate == '3.5' ? 'checked' : ''}}>

                                        <label class="full" for="star3" data-toggle="tooltip" title="Standard"></label>
                                        <input type="radio" id="star3" name="rating" value="3" {{$find != "" &&
                                        $find->rate == '3' ? 'checked' : ''}}>

                                        <label class="half" for="star2half" data-toggle="tooltip"
                                               title="Kinda bad"></label>
                                        <input type="radio" id="star2half" name="rating" value="2.5" {{$find != "" &&
                                        $find->rate == '2.5' ? 'checked' : ''}}>

                                        <label class="full" for="star2" data-toggle="tooltip" title="Bad"></label>
                                        <input type="radio" id="star2" name="rating" value="2" {{$find != "" &&
                                        $find->rate == '2' ? 'checked' : ''}}>

                                        <label class="half" for="star1half" data-toggle="tooltip"
                                               title="Too bad"></label>
                                        <input type="radio" id="star1half" name="rating" value="1.5" {{$find != "" &&
                                        $find->rate == '1.5' ? 'checked' : ''}}>

                                        <label class="full" for="star1" data-toggle="tooltip" title="Pathetic"></label>
                                        <input type="radio" id="star1" name="rating" value="1" {{$find != "" &&
                                        $find->rate == '1' ? 'checked' : ''}}>

                                        <label class="half" for="starhalf" data-toggle="tooltip"
                                               title="Sucks big time"></label>
                                        <input type="radio" id="starhalf" name="rating" value="0.5" {{$find != "" &&
                                        $find->rate == '0.5' ? 'checked' : ''}}>
                                    </fieldset>

                                    <textarea name="comment" id="comment" class="form-control" style="resize: vertical"
                                              placeholder="Bagikan pengalaman Anda tentang layanan kami disini&hellip;"
                                              required autofocus>{{$find != "" ? $find->comment : ''}}</textarea>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            @if($find != "")
                                <a href="{{route('feedback.delete',['id' => encrypt($find->id)])}}"
                                   class="btn btn-light delete-data">Delete</a>
                            @endif
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">{{$find != "" ? 'Save Changes' : 'Submit'}}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endauth
@endsection
@push('scripts')
    <script>
        $(function ($) {
            "use strict";
            $('#customers-testimonials').owlCarousel({
                loop: true,
                center: true,
                items: '{{count($feedback)}}',
                margin: 0,
                autoplay: true,
                dots: true,
                smartSpeed: 450,
                responsive: {
                    0: {
                        items: 1
                    },
                    768: {
                        items: 2
                    },
                    1170: {
                        items: 3
                    }
                }
            });
        });

        function feedbackModal() {
            @if(Auth::check())
            $("#feedbackModal").modal('show');
            @elseif(Auth::guard('admin')->check())
            swal('PERHATIAN!', 'Fitur ini hanya dapat digunakan oleh user non-admin saja.', 'warning');
            @else
            openLoginModal();
            @endif
        }
    </script>
@endpush