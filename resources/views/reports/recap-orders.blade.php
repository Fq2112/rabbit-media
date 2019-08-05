<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Recap Orders Report: {{$period}}</title>
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
<h1>Recap Orders Report</h1>
<h2>Period: {{$period}}</h2>
<table id="data-table">
    <thead>
    <tr>
        <th align="center">#</th>
        <th align="center">Details</th>
        <th align="center">Order Date</th>
        <th align="center">Billing (IDR)</th>
        <th align="center">Status</th>
    </tr>
    </thead>
    <tbody>
    @php $no=1 @endphp
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
            if(now() >= \Carbon\Carbon::parse($row->start)->subDays(2) && $row->status_payment == 0){
                $status = 'EXPIRED';
            } else{
                if($row->isAccept == false && $row->isReject == false){
                    $status = 'Waiting for Confirmation';
                } elseif($row->isAccept == false && $row->isReject == true){
                    $status = 'REJECTED';
                } else{
                    if($row->status_payment == 0 && $row->payment_id != "" && $row->payment_proof != ""){
                        $status = 'Waiting for Verification';
                    } elseif($row->status_payment == 0 && $row->payment_id == "" && $row->payment_proof == ""){
                        $status = 'Waiting for Payment';
                    } elseif($row->status_payment == 1){
                        $status = 'DP 30%';
                    } else{
                        $status = 'Fully Paid';
                    }
                }
            }
        @endphp
        <tr>
            <td align="center">{{$no++}}</td>
            <td>
                <strong>#{{$invoice}}</strong><br>{{$plan->paket}}: Rp{{number_format($price, 2,'.',',')}}
                <hr style="margin-top: .1em;margin-bottom: .5em">
                <strong>{{$user->name}}</strong><br>{{$user->email}}<br>{{$user->no_telp}}
            </td>
            <td align="center">{{\Carbon\Carbon::parse($row->created_at)->format('j F Y')}}</td>
            <td align="center">{{number_format($row->total_payment,2,',','.')}}</td>
            <td align="center"><strong>{{$status}}</strong></td>
        </tr>
    @endforeach
    </tbody>
    <tfoot>
    <tr>
        <th colspan="4" align="right"><em>Total Order</em></th>
        <th align="right">{{count($orders)}}</th>
    </tr>
    </tfoot>
</table>
</body>
</html>
