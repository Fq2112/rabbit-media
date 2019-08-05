@extends('layouts.auth.mst_admin')
@section('title', 'The Rabbits: Payment Methods Table | Rabbit Media – Digital Creative Service')
@push('styles')
    <link rel="stylesheet" href="{{asset('admins/modules/datatables/datatables.min.css')}}">
    <link rel="stylesheet"
          href="{{asset('admins/modules/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css')}}">
    <link rel="stylesheet" href="{{asset('admins/modules/datatables/Select-1.2.4/css/select.bootstrap4.min.css')}}">
    <link rel="stylesheet" href="{{asset('admins/modules/datatables/Buttons-1.5.6/css/buttons.dataTables.min.css')}}">
    <style>
        .bootstrap-select .dropdown-menu {
            min-width: 100% !important;
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
            <h1>Payment Methods Table</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{route('home-admin')}}">Dashboard</a></div>
                <div class="breadcrumb-item">Data Master</div>
                <div class="breadcrumb-item">Features</div>
                <div class="breadcrumb-item">Payment Methods</div>
            </div>
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-header-form">
                                <button onclick="createPaymentMethod()" class="btn btn-primary text-uppercase">
                                    <strong><i class="fas fa-plus mr-2"></i>Create</strong>
                                </button>
                            </div>
                        </div>

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
                                        <th class="text-center">Created at</th>
                                        <th class="text-center">Last Update</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @php $no = 1; @endphp
                                    @foreach($methods as $row)
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
                                                <img class="img-fluid float-left mr-2" alt="logo" width="100"
                                                     src="{{asset('images/paymentMethod/'.$row->logo)}}">
                                                <strong>{{$row->name}}</strong><br>{{$row->paymentCategories->name}}
                                                @if($row->account_number != "")
                                                    <br>{{$row->account_number.' (a/n '.$row->account_name.')'}}
                                                @endif
                                            </td>
                                            <td style="vertical-align: middle" align="center">
                                                {{\Carbon\Carbon::parse($row->created_at)->format('j F Y')}}</td>
                                            <td style="vertical-align: middle" align="center">
                                                {{$row->updated_at->diffForHumans()}}</td>
                                            <td style="vertical-align: middle" align="center">
                                                <button data-placement="left" data-toggle="tooltip" title="Edit"
                                                        type="button" class="btn btn-warning" onclick="editPaymentMethod
                                                        ('{{$row->id}}','{{$row->payment_category_id}}',
                                                        '{{$row->logo}}','{{$row->name}}','{{$row->account_name}}',
                                                        '{{$row->account_number}}')"><i class="fa fa-edit"></i></button>
                                                <hr class="mt-1 mb-1">
                                                <a href="{{route('delete.PaymentMethods', ['id' => encrypt($row->id)])}}"
                                                   class="btn btn-danger delete-data" data-toggle="tooltip"
                                                   title="Delete" data-placement="left">
                                                    <i class="fas fa-trash-alt"></i></a>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                                <form method="post" id="form-mass">
                                    {{csrf_field()}}
                                    <input type="hidden" name="method_ids">
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="modal fade" id="paymentMethodModal" tabindex="-1" role="dialog"
         aria-labelledby="paymentMethodModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Create Form</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="form-paymentMethod" method="post" action="{{route('create.PaymentMethods')}}"
                      enctype="multipart/form-data">
                    {{csrf_field()}}
                    <input type="hidden" name="_method">
                    <input type="hidden" name="id">
                    <div class="modal-body">
                        <div class="row form-group">
                            <div class="col-2 text-center align-self-center" style="display: none">
                                <img class="img-fluid" id="btn_img" style="cursor: pointer" data-toggle="tooltip"
                                     data-placement="bottom" alt="logo" src="#" title="Click here to change the logo!">
                            </div>
                            <div class="col">
                                <div class="row">
                                    <div class="col">
                                        <label for="logo">Logo</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fa fa-image"></i></span>
                                            </div>
                                            <div class="custom-file">
                                                <input type="file" name="logo" class="custom-file-input" id="logo"
                                                       accept="image/*" required>
                                                <label class="custom-file-label" id="txt_logo">Choose File</label>
                                            </div>
                                        </div>
                                        <div class="form-text text-muted">
                                            Allowed extension: jpg, jpeg, gif, png. Allowed size: < 1 MB
                                        </div>
                                    </div>
                                    <div class="col-5 fix-label-group">
                                        <label for="category_id">Payment Category</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text fix-label-item" style="height: 2.25rem">
                                                    <i class="fa fa-university"></i></span>
                                            </div>
                                            <select id="category_id" class="form-control selectpicker"
                                                    title="-- Choose --" name="category_id" data-live-search="true"
                                                    required onchange="ifBank($(this).val())">
                                                @foreach(\App\Models\PaymentCategory::orderBy('name')->get() as $row)
                                                    <option value="{{$row->id}}">{{$row->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row form-group">
                            <div class="col">
                                <label for="name">Name</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa fa-wallet"></i></span>
                                    </div>
                                    <input id="name" type="text" maxlength="191" name="name" class="form-control"
                                           placeholder="Write the payment method name here&hellip;" required>
                                </div>
                            </div>
                        </div>

                        <div class="row" id="ifBank" style="display: none">
                            <div class="col">
                                <label for="account_number">Account Number & Name</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fa fa-ellipsis-h"></i></span>
                                    </div>
                                    <input id="account_number" type="text" maxlength="191" name="account_number"
                                           class="form-control" placeholder="Write the account number here&hellip;">
                                    <input id="account_name" type="text" maxlength="191" name="account_name"
                                           class="form-control" placeholder="Write the account name here&hellip;">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@push("scripts")
    <script src="{{asset('admins/modules/datatables/datatables.min.js')}}"></script>
    <script src="{{asset('admins/modules/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js')}}"></script>
    <script src="{{asset('admins/modules/datatables/Select-1.2.4/js/dataTables.select.min.js')}}"></script>
    <script src="{{asset('admins/modules/datatables/Buttons-1.5.6/js/buttons.dataTables.min.js')}}"></script>
    <script src="{{asset('admins/modules/jquery-ui/jquery-ui.min.js')}}"></script>
    <script>
        $(function () {
            var export_filename = 'Payment Methods Table ({{now()->format('j F Y')}})',
                table = $("#dt-buttons").DataTable({
                    dom: "<'row'<'col-sm-12 col-md-3'l><'col-sm-12 col-md-5'B><'col-sm-12 col-md-4'f>>" +
                        "<'row'<'col-sm-12'tr>><'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
                    columnDefs: [
                        {sortable: false, targets: 5},
                        {targets: 1, visible: false, searchable: false}
                    ],
                    buttons: [
                        {
                            text: '<strong class="text-uppercase"><i class="far fa-clipboard mr-2"></i>Copy</strong>',
                            extend: 'copy',
                            exportOptions: {
                                columns: [0, 2, 3, 4]
                            },
                            className: 'btn btn-warning assets-export-btn export-copy ttip'
                        }, {
                            text: '<strong class="text-uppercase"><i class="far fa-file-excel mr-2"></i>Excel</strong>',
                            extend: 'excel',
                            exportOptions: {
                                columns: [0, 2, 3, 4]
                            },
                            className: 'btn btn-success assets-export-btn export-xls ttip',
                            title: export_filename,
                            extension: '.xls'
                        }, {
                            text: '<strong class="text-uppercase"><i class="fa fa-print mr-2"></i>Print</strong>',
                            extend: 'print',
                            exportOptions: {
                                columns: [0, 2, 3, 4]
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
                            $("#form-mass input[name=method_ids]").val(ids);
                            $("#form-mass").attr("action", "{{route('massDelete.PaymentMethods')}}");

                            if (ids.length > 0) {
                                swal({
                                    title: 'Delete Payment Methods',
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
                                        $("#form-mass")[0].submit();
                                    }
                                });
                            } else {
                                $("#cb-all").prop("checked", false).trigger('change');
                                swal("Error!", "There's no any selected record!", "error");
                            }
                        });
                    },
                });
        });

        function createPaymentMethod() {
            $(".fix-label-group .bootstrap-select").addClass('p-0');
            $(".fix-label-group .bootstrap-select button").css('border-color', '#e4e6fc');

            $("#paymentMethodModal .modal-title").text('Create Form');
            $("#form-paymentMethod").attr('action', '{{route('create.PaymentMethods')}}');
            $("#form-paymentMethod input[name=_method]").val('');
            $("#form-paymentMethod input[name=id]").val('');
            $("#form-paymentMethod button[type=submit]").text('Submit');
            $("#logo").attr('required', 'required');
            $("#txt_logo").text('Choose File');
            $("#logo, #name, #account_name, #account_number").val('');
            $("#category_id").val('').selectpicker('refresh');

            $("#btn_img").attr('src', '#').parent().hide();
            $("#paymentMethodModal").modal('show');
        }

        function editPaymentMethod(id, category_id, logo, name, account_name, account_number) {
            $(".fix-label-group .bootstrap-select").addClass('p-0');
            $(".fix-label-group .bootstrap-select button").css('border-color', '#e4e6fc');

            $("#paymentMethodModal .modal-title").text('Edit Form');
            $("#form-paymentMethod").attr('action', '{{route('update.PaymentMethods')}}');
            $("#form-paymentMethod input[name=_method]").val('PUT');
            $("#form-paymentMethod input[name=id]").val(id);
            $("#form-paymentMethod button[type=submit]").text('Save Changes');
            $("#logo").removeAttr('required');
            $("#txt_logo").text(logo.length > 30 ? logo.slice(0, 30) + "..." : logo);
            $("#name").val(name);
            $("#account_name").val(account_name);
            $("#account_number").val(account_number);
            $("#category_id").val(category_id).selectpicker('refresh');

            $("#btn_img").attr('src', '{{asset('images/paymentMethod')}}/' + logo).on('click', function () {
                $("#logo").click();
            }).parent().show();

            $("#paymentMethodModal").modal('show');
        }

        function ifBank(val) {
            if (val == 1) {
                $("#ifBank").slideDown(300);
                $("#account_name,#account_number").prop('required', true);

            } else {
                $("#ifBank").slideUp(300);
                $("#account_name,#account_number").prop('required', false);
            }
        }

        $("#logo").on('change', function () {
            var files = $(this).prop("files"), names = $.map(files, function (val) {
                return val.name;
            }), text = names[0];
            $("#txt_logo").text(text.length > 30 ? text.slice(0, 30) + "..." : text);
        });
    </script>
@endpush
