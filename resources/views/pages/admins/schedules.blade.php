@extends('layouts.auth.mst_admin')
@section('title', 'The Rabbits: Schedules | Rabbit Media – Digital Creative Service')
@push('styles')
    <link href="{{asset('admins/modules/fullcalendar/packages/core/main.css')}}" rel="stylesheet">
    <link href="{{asset('admins/modules/fullcalendar/packages/daygrid/main.css')}}" rel="stylesheet">
    <link href="{{asset('admins/modules/fullcalendar/packages/timegrid/main.css')}}" rel="stylesheet">
    <link href="{{asset('admins/modules/fullcalendar/packages/list/main.css')}}" rel="stylesheet">
    <link href="{{asset('admins/modules/fullcalendar/packages/bootstrap/main.css')}}" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('css/tempusdominus-datetimepicker.min.css')}}">
    <style>
        .fc-toolbar button {
            text-transform: uppercase;
        }

        .form-control-feedback {
            position: absolute;
            top: 3em;
            right: 2em;
        }

        .modal-header {
            padding: 1rem !important;
            border-bottom: 1px solid #e9ecef !important;
        }

        .modal-footer {
            padding: 1rem !important;
            border-top: 1px solid #e9ecef !important;
        }
    </style>
@endpush
@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Schedules</h1>
            <div class="section-header-breadcrumb">
                @if(Auth::guard('admin')->user()->isRoot() || Auth::guard('admin')->user()->isAdmin())
                    <div class="breadcrumb-item active"><a href="{{route('home-admin')}}">Dashboard</a></div>
                    <div class="breadcrumb-item">Schedules</div>
                @else
                    <div class="breadcrumb-item active">Dashboard</div>
                    <div class="breadcrumb-item"><a href="{{route('show.schedules')}}">Schedules</a></div>
                @endif
            </div>
        </div>

        <div class="section-body">
            <h2 class="section-title">Rabbits Schedule</h2>
            <p class="section-lead">Here is the list of booked date by our clients. Besides that on this page, we can
                also manage our own agenda here.</p>

            <div class="row mt-sm-4">
                <div class="col">
                    <div id="calendar"></div>
                </div>
            </div>
        </div>
    </section>

    <div class="modal fade" id="scheduleModal" tabindex="-1" role="dialog" aria-labelledby="scheduleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="scheduleModalLabel">Schedule Setup</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form id="form-schedule" method="post" action="{{route('create.schedules')}}">
                    {{csrf_field()}}
                    <input type="hidden" name="_method">
                    <input type="hidden" name="id">
                    <div class="modal-body">
                        <div class="row form-group" id="dtp_errDiv">
                            <div class="col">
                                <label class="control-label mb-0" for="start">Start Date</label>
                                <div class="input-group date" id="start" data-target-input="nearest">
                                    <div class="input-group-prepend" data-target="#start"
                                         data-toggle="datetimepicker">
                                        <div class="input-group-text"><i class="fa fa-calendar-alt"></i></div>
                                    </div>
                                    <input type="text" class="form-control datetimepicker-input" name="start"
                                           data-target="#start" data-toggle="datetimepicker"
                                           placeholder="yyyy-mm-dd hh:mm:ss" required>
                                </div>
                            </div>
                            <div class="col" id="end_errDiv">
                                <label class="control-label mb-0" for="end">End Date</label>
                                <div class="input-group date" id="end" data-target-input="nearest">
                                    <input type="text" class="form-control datetimepicker-input" data-target="#end"
                                           data-toggle="datetimepicker" placeholder="yyyy-mm-dd hh:mm:ss"
                                           name="end" required>
                                    <div class="input-group-append" data-target="#end" data-toggle="datetimepicker">
                                        <div class="input-group-text"><i class="fa fa-calendar-check"></i></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row form-group" style="display: none">
                            <div class="col">
                                <span class="invalid-feedback">
                                    <strong id="dtp_errTxt" style="text-transform: none"></strong>
                                </span>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col">
                                <label class="control-label mb-0" for="judul">Title</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa fa-text-width"></i></span>
                                    </div>
                                    <input id="judul" class="form-control" type="text" name="judul"
                                           placeholder="Write the event title here&hellip;" required>
                                </div>
                            </div>
                        </div>
                        <div class="row has-feedback">
                            <div class="col">
                                <label for="description">Description</label>
                                <textarea id="description" type="text" name="description" class="form-control"
                                          placeholder="Describe it here&hellip;" required></textarea>
                                <span class="glyphicon glyphicon-text-height form-control-feedback"></span>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" id="btnDelete" style="display: none">Delete</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary add" id="btnSubmit">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@push("scripts")
    <script src="{{asset('js/jquery.easing.1.3.js')}}"></script>
    <script src="{{asset('admins/modules/fullcalendar/packages/core/main.js')}}"></script>
    <script src="{{asset('admins/modules/fullcalendar/packages/interaction/main.js')}}"></script>
    <script src="{{asset('admins/modules/fullcalendar/packages/daygrid/main.js')}}"></script>
    <script src="{{asset('admins/modules/fullcalendar/packages/timegrid/main.js')}}"></script>
    <script src="{{asset('admins/modules/fullcalendar/packages/list/main.js')}}"></script>
    <script src="{{asset('admins/modules/fullcalendar/packages/core/locales-all.js')}}"></script>
    <script src="{{asset('admins/modules/fullcalendar/packages/bootstrap/main.js')}}"></script>
    <script src="{{asset('js/tempusdominus-datetimepicker.min.js')}}"></script>
    <script>
        $(function () {
            window.mobilecheck() ?
                swal({
                    title: 'ATTENTION!',
                    text: 'This page is not fully support on mobile device! ' +
                        'Please, use your PC or another wide screen device!',
                    icon: 'warning',
                    dangerMode: true,
                    buttons: ["Back", "Continue"],
                    closeOnEsc: false,
                    closeOnClickOutside: false,
                }).then((confirm) => {
                    if (confirm) {
                        //
                    } else {
                        window.location = '{{route('home-admin')}}';
                    }

                }) : '';
        });

        document.addEventListener('DOMContentLoaded', function () {
            var $div = document.getElementById('calendar'), start = $('#start'), end = $('#end'), findSchedule,
                fc = new FullCalendar.Calendar($div, {
                    plugins: ['dayGrid', 'timeGrid', 'list', 'interaction', 'bootstrap'],
                    themeSystem: 'bootstrap',
                    locale: 'en',
                    header: {
                        left: 'prev,next today',
                        center: 'title',
                        right: 'dayGridMonth,timeGridWeek,timeGridDay,listMonth'
                    },
                    defaultDate: '{{now()->format('Y-m-d')}}',
                    validRange: {
                        start: '{{now()->format('Y-m-d')}}',
                    },
                    // defaultView: "timeGridWeek",
                    navLinks: true,
                    displayEventTime: true,
                    displayEventEnd: true,
                    nowIndicator: true,
                    @if(Auth::guard('admin')->user()->isRoot() || Auth::guard('admin')->user()->isAdmin())
                    editable: true,
                    selectable: true,
                    @endif
                    selectMirror: true,
                    eventLimit: true,
                    longPressDelay: 0,
                    businessHours: [
                        {
                            daysOfWeek: [0, 1, 2, 3, 4, 5, 6],
                            startTime: '07:00',
                            endTime: '23:00'
                        }
                    ],
                    events: [
                            @foreach($schedules as $row)
                            @if($row->pemesanan_id != null)
                        {
                            id: '{{$row->id}}',
                            status: 'booked',
                            title: '{{$row->getPemesanan->judul}}',
                            start: '{{$row->getPemesanan->start}}',
                            end: '{{$row->getPemesanan->end}}',
                            description: '{{$row->getPemesanan->deskripsi}}',
                            color: '#17a2b8'
                        },
                            @else
                        {
                            id: '{{$row->id}}',
                            status: 'unavailable',
                            title: '{{$row->judul}}',
                            start: '{{$row->start}}',
                            end: '{{$row->end}}',
                            description: '{{$row->deskripsi}}',
                            color: '#f23a2e',
                        },
                        {
                            start: '{{\Carbon\Carbon::parse($row->start)->format('Y-m-d')}}',
                            end: '{{\Carbon\Carbon::parse($row->end)->format('Y-m-d')}}',
                            rendering: 'background',
                            color: '#ff9f89',
                        },
                        @endif
                        @endforeach
                    ],
                    select: function (info) {
                        $("#scheduleModalLabel").text('Schedule Setup');
                        $("#form-schedule").attr('action', '{{route('create.schedules')}}');
                        $("#form-schedule input[name=_method], #form-schedule input[name=id]").val('');
                        $('#start input').val(moment(info.start).format('YYYY-MM-DD') + ' 07:00:00');
                        $('#end input').val(moment(info.end).format('YYYY-MM-DD') + ' 08:00:00');
                        $('#judul, #description').val('');
                        $("#btnDelete").hide();
                        $("#btnSubmit").text('Submit');
                        $('#scheduleModal').modal('show');
                    },
                    selectOverlap: function (event) {
                        if (event.extendedProps.status == 'booked' || event.extendedProps.status == 'unavailable') {
                            swal('ATTENTION!', 'This date is unavailable! Please, select another one.', 'warning');

                        } else {
                            $("#scheduleModalLabel").text('Schedule Setup');
                            $("#form-schedule").attr('action', '{{route('create.schedules')}}');
                            $("#form-schedule input[name=_method], #form-schedule input[name=id]").val('');
                            $('#start input').val(moment(event.start).format('YYYY-MM-DD') + ' 07:00:00');
                            $('#end input').val(moment(event.start).format('YYYY-MM-DD') + ' 08:00:00');
                            $('#judul, #description').val('');
                            $("#btnDelete").hide();
                            $("#btnSubmit").text('Submit');
                            $('#scheduleModal').modal('show');
                        }
                    },
                    eventClick: function (info) {
                        findSchedule = fc.getEventById(info.event.id);

                        @if(Auth::guard('admin')->user()->isRoot() || Auth::guard('admin')->user()->isAdmin())
                        if (info.event.extendedProps.status == 'booked') {
                            swal({
                                title: info.event.title,
                                text: info.event.extendedProps.description,
                                icon: 'info',
                                buttons: {
                                    cancel: 'Close'
                                }
                            });

                        } else {
                            $("#scheduleModalLabel").text('Edit Schedule');
                            $("#form-schedule").attr('action', '{{route('update.schedules')}}');
                            $("#form-schedule input[name=_method]").val('PUT');
                            $("#form-schedule input[name=id]").val(info.event.id);
                            $('#start input').val(moment(info.event.start).format('YYYY-MM-DD HH:mm:ss'));
                            $('#end input').val(moment(info.event.end).format('YYYY-MM-DD HH:mm:ss'));
                            $('#judul').val(info.event.title);
                            $("#description").val(info.event.extendedProps.description);
                            $("#btnDelete").show();
                            $("#btnSubmit").text('Save Changes');
                            $('#scheduleModal').modal('show');
                        }
                        @else
                        swal({
                            title: info.event.title,
                            text: info.event.extendedProps.description,
                            icon: 'info',
                            buttons: {
                                cancel: 'Close'
                            }
                        });
                        @endif
                    },
                    eventDrop: function (info) {
                        swal({
                            title: info.event.extendedProps.status == 'booked' ? 'Edit Booking Date' : 'Edit Schedule',
                            text: 'Are you sure about this change? You won\'t be able to revert this!',
                            icon: 'warning',
                            dangerMode: true,
                            buttons: ["No", "Yes"],
                        }).then((confirm) => {
                            if (confirm) {
                                $("#form-schedule input[name=_method]").val('PUT');
                                $("#form-schedule input[name=id]").val(info.event.id);
                                $("#start input").val(moment(info.event.start).format('YYYY-MM-DD HH:mm:ss'));
                                $("#end input").val(moment(info.event.end).format('YYYY-MM-DD HH:mm:ss'));
                                $("#judul").val(info.event.title);
                                $("#description").val(info.event.extendedProps.description);
                                $("#form-schedule").attr('action', '{{route('update.schedules')}}')[0].submit();
                            } else {
                                info.revert();
                            }
                        });
                    },
                    eventResize: function (info) {
                        swal({
                            title: info.event.extendedProps.status == 'booked' ? 'Edit Booking Date' : 'Edit Schedule',
                            text: 'Are you sure about this change? You won\'t be able to revert this!',
                            icon: 'warning',
                            dangerMode: true,
                            buttons: ["No", "Yes"],
                        }).then((confirm) => {
                            if (confirm) {
                                $("#form-schedule input[name=_method]").val('PUT');
                                $("#form-schedule input[name=id]").val(info.event.id);
                                $("#start input").val(moment(info.event.start).format('YYYY-MM-DD HH:mm:ss'));
                                $("#end input").val(moment(info.event.end).format('YYYY-MM-DD HH:mm:ss'));
                                $("#judul").val(info.event.title);
                                $("#description").val(info.event.extendedProps.description);
                                $("#form-schedule").attr('action', '{{route('update.schedules')}}')[0].submit();
                            } else {
                                info.revert();
                            }
                        });
                    }
                });

            fc.render();

            $("#calendar .fc-header-toolbar").after(
                '<div class="row"><div class="col text-uppercase">' +
                '<label class="control-label text-capitalize">Legend:</label>&ensp;' +
                '<a href="javascript:void(0)" class="badge badge-info py-1 px-2 mr-2" ' +
                'style="cursor: default;background-color: #592f83">Selected Date</a>' +
                '<a href="javascript:void(0)" class="badge badge-info py-1 px-2 mr-2" ' +
                'style="cursor: default;background-color: #17a2b8">Booked</a>' +
                '<a href="javascript:void(0)" class="badge badge-info py-1 px-2" ' +
                'style="cursor: default;background-color: #f23a2e">Day Off</a></div></div>'
            );

            $("#start, #end").datetimepicker({
                format: 'YYYY-MM-DD HH:mm:00',
                icons: {
                    time: "fa fa-clock",
                    date: "fa fa-calendar-alt",
                    up: "fa fa-chevron-up",
                    down: "fa fa-chevron-down"
                },
                minDate: '{{now()->format('Y-m-d')}}',
                disabledDates: [
                    @foreach($schedules as $row)
                            @if($row->pemesanan_id != null)
                        "{{\Carbon\Carbon::parse($row->start)->format('m/d/Y')}}",
                    "{{\Carbon\Carbon::parse($row->end)->format('m/d/Y')}}",
                    @endif
                    @endforeach
                ],
                disabledHours: [0, 1, 2, 3, 4, 5, 6],
            });

            start.on("change.datetimepicker", function (e) {
                start.val(e.date);
                if ($("#start input").val() >= $("#end input").val()) {
                    $("#dtp_errDiv").addClass('has-danger mb-0');
                    $("#start input, #end input").addClass('is-invalid');
                    $("#dtp_errTxt")
                        .html("<u>Start Date</u> value shouldn't be greater than equal to <u>End Date</u> value.")
                        .parent().show().parent().parent().show();
                    $("#btnSubmit").attr('disabled', 'disabled');
                } else {
                    $("#dtp_errDiv").removeClass('has-danger mb-0');
                    $("#start input, #end input").removeClass('is-invalid');
                    $("#dtp_errTxt").html("").parent().hide().parent().parent().hide();
                    $("#btnSubmit").removeAttr('disabled');
                }
            });

            end.on("change.datetimepicker", function (e) {
                end.val(e.date);
                if ($("#start input").val() >= $("#end input").val()) {
                    $("#dtp_errDiv").addClass('has-danger mb-0');
                    $("#start input, #end input").addClass('is-invalid');
                    $("#dtp_errTxt")
                        .html("<u>Start Date</u> value shouldn't be greater than equal to <u>End Date</u> value.")
                        .parent().show().parent().parent().show();
                    $("#btnSubmit").attr('disabled', 'disabled');
                } else {
                    $("#dtp_errDiv").removeClass('has-danger mb-0');
                    $("#start input, #end input").removeClass('is-invalid');
                    $("#dtp_errTxt").html("").parent().hide().parent().parent().hide();
                    $("#btnSubmit").removeAttr('disabled');
                }
            });

            $("#form-schedule").on("submit", function (e) {
                var $judul = $("#judul").val(), $start = $("#start input").val(), $end = $("#end input").val();

                if (findSchedule) {
                    findSchedule.remove();
                }

                fc.addEvent({
                    id: 'selected',
                    title: $judul,
                    start: $start,
                    end: $end,
                    color: '#592f83',
                });

                $("#scheduleModal").modal('hide');
            });

            $("#btnDelete").on("click", function () {
                swal({
                    title: 'Delete Schedule',
                    text: 'Are you sure to delete it? You wont\'t be able to revert this!',
                    icon: 'warning',
                    dangerMode: true,
                    buttons: ["No", "Yes"],
                }).then((confirm) => {
                    if (confirm) {
                        findSchedule.remove();
                        $("#form-schedule input[name=_method]").val('DELETE');
                        $("#form-schedule input[name=id]").val(findSchedule.id);
                        $("#form-schedule").attr('action', '{{route('delete.schedules')}}')[0].submit();
                        $("#scheduleModal").modal('hide');
                    }
                });
            });

            $('#scheduleModal').on('hidden.bs.modal', function () {
                fc.unselect()
            });
        });
    </script>
@endpush