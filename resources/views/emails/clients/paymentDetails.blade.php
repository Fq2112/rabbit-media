<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scaleable=no">
    <title>Payment Details! ({{$data['invoice']}})</title>
    <style type="text/css">
        /*Bootstrap*/
        .alert {
            padding: 15px;
            margin: 0 1.5em 1em 1.5em;
            border: 1px solid transparent;
            border-radius: 4px;
        }

        .alert h4 {
            margin-top: 0;
            color: inherit;
        }

        .alert .alert-link {
            font-weight: bold;
        }

        .alert > p,
        .alert > ul {
            margin-bottom: 0;
        }

        .alert > p + p {
            margin-top: 5px;
        }

        .alert-dismissable,
        .alert-dismissible {
            padding-right: 35px;
        }

        .alert-dismissable .close,
        .alert-dismissible .close {
            position: relative;
            top: -2px;
            right: -21px;
            color: inherit;
        }

        .alert-success {
            background-color: #dff0d8;
            border-color: #d6e9c6;
            color: #3c763d;
        }

        .alert-success hr {
            border-top-color: #c9e2b3;
        }

        .alert-success .alert-link {
            color: #2b542c;
        }

        .alert-info {
            background-color: #d9edf7;
            border-color: #bce8f1;
            color: #31708f;
        }

        .alert-info hr {
            border-top-color: #a6e1ec;
        }

        .alert-info .alert-link {
            color: #245269;
        }

        .alert-warning {
            background-color: #fcf8e3;
            border-color: #faebcc;
            color: #8a6d3b;
        }

        .alert-warning hr {
            border-top-color: #f7e1b5;
        }

        .alert-warning .alert-link {
            color: #66512c;
        }

        .alert-danger {
            background-color: #f2dede;
            border-color: #ebccd1;
            color: #a94442;
        }

        .alert-danger hr {
            border-top-color: #e4b9c0;
        }

        .alert-danger .alert-link {
            color: #843534;
        }

        .text-left {
            text-align: left;
        }

        .text-right {
            text-align: right;
        }

        .text-center {
            text-align: center;
        }

        blockquote {
            padding: 10px 20px;
            margin: 0 0 20px;
            font-size: 17.5px;
            border-left: 5px solid #eeeeee;
        }

        blockquote p:last-child,
        blockquote ul:last-child,
        blockquote ol:last-child {
            margin-bottom: 0;
        }

        blockquote footer,
        blockquote small,
        blockquote .small {
            display: block;
            font-size: 80%;
            line-height: 1.42857;
            color: #777777;
        }

        blockquote footer:before,
        blockquote small:before,
        blockquote .small:before {
            content: '\2014 \00A0';
        }

        .blockquote-reverse,
        blockquote.pull-right {
            padding-right: 15px;
            padding-left: 0;
            border-right: 5px solid #eeeeee;
            border-left: 0;
            text-align: right;
        }

        .blockquote-reverse footer:before,
        .blockquote-reverse small:before,
        .blockquote-reverse .small:before,
        blockquote.pull-right footer:before,
        blockquote.pull-right small:before,
        blockquote.pull-right .small:before {
            content: '';
        }

        .blockquote-reverse footer:after,
        .blockquote-reverse small:after,
        .blockquote-reverse .small:after,
        blockquote.pull-right footer:after,
        blockquote.pull-right small:after,
        blockquote.pull-right .small:after {
            content: '\00A0 \2014';
        }

        .list-inline {
            padding-left: 0;
            list-style: none;
            margin-left: -5px;
        }

        .list-inline > li {
            display: inline-block;
            padding-left: 5px;
            padding-right: 5px;
        }

        /*end:Bootstrap*/

        .hr-divider {
            margin: 0 0 .5em 0;
            border: 0;
            height: 1px;
            background-image: linear-gradient(to right, rgba(0, 0, 0, .4), rgba(0, 0, 0, .1), rgba(0, 0, 0, 0));
        }

        #activate {
            color: #FFFFFF;
            background: #5bd3d1;
            -moz-border-radius: 9px;
            -webkit-border-radius: 9px;
            border-radius: 9px;
            padding-left: 20px;
            padding-right: 20px;
            width: 320px;
            display: block;
            font-size: 18px;
            font-weight: bold;
            line-height: 50px;
            text-align: center;
            text-decoration: none;
        }

        .zoom {
            transition: transform .3s;
        }

        .zoom:hover {
            -ms-transform: scale(1.1);
            -webkit-transform: scale(1.1);
            transform: scale(1.1);
        }

        small {
            font-size: 16px;
        }

        div, p, a, li, td {
            color: #666;
            -webkit-text-size-adjust: none;
        }

        .ExternalClass * {
            line-height: 100%
        }

        .ReadMsgBody {
            width: 100%
        }

        .ExternalClass {
            width: 100%
        }

        .appleLinks a {
            color: #646464;
            text-decoration: none;
        }

        table {
            border-collapse: collapse;
            font-size: 16px;
        }

        body {
            margin: 0;
            padding: 0;
            font-family: helvetica, arial, sans-serif;
            -webkit-text-size-adjust: none;
        }

        .appleLinksWhite a {
            color: #949494;
            text-decoration: none;
        }

        @media screen and (max-width: 480px) {
            /* Width Control */
            table[class=full-width], img[class=full-width], a[class=full-width], div[class=full-width] {
                width: 100% !important;
                height: auto !important;
            }

            div[class=line40] {
                line-height: 40px !important;
            }

            /* Hiding Elements */
            table[id=hide], td[class="hide"], img[id=hide] {
                display: none !important;
            }

            img[class=logo] {
                width: 240px !important;
                height: 75px !important;
            }
        }

        /* Medium Screen Tablets */
        @media screen and (max-width: 650px) {
            img[class=logo] {
                width: 240px !important;
                height: 75px !important;
            }

            a[class=footerlinks] {
                display: block !important;
                font-size: 16px !important;
                padding: 0px 4px 2px 4px !important;
                line-height: 14px !important;
                width: 70% !important;
                text-align: center !important;
                color: #F9F9F9 !important;
                text-decoration: none !important;
            }

            table[class=full-width], img[class=full-width], a[class=full-width], div[class=full-width] {
                width: 100% !important;
                height: auto !important;
            }

            table[class=hide], img[class=hide], td[class=hide], span[class=hide] {
                display: none !important;
            }

            div[class=line40] {
                line-height: 40px !important;
            }

            td[class=headline] {
                padding-left: 10px !important;
            }

            span[class=content2] {
                font-size: 18px !important;
            }

            span[class=appleLinksWhite] {
                color: #949494 !important;
            }

            td[class=body], span[class=body] {
                padding-right: 25px !important;
                padding-left: 25px !important;
                font-size: 20px !important;
            }

            td[class=footer-padding] {
                padding-right: 15px !important;
                padding-left: 15px !important;
            }

            img[class=social-icons] {
                height: 90px !important;
                width: auto !important;
            }
        }
    </style>
</head>
<body>
<table width="100%" border="0" align="center" cellspacing="0" cellpadding="0" bgcolor="#FAFAFA" class="full-width">
    <tbody>
    <tr>
        <td>
            <div style="font-size:10px;line-height:10px;">&nbsp;</div>
        </td>
    </tr>
    </tbody>
</table>
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#FAFAFA">
    <tbody>
    <tr>
        <td align="center">
            <table width="700" border="0" align="center" cellspacing="0" cellpadding="0" class="full-width"
                   style="margin:0 auto;">
                <tbody>
                <tr>
                    <td width="700" align="center">
                        <table width="700" border="0" align="center" cellpadding="0" cellspacing="0"
                               class="full-width" style="margin:0 auto;">
                            <tbody>
                            <tr>
                                <td width="14" bgcolor="#fafafa"></td>
                                <td width="2" bgcolor="#f9f9f9"></td>
                                <td width="2" bgcolor="#f7f7f7"></td>
                                <td width="2" bgcolor="#f3f3f3"></td>
                                <td width="660" valign="top" bgcolor="#fff">
                                    <table bgcolor="#fff" border="0" cellspacing="0" cellpadding="0" class="full-width"
                                           style="border-top: 2px solid #f3f3f3">
                                        <tbody>
                                        <tr>
                                            <td align="center" width="660">
                                                <a name="Logo" style="display:block" href="{{route('home')}}"
                                                   target="_blank">
                                                    <img src="https://cdn1.imggmi.com/uploads/2019/3/31/ce87edc5c38037e4f9a2c74dc80bc699-full.png"
                                                         border="0" style="display:block;width: 40%;margin: 1em"
                                                         class="logo"></a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div style="border-top: 1px solid #e0e0e0; height: 2px"
                                                     class="full-width"></div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <table border="0" cellpadding="10" cellspacing="0"
                                                       style="margin: .5em 1em">
                                                    <tr>
                                                        <td>
                                                            <small style="line-height: 2em">
                                                                <strong style="font-size: 22px">Mohon untuk segera
                                                                    menyelesaikan pembayaran Anda</strong><br>
                                                                Checkout pesanan berhasil dilakukan pada
                                                                {{$data['order']->created_at
                                                                ->isoFormat('DD MMMM YYYY [pukul] HH:mm')}}
                                                            </small>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div style="font-size:20px;line-height:20px;">&nbsp;</div>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                    <table bgcolor="#fff" border="0" cellpadding="0" cellspacing="0" width="660"
                                           align="center">
                                        <tr>
                                            <td valign="top" width="60%">
                                                <table border="0" cellpadding="10" cellspacing="0" width="100%"
                                                       style="margin-left: 1em">
                                                    <tr>
                                                        <td>
                                                            <small>
                                                                <a href="{{route('invoice.order', ['id' => 
                                                                encrypt($data['order']->id)])}}"
                                                                   style="text-decoration: none;color: #592f83">
                                                                    <strong>{{$data['invoice']}}</strong></a>
                                                            </small>
                                                            <hr class="hr-divider">
                                                            <table>
                                                                <tr>
                                                                    <td><strong>{{$data['plans']->paket}}</strong></td>
                                                                    <td>&emsp;</td>
                                                                    <td align="center">
                                                                        <strong>{{$data['totalPlan']}}</strong>
                                                                    </td>
                                                                    <td>&emsp;</td>
                                                                    <td align="right">
                                                                        <strong>Rp{{number_format
                                                                        ($data['price_totalPlan'],2,',','.')}}</strong>
                                                                    </td>
                                                                </tr>
                                                                @if($data['plans']->isHours == true)
                                                                    <tr>
                                                                        <td>Hours</td>
                                                                        <td>&emsp;</td>
                                                                        <td align="center">
                                                                            <strong>{{$data['totalHours']}}</strong>
                                                                        </td>
                                                                        <td>&emsp;</td>
                                                                        <td align="right">
                                                                            <strong>Rp{{number_format
                                                                            ($data['price_totalHours'],2,',','.')}}
                                                                            </strong>
                                                                        </td>
                                                                    </tr>
                                                                @endif
                                                                @if($data['plans']->isQty == true)
                                                                    <tr>
                                                                        <td>Qty.</td>
                                                                        <td>&emsp;</td>
                                                                        <td align="center">
                                                                            <strong>{{$data['totalQty']}}</strong></td>
                                                                        <td>&emsp;</td>
                                                                        <td align="right">
                                                                            <strong>Rp{{number_format
                                                                            ($data['price_totalQty'],2,',','.')}}
                                                                            </strong>
                                                                        </td>
                                                                    </tr>
                                                                @endif
                                                                @if($data['plans']->isStudio == true)
                                                                    <tr>
                                                                        <td><strong>{{$data['studio']}}</strong></td>
                                                                        <td>&emsp;</td>
                                                                        <td align="center">
                                                                            <strong>{{$data['totalStudio']}}</strong>
                                                                        </td>
                                                                        <td>&emsp;</td>
                                                                        <td align="right">
                                                                            <strong>Rp{{number_format
                                                                            ($data['price_totalStudio'],2,',','.')}}
                                                                            </strong>
                                                                        </td>
                                                                    </tr>
                                                                @endif
                                                                <tr style="border-top: 1px solid #eee">
                                                                    <td><strong>Total Bill</strong></td>
                                                                    <td colspan="4" align="right">
                                                                        <strong>Rp{{number_format($data['order']
                                                                        ->total_payment,2,',','.')}}</strong>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Payment Type (<strong>{{$data['order']
                                                                    ->payment_type}}</strong>)
                                                                    </td>
                                                                    <td colspan="4" align="right">
                                                                        <strong>{{$data['order']->payment_type == 'DP' ?
                                                                        '30%' : '100%'}}</strong>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td><strong style="color: #592f83">Amount to Pay
                                                                        </strong></td>
                                                                    <td colspan="4" align="right">
                                                                        <strong style="font-size: 18px;color: #592f83">
                                                                            Rp{{$data['amountToPay']}}</strong>
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>
                                            <td valign="top" width="40%">
                                                <table border="0" cellpadding="10" cellspacing="0" width="100%"
                                                       style="margin-left: 1em">
                                                    <tr>
                                                        <td>
                                                            <small><strong>Payment Deadline</strong></small>
                                                            <hr class="hr-divider">
                                                            <span>{{\Carbon\Carbon::parse($data['order']->start)
                                                            ->subDays(2)->format('l, j F Y')}}<br>
                                                            at {{\Carbon\Carbon::parse($data['order']->start)
                                                            ->subDays(2)->format('H:i')}}
                                                            </span>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <small><strong>Payment Reference</strong></small>
                                                            <hr class="hr-divider">
                                                            <span>{{$data['invoice']}}</span>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td valign="top" width="50%">
                                                <table border="0" cellpadding="10" cellspacing="0"
                                                       style="margin-left: 1em" width="100%">
                                                    <tr>
                                                        <td>
                                                            <small><strong>Payment Method</strong>
                                                                <sub>{{$data['payment_category']->name}}</sub></small>
                                                            <hr class="hr-divider">
                                                            <table>
                                                                <tr>
                                                                    <td width="50%">
                                                                        <img src="{{env('APP_URL').'/images/paymentMethod/'
                                                                        .$data['payment_method']->logo}}"
                                                                             style="width: 90%;"
                                                                             alt="{{$data['payment_method']->name}}">
                                                                    </td>
                                                                    <td>
                                                                        <small style="line-height: 1.5em;font-size: 14px">
                                                                            @if($data['payment_category']->id == 1)
                                                                                <strong style="font-size: 16px">
                                                                                    {{number_format
                                                                                    ($data['payment_method']
                                                                                    ->account_number,0," "," ")}}
                                                                                </strong>
                                                                                <br>a/n {{$data['payment_method']
                                                                                ->account_name}}
                                                                            @endif
                                                                        </small>
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>
                                            <td valign="top" width="50%">
                                                <table width="100%" border="0" cellpadding="10" cellspacing="0"
                                                       style="margin-left: 1em">
                                                    <tr>
                                                        <td>
                                                            <small><strong>Payment Status</strong></small>
                                                            <hr class="hr-divider">
                                                            <span>Menunggu Pembayaran</span>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                    </table>
                                    <table bgcolor="#fff" border="0" cellpadding="0" cellspacing="0" width="660"
                                           align="center">
                                        <tr>
                                            <td>
                                                <div style="font-size:20px;line-height:20px;">&nbsp;</div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div style="font-size:20px;line-height:20px;">&nbsp;</div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div class="alert alert-info text-center">
                                                    <a target="_blank" style="color: #31708f;text-decoration: none"
                                                       href="{{route('client.dashboard',['id' => encrypt
                                                       ($data['order']->id),'invoice'=> $data['invoice']])}}">
                                                        <strong>Unggah Bukti Pembayaran</strong>
                                                    </a> untuk mempercepat proses verifikasi
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div class="alert alert-warning text-center">
                                                    Pastikan untuk tidak menyebarkan rincian pembayaran Anda beserta
                                                    buktinya kepada pihak manapun kecuali <strong>Rabbit Media</strong>.
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div style="font-size:20px;line-height:20px;">&nbsp;</div>
                                            </td>
                                        </tr>
                                    </table>
                                    <table bgcolor="#fff" border="0" cellpadding="0" cellspacing="0" width="660"
                                           align="center" style="border-top: 2px solid #f3f3f3">
                                        <tr>
                                            <td>
                                                <table border="0" cellpadding="10" cellspacing="0"
                                                       style="margin: .5em 1em">
                                                    <tr>
                                                        <td>
                                                            <small style="line-height: 2em">
                                                                <strong style="font-size: 20px">
                                                                    Tetap awasi status pesanan Anda pada halaman
                                                                    Order Status</strong><br>Untuk beralih ke halaman
                                                                tersebut, silahkan klik tombol Order Status berikut.
                                                            </small>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td align="center" width="600" class="full-width"
                                                            style="padding-left: 20px; padding-right:20px" valign="top">
                                                            <a class="zoom" id="activate"
                                                               href="{{route('client.dashboard')}}" target="_blank">
                                                                ORDER STATUS</a>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                                <td width="2" bgcolor="#f3f3f3"></td>
                                <td width="2" bgcolor="#f7f7f7"></td>
                                <td width="2" bgcolor="#f9f9f9"></td>
                                <td width="14" bgcolor="#fafafa"></td>
                        </table>
                    </td>
                </tr>
                </tbody>
            </table>
        </td>
    </tr>
    </tbody>
</table>

<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#ffffff">
    <tbody>
    <tr>
        <td valign="top" align="center">
            <table width="700" border="0" align="center" cellspacing="0" cellpadding="0" bgcolor="#ffffff"
                   class="full-width" style="margin:0 auto;">
                <tbody>
                <tr>
                    <td valign="top" width="20" class="hide" bgcolor="#1a1c21">
                        <div style="font-size:44px;line-height:44px;">&nbsp;</div>
                    </td>
                    <td valign="top" width="660" bgcolor="#FFFFFF" class="hide" height="40" alt="" border="0"></td>
                    <td valign="top" width="20" class="hide" bgcolor="#1a1c21">
                        <div style="font-size:44px;line-height:44px;">&nbsp;</div>
                    </td>
                </tr>
                </tbody>
            </table>
            <table width="700" border="0" align="center" cellspacing="0" cellpadding="0" bgcolor="#1a1c21"
                   class="full-width" style="margin:0 auto;">
                <tbody>
                <tr>
                    <td valign="top" align="center">
                        <table width="700" border="0" align="center" cellspacing="0" cellpadding="0" bgcolor="#1a1c21"
                               class="full-width">
                            <tbody>
                            <tr>
                                <td valign="top" align="center">
                                    <table width="700" border="0" align="center" cellspacing="0" cellpadding="0"
                                           bgcolor="#1a1c21" class="full-width">
                                        <tbody>
                                        <tr>
                                            <td valign="top" width="660" bgcolor="#1a1c21">
                                                <div style="font-size:39px;line-height:39px;">&nbsp;</div>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                    <table width="700" border="0" align="center" cellspacing="0" cellpadding="0"
                                           bgcolor="#1a1c21" class="full-width">
                                        <tbody>
                                        <tr>
                                            <td valign="top" width="20" class="hide">&nbsp;</td>
                                            <td align="center" valign="top" width="660" bgcolor="#1a1c21">
                                                <a name="Logo_1" style="display:block;" href="{{route('home')}}"
                                                   target="_blank">
                                                    <img src="https://cdn1.imggmi.com/uploads/2019/3/31/9351b2d132efd335ceae6c6e492fc93d-full.png"
                                                         alt="logo"
                                                         border="0" style="display:block;width: 15%;"></a>
                                            </td>
                                            <td valign="top" width="20" class="hide">&nbsp;</td>
                                        </tr>
                                        </tbody>
                                    </table>
                                    <table width="700" border="0" align="center" cellspacing="0" cellpadding="0"
                                           bgcolor="#1a1c21" class="full-width">
                                        <tbody>
                                        <tr>
                                            <td valign="top" width="20" class="hide">&nbsp;</td>
                                            <td align="center" valign="top" width="660" bgcolor="#1a1c21">
                                                <div style="font-size:5px;line-height:5px;">&nbsp;</div>
                                            </td>
                                            <td valign="top" width="20" class="hide">&nbsp;</td>
                                        </tr>
                                        </tbody>
                                    </table>
                                    <table width="700" border="0" align="center" cellspacing="0" cellpadding="0"
                                           bgcolor="#1a1c21" class="full-width">
                                        <tbody>
                                        <tr>
                                            <table width="700" border="0" align="center" cellspacing="0" cellpadding="0"
                                                   bgcolor="#1a1c21" class="full-width">
                                                <tbody>
                                                <tr>
                                                    <td valign="top" width="20" class="hide">&nbsp;</td>
                                                    <td align="center" valign="top" width="660" bgcolor="#1a1c21">
                                                        <div style="font-family:Helvetica, arial,helv,sans-serif;font-size:12px;color:#F9F9F9;">
                                                            Unduh aplikasi kami disini, GRATIS!
                                                        </div>
                                                    </td>
                                                    <td valign="top" width="20" class="hide">&nbsp;</td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </tr>
                                        <tr>
                                            <td valign="top" width="700">
                                                <table width="700" border="0" align="center" cellpadding="0"
                                                       cellspacing="0" bgcolor="#1a1c21" class="full-width">
                                                    <tbody>
                                                    <tr>
                                                        <td align="center">
                                                            <table border="0" align="center" cellpadding="0"
                                                                   cellspacing="0" bgcolor="#1a1c21">
                                                                <tbody>
                                                                <tr>
                                                                    <td align="center" bgcolor="#1a1c21">
                                                                        <a href="https://play.google.com/store/apps/details?id=com.siska.mobile"><img
                                                                                    class="zoom"
                                                                                    src="http://i67.tinypic.com/2n8nadu.png"
                                                                                    style="width: 15%"></a>&nbsp;&nbsp;&nbsp;&nbsp;
                                                                        <a href="https://itunes.apple.com/id/app/siska.com/id1143444473?mt=8"><img
                                                                                    class="zoom"
                                                                                    src="http://i67.tinypic.com/34sfhg7.png"
                                                                                    style="width: 15%"></a>
                                                                    </td>
                                                                </tr>
                                                                </tbody>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                    <table width="700" border="0" align="center" cellspacing="0" cellpadding="0"
                                           bgcolor="#1a1c21" class="full-width">
                                        <tbody>
                                        <tr>
                                            <td align="center" valign="top" width="660" bgcolor="#1a1c21">
                                                <div style="font-size:25px;line-height:25px;">&nbsp;</div>
                                            </td>

                                        </tr>
                                        </tbody>
                                    </table>
                                    <table width="700" border="0" align="center" cellspacing="0" cellpadding="0"
                                           bgcolor="#1a1c21" class="full-width">
                                        <tbody>
                                        <tr>
                                            <td align="center" valign="top" width="660" bgcolor="#1a1c21"
                                                style="font-family:Helvetica, arial,helv,sans-serif;font-size:12px;color:#F9F9F9;">
                                                Tetap berhubungan dengan kami :)
                                            </td>
                                        </tr>
                                        <tr>
                                            <td valign="top" width="700">
                                                <table width="700" border="0" align="center" cellpadding="0"
                                                       cellspacing="0" bgcolor="#1a1c21" class="full-width">
                                                    <tbody>
                                                    <tr>
                                                        <td align="center">
                                                            <table border="0" align="center" cellpadding="0"
                                                                   cellspacing="0" bgcolor="#1a1c21">
                                                                <tbody>
                                                                <tr>
                                                                    <td align="center"><a
                                                                                href="https://fb.com/RabbitMedia"
                                                                                name="Facebook" target="_blank"><img
                                                                                    class="social-icons"
                                                                                    src="https://cdn.shazam.com/shazamauth/facebook.jpg"
                                                                                    width="34" height="50"
                                                                                    style="display:block" border="0"
                                                                                    alt="Facebook"></a>
                                                                    </td>
                                                                    <td>
                                                                        <a href="https://twitter.com/RabbitMediaID"
                                                                           name="Twitter" target="_blank"><img
                                                                                    class="social-icons"
                                                                                    src="https://cdn.shazam.com/shazamauth/twitter.jpg"
                                                                                    width="36" height="50"
                                                                                    style="display:block" border="0"
                                                                                    alt="Twitter"></a>
                                                                    </td>
                                                                    <td>
                                                                        <a href="https://instagram.com/rabbit.media"
                                                                           name="Instagram" target="_blank"><img
                                                                                    class="social-icons"
                                                                                    src="https://cdn.shazam.com/shazamauth/instagram.jpg"
                                                                                    width="39" height="50"
                                                                                    style="display:block" border="0"
                                                                                    alt="Instagram"></a>
                                                                    </td>
                                                                </tr>
                                                                </tbody>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                    <table width="700" border="0" align="center" cellspacing="0" cellpadding="0"
                                           bgcolor="#1a1c21" class="full-width">
                                        <tbody>
                                        <tr>
                                            <td align="center" valign="top" width="660" bgcolor="#1a1c21">
                                                <div style="font-size:25px;line-height:25px;">&nbsp;</div>
                                            </td>

                                        </tr>
                                        </tbody>
                                    </table>
                                    <table width="700" border="0" align="center" cellspacing="0" cellpadding="0"
                                           bgcolor="#1a1c21" class="full-width">
                                        <tbody>
                                        <tr>
                                            <td valign="top" width="700">
                                                <table width="700" border="0" align="center" cellpadding="0"
                                                       cellspacing="0" bgcolor="#1a1c21" class="full-width">
                                                    <tbody>
                                                    <tr>
                                                        <td>
                                                            <table border="0" cellspacing="0" cellpadding="0"
                                                                   width="700" class="full-width" bgcolor="#1a1c21">
                                                                <tbody>
                                                                <tr>
                                                                    <td align="center"
                                                                        style="font-family:Helvetica, arial,helv,sans-serif;font-size:16px;color:#F9F9F9; font-weight:bold;"
                                                                        bgcolor="#1a1c21">
                                                                        <a name="Privacy Policy"
                                                                           href="{{route('info')}}"
                                                                           class="footerlinks"
                                                                           style="color:#F9F9F9; text-decoration:none;"
                                                                           target="_blank">Privacy Policy</a>&nbsp;&nbsp;&nbsp;&nbsp;
                                                                        <a name="Terms" class="footerlinks"
                                                                           style="color:#F9F9F9; text-decoration:none;"
                                                                           href="{{route('info')}}"
                                                                           target="_blank">Terms of Service</a>
                                                                    </td>
                                                                </tr>
                                                                </tbody>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                    <table width="700" border="0" align="center" cellspacing="0" cellpadding="0"
                                           bgcolor="#1a1c21" class="full-width">
                                        <tbody>
                                        <tr>
                                            <td align="center" valign="top" width="660" bgcolor="#1a1c21">
                                                <div style="font-size:25px;line-height:25px;">&nbsp;</div>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                    <table width="700" border="0" align="center" cellspacing="0" cellpadding="0"
                                           bgcolor="#1a1c21" class="full-width">
                                        <tbody>
                                        <tr>
                                            <td align="center" valign="top" width="620" bgcolor="#1a1c21">
                                                <table width="93%" border="0" align="center" cellspacing="0"
                                                       cellpadding="0">
                                                    <tbody>
                                                    <tr>
                                                        <td align="center" height="1">
                                                            <table width="660" border="0" align="center" cellspacing="0"
                                                                   cellpadding="0" class="full-width">
                                                                <tbody>
                                                                <tr>
                                                                    <td align="center" height="1" bgcolor="#646464">
                                                                        <div style="font-size:1px;line-height:1px;">
                                                                            &nbsp;
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                                </tbody>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                    <table width="700" border="0" align="center" cellspacing="0" cellpadding="0"
                                           bgcolor="#1a1c21" class="full-width">
                                        <tbody>
                                        <tr>
                                            <td align="center" valign="top" width="660" bgcolor="#1a1c21">
                                                <div style="font-size:25px;line-height:25px;">&nbsp;</div>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                    <table width="700" border="0" align="center" cellspacing="0" cellpadding="0"
                                           bgcolor="#1a1c21" class="full-width">
                                        <tbody>
                                        <tr>
                                            <td valign="top" width="700">
                                                <table width="700" border="0" align="center" cellpadding="0"
                                                       cellspacing="0" bgcolor="#1a1c21" class="full-width">
                                                    <tbody>
                                                    <tr>
                                                        <td>
                                                            <table border="0" cellspacing="0" cellpadding="0"
                                                                   width="700" class="full-width" bgcolor="#1a1c21">
                                                                <tbody>
                                                                <tr>
                                                                    <td align="center" class="footer-padding"
                                                                        style="font-family:Helvetica, arial,helv,sans-serif;font-size:10px; color:#949494; font-weight:bold; padding-left:20px; padding-right:20px"
                                                                        bgcolor="#1a1c21">
                                                                        Ini adalah pemberitahuan yang dibuat secara
                                                                        otomatis - tolong jangan balas pesan ini. Anda
                                                                        menerima email ini untuk menyelesaikan
                                                                        pendaftaran yang dimulai pada aplikasi Rabbit
                                                                        Media; jika Anda tidak memasukkan alamat email
                                                                        Anda di situs Rabbit Media maka Anda dapat
                                                                        mengabaikan pesan ini atau menghubungi
                                                                        info@rabbit-media.net untuk informasi lebih
                                                                        lanjut.<br><br>Rabbit Media didirikan di
                                                                        Indonesia dengan nomor perusahaan
                                                                        <span class="appleLinksWhite">+62315667102</span>.
                                                                        <span class="appleLinksWhite">© {{now()->format('Y')}} Rabbit Media – Digital Creative Service. All rights reserved.  JL. Dukuh Kupang Timur XX, Kav. 788, Kompleks Diponggo, Pakis, Surabaya — 60265.</span>
                                                                        <br>
                                                                        <div id="stat-div"
                                                                             style="visibility:hidden !important;"
                                                                             height="0px">
                                                                            <img id="stat-link"
                                                                                 src="https://www.shazam.com/validate-email/email-view?email=matt@reallygoodemails.com"
                                                                                 alt="" border="0" width="0px"
                                                                                 height="0px"
                                                                                 style="visibility:hidden !important;">
                                                                        </div>
                                                                        <br>
                                                                        <br>
                                                                        <br></td>
                                                                </tr>
                                                                </tbody>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>

                                    <!-- Footer END --> <!-- END Wrapper --></td>
                            </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
                </tbody>
            </table>
        </td>
    </tr>
    </tbody>
</table>
</body>