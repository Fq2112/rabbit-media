<?php

namespace App\Http\Controllers\Pages\Client;

use App\Models\JenisStudio;
use App\Models\layanan;
use App\Models\OrderLogs;
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

    public function submitOrder(Request $request)
    {
        Pemesanan::create([
            'user_id' => Auth::id(),
            'layanan_id' => $request->layanan_id,
            'studio_id' => $request->studio,
            'start' => $request->start,
            'end' => $request->end,
            'judul' => $request->judul,
            'hours' => $request->hours,
            'qty' => $request->qty,
            'meeting_location' => $request->meeting_location,
            'deskripsi' => $request->deskripsi,
            'total_payment' => $request->total_payment,
            'status_payment' => 0
        ]);

        return redirect()->route('client.dashboard')->with('update', 'Pesanan Anda berhasil diproses! Mohon untuk menunggu informasi lebih lanjut dari kami dan status pesanan Anda dapat dilihat pada halaman ini, terimakasih.');
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
        $result = Pemesanan::where('user_id', Auth::id())
            ->whereBetween('start', [$request->start_date, $request->end_date])
            ->orderByDesc('id')->paginate(6)->toArray();

        $i = 0;
        foreach ($result['data'] as $row) {
            $id['encryptID'] = encrypt($row['id']);
            $date = Carbon::parse($row['created_at']);
            $romanDate = RomanConverter::numberToRoman($date->format('y')) . '/' .
                RomanConverter::numberToRoman($date->format('m'));
            $findStudio = Studio::find($row['studio_id']);
            $plan = layanan::find($row['layanan_id']);
            $payment_method = PaymentMethod::find($row['payment_id']);
            $log = OrderLogs::where('pemesanan_id', $row['id'])->first();

            $paid = array('ava' => asset('images/services/' . $plan->getJenisLayanan->icon));
            $invoice = array('invoice' => '#INV/' . $date->format('Ymd') . '/' . $romanDate . '/' . $row['id']);
            $pl = array('plan' => $plan);
            $price = array('harga' => number_format($plan->harga - ($plan->harga * $plan->diskon / 100),
                2, ',', '.'));
            $pm = array('pm' => $payment_method != "" ? $payment_method->name : null);
            $pc = array('pc' => $payment_method != "" ? $payment_method->paymentCategories->name : null);
            $created_at = array('created_at' => Carbon::parse($row['created_at'])->diffForHumans());
            $created_at3DayAdd = array('add_day' => Carbon::parse($row['created_at'])->addDays(3));
            $status = array('expired' => now() >= Carbon::parse($row['created_at'])->addDays(3) ? true : false);
            $deadline = array('deadline' => Carbon::parse($row['created_at'])->addDays(3)->format('l, j F Y') .
                ' pukul ' . Carbon::parse($row['created_at'])->addDays(3)->format('H:i'));

            $tagihan = array('total_payment' => number_format($row['total_payment'],
                2, ',', '.'));
            $start = array('start' => Carbon::parse($row['start'])->format('j F Y'));
            $end = array('end' => Carbon::parse($row['end'])->format('j F Y'));
            $orderDate = array('date_order' => Carbon::parse($row['created_at'])->format('l, j F Y'));
            $paidDate = array('date_payment' => Carbon::parse($row['date_payment'])->format('l j F Y'));

            $studio = array('nama_studio' => $findStudio != "" ? $findStudio->nama : null,
                'harga_studio' => $findStudio != "" ? $findStudio->harga : null);
            $jenis = array('jenis_studio' => $findStudio != "" ? $findStudio->getJenisStudio->nama : null);
            $meeting = array('meeting_location' => $row['meeting_location'] != "" ? $row['meeting_location'] : '(Kosong)',
                'deskripsi' => $row['deskripsi'] != "" ? $row['deskripsi'] : '(Kosong)');

            $orderlog = array(
                'log_id' => $log != "" ? $log->id : null,
                'log_desc' => $log != "" ? $log->deskripsi : null,
                'log_files' => $log != "" ? $log->files : null,
                'admin_name' => $log != "" ? $log->getAdmin->name : null,
            );
            if ($log != "") {
                $ava = array('admin_ava' => $log->getAdmin->ava != "" ?
                    asset('storage/users/ava/' . $log->getAdmin->ava) : asset('images/avatar.png'));
            } else {
                $ava = array('admin_ava' => null);
            }

            $result['data'][$i] = array_replace($paid, $id, $invoice, $result['data'][$i], $pl, $price, $pm, $pc,
                $created_at, $created_at3DayAdd, $start, $end, $orderDate, $paidDate, $deadline, $status, $studio,
                $jenis, $tagihan, $meeting, $orderlog, $ava);
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

    public function getPaymentMethod($id)
    {
        return PaymentMethod::find($id);
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
}
