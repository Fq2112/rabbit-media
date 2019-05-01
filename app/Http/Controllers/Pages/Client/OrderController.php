<?php

namespace App\Http\Controllers\Pages\Client;

use App\Events\Clients\PaymentDetails;
use App\Mail\Clients\OrderDetailsEmail;
use App\Models\Feedback;
use App\Models\JenisStudio;
use App\Models\layanan;
use App\Models\OrderLogs;
use App\Models\OrderRevision;
use App\Models\PaymentMethod;
use App\Models\Pemesanan;
use App\Models\Schedule;
use App\Models\Studio;
use App\Support\RomanConverter;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
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
        $types = JenisStudio::orderBy('nama')->get();

        $layanan = layanan::find(decrypt($id));
        $price = $layanan->harga - ($layanan->harga * $layanan->diskon / 100);

        $booked = Schedule::has('getPemesanan')->where('isDayOff', false)->get();
        $holidays = Schedule::doesntHave('getPemesanan')->where('isDayOff', true)->get();

        return view('pages.clients.orderForm', compact('user', 'types', 'layanan', 'price',
            'booked', 'holidays'));
    }

    public function getDetailStudio($id)
    {
        $studio = Studio::find($id);

        return array_replace($studio->toArray(), array('jenis_id' => $studio->getJenisStudio->nama));
    }

    public function submitOrder(Request $request)
    {
        $order = Pemesanan::create([
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

        $data = $this->paymentDetailsMail($order->id);
        Mail::to('rm.rabbitmedia@gmail.com')->send(new OrderDetailsEmail($data));

        return redirect()->route('client.dashboard')->with('update', 'Pesanan Anda berhasil diproses! ' .
            'Mohon untuk menunggu informasi lebih lanjut dari kami dan status pesanan Anda dapat dilihat ' .
            'pada halaman ini, terimakasih.');
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
            ->whereBetween('created_at', [$request->start_date, $request->end_date])
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
            $status = array('expired' => now() >= Carbon::parse($row['start'])->subDays(2) ? true : false);
            $deadline = array('deadline' => Carbon::parse($row['start'])->subDays(2)
                ->isoFormat('dddd, DD MMMM YYYY [pukul] HH:mm'));

            $bookDate = array('date_booking' => Carbon::parse($row['end'])->diffInDays(Carbon::parse($row['start'])) > 0 ?
                '<span style="font-weight: 600">' . Carbon::parse($row['start'])->format('j F Y') . '</span> &mdash; ' .
                '<span style="font-weight: 600">' . Carbon::parse($row['end'])->format('j F Y') . '</span>' :
                '<span style="font-weight: 600">' . Carbon::parse($row['start'])->format('j F Y') . '</span>');
            $orderDate = array('date_order' => Carbon::parse($row['created_at'])->format('l, j F Y'));
            $paidDate = array('date_payment' => Carbon::parse($row['date_payment'])->format('l j F Y'));

            $studio = array('nama_studio' => $findStudio != "" ? $findStudio->nama : null,
                'harga_studio' => $findStudio != "" ? $findStudio->harga : null);
            $jenis = array('jenis_studio' => $findStudio != "" ? $findStudio->getJenisStudio->nama : null);
            $meeting = array('meeting_location' => $row['meeting_location'] != "" ? $row['meeting_location'] : '(Kosong)',
                'deskripsi' => $row['deskripsi'] != "" ? $row['deskripsi'] : '(Kosong)');

            $orderLog = array(
                'log_id' => $log != "" ? $log->id : null,
                'log_desc' => $log != "" ? $log->deskripsi : null,
                'log_files' => $log != "" ? $log->files : null,
                'log_link' => $log != "" ? $log->link : null,
                'log_isReady' => $log != "" ? $log->isReady : false,
                'log_isComplete' => $log != "" ? $log->isComplete : false,
                'admin_name' => $log != "" ? $log->getAdmin->name : null,
                'total_rev' => $log != "" ? $log->getOrderRevision->count() : 0,
                'check_feedback' => Feedback::where('user_id', Auth::id())->count()
            );

            if ($log != "") {
                $ava = array('admin_ava' => $log->getAdmin->ava != "" ?
                    asset('storage/users/ava/' . $log->getAdmin->ava) : asset('images/avatar.png'));
            } else {
                $ava = array('admin_ava' => null);
            }

            $result['data'][$i] = array_replace($paid, $id, $invoice, $result['data'][$i], $pl, $price, $pm, $pc,
                $created_at, $bookDate, $orderDate, $paidDate, $deadline, $status, $studio, $jenis, $meeting,
                $orderLog, $ava);
            $i = $i + 1;
        }

        return $result;
    }

    public function getPaymentMethod($id)
    {
        return PaymentMethod::find($id);
    }

    public function payOrder(Request $request)
    {
        $order = Pemesanan::find($request->order_id);
        $order->update([
            'payment_id' => $request->pm_id,
            'payment_type' => $request->payment_type,
        ]);

        $data = $this->paymentDetailsMail($request->order_id);
        event(new PaymentDetails($data));

        $date = Carbon::parse($order->created_at);
        $romanDate = RomanConverter::numberToRoman($date->format('y')) . '/' .
            RomanConverter::numberToRoman($date->format('m'));

        return array_replace($order->toArray(), array('encryptID' => encrypt($order->id),
            'invoice' => '#INV/' . $date->format('Ymd') . '/' . $romanDate . '/' . $order->id));
    }

    private function paymentDetailsMail($id)
    {
        $order = Pemesanan::find($id);
        $pm = $order->payment_id != null ? $order->getPayment : null;
        $pc = $order->payment_id != null ? $pm->paymentCategories : null;
        $pl = $order->getLayanan;

        $date = Carbon::parse($order->created_at);
        $romanDate = RomanConverter::numberToRoman($date->format('y')) . '/' .
            RomanConverter::numberToRoman($date->format('m'));

        $plan_price = $pl->harga - ($pl->harga * $pl->diskon / 100);

        $diffTotalPlan = Carbon::parse($order->end)->diffInDays(Carbon::parse($order->start)) - 1;
        $totalPlan = $diffTotalPlan > 0 ? 1 . "(+" . $diffTotalPlan . ")" : 1;
        $price_totalPlan = $diffTotalPlan > 0 ? $diffTotalPlan * $plan_price : $plan_price;

        if ($pl->isHours == true) {
            $diffTotalHours = $order->hours - $pl->hours;
            $totalHours = $diffTotalHours >= 0 ? $pl->hours . "(+" . $diffTotalHours . ")" : $pl->hours;
            $price_totalHours = $diffTotalHours * $pl->price_per_hours;
        } else {
            $totalHours = null;
            $price_totalHours = null;
        }

        if ($pl->isQty == true) {
            $diffTotalQty = $order->qty - $pl->qty;
            $totalQty = $diffTotalQty >= 0 ? $pl->qty . "(+" . $diffTotalQty . ")" : $pl->qty;
            $price_totalQty = $diffTotalQty * $pl->price_per_qty;
        } else {
            $totalQty = null;
            $price_totalQty = null;
        }

        if ($pl->isStudio == true) {
            $studio = $order->getStudio->nama;
            $totalStudio = $diffTotalPlan > 0 ? 1 . "(+" . $diffTotalPlan . ")" : 1;
            $price_totalStudio = $diffTotalPlan > 0 ? $diffTotalPlan * $order->getStudio->harga : $order->getStudio->harga;
        } else {
            $studio = null;
            $totalStudio = null;
            $price_totalStudio = null;
        }

        $amountToPay = number_format($order->payment_type == 'DP' ?
            ceil($order->total_payment * .3) : $order->total_payment, 2, ',', '.');

        $data = [
            'order' => $order,
            'invoice' => '#INV/' . $date->format('Ymd') . '/' . $romanDate . '/' . $order->id,
            'payment_method' => $pm,
            'payment_category' => $pc,
            'plans' => $pl,
            'plan_price' => $plan_price,
            'totalPlan' => $totalPlan,
            'price_totalPlan' => $price_totalPlan,
            'totalHours' => $totalHours,
            'price_totalHours' => $price_totalHours,
            'totalQty' => $totalQty,
            'price_totalQty' => $price_totalQty,
            'studio' => $studio,
            'totalStudio' => $totalStudio,
            'price_totalStudio' => $price_totalStudio,
            'amountToPay' => $amountToPay
        ];

        return $data;
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

    public function deleteOrder($id)
    {
        $order = Pemesanan::find(decrypt($id));
        $date = Carbon::parse($order->created_at);
        $romanDate = RomanConverter::numberToRoman($date->format('y')) . '/' .
            RomanConverter::numberToRoman($date->format('m'));
        $invoice = '#INV/' . $date->format('Ymd') . '/' . $romanDate . '/' . $order->id;
        $order->delete();

        return redirect()->route('client.dashboard')->with('delete', 'Pesanan: ' . $invoice . ' berhasil dibatalkan!');
    }

    public function invoiceOrder($id)
    {
        $order = Pemesanan::find(decrypt($id));
        $user = $order->getUser;
        $pm = $order->getPayment;
        $pc = $pm->paymentCategories;
        $pl = $order->getLayanan;

        $date = Carbon::parse($order->created_at);
        $romanDate = RomanConverter::numberToRoman($date->format('y')) . '/' .
            RomanConverter::numberToRoman($date->format('m'));
        $invoice = '#INV/' . $date->format('Ymd') . '/' . $romanDate . '/' . $order->id;

        $plan_price = $pl->harga - ($pl->harga * $pl->diskon / 100);

        $diffTotalPlan = Carbon::parse($order->end)->diffInDays(Carbon::parse($order->start)) - 1;
        $totalPlan = $diffTotalPlan > 0 ? 1 . "(+" . $diffTotalPlan . ")" : 1;
        $price_totalPlan = $diffTotalPlan > 0 ? $diffTotalPlan * $plan_price : $plan_price;

        if ($pl->isHours == true) {
            $diffTotalHours = $order->hours - $pl->hours;
            $totalHours = $diffTotalHours >= 0 ? $pl->hours . "(+" . $diffTotalHours . ")" : $pl->hours;
            $price_totalHours = $diffTotalHours * $pl->price_per_hours;
        } else {
            $totalHours = null;
            $price_totalHours = null;
        }

        if ($pl->isQty == true) {
            $diffTotalQty = $order->qty - $pl->qty;
            $totalQty = $diffTotalQty >= 0 ? $pl->qty . "(+" . $diffTotalQty . ")" : $pl->qty;
            $price_totalQty = $diffTotalQty * $pl->price_per_qty;
        } else {
            $totalQty = null;
            $price_totalQty = null;
        }

        if ($pl->isStudio == true) {
            $totalStudio = $diffTotalPlan > 0 ? 1 . "(+" . $diffTotalPlan . ")" : 1;
            $price_totalStudio = $diffTotalPlan > 0 ? $diffTotalPlan * $order->getStudio->harga : $order->getStudio->harga;
        } else {
            $studio = null;
            $totalStudio = null;
            $price_totalStudio = null;
        }

        if ($order->payment_type == 'DP') {
            $amountToPay = number_format(ceil($order->total_payment * .3), 2, ',', '.');
        } else {
            $amountToPay = number_format($order->total_payment, 2, ',', '.');
        }

        return view('pages.clients.invoice', compact('order', 'user', 'pm', 'pc', 'pl',
            'plan_price', 'invoice', 'totalPlan', 'price_totalPlan', 'totalHours', 'price_totalHours',
            'totalQty', 'price_totalQty', 'totalStudio', 'price_totalStudio', 'amountToPay'));
    }

    public function orderLogReview(Request $request)
    {
        $log = OrderLogs::find($request->id);
        if ($request->check_form == 'revisi') {
            OrderRevision::create([
                'log_id' => $log->id,
                'judul' => $request->judul,
                'deskripsi' => $request->deskripsi
            ]);
        }
        $log->update(['isComplete' => true]);
    }
}
