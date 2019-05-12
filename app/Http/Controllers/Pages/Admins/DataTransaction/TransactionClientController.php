<?php

namespace App\Http\Controllers\Pages\Admins\DataTransaction;

use App\Models\Feedback;
use App\Models\Pemesanan;
use App\Support\RomanConverter;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TransactionClientController extends Controller
{
    public function showFeedbackTable()
    {
        $feedback = Feedback::orderByDesc('id')->get();

        return view('pages.admins.dataTransaction.feedback-table', compact('feedback'));
    }

    public function deleteFeedback($id)
    {
        $feedback = Feedback::find(decrypt($id));
        $feedback->delete();

        return back()->with('success', 'Feedback from ' . $feedback->getUser->name . ' is successfully deleted!');
    }

    public function massDeleteFeedback(Request $request)
    {
        $feedback = Feedback::whereIn('id', explode(",", $request->feedback_ids))->get();
        foreach ($feedback as $row) {
            $row->delete();
        }
        $message = count($feedback) > 1 ? count($feedback) . ' feedback are ' : count($feedback) . ' feedback is ';

        return back()->with('success', $message . 'successfully deleted!');
    }

    public function showOrdersTable(Request $request)
    {
        $orders = Pemesanan::orderByDesc('id')->get();

        if ($request->has("q")) {
            $find = $request->q;
        } else {
            $find = null;
        }

        return view('pages.admins.dataTransaction.orders-table', compact('orders', 'find'));
    }

    public function updateOrders(Request $request)
    {
        $order = Pemesanan::find($request->id);
        if ($request->isPaid == 1) {
            $order->update([
                'isPaid' => true,
                'date_payment' => now(),
                'admin_id' => Auth::guard('admin')->id()
            ]);

        } elseif ($request->isPaid == 0) {
            $order->update([
                'isPaid' => false,
                'date_payment' => null,
                'admin_id' => Auth::guard('admin')->id()
            ]);

            if ($request->isAbort == 1) {
                $order->update(['isAbort' => true]);
            }
        }

        if ($request->isPaid == 1 || $request->isAbort == 1) {
            $this->orderMail($order);
        }

        return back()->with('success', '' . $request->invoice . ' is successfully updated!');
    }

    public function deleteOrders($id)
    {
        $order = Pemesanan::find(decrypt($id));
        $order->delete();
        $romanDate = RomanConverter::numberToRoman($order->created_at->format('y')) . '/' .
            RomanConverter::numberToRoman($order->created_at->format('m'));
        $invoice = 'INV/' . $order->created_at->format('Ymd') . '/' . $romanDate . '/' . $order->id;

        return back()->with('success', $invoice . ' is successfully deleted!');
    }

    public function massDeleteOrders(Request $request)
    {
        $orders = Pemesanan::whereIn('id', explode(",", $request->order_ids))->get();

        foreach ($orders as $order) {
            $order->delete();
        }
        $message = count($orders) > 1 ? count($orders) . ' orders are ' : count($orders) . ' order is ';

        return back()->with('success', $message . 'successfully deleted!');
    }
}
