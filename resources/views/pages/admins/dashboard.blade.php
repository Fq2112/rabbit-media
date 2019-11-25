@extends('layouts.auth.mst_admin')
@section('title', 'The Rabbits: Dashboard | Rabbit Media – Digital Creative Service')
@push('styles')
    <link rel="stylesheet" href="{{asset('css/bootstrap-datepicker.css')}}">
    <style>
        .bootstrap-select {
            padding: 0 !important;
        }

        .bootstrap-select button {
            border-color: #e4e6fc;
        }
    </style>
@endpush
@php $role = Auth::guard('admin')->user(); @endphp
@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Dashboard</h1>
        </div>
        <div class="row">
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <a href="{{route('table.admins')}}">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-primary">
                            <i class="fas fa-user-secret"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>Rabbits</h4>
                            </div>
                            <div class="card-body">
                                {{count($admins)}}
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <a href="{{route('table.users')}}">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-info">
                            <i class="fas fa-user-tie"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>Clients</h4>
                            </div>
                            <div class="card-body">
                                {{count($users)}}
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <a href="{{route('table.orders')}}">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-success">
                            <i class="fas fa-dollar-sign"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>Orders</h4>
                            </div>
                            <div class="card-body">
                                {{count($orders)}}
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                <a href="{{route('table.feedback')}}">
                    <div class="card card-statistic-1">
                        <div class="card-icon bg-warning">
                            <i class="fas fa-comment-dots"></i>
                        </div>
                        <div class="card-wrap">
                            <div class="card-header">
                                <h4>Feedback</h4>
                            </div>
                            <div class="card-body">
                                {{count($feedback)}}
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        </div>

        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="card-header">
                        <h4>Visitors Traffic</h4>
                        <div class="card-header-form" style="margin-left: auto;">
                            <form id="form-visitor" action="{{route('home-admin')}}">
                                <div class="row">
                                    <div class="col">
                                        <input id="visitor" type="text" class="form-control yearpicker"
                                               placeholder="Period Filter (yyyy)" name="visitor"
                                               autocomplete="off" readonly>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="card-body">
                        <canvas id="visitor_graph" height="100"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="card-header">
                        <h4>Outcome vs Income (in millions)</h4>
                        <div class="card-header-form" style="margin-left: auto;">
                            <form id="form-filter" action="{{route('home-admin')}}">
                                <div class="row">
                                    <div class="col">
                                        <select id="jenisLayanan_id" class="form-control selectpicker"
                                                title="-- Service Types Filter --" name="service"
                                                data-live-search="true">
                                            <option value="any">Any</option>
                                            @foreach(\App\Models\JenisLayanan::orderBy('nama')->get() as $type)
                                                <option value="{{$type->id}}">{{$type->nama}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col">
                                        <input id="period" type="text" class="form-control yearpicker"
                                               placeholder="Period Filter (yyyy)" name="period"
                                               autocomplete="off" readonly>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="card-body">
                        <canvas id="income_graph" height="100"></canvas>
                    </div>
                </div>
            </div>
        </div>

        @if(count($orders) > 0 || \App\Models\Contact::count() > 0)
            <div class="row">
                @if(count($orders) > 0)
                    <div class="col{{\App\Models\Contact::count() > 0 ? '-8' : ''}}">
                        <div class="card">
                            <div class="card-header">
                                <h4>Invoices</h4>
                                <div class="card-header-action">
                                    <a href="{{route('table.orders')}}" class="btn btn-danger">
                                        View More <i class="fas fa-chevron-right"></i></a>
                                </div>
                            </div>
                            <div class="card-body p-0">
                                <div class="table-responsive table-invoice">
                                    <table class="table table-striped">
                                        <tr>
                                            <th>Invoice ID</th>
                                            <th>Customer</th>
                                            <th>Status</th>
                                            <th>Due Date</th>
                                            <th>Action</th>
                                        </tr>
                                        @foreach(\App\Models\Pemesanan::orderByDesc('id')->take(5)->get() as $order)
                                            <tr>
                                                <td>
                                                    <a href="{{$order->payment_id != null ?
                                                route('invoice.order', ['id' => encrypt($order->id)]) :
                                                'javascript:void(0)'}}" style="cursor: {{$order->payment_id != null ?
                                                'pointer' : 'no-drop;text-decoration: none'}}">
                                                        INV-{{str_pad($order->id, 4, 0, STR_PAD_LEFT)}}</a>
                                                </td>
                                                <td class="font-weight-600">{{$order->getUser->name}}</td>
                                                <td>
                                                    <img src="{{$order->status_payment >= 1 ?
                                                asset('images/stamp_paid.png') : asset('images/stamp_unpaid.png')}}"
                                                         class="img-fluid" width="100">
                                                </td>
                                                <td>{{\Carbon\Carbon::parse($order->created_at)->addWeek()->format('j F Y')}}</td>

                                                <td>
                                                    <a href="{{route('table.orders').'?q='.$order->getUser->name}}"
                                                       class="btn btn-primary">Detail</a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                @if(\App\Models\Contact::count() > 0)
                    <div class="col">
                        <div class="card card-hero">
                            <div class="card-header">
                                <div class="card-icon">
                                    <i class="far fa-question-circle"></i>
                                </div>
                                <h4>{{\App\Models\Contact::count()}}</h4>
                                <div class="card-description">Clients need help</div>
                            </div>
                            <div class="card-body p-0">
                                <div class="tickets-list">
                                    @foreach(\App\Models\Contact::orderByDesc('id')->take(3)->get() as $row)
                                        <a href="{{route('admin.inbox',['id' => $row->id])}}" class="ticket-item">
                                            <div class="ticket-title">
                                                <h4>{{$row->subject}}</h4>
                                            </div>
                                            <div class="ticket-info">
                                                <div>{{$row->name}}</div>
                                                <div class="bullet"></div>
                                                <div class="text-primary">
                                                    {{\Carbon\Carbon::parse($row->created_at)->diffForHumans()}}</div>
                                            </div>
                                        </a>
                                    @endforeach
                                    <a href="{{route('admin.inbox')}}" class="ticket-item ticket-more">
                                        View All <i class="fas fa-chevron-right"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        @endif
    </section>
