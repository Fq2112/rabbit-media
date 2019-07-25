@extends('layouts.mst_user')
@section('title', 'Information | Rabbit Media – Digital Creative Service')
@push('styles')
    <link rel="stylesheet" href="{{asset('css/info.css')}}">
@endpush
@section('content')
    <div class="site-section">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-md-7">
                    <div class="row mb-5">
                        <div class="col-12">
                            <h3 class="site-section-heading text-center" data-aos="fade-right">Information</h3>
                            <h5 class="text-center" data-aos="fade-left">{{$info->caption}}</h5>
                        </div>
                    </div>
                    <div class="row mb-5">
                        <div class="col" data-aos="fade-down">
                            <img src="{{asset('images/'.$info->icon)}}" alt="Our Pride" class="wrapReady">
                            {!! $info->terms_conditions !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push("scripts")
    <script>
        $(function () {
            $('.wrapReady').slickWrap({
                cutoff: 10,
                resolution: 15,
                bloomPadding: true
            });
        });
    </script>
@endpush