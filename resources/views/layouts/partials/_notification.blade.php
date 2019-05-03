<style>
    .alert-banner {
        z-index: 1049;
        position: fixed;
        top: 0;
        right: 0;
        left: 0;
        background: #592f83;
        width: 100%;
        padding: 10px;
        box-shadow: 0 2px 5px 0 rgba(0, 0, 0, 0.16), 0 2px 10px 0 rgba(0, 0, 0, 0.12);
        box-sizing: border-box;
        -webkit-transform: translateY(-150%);
        transform: translateY(-150%);
        color: #FFFFFF;
        font-family: "Open Sans", sans-serif;
        -webkit-font-smoothing: antialiased;
        -moz-osx-font-smoothing: grayscale;
        -webkit-animation: alert-banner-slide-in 0.8s ease forwards;
        animation: alert-banner-slide-in 0.8s ease forwards;
    }

    .alert-banner-content {
        display: -webkit-box;
        display: -ms-flexbox;
        display: flex;
        -webkit-box-align: center;
        -ms-flex-align: center;
        align-items: center;
        -webkit-box-orient: horizontal;
        -webkit-box-direction: normal;
        -ms-flex-direction: row;
        flex-direction: row;
        -webkit-box-pack: center;
        -ms-flex-pack: center;
        justify-content: center;
        width: 90%;
        margin: 0 auto;
        padding: 10px 40px;
        box-sizing: border-box;
    }

    .alert-banner-title {
        font-size: 18px;
    }

    .alert-banner-text {
        margin: 0 20px 0 0;
    }

    .alert-banner-button {
        display: inline-block;
        padding: 0 20px;
        cursor: pointer;
        color: #592f83;
        background: #fff;
        border: 0 none;
        border-radius: 4px;
        border-bottom: 4px solid #312855;
        outline: none;
        text-transform: none;
        font-size: 12px;
        font-weight: 700;
        line-height: 40px;
        transition: all .2s ease;
    }

    .alert-banner-button:hover {
        background: #402E69;
        color: #fff;
        transition: all .2s ease;
    }

    .alert-banner-button:active {
        border: 0;
        transition: all .2s ease;
    }

    .alert-banner-close {
        position: absolute;
        top: 50%;
        right: 20px;
        width: 20px;
        height: 20px;
        -webkit-transform: translateY(-50%);
        transform: translateY(-50%);
        cursor: pointer;
    }

    .alert-banner-close:before, .alert-banner-close:after {
        content: "";
        position: absolute;
        top: 50%;
        left: 50%;
        display: block;
        background: #FFFFFF;
        width: 100%;
        height: 3px;
        border-radius: 2px;
        -webkit-transform-origin: center;
        transform-origin: center;
    }

    .alert-banner-close:before {
        -webkit-transform: translate(-50%, -50%) rotate(-45deg);
        transform: translate(-50%, -50%) rotate(-45deg);
    }

    .alert-banner-close:after {
        -webkit-transform: translate(-50%, -50%) rotate(45deg);
        transform: translate(-50%, -50%) rotate(45deg);
    }

    @-webkit-keyframes alert-banner-slide-in {
        0% {
            -webkit-transform: translateY(-150%);
            transform: translateY(-150%);
        }
        100% {
            -webkit-transform: translateY(0%);
            transform: translateY(0%);
        }
    }

    @keyframes alert-banner-slide-in {
        0% {
            -webkit-transform: translateY(-150%);
            transform: translateY(-150%);
        }
        100% {
            -webkit-transform: translateY(0%);
            transform: translateY(0%);
        }
    }
</style>
@auth
    @php
        $pays = \App\Models\Pemesanan::where('user_id',Auth::id())->where('isAccept',true)
        ->where('start', '>', now()->addDays(2))->where('status_payment' ,'<=', 1)->whereNull('payment_id')->count();

        $reviews = \App\Models\Pemesanan::where('user_id',Auth::id())->whereHas('getOrderLog', function ($q){
            $q->where('isReady', true)->where('isComplete', false);
        })->count();
    @endphp
    @if($pays && !Illuminate\Support\Facades\Request::is('account/dashboard/order-status'))
        <div class="alert-banner">
            <div class="alert-banner-content">
                <div class="alert-banner-text">
                    Tampaknya ada <strong>{{$pays}}</strong> pesanan Anda yang belum dibayar!
                </div>
                <a class="alert-banner-button" href="{{route('client.dashboard')}}" style="text-decoration: none">
                    Alihkan saya ke halaman Order Status!</a>
            </div>
            <div class="alert-banner-close"></div>
        </div>
    @endif
    @if($reviews && !Illuminate\Support\Facades\Request::is('account/dashboard/order-status'))
        <div class="alert-banner">
            <div class="alert-banner-content">
                <div class="alert-banner-text">
                    Tampaknya ada <strong>{{$reviews}}</strong> pesanan Anda yang belum diulas (revisi)!
                </div>
                <a class="alert-banner-button" href="{{route('client.dashboard')}}" style="text-decoration: none">
                    Alihkan saya ke halaman Order Status!</a>
            </div>
            <div class="alert-banner-close"></div>
        </div>
    @endif
@endauth
@auth('admin')
    @php
        $orders = \App\Models\Pemesanan::where('isAccept',false)->count();
        $pays = \App\Models\Pemesanan::where('isAccept',true)->where('start', '>', now()->addDays(2))
        ->whereNotNull('payment_id')->whereNotNull('payment_proof')->where('status_payment' ,'<=', 1)->count();
    @endphp
    @if($orders > 0 && (Auth::guard('admin')->user()->isRoot() || Auth::guard('admin')->user()->isCEO()))
        <div class="alert-banner">
            <div class="alert-banner-content">
                <div class="alert-banner-text">
                    Tampaknya ada <strong>{{$orders}}</strong> pesanan yang belum Anda konfirmasi!
                </div>
                <a class="alert-banner-button" href="{{route('table.orders')}}" style="text-decoration: none">
                    Alihkan saya ke halaman Orders Table!</a>
            </div>
            <div class="alert-banner-close"></div>
        </div>
    @endif
    @if($pays > 0 && (Auth::guard('admin')->user()->isRoot() || Auth::guard('admin')->user()->isAdmin()))
        <div class="alert-banner">
            <div class="alert-banner-content">
                <div class="alert-banner-text">
                    Tampaknya ada <strong>{{$pays}}</strong> pesanan yang belum Anda verifikasi pembayarannya!
                </div>
                <a class="alert-banner-button" href="{{route('table.orders')}}" style="text-decoration: none">
                    Alihkan saya ke halaman Orders Table!</a>
            </div>
            <div class="alert-banner-close"></div>
        </div>
    @endif
@endauth
<script>
    $('.alert-banner-close').on('click', function () {
        $(this).parent().slideUp(300, function () {
            $(this).remove();
        });
    });
</script>