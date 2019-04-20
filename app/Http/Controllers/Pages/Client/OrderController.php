<?php

namespace App\Http\Controllers\Pages\Client;

use App\Models\JenisStudio;
use App\Models\layanan;
use App\Models\PaymentCategory;
use App\Models\PaymentMethod;
use App\Models\Pemesanan;
use App\Models\Schedule;
use App\Models\Studio;
use App\Support\RomanConverter;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Storage;

class OrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except('invoiceOrder');
        $this->middleware('invoice')->only('invoiceOrder');
    }

    public function showOrder($id)
    {
        $user = Auth::user();
        $paymentCategories = PaymentCategory::all();
        $types = JenisStudio::orderBy('nama')->get();

        $layanan = layanan::find(decrypt($id));
        $price = $layanan->harga - ($layanan->harga * $layanan->diskon / 100);

        $booked = Schedule::has('getPemesanan')->where('isDayOff', false)->get();
        $holidays = Schedule::doesntHave('getPemesanan')->where('isDayOff', true)->get();

        return view('pages.clients.orderForm', compact('user', 'paymentCategories', 'types',
            'layanan', 'price', 'booked', 'holidays'));
    }

    public function getDetailStudio($id)
    {
        $studio = Studio::find($id);

        return array_replace($studio->toArray(), array('jenis_id' => $studio->getJenisStudio->nama));
    }

    public function getPaymentMethod($id)
    {
        return PaymentMethod::find($id);
    }

    public function submitOrder(Request $request)
    {
        $user = Auth::user();
        $order = Pemesanan::create([
            'user_id' => $user->id,
            'layanan_id' => $request->layanan_id,
            'qty' => $request->qty,
            'deskripsi' => $request->deskripsi,
            'payment_method_id' => $request->pm_id,
            'payment_code' => strtoupper($request->payment_code),
            'cc_number' => $request->number,
            'cc_name' => $request->name,
            'cc_expiry' => $request->expiry,
            'cc_cvc' => $request->cvc,
            'total_payment' => $request->total_payment,
        ]);

        $this->paymentDetailsMail($order);

        return back()->withInput(Input::all())->with([
            'orderSubmit' => 'Kami telah mengirimkan rincian pembayaran Anda ke ' . $user->email . '. Permintaan Anda akan segera kami proses setelah pembayaran Anda selesai.',
            'order' => $order,
            'order_id' => $order->id
        ]);
    }

    private function paymentDetailsMail($order)
    {
        $pm = PaymentMethod::find($order->payment_method_id);
        $pc = PaymentCategory::find($pm->payment_category_id);
        $pl = layanan::find($order->layanan_id);

        $plan_price = $pl->harga - ($pl->harga * $pl->diskon / 100);

        $diffTotal = $order->qty - 1;
        $total = 1 . "(+" . $diffTotal . ")";
        $price_total = $diffTotal * $plan_price;

        $data = [
            'order' => $order,
            'payment_method' => $pm,
            'payment_category' => $pc,
            'layanan' => $pl,
            'plan_price' => $plan_price,
            'totalVacancy' => $total,
            'price_totalVacancy' => $price_total,
        ];

        event(new OrderPaymentDetails($data));
    }

    public function invoiceJobPosting($id)
    {
        $order = Pemesanan::find(decrypt($id));
        $user = $order->getUser;

        $pm = $order->getPayment;
        $pc = $pm->paymentCategories;
        $pl = $order->getLayanan;

        $plan_price = $pl->harga - ($pl->harga * $pl->diskon / 100);

        $diffTotal = $order->qty - 1;
        $total = 1 . "(+" . $diffTotal . ")";
        $price_total = $diffTotal * $plan_price;

        $date = Carbon::parse($order->created_at);
        $romanDate = RomanConverter::numberToRoman($date->format('y')) . '/' .
            RomanConverter::numberToRoman($date->format('m'));
        $invoice = 'INV/' . $date->format('Ymd') . '/' . $romanDate . '/' . $order->id;

        return view('pages.clients.orderInvoice', compact('order', 'user', 'pm', 'pc', 'pl',
            'plan_price', 'total', 'price_total', 'invoice'));
    }

    public function uploadPaymentProof(Request $request)
    {
        $order = Pemesanan::find($request->order_id);

        $payment_proof = $request->file('payment_proof');
        $name = $payment_proof->getClientOriginalName();

        if ($order->payment_proof != '') {
            Storage::delete('public/users/payment/' . $order->payment_proof);
        }

        $request->payment_proof->storeAs('public/users/payment', $name);

        $order->update([
            'payment_proof' => $name
        ]);

        return $name;
    }

    public function deleteJobPosting($id)
    {
        $order = Pemesanan::find(decrypt($id));
        $date = Carbon::parse($order->created_at);
        $romanDate = RomanConverter::numberToRoman($date->format('y')) . '/' . RomanConverter::numberToRoman($date->format('m'));
        $invoice = '#INV/' . $date->format('Ymd') . '/' . $romanDate . '/' . $order->id;
        $order->delete();

        return redirect()->route('client.dashboard')->with('delete', 'Invoice ' . $invoice . ' berhasil dihapus!');
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
