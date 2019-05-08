@extends('layouts.auth.mst_admin')
@section('title', 'The Rabbits: Company Profile | Rabbit Media – Digital Creative Service')
@push('styles')
    <link rel="stylesheet" href="{{asset('admins/modules/summernote/summernote-bs4.css')}}">
@endpush
@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Company Profile</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{route('home-admin')}}">Dashboard</a></div>
                <div class="breadcrumb-item">Data Master</div>
                <div class="breadcrumb-item">Company Profile</div>
                <div class="breadcrumb-item">About</div>
            </div>
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header">
                            <h4>Jump To</h4>
                        </div>
                        <div class="card-body">
                            <ul class="nav nav-pills flex-column">
                                <li class="nav-item">
                                    <a id="gs" href="javascript:void(0)" class="nav-link active">General Settings</a>
                                </li>
                                <li class="nav-item">
                                    <a id="vs" href="javascript:void(0)" class="nav-link">Vision & Mission</a>
                                </li>
                                <li class="nav-item">
                                    <a id="tc" href="javascript:void(0)" class="nav-link">Terms & Conditions</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-md-8">
                    <form id="form-compro" method="post" action="{{route('update.company.profile')}}"
                          enctype="multipart/form-data">
                        {{csrf_field()}}
                        {{method_field('PUT')}}
                        <input type="hidden" name="check_form" value="gs">
                        <input type="hidden" name="id" value="{{$about->id}}">
                        <div class="card">
                            <div class="card-header"><h4>General Settings</h4></div>
                            <div class="card-body">
                                <div id="gs-input">
                                    <div class="form-group row align-items-center">
                                        <label for="mascot" class="form-control-label col-sm-3 text-md-right">
                                            <img id="btn_mascot" class="img-fluid" alt="Mascot"
                                                 src="{{asset('images/'.$about->icon)}}" style="cursor: pointer">
                                        </label>
                                        <div class="col-sm-6 col-md-9">
                                            <div class="custom-file">
                                                <input type="file" name="icon" class="custom-file-input" id="mascot">
                                                <label class="custom-file-label" id="txt_mascot"></label>
                                            </div>
                                            <div class="form-text text-muted">
                                                Allowed extension: jpg, jpeg, gif, png. Allowed size: < 2 MB
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row form-group">
                                        <div class="col">
                                            <label for="tagline">Tagline</label>
                                            <input id="tagline" type="text" class="form-control" name="tagline"
                                                   placeholder="Tagline" value="{{$about->tagline}}" required>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col">
                                            <label for="deskripsi">Description</label>
                                            <textarea id="deskripsi" class="form-control"
                                                      name="deskripsi">{{$about->deskripsi}}</textarea>
                                        </div>
                                    </div>
                                </div>
                                <div id="vs-input" style="display: none;">
                                    <div class="row form-group">
                                        <div class="col">
                                            <label for="vision">Vision</label>
                                            <textarea id="vision" class="form-control"
                                                      style="min-height: 150px !important;"
                                                      name="visi" required>{{$about->visi}}</textarea>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col">
                                            <label for="mission">Mission</label>
                                            <textarea id="mission" class="form-control"
                                                      name="misi">{{$about->misi}}</textarea>
                                        </div>
                                    </div>
                                </div>
                                <div id="tc-input" style="display: none;">
                                    <div class="row">
                                        <div class="col">
                                            <textarea id="terms_conditions" class="form-control"
                                                      name="terms_conditions">{{$about->terms_conditions}}</textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer bg-whitesmoke text-md-right">
                                <button type="submit" class="btn btn-primary btn-block">Save Changes</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection
@push("scripts")
    <script src="{{asset('admins/modules/summernote/summernote-bs4.js')}}"></script>
    <script>
        $(function () {
            var $text = '{{$about->icon != "" ? $about->icon : 'Choose File'}}';
            $("#txt_mascot").text($text.length > 60 ? $text.slice(0, 60) + "..." : $text)
        });

        $("#gs").on('click', function () {
            $('.nav-link').removeClass('active');
            $(this).addClass('active');

            $("#form-compro .card-header h4").text('General Settings');
            $("#form-compro input[name=check_form]").val('gs');

            $("#vs-input, #tc-input").hide('slide');
            $("#gs-input").show('slide');

            $('.use-nicescroll').getNiceScroll().resize();
        });

        $("#vs").on('click', function () {
            $('.nav-link').removeClass('active');
            $(this).addClass('active');

            $("#form-compro .card-header h4").text('Vision & Mission');
            $("#form-compro input[name=check_form]").val('vs');

            $("#gs-input, #tc-input").hide('slide');
            $("#vs-input").show('slide');

            $('.use-nicescroll').getNiceScroll().resize();
        });

        $("#tc").on('click', function () {
            $('.nav-link').removeClass('active');
            $(this).addClass('active');

            $("#form-compro .card-header h4").text('Terms & Conditions');
            $("#form-compro input[name=check_form]").val('tc');

            $("#gs-input, #vs-input").hide('slide');
            $("#tc-input").show('slide');

            $('.use-nicescroll').getNiceScroll().resize();
        });

        $("#btn_mascot").on('click', function () {
            $("#mascot").click();
        });

        $("#mascot").on('change', function () {
            var files = $(this).prop("files"), names = $.map(files, function (val) {
                return val.name;
            }), text = names[0];
            $("#txt_mascot").text(text.length > 60 ? text.slice(0, 60) + "..." : text);
        });

        $("#deskripsi, #mission, #terms_conditions").summernote({
            dialogsInBody: true,
            minHeight: 300,
        });

        $("#form-compro").on('submit', function (e) {
            e.preventDefault();

            var check = $("#form-compro input[name=check_form]").val();

            if (check == 'gs' && $("#deskripsi").summernote('isEmpty')) {
                swal('PERHATIAN!', 'Please, write something about Rabbit Media!', 'warning');
            } else if (check == 'vs' && $("#mission").summernote('isEmpty')) {
                swal('PERHATIAN!', 'Please, write something about Rabbit\'s mission!', 'warning');
            } else if (check == 'tc' && $("#terms_conditions").summernote('isEmpty')) {
                swal('PERHATIAN!', 'Please, write something about Rabbit\'s terms & conditions!', 'warning');
            } else {
                $(this)[0].submit();
            }
        });
    </script>
@endpush