@endsection

@push('scripts')
    <script src="{{asset('admins/modules/chart.min.js')}}"></script>
    <script src="{{asset('js/bootstrap-datepicker.js')}}"></script>
    <script>
        $(function () {
            $("#visitor, #period").datepicker({
                format: "yyyy",
                viewMode: "years",
                minViewMode: "years",
                todayBtn: false,
            });

            @if($service != "")
            $("#jenisLayanan_id").val('{{$service}}').selectpicker('refresh');
            @endif
            @if($visitor != "")
            $("#visitor").val('{{$visitor}}');
            @endif
            @if($period != "")
            $("#period").val('{{$period}}');
            @endif
        });
        
        var visitorGraph = document.getElementById("visitor_graph").getContext('2d');

        new Chart(visitorGraph, {
            type: 'line',
            data: {
                labels: [
                    'January', 'February', 'March', 'April', 'May', 'June', 'July',
                    'August', 'September', 'October', 'November', 'December'
                ],
                datasets: [{
                    label: 'Visits',
                    data: [
                        @php $total = 0; @endphp
                        @for($i=1;$i<=12;$i++)
                        @php
                            $total = 0;
                            $visitors = \App\Models\Visitor::when($visitor, function ($query) use ($visitor) {
                                $query->whereYear('date', $visitor);
                            })->whereMonth('date',$i)->get();
                            foreach ($visitors as $row){
                                $total += $row->hits;
                            }
                        @endphp
                        {{$total}},
                        @endfor
                    ],
                    borderWidth: 2,
                    backgroundColor: 'rgba(89,47,131,0.8)',
                    borderWidth: 0,
                    borderColor: 'transparent',
                    pointBorderWidth: 0,
                    pointRadius: 3.5,
                    pointBackgroundColor: 'transparent',
                    pointHoverBackgroundColor: 'rgba(89,47,131,0.8)',
                }]
            },
            options: {
                legend: {
                    display: false
                },
                scales: {
                    yAxes: [{
                        gridLines: {
                            display: true,
                            drawBorder: false,
                            color: '#f2f2f2',
                        },
                        ticks: {
                            beginAtZero: true,
                            stepSize: 100,
                            callback: function (value, index, values) {
                                return value;
                            }
                        }
                    }],
                    xAxes: [{
                        gridLines: {
                            display: false,
                            tickMarkLength: 15,
                        }
                    }]
                },
            }
        });

        $("#visitor").on('change', function () {
            $("#form-visitor")[0].submit();
        });

        var incomeGraph = document.getElementById("income_graph").getContext('2d');

        new Chart(incomeGraph, {
            type: 'line',
            data: {
                labels: [
                    'January', 'February', 'March', 'April', 'May', 'June', 'July',
                    'August', 'September', 'October', 'November', 'December'
                ],
                datasets: [{
                    label: 'Income (IDR)',
                    data: [
                        @for($i=1;$i<=12;$i++)
                                @php
                                    $total = 0;
                                    $orders = \App\Models\Pemesanan::when($service, function ($query) use ($service) {
                                        $query->whereHas('getLayanan', function ($query) use ($service) {
                                            if($service != 'any'){
                                                $query->where('jenis_id', $service);
                                            } else{
                                                $query->whereIn('jenis_id', \App\Models\JenisLayanan::pluck('id')->toArray());
                                            }
                                        });
                                    })->when($period, function ($query) use ($period) {
                                        $query->whereYear('created_at', $period);
                                    })->where('status_payment',2)->whereMonth('date_payment',$i)->get();
                                    foreach ($orders as $row){
                                        $total += $row->total_payment;
                                    }
                                    $income = number_format($total/1000000,1,'.','');
                                @endphp
                            '{{$income}}',
                        @endfor
                    ],
                    borderWidth: 2,
                    backgroundColor: 'rgba(89,47,131,0.8)',
                    borderWidth: 0,
                    borderColor: 'transparent',
                    pointBorderWidth: 0,
                    pointRadius: 3.5,
                    pointBackgroundColor: 'transparent',
                    pointHoverBackgroundColor: 'rgba(89,47,131,0.8)',
                },
                    {
                        label: 'Outcome (IDR)',
                        data: [
                            @php $x = 1; @endphp
                                    @for($i=1;$i<=12;$i++)
                                    @php
                                        $total = 0;
                                        $ids = \App\Models\Pemesanan::where('status_payment',2)
                                        ->whereMonth('date_payment',$i)->get()->pluck('id');

                                        $order_outcomes = \App\Models\Outcomes::when($service, function ($query) use ($service) {
                                            $query->whereHas('getPemesanan', function ($query) use ($service) {
                                                $query->whereHas('getLayanan', function ($query) use ($service) {
                                                    if($service != 'any'){
                                                        $query->where('jenis_id', $service);
                                                    } else{
                                                        $query->whereIn('jenis_id', \App\Models\JenisLayanan::pluck('id')->toArray());
                                                    }
                                                });
                                            });
                                        })->when($period, function ($query) use ($period) {
                                            $query->whereYear('created_at', $period);
                                        })->wherenotnull('pemesanan_id')->whereIn('pemesanan_id', $ids)->get();

                                        foreach ($order_outcomes as $row){
                                            $total += $row->price_total;
                                        }

                                        $nonOrder_outcomes = \App\Models\Outcomes::when($period, function ($query) use ($period) {
                                            $query->whereYear('created_at', $period);
                                        })->wherenull('pemesanan_id')->whereMonth('created_at', $x++)->get();

                                        foreach ($nonOrder_outcomes as $row){
                                            $total += $row->price_total;
                                        }

                                        $outcome = number_format($total/1000000,1,'.','');
                                    @endphp
                                '{{$outcome}}',
                            @endfor
                        ],
                        borderWidth: 2,
                        backgroundColor: 'rgba(252,84,75,0.7)',
                        borderWidth: 0,
                        borderColor: 'transparent',
                        pointBorderWidth: 0,
                        pointRadius: 3.5,
                        pointBackgroundColor: 'transparent',
                        pointHoverBackgroundColor: 'rgba(252,84,75,0.8)',
                    }]
            },
            options: {
                legend: {
                    display: false
                },
                scales: {
                    yAxes: [{
                        gridLines: {
                            display: true,
                            drawBorder: false,
                            color: '#f2f2f2',
                        },
                        ticks: {
                            beginAtZero: true,
                            stepSize: 5,
                            callback: function (value, index, values) {
                                return 'Rp' + value + 'M';
                            }
                        }
                    }],
                    xAxes: [{
                        gridLines: {
                            display: false,
                            tickMarkLength: 15,
                        }
                    }]
                },
            }
        });

        $("#jenisLayanan_id, #period").on('change', function () {
            $("#form-filter")[0].submit();
        });
    </script>
@endpush
