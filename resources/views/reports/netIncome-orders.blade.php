<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Net Income Orders Report: {{$service->nama.', '.$period}}</title>
    <style>
        h1, h2, h3 {
            text-align: center;
        }

        #data-table {
            width: 90%;
            border-collapse: collapse;
            margin: 0 auto;
        }

        #data-table td, #data-table th {
            border: 1px solid #ddd;
            padding: 8px;
        }

        #data-table tr:nth-child(even) {
            background-color: #eee;
        }
    </style>
</head>
<body>
<h1>Net Incomes Report</h1>
<h2>Service / Period: {{$service->nama.', '.$period}}</h2>
<table id="data-table">
    <thead>
    <tr>
        <th align="center">#</th>
        <th align="center">Details</th>
        <th align="center">Date<br>(Order - Complete)</th>
        <th align="center">Profit (IDR)</th>
    </tr>
    </thead>
    <tbody>
    @php $no=1; $profit = 0; @endphp
    @foreach($orders as $row)
        @php
            $user = $row->getUser;
            $plan = $row->getLayanan;
            $price = $plan->harga - ($plan->harga * $plan->diskon/100);
            $start = \Carbon\Carbon::parse($row->start)->format('j F Y');
            $end = \Carbon\Carbon::parse($row->end)->format('j F Y');
            $date = $row->created_at;
            $romanDate = \App\Support\RomanConverter::numberToRoman($date->format('y')).'/'.
            \App\Support\RomanConverter::numberToRoman($date->format('m'));
            $invoice = 'INV/'.$date->format('Ymd').'/'.$romanDate.'/'.$row->id;
            $outcome = 0;
            foreach ($row->getOutcome as $item){
                $outcome += $item->price_total;
            }
            $profit += $row->total_payment - $outcome;
        @endphp
        <tr>
            <td align="center">{{$no++}}</td>
            <td>
                <strong>#{{$invoice}}</strong><br>{{$plan->paket}}: Rp{{number_format($price, 2,'.',',')}}
                <hr style="margin-top: .1em;margin-bottom: .5em">
                <strong>{{$user->name}}</strong><br>{{$user->email}}<br>{{$user->no_telp}}
            </td>
            <td align="center">
                {{\Carbon\Carbon::parse($row->created_at)->format('j F Y')}} &ndash; {{\Carbon\Carbon::parse($row->getOrderLog->updated_at)->format('j F Y')}}
            </td>
            <td align="right">
                {{number_format($row->total_payment,2,',','.')}}<br>
                -{{number_format($outcome,2,',','.')}}
                <hr style="margin: .5em 0">
                {{number_format($row->total_payment - $outcome,2,',','.')}}
            </td>
        </tr>
    @endforeach
    </tbody>
    <tfoot>
    <tr>
        <th colspan="3" align="right"><em>Total Profit (IDR)</em></th>
        <th align="right">{{number_format($profit, 2,',','.')}}</th>
    </tr>
    </tfoot>
</table>
</body>
</html>
