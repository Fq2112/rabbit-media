<!DOCTYPE html>
<html lang="id">
<head>
    <title>{{$invoice}}</title>
    <style>
        @media print {
            a[href]:after {
                content: none !important;
            }
        }

        @page {
            size: A4 portrait;
            margin: 0;
        }

        body {
            font-family: open sans, tahoma, sans-serif;
            -webkit-print-color-adjust: exact;
        }

        .watermark {
            position: absolute;
            top: 0;
            right: 0;
            left: 0;
            bottom: 0;
            width: 100%;
            height: 100%;
            opacity: .13;
        }

        .sign {
            position: absolute;
            top: 38.5rem;
            left: 31.5rem;
            width: 150px;
            display: {{$order->status_payment > 1 ? '' : 'none'}};
        }

        .container {
            width: 80%;
            height: 100%;
            margin: 0 auto;
        }

        .invoice {
            position: absolute;
            left: -6.2rem;
            top: 13.5rem;
            font-weight: 600;
            font-size: 48px;
            -webkit-transform: rotate(-90deg);
            -moz-transform: rotate(-90deg);
            -ms-transform: rotate(-90deg);
            -o-transform: rotate(-90deg);
            transform: rotate(-90deg);
        }

        .items {
            width: 100%;
            text-align: center;
            padding: 15px 0;
            border: 1px solid black;
            border-collapse: collapse;
            font-size: 14px;
        }

        .items th, .items td {
            border: 1px solid black;
            border-collapse: collapse;
        }

        a {
            font-size: 14px;
            text-decoration: none;
        }

        .paid, .text-purple {
            color: #592f83;
        }

        .unpaid {
            color: #f23a2e;
        }
    </style>
</head>
<body onload="window.print()">
<img class="watermark" alt="watermark"
     src="{{$order->status_payment > 1 ? asset('images/bg_invoice_paid.jpg') : asset('images/bg_invoice_unpaid.jpg')}}">
