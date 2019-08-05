@extends('layouts.auth.mst_admin')
@section('title', 'The Rabbits: Feedback Table | Rabbit Media – Digital Creative Service')
@push('styles')
    <link rel="stylesheet" href="{{asset('admins/modules/datatables/datatables.min.css')}}">
    <link rel="stylesheet"
          href="{{asset('admins/modules/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css')}}">
    <link rel="stylesheet" href="{{asset('admins/modules/datatables/Select-1.2.4/css/select.bootstrap4.min.css')}}">
    <link rel="stylesheet" href="{{asset('admins/modules/datatables/Buttons-1.5.6/css/buttons.dataTables.min.css')}}">
@endpush
@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Feedback Table</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{route('home-admin')}}">Dashboard</a></div>
                <div class="breadcrumb-item">Data Transaction</div>
                <div class="breadcrumb-item"><a href="{{route('table.users')}}">Clients</a></div>
                <div class="breadcrumb-item">Feedback</div>
            </div>
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped" id="dt-buttons">
                                    <thead>
                                    <tr>
                                        <th class="text-center">
                                            <div class="custom-checkbox custom-control">
                                                <input type="checkbox" class="custom-control-input" id="cb-all">
                                                <label for="cb-all" class="custom-control-label">#</label>
                                            </div>
                                        </th>
                                        <th class="text-center">ID</th>
                                        <th>Details</th>
                                        <th class="text-center">Rating</th>
                                        <th class="text-center">Created at</th>
                                        <th class="text-center">Last Update</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @php $no = 1; @endphp
                                    @foreach($feedback as $row)
                                        <tr>
                                            <td style="vertical-align: middle" align="center">
                                                <div class="custom-checkbox custom-control">
                                                    <input type="checkbox" id="cb-{{$row->id}}"
                                                           class="custom-control-input dt-checkboxes">
                                                    <label for="cb-{{$row->id}}"
                                                           class="custom-control-label">{{$no++}}</label>
                                                </div>
                                            </td>
                                            <td style="vertical-align: middle" align="center">{{$row->id}}</td>
                                            <td style="vertical-align: middle">
                                                <img class="img-fluid float-left mr-2" width="64" alt="Avatar"
                                                     src="{{$row->getUser->ava == "" ? asset('images/avatar.png') :
                                                     asset('storage/users/ava/'.$row->getUser->ava)}}">
                                                <strong>{{$row->getUser->name}}</strong>
                                                <a href="mailto:{{$row->getUser->email}}">
                                                    <sub>{{$row->getUser->email}}</sub></a>
                                                <p>{{$row->comment}}</p>
                                            </td>
                                            <td style="vertical-align: middle;color: #592f83" align="center">
                                                <strong>{{$row->rate}}<i class="fa fa-star ml-1"></i></strong>
                                            </td>
                                            <td style="vertical-align: middle" align="center">
                                                {{\Carbon\Carbon::parse($row->created_at)->format('j F Y')}}</td>
                                            <td style="vertical-align: middle"
                                                align="center">{{$row->updated_at->diffForHumans()}}</td>
                                            <td style="vertical-align: middle" align="center">
                                                <a href="{{route('delete.feedback', ['id' => encrypt($row->id)])}}"
                                                   class="btn btn-danger delete-data" data-toggle="tooltip"
                                                   title="Delete"><i class="fas fa-trash-alt"></i></a>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                                <form method="post" id="form-feedback">
                                    {{csrf_field()}}
                                    <input type="hidden" name="feedback_ids">
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@push("scripts")
    <script src="{{asset('admins/modules/datatables/datatables.min.js')}}"></script>
    <script src="{{asset('admins/modules/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js')}}"></script>
    <script src="{{asset('admins/modules/datatables/Select-1.2.4/js/dataTables.select.min.js')}}"></script>
    <script src="{{asset('admins/modules/datatables/Buttons-1.5.6/js/buttons.dataTables.min.js')}}"></script>
    <script src="{{asset('admins/modules/jquery-ui/jquery-ui.min.js')}}"></script>
    <script>
        $(function () {
            var export_filename = 'Feedback Table ({{now()->format('j F Y')}})', table = $("#dt-buttons").DataTable({
                dom: "<'row'<'col-sm-12 col-md-3'l><'col-sm-12 col-md-5'B><'col-sm-12 col-md-4'f>>" +
                    "<'row'<'col-sm-12'tr>><'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
                columnDefs: [
                    {sortable: false, targets: 6},
                    {targets: 1, visible: false, searchable: false}
                ],
                buttons: [
                    {
                        text: '<strong class="text-uppercase"><i class="far fa-clipboard mr-2"></i>Copy</strong>',
                        extend: 'copy',
                        exportOptions: {
                            columns: [0, 2, 3, 4, 5]
                        },
                        className: 'btn btn-warning assets-export-btn export-copy ttip'
                    }, {
                        text: '<strong class="text-uppercase"><i class="far fa-file-excel mr-2"></i>Excel</strong>',
                        extend: 'excel',
                        exportOptions: {
                            columns: [0, 2, 3, 4, 5]
                        },
                        className: 'btn btn-success assets-export-btn export-xls ttip',
                        title: export_filename,
                        extension: '.xls'
                    }, {
                        text: '<strong class="text-uppercase"><i class="fa fa-print mr-2"></i>Print</strong>',
                        extend: 'print',
                        exportOptions: {
                            columns: [0, 2, 3, 4, 5]
                        },
                        className: 'btn btn-info assets-select-btn export-print'
                    }, {
                        text: '<strong class="text-uppercase"><i class="fa fa-trash-alt mr-2"></i>Deletes</strong>',
                        className: 'btn btn-danger btn_massDelete'
                    }
                ],
                fnDrawCallback: function (oSettings) {
                    $('.use-nicescroll').getNiceScroll().resize();
                    $('[data-toggle="tooltip"]').tooltip();

                    $("#cb-all").on('click', function () {
                        if ($(this).is(":checked")) {
                            $("#dt-buttons tbody tr").addClass("terpilih")
                                .find('.dt-checkboxes').prop("checked", true).trigger('change');
                        } else {
                            $("#dt-buttons tbody tr").removeClass("terpilih")
                                .find('.dt-checkboxes').prop("checked", false).trigger('change');
                        }
                    });

                    $("#dt-buttons tbody tr").on("click", function () {
                        $(this).toggleClass("terpilih");
                        if ($(this).hasClass('terpilih')) {
                            $(this).find('.dt-checkboxes').prop("checked", true).trigger('change');
                        } else {
                            $(this).find('.dt-checkboxes').prop("checked", false).trigger('change');
                        }
                    });

                    $('.dt-checkboxes').on('click', function () {
                        if ($(this).is(':checked')) {
                            $(this).parent().parent().parent().addClass("terpilih");
                        } else {
                            $(this).parent().parent().parent().removeClass("terpilih");
                        }
                    });

                    $('.btn_massDelete').on("click", function () {
                        var ids = $.map(table.rows('.terpilih').data(), function (item) {
                            return item[1]
                        });
                        $("#form-feedback input[name=feedback_ids]").val(ids);
                        $("#form-feedback").attr("action", "{{route('massDelete.feedback')}}");

                        @if(Auth::guard('admin')->user()->isRoot())
                        if (ids.length > 0) {
                            swal({
                                title: 'Delete Feedback',
                                text: 'Are you sure to delete this ' + ids.length + ' selected record(s)? ' +
                                    'You won\'t be able to revert this!',
                                icon: 'warning',
                                dangerMode: true,
                                buttons: ["No", "Yes"],
                                closeOnEsc: false,
                                closeOnClickOutside: false,
                            }).then((confirm) => {
                                if (confirm) {
                                    swal({icon: "success", buttons: false});
                                    $("#form-feedback")[0].submit();
                                }
                            });
                        } else {
                            $("#cb-all").prop("checked", false).trigger('change');
                            swal("Error!", "There's no any selected record!", "error");
                        }
                        @else
                        swal('ATTENTION!', 'This feature only for ROOT.', 'warning');
                        @endif
                    });
                },
            });
        });
    </script>
@endpush