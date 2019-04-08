@extends('layouts.mst_user')
@section('title', 'FAQ | Rabbit Media – Digital Creative Service')
@push('styles')
    <link rel="stylesheet" href="{{asset('css/info.css')}}">
@endpush
@section('content')
    <div class="site-section">
        <div class="container-fluid">
            <div id="faqs" class="row justify-content-center">
                <div class="col-md-7">
                    <div class="row mb-5">
                        <div class="col-12">
                            <h3 class="site-section-heading text-center" data-aos="fade-right">FAQ</h3>
                            <h5 class="text-center" data-aos="fade-left">Segala sesuatu yang Anda harus ketahui sebelum
                                menggunakan aplikasi Rabbit Media dan kami disini untuk membantu Anda!</h5>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-xl-8 col-lg-8 col-md-10 col-sm-12">
                    <div class="accordion">
                        @foreach($faqs as $faq)
                            <div class="accordion-item" data-aos="fade-down">
                                <a>{{$faq->pertanyaan}}</a>
                                <div class="content">
                                    <p>{{$faq->jawaban}}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        const items = document.querySelectorAll(".accordion a");

        function toggleAccordion() {
            this.classList.toggle("active");
            this.nextElementSibling.classList.toggle("active");
        }

        items.forEach(item => item.addEventListener("click", toggleAccordion));
    </script>
@endpush