<img class="sign" alt="stamp" src="{{asset('images/stamp_rabbit.png')}}">
<div class="container">
    <div class="invoice">Invoice <span style="color: #592f83">{{str_pad($order->id, 4, 0, STR_PAD_LEFT)}}</span></div>
    <table cellspacing="0" cellpadding="0" style="margin-top: 4.5rem">
        <tr>
            <td>
                <table cellspacing="0" cellpadding="0"
                       style="width: 100%; padding-bottom: 20px;font-weight: 600;font-size: 14px">
                    <tbody>
                    <tr style="margin-bottom: 8px;">
                        <td>
                            <h2 class="text-purple" style="margin-bottom: 10px">Rabbit Media – Digital Creative
                                Service</h2>
                            <span>Komplek Bintang Diponggo Kav. 885<br>Surabaya 60265, East Java – Indonesia</span>
                            <table style="margin-left: -3px;margin-top: 10px">
                                <tr>
                                    <td>Phone</td>
                                    <td>&nbsp;:&nbsp;</td>
                                    <td>+62 856 3094 333 (Fiqy) | +62 822 3438 9870 (Laras)</td>
                                </tr>
                                <tr>
                                    <td>E-mail</td>
                                    <td>&nbsp;:&nbsp;</td>
                                    <td>rm.rabbitmedia@gmail.com</td>
                                </tr>
                                <tr>
                                    <td>Web</td>
                                    <td>&nbsp;:&nbsp;</td>
                                    <td>www.rabbit-media.net</td>
                                </tr>
                            </table>
                        </td>
                        <td style="text-align: center">
                            <img src="{{asset('images/logo_purple_ver.png')}}" alt="Print"
                                 style="vertical-align: middle;width: 150px">
                        </td>
                    </tr>
                    </tbody>
                </table>

                <table cellspacing="0" cellpadding="0"
                       style="width: 100%; padding-bottom: 15px;border-top: 3px solid #592f83">
                    <tbody>
                    <tr style="font-weight: 600;">
                        <td style="padding: 0 10px;">
                            <span class="text-purple">Bill To</span>
                            <p>{{$order->getUser->name}}<br>{{$order->getUser->alamat}}<br>{{$order->getUser->no_telp}}
                            </p>
                        </td>
                        <td style="padding: 0 10px;">
                            <span class="text-purple">Ship To</span>
                            <p>{{$order->getUser->name}}<br>{{$order->getUser->alamat}}<br>{{$order->getUser->no_telp}}
                            </p>
                        </td>
                        <td style="padding: 0 10px; vertical-align: top">
                            <table style="margin-top:-11px;border-collapse:separate;-webkit-border-vertical-spacing: 10px;vertical-align: top">
                                <tr>
                                    <td class="text-purple" style="text-align: right">Invoice&nbsp;Date</td>
                                    <td>&emsp;</td>
                                    <td>{{\Carbon\Carbon::parse($order->created_at)->format('m/d/Y')}}</td>
                                </tr>
                                <tr>
                                    <td class="text-purple" style="text-align: right">P.O</td>
                                    <td>&emsp;</td>
                                    <td>{{\Carbon\Carbon::parse($order->start)->format('m/d/Y')}}</td>
                                </tr>
                                <tr>
                                    <td class="text-purple" style="text-align: right">Due&nbsp;Date</td>
                                    <td>&emsp;</td>
                                    <td>{{\Carbon\Carbon::parse($order->start)->subDays(2)->format('m/d/Y')}}</td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    </tbody>
                </table>

                <table class="items" cellspacing="0" cellpadding="0" style="width: 100%; padding-bottom: 15px;">
                    <thead>
                    <tr style="background-color: #592f83;color: #fff;text-align: center">
                        <th style="padding: 2px 8px;">Qty</th>
                        <th style="padding: 2px 8px;">Description</th>
                        <th style="padding: 2px 8px;">Unit Price</th>
                        <th style="padding: 2px 8px;">Amount</th>
                    </tr>
                    </thead>
                    <tbody style="font-weight: 600">
                    <tr>
                        <td style="text-align: center">{{$totalPlan}}</td>
                        <td style="text-align: justify;padding: 0 5px">{{$pl->paket}}</td>
                        <td style="text-align: right;padding-right: 5px">{{number_format($plan_price, 2, ',', '.')}}</td>
                        <td style="text-align: right;padding-right: 5px">{{number_format($price_totalPlan, 2, ',', '.')}}</td>
                    </tr>
                    @if($pl->isHours == true)
                        <tr>
                            <td style="text-align: center">{{$totalHours}}</td>
                            <td style="text-align: justify;padding: 0 5px">Total Durasi (Jam)</td>
                            <td style="text-align: right;padding-right: 5px">{{number_format($pl->price_per_hours, 2, ',', '.')}}</td>
                            <td style="text-align: right;padding-right: 5px">{{number_format($price_totalHours, 2, ',', '.')}}</td>
                        </tr>
                    @endif
                    @if($pl->isQty == true)
                        <tr>
                            <td style="text-align: center">{{$totalQty}}</td>
                            <td style="text-align: justify;padding: 0 5px">Total Item (Orang/Produk)</td>
                            <td style="text-align: right;padding-right: 5px">{{number_format($pl->price_per_qty, 2, ',', '.')}}</td>
                            <td style="text-align: right;padding-right: 5px">{{number_format($price_totalQty, 2, ',', '.')}}</td>
                        </tr>
                    @endif
                    @if($pl->isStudio == true)
                        <tr>
                            <td style="text-align: center">{{$totalStudio}}</td>
                            <td style="text-align: justify;padding: 0 5px">{{$order->getStudio->nama}}
                                ({{$order->getStudio->getJenisStudio->nama}})
                            </td>
                            <td style="text-align: right;padding-right: 5px">{{number_format($order->getStudio->harga, 2, ',', '.')}}</td>
                            <td style="text-align: right;padding-right: 5px">{{number_format($price_totalStudio, 2, ',', '.')}}</td>
                        </tr>
                    @endif
                    </tbody>
                </table>

                <table cellspacing="0" cellpadding="0" style="text-align: right; padding: 2rem 0 3rem 0;float: right">
                    <tbody>
                    <tr>
                        <td style="font-weight: 600">Total Bill</td>
                        <td>&emsp;&emsp;&emsp;</td>
                        <td style="font-weight: 600">{{number_format($order->total_payment, 2, ',', '.')}}</td>
                    </tr>
                    <tr>
                        <td>Payment Type (<b>{{$order->payment_type}}</b>)</td>
                        <td>&emsp;&emsp;&emsp;</td>
                        <td style="font-weight: 600">{{$order->payment_type == 'DP' ? '30%' : '100%'}}</td>
                    </tr>
                    <tr style="font-weight: 800" class="text-purple">
                        <td>Amount to Pay</td>
                        <td>&emsp;&emsp;&emsp;</td>
                        <td>Rp{{$amountToPay}}</td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>Surabaya, {{now()->format('j F Y')}}<br><br><br><br>Admin<br><br><br></td>
                    </tr>
                    </tbody>
                </table>

                <table cellspacing="0" cellpadding="0"
                       style="width: 100%;border-top: 3px solid #592f83">
                    <tbody>
                    <tr style="font-weight: 600;">
                        <td style="padding: 0 10px;">
                            <span class="text-purple">Terms & Condition</span>
                            <p style="font-size: 14px">
                                Payment is due within 3 days<br><br>
                                @if($pc->id == 1)
                                    {{$pm->name}}<br>
                                    Account Number: {{$pm->account_number}} ({{$pm->account_name}})
                                @endif
                            </p>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </td>
        </tr>
    </table>
</div>
</body>
</html>
