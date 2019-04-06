<?php

namespace App\Http\Controllers\Pages\Client;

use App\Models\layanan;
use App\Models\PaymentMethod;
use App\Models\Pemesanan;
use App\Support\RomanConverter;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except('invoiceOrder');
        $this->middleware('invoice')->only('invoiceOrder');
    }

    public function showDashboard(Request $request)
    {
        $user = Auth::user();
        $req_id = $request->id;
        $req_invoice = $request->invoice;
        $findOrder = $req_id != null ? Pemesanan::find(decrypt($req_id)) : '';

        return view('pages.clients.dashboard', compact('user', 'req_id', 'req_invoice', 'findOrder'));
    }

    public function getOrderStatus(Request $request)
    {
        $start = $request->start_date;
        $end = $request->end_date;

        $result = Pemesanan::where('user_id', $request->user_id)
            ->whereBetween('created_at', [$start, $end])->orderByDesc('id')->paginate(6)->toArray();

        $i = 0;
        foreach ($result['data'] as $row) {
            $id['encryptID'] = encrypt($row['id']);
            $date = Carbon::parse($row['created_at']);
            $romanDate = RomanConverter::numberToRoman($date->format('y')) . '/' .
                RomanConverter::numberToRoman($date->format('m'));

            $filename = $row['isPaid'] == true ? asset('images/stamp_paid.png') :
                asset('images/stamp_unpaid.png');

            $plan = layanan::find($row['layanan_id']);
            $payment_method = PaymentMethod::find($row['payment_id']);

            $paid = array('ava' => $filename);
            $invoice = array('invoice' => '#INV/' . $date->format('Ymd') . '/' . $romanDate . '/' . $row['id']);
            $pl = array('plan' => $plan->paket);
            $pm = array('pm' => $payment_method->name);
            $pc = array('pc' => $payment_method->paymentCategories->name);
            $created_at = array('created_at' => Carbon::parse($row['created_at'])->diffForHumans());
            $created_at1DayAdd = array('add_day' => Carbon::parse($row['created_at'])->addDay());
            $status = array('expired' => now() >= Carbon::parse($row['created_at'])->addDay() ? true : false);
            $deadline = array('deadline' => Carbon::parse($row['created_at'])->addDay()->format('l, j F Y') .
                ' at ' . Carbon::parse($row['created_at'])->addDay()->format('H:i'));

            $orderDate = array('date_order' => Carbon::parse($row['created_at'])->format('l, j F Y'));
            $paidDate = array('date_payment' => Carbon::parse($row['date_payment'])->format('l j F Y'));

            $result['data'][$i] = array_replace($paid, $id, $invoice, $result['data'][$i], $pl, $pm, $pc,
                $created_at, $created_at1DayAdd, $orderDate, $paidDate, $deadline, $status);
            $i = $i + 1;
        }

        return $result;
    }

    public function invoiceOrder($id)
    {
        $order = Pemesanan::find(decrypt($id));
        $user = $order->getUser;

        $pm = $order->getPayment;
        $pc = $pm->paymentCategories;
        $pl = $order->getLayanan;

        $plan_price = $pl->harga - ($pl->harga * $pl->diskon / 100);

        $date = Carbon::parse($order->created_at);
        $romanDate = RomanConverter::numberToRoman($date->format('y')) . '/' .
            RomanConverter::numberToRoman($date->format('m'));
        $invoice = 'INV/' . $date->format('Ymd') . '/' . $romanDate . '/' . $order->id;

        return view('pages.clients.invoice', compact('order', 'user', 'pm', 'pc', 'pl',
            'plan_price', 'invoice'));
    }
}
