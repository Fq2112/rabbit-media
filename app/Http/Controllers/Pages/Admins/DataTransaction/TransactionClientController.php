<?php

namespace App\Http\Controllers\Pages\Admins\DataTransaction;

use App\Models\Feedback;
use App\Models\Pemesanan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TransactionClientController extends Controller
{
    public function showFeedbackTable()
    {
        $feedback = Feedback::all();

        return view('pages.admins.dataTransaction.feedback-table', compact('feedback'));
    }

    public function deleteFeedback($id)
    {
        $feedback = Feedback::find(decrypt($id));
        $feedback->delete();

        return back()->with('success', 'Feedback from ' . $feedback->getUser->name . ' is successfully deleted!');
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
}
