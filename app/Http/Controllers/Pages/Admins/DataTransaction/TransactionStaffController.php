<?php

namespace App\Http\Controllers\Pages\Admins\DataTransaction;

use App\Mail\Clients\OrderLogEmail;
use App\Models\JenisLayanan;
use App\Models\OrderLogs;
use App\Models\Outcomes;
use App\Models\Pemesanan;
use App\Support\RomanConverter;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class TransactionStaffController extends Controller
{
    public function getOrders($id)
    {
        $invoice = route('invoice.order', ['id' => encrypt($id)]);

        return $invoice;
    }

    public function showOrderLogsTable(Request $request)
    {
        $logs = OrderLogs::orderByDesc('pemesanan_id')->get();
        $orders = Pemesanan::where('status_payment', '>=', 1)->doesntHave('getOrderLog')->orderByDesc('id')->get();

        if ($request->has("id")) {
            $find = $request->id;
            $invoice = $request->q;
        } else {
            $find = null;
            $invoice = null;
        }

        if ($request->has('check')) {
            $check = $request->check;
        } else {
            $check = null;
        }

        return view('pages.admins.dataTransaction.staffs.orderLogs-table', compact('logs',
            'orders', 'find', 'check', 'invoice'));
    }

    public function createOrderLogs(Request $request)
    {
        $order = Pemesanan::find($request->pemesanan_id);
        $romanDate = RomanConverter::numberToRoman($order->created_at->format('y')) . '/' .
            RomanConverter::numberToRoman($order->created_at->format('m'));
        $invoice = 'INV/' . $order->created_at->format('Ymd') . '/' . $romanDate . '/' . $order->id;

        $files = [];
        if ($request->hasFile('files')) {
            $this->validate($request, [
                'files' => 'array',
                'files.*' => 'mimes:jpg,jpeg,gif,png|max:5120'
            ]);

            foreach ($request->file('files') as $i => $file) {
                $i = $i + 1;
                $name = 'attachment_' . $i . '.' . $file->getClientOriginalExtension();
                $file->storeAs('public/order-logs', $name);

                $files[$i] = $name;
            }

        } else {
            $files = null;
        }

        $log = OrderLogs::create([
            'pemesanan_id' => $order->id,
            'admin_id' => Auth::guard('admin')->id(),
            'deskripsi' => $request->deskripsi,
            'files' => $files,
            'link' => $request->link,
            'isReady' => $request->isReady,
        ]);

        Mail::to($order->getUser->email)->send(new OrderLogEmail($log, $invoice));

        return redirect()->route('table.order-logs')
            ->with('success', 'Order log for #' . $invoice . ' is successfully created!');
    }

    public function updateOrderLogs(Request $request)
    {
        $log = OrderLogs::find($request->id);

        $order = $log->getPemesanan;
        $romanDate = RomanConverter::numberToRoman($order->created_at->format('y')) . '/' .
            RomanConverter::numberToRoman($order->created_at->format('m'));
        $invoice = 'INV/' . $order->created_at->format('Ymd') . '/' . $romanDate . '/' . $order->id;

        $files = [];
        if ($request->hasFile('files')) {
            if ($log->files != "") {
                foreach ($log->files as $file) {
                    if ($file != 'nature_big_1.jpg' || $file != 'nature_big_2.jpg' || $file != 'nature_big_3.jpg' ||
                        $file != 'nature_big_4.jpg' || $file != 'nature_big_5.jpg') {

                        Storage::delete('public/order-logs/' . $file);
                    }
                }
            }

            $this->validate($request, [
                'files' => 'array',
                'files.*' => 'mimes:jpg,jpeg,gif,png|max:5120'
            ]);

            foreach ($request->file('files') as $i => $file) {
                $name = 'attachment_' . $i . '.' . $file->getClientOriginalExtension();
                $file->storeAs('public/order-logs', $name);

                $files[$i] = $name;
            }

        } else {
            $files = $log->files;
        }

        $log->update([
            'deskripsi' => $request->deskripsi,
            'files' => $files,
            'link' => $request->link,
            'isReady' => $request->isReady,
        ]);

        Mail::to($order->getUser->email)->send(new OrderLogEmail($log, $invoice));

        return redirect()->route('table.order-logs')
            ->with('success', 'Order log for #' . $invoice . ' is successfully updated!');
    }

    public function deleteOrderLogs($id)
    {
        $log = OrderLogs::find(decrypt($id));

        $order = $log->getPemesanan;
        $romanDate = RomanConverter::numberToRoman($order->created_at->format('y')) . '/' .
            RomanConverter::numberToRoman($order->created_at->format('m'));
        $invoice = 'INV/' . $order->created_at->format('Ymd') . '/' . $romanDate . '/' . $order->id;

        if ($log->files != "") {
            foreach ($log->files as $file) {
                if ($file != 'nature_big_1.jpg' || $file != 'nature_big_2.jpg' || $file != 'nature_big_3.jpg' ||
                    $file != 'nature_big_4.jpg' || $file != 'nature_big_5.jpg') {

                    Storage::delete('public/order-logs/' . $file);
                }
            }
        }

        $log->delete();

        return redirect()->route('table.order-logs')
            ->with('success', 'Order log for #' . $invoice . ' is successfully deleted!');
    }

    public function showOrderOutcomesTable(Request $request)
    {
        $orders = Pemesanan::where('status_payment', 2)->orderByDesc('id')->get();

        if ($request->has("id")) {
            $find = $request->id;
        } else {
            $find = null;
        }

        if ($request->has('service')) {
            $service = $request->service;
        } else {
            $service = null;
        }

        if ($request->has('period')) {
            $period = $request->period;
        } else {
            $period = null;
        }

        $outcomes = Outcomes::wherenotnull('pemesanan_id')->when($service, function ($query) use ($service) {
            $query->whereHas('getPemesanan', function ($query) use ($service) {
                $query->whereHas('getLayanan', function ($query) use ($service) {
                    if($service != 'any'){
                        $query->where('jenis_id', $service);
                    } else{
                        $query->whereIn('jenis_id', JenisLayanan::pluck('id')->toArray());
                    }
                });
            });
        })->when($period, function ($query) use ($period) {
            $query->whereYear('created_at', substr($period, -4))
                ->whereMonth('created_at', substr($period, 0, 2));
        })->orderByDesc('pemesanan_id')->get();

        return view('pages.admins.dataTransaction.staffs.orderOutcomes-table', compact('outcomes',
            'orders', 'find', 'service', 'period'));
    }

    public function createOrderOutcomes(Request $request)
    {
        $order = Pemesanan::find($request->pemesanan_id);
        $romanDate = RomanConverter::numberToRoman($order->created_at->format('y')) . '/' .
            RomanConverter::numberToRoman($order->created_at->format('m'));
        $invoice = 'INV/' . $order->created_at->format('Ymd') . '/' . $romanDate . '/' . $order->id;

        $it = new \MultipleIterator();
        $it->attachIterator(new \ArrayIterator($request->item));
        $it->attachIterator(new \ArrayIterator($request->qty));
        $it->attachIterator(new \ArrayIterator($request->price_per_qty));
        $it->attachIterator(new \ArrayIterator($request->price_total));
        foreach ($it as $value) {
            Outcomes::create([
                'pemesanan_id' => $order->id,
                'item' => $value[0],
                'qty' => str_replace('.', '', $value[1]),
                'price_per_qty' => str_replace('.', '', $value[2]),
                'price_total' => str_replace('.', '', $value[3])
            ]);
        }

        $message = count($request->item) > 1 ? count($request->item) . ' items are successfully added to order #'
            . $invoice . ' outcome!' : count($request->item) . ' item is successfully added to order #'
            . $invoice . ' outcome!';

        return redirect()->route('table.order-outcomes')->with('success', $message);
    }

    public function updateOrderOutcomes(Request $request)
    {
        $outcome = Outcomes::find($request->id);

        $order = $outcome->getPemesanan;
        $romanDate = RomanConverter::numberToRoman($order->created_at->format('y')) . '/' .
            RomanConverter::numberToRoman($order->created_at->format('m'));
        $invoice = 'INV/' . $order->created_at->format('Ymd') . '/' . $romanDate . '/' . $order->id;

        $outcome->update([
            'item' => $request->item,
            'qty' => str_replace('.', '', $request->qty),
            'price_per_qty' => str_replace('.', '', $request->price_per_qty),
            'price_total' => str_replace('.', '', $request->price_total)
        ]);

        return redirect()->route('table.order-outcomes')
            ->with('success', 'Order outcome (' . $outcome->item . ') for #' . $invoice . ' is successfully updated!');
    }

    public function deleteOrderOutcomes($id)
    {
        $outcome = Outcomes::find(decrypt($id));

        $order = $outcome->getPemesanan;
        $romanDate = RomanConverter::numberToRoman($order->created_at->format('y')) . '/' .
            RomanConverter::numberToRoman($order->created_at->format('m'));
        $invoice = 'INV/' . $order->created_at->format('Ymd') . '/' . $romanDate . '/' . $order->id;

        $outcome->delete();

        return redirect()->route('table.order-outcomes')
            ->with('success', 'Order outcome (' . $outcome->item . ') for #' . $invoice . ' is successfully deleted!');
    }

    public function massDeleteOrderOutcomes(Request $request)
    {
        $outcomes = Outcomes::whereIn('id', explode(",", $request->outcome_ids))->get();

        foreach ($outcomes as $outcome) {
            $outcome->delete();
        }
        $message = count($outcomes) > 1 ? count($outcomes) . ' order outcomes are ' :
            count($outcomes) . ' order outcome is ';

        return redirect()->route('table.order-outcomes')->with('success', $message . 'successfully deleted!');
    }

    public function showNonOrderOutcomesTable(Request $request)
    {
        if ($request->has('period')) {
            $period = $request->period;
        } else {
            $period = null;
        }

        $outcomes = Outcomes::wherenull('pemesanan_id')->when($period, function ($query) use ($period) {
            $query->whereYear('created_at', substr($period, -4))
                ->whereMonth('created_at', substr($period, 0, 2));
        })->orderByDesc('pemesanan_id')->get();

        return view('pages.admins.dataTransaction.staffs.nonOrderOutcomes-table', compact('outcomes', 'period'));
    }

    public function createNonOrderOutcomes(Request $request)
    {
        $it = new \MultipleIterator();
        $it->attachIterator(new \ArrayIterator($request->item));
        $it->attachIterator(new \ArrayIterator($request->qty));
        $it->attachIterator(new \ArrayIterator($request->price_per_qty));
        $it->attachIterator(new \ArrayIterator($request->price_total));
        foreach ($it as $value) {
            Outcomes::create([
                'description' => $request->description,
                'item' => $value[0],
                'qty' => str_replace('.', '', $value[1]),
                'price_per_qty' => str_replace('.', '', $value[2]),
                'price_total' => str_replace('.', '', $value[3])
            ]);
        }

        $message = count($request->item) > 1 ? count($request->item) . ' items are successfully added to ' .
            $request->description . ' outcome!' : count($request->item) . ' item is successfully added to ' .
            $request->description . ' outcome!';

        return redirect()->route('table.nonOrder-outcomes')->with('success', $message);
    }

    public function updateNonOrderOutcomes(Request $request)
    {
        $outcome = Outcomes::find($request->id);
        $outcome->update([
            'description' => $request->description,
            'item' => $request->item,
            'qty' => str_replace('.', '', $request->qty),
            'price_per_qty' => str_replace('.', '', $request->price_per_qty),
            'price_total' => str_replace('.', '', $request->price_total)
        ]);

        return redirect()->route('table.nonOrder-outcomes')->with('success', 'Non-order outcome (' .
            $outcome->item . ') for ' . $outcome->description . ' is successfully updated!');
    }

    public function deleteNonOrderOutcomes($id)
    {
        $outcome = Outcomes::find(decrypt($id));
        $outcome->delete();

        return redirect()->route('table.nonOrder-outcomes')->with('success', 'Non-order outcome (' .
            $outcome->item . ') for ' . $outcome->description . ' is successfully deleted!');
    }

    public function massDeleteNonOrderOutcomes(Request $request)
    {
        $outcomes = Outcomes::whereIn('id', explode(",", $request->outcome_ids))->get();

        foreach ($outcomes as $outcome) {
            $outcome->delete();
        }

        $message = count($outcomes) > 1 ? count($outcomes) . ' non-order outcomes are ' :
            count($outcomes) . ' non-order outcome is ';

        return redirect()->route('table.nonOrder-outcomes')->with('success', $message . 'successfully deleted!');
    }
}
