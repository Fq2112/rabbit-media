<?php

namespace App\Http\Controllers\Pages\Admins\DataTransaction;

use App\Events\Clients\PaymentDetails;
use App\Http\Controllers\Pages\Client\OrderController as OrderMail;
use App\Mail\Clients\ConfirmOrderEmail;
use App\Models\Feedback;
use App\Models\OrderRevision;
use App\Models\Pemesanan;
use App\Models\Schedule;
use App\Support\RomanConverter;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;

class TransactionClientController extends Controller
{
    public function showFeedbackTable()
    {
        $feedback = Feedback::orderByDesc('id')->get();

        return view('pages.admins.dataTransaction.clients.feedback-table', compact('feedback'));
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

        return view('pages.admins.dataTransaction.clients.orders-table', compact('orders', 'find'));
    }

    public function getOrderOutcomes($id)
    {
        $order = Pemesanan::find($id);
        return $order->getOutcome;
    }

    public function updateOrders(Request $request)
    {
        $order = Pemesanan::find($request->order_ids);
        if ($request->check_form == 'confirm_order') {
            $order->update([
                'isAccept' => $request->isAccept,
                'isReject' => $request->isReject,
            ]);

            $data = app(OrderMail::class)->paymentDetailsMail($order->id);
            if ($order->isAccept == false && $order->isReject == false) {
                Mail::to($order->getUser->email)->send(new ConfirmOrderEmail($data, 'revert_order'));

                if ($order->getSchedule != null) {
                    $order->getSchedule->delete();
                }

                return back()->with('success', 'Order confirmation #' . $request->invoice . ' is successfully reverted!');

            } else {
                Mail::to($order->getUser->email)->send(new ConfirmOrderEmail($data, 'confirm_order'));

                if ($order->isAccept == true) {
                    Schedule::create(['pemesanan_id' => $order->id]);
                }

                $message = $order->isAccept == true ? 'accepted!' : 'rejected!';
                return back()->with('success', 'Order #' . $request->invoice . ' is successfully ' . $message);
            }

        } else {
            $order->update([
                'isAbort' => $request->isAbort,
                'status_payment' => $request->status_payment
            ]);

            $data = app(OrderMail::class)->paymentDetailsMail($order->id);
            if ($order->isAbort == false && $order->status_payment == 0) {
                Mail::to($order->getUser->email)->send(new ConfirmOrderEmail($data, 'revert_pay'));

                return back()->with('success', 'Order payment #' . $request->invoice . ' is successfully reverted!');

            } else {
                event(new PaymentDetails($data));

                if ($order->isAbort == true) {
                    $order->getSchedule->delete();
                }

                $message = $order->isAbort == true ? 'aborted!' : 'verified!';
                return back()->with('success', 'Order Payment #' . $request->invoice . ' is successfully ' . $message);
            }
        }
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

    public function showOrderRevisionsTable()
    {
        $revisions = OrderRevision::orderByDesc('id')->get();

        return view('pages.admins.dataTransaction.clients.orderRevisions-table', compact('revisions'));
    }

    public function deleteOrderRevisions($id)
    {
        $revision = OrderRevision::find(decrypt($id));
        $romanDate = RomanConverter::numberToRoman($revision->getOrderLog->getPemesanan->created_at->format('y')) .
            '/' . RomanConverter::numberToRoman($revision->getOrderLog->getPemesanan->created_at->format('m'));
        $invoice = 'INV/' . $revision->getOrderLog->getPemesanan->created_at->format('Ymd') . '/' . $romanDate . '/' .
            $revision->getOrderLog->getPemesanan->id;

        $revision->delete();

        return back()->with('success', 'Order revision ' . $invoice . ' is successfully deleted!');
    }

    public function massDeleteOrderRevisions(Request $request)
    {
        $revisions = OrderRevision::whereIn('id', explode(",", $request->revision_ids))->get();
        foreach ($revisions as $row) {
            $row->delete();
        }
        $message = count($revisions) > 1 ? count($revisions) . ' order revisions are ' :
            count($revisions) . ' order revision is ';

        return back()->with('success', $message . 'successfully deleted!');
    }
}
