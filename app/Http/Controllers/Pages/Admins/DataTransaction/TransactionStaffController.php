<?php

namespace App\Http\Controllers\Pages\Admins\DataTransaction;

use App\Models\Outcomes;
use App\Models\Pemesanan;
use App\Support\RomanConverter;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TransactionStaffController extends Controller
{
    public function showOutcomesTable(Request $request)
    {
        $outcomes = Outcomes::orderByDesc('id')->get();

        if ($request->has("q")) {
            $find = $request->q;
        } else {
            $find = null;
        }

        return view('pages.admins.dataTransaction.staffs.orderOutcomes-table', compact('outcomes', 'find'));
    }

    public function createOutcomesTable(Request $request)
    {
        $order = Pemesanan::find($request->pemesanan_id);
        $romanDate = RomanConverter::numberToRoman($order->created_at->format('y')) . '/' .
            RomanConverter::numberToRoman($order->created_at->format('m'));
        $invoice = 'INV/' . $order->created_at->format('Ymd') . '/' . $romanDate . '/' . $order->id;

        $outcome = Outcomes::create([
            'item' => $request->item,
            'qty' => $request->qty,
            'price_per_qty' => $request->price_per_qty,
            'price_total' => $request->price_total
        ]);

        return back()->with('success', 'Order outcome (' . $outcome->item . ') for #' . $invoice . ' is successfully created!');
    }

    public function updateOutcomesTable(Request $request)
    {
        $outcome = Outcomes::find($request->id);

        $order = $outcome->getPemesanan;
        $romanDate = RomanConverter::numberToRoman($order->created_at->format('y')) . '/' .
            RomanConverter::numberToRoman($order->created_at->format('m'));
        $invoice = 'INV/' . $order->created_at->format('Ymd') . '/' . $romanDate . '/' . $order->id;

        $outcome->update([
            'item' => $request->item,
            'qty' => $request->qty,
            'price_per_qty' => $request->price_per_qty,
            'price_total' => $request->price_total
        ]);

        return back()->with('success', 'Order outcome (' . $outcome->item . ') for #' . $invoice . ' is successfully updated!');
    }

    public function deleteOutcomesTable($id)
    {
        $outcome = Outcomes::find(decrypt($id));

        $order = $outcome->getPemesanan;
        $romanDate = RomanConverter::numberToRoman($order->created_at->format('y')) . '/' .
            RomanConverter::numberToRoman($order->created_at->format('m'));
        $invoice = 'INV/' . $order->created_at->format('Ymd') . '/' . $romanDate . '/' . $order->id;

        $outcome->delete();

        return back()->with('success', 'Order outcome (' . $outcome->item . ') for #' . $invoice . ' is successfully deleted!');
    }

    public function massDeleteOutcomesTable(Request $request)
    {
        $outcomes = Outcomes::whereIn('id', explode(",", $request->outcome_ids))->get();

        foreach ($outcomes as $outcome) {
            $outcome->delete();
        }
        $message = count($outcomes) > 1 ? count($outcomes) . ' order outcomes are ' :
            count($outcomes) . ' order outcome is ';

        return back()->with('success', $message . 'successfully deleted!');
    }
}
