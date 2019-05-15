<?php

namespace App\Http\Controllers\Pages\Admins\DataTransaction;

use App\Models\Outcomes;
use App\Models\Pemesanan;
use App\Support\RomanConverter;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TransactionStaffController extends Controller
{
    public function showOrderOutcomesTable(Request $request)
    {
        $outcomes = Outcomes::orderByDesc('pemesanan_id')->get();
        $orders = Pemesanan::where('status_payment', 2)->orderByDesc('id')->get();

        if ($request->has("id")) {
            $find = $request->id;
        } else {
            $find = null;
        }

        return view('pages.admins.dataTransaction.staffs.orderOutcomes-table', compact('outcomes',
            'orders', 'find'));
    }

    public function getOrders($id)
    {
        $invoice = route('invoice.order', ['id' => encrypt($id)]);

        return $invoice;
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

        return redirect()->route('table.order-outcomes')
            ->with('success', $message . 'successfully deleted!');
    }
}
