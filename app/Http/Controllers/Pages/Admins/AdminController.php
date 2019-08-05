<?php

namespace App\Http\Controllers\Pages\Admins;

use App\Admin;
use App\Models\Contact;
use App\Models\Feedback;
use App\Http\Controllers\Controller;
use App\Models\Pemesanan;
use App\Models\Schedule;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    public function index(Request $request)
    {
        $admins = Admin::all();
        $users = User::all();
        $orders = Pemesanan::all();
        $feedback = Feedback::all();

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

        return view('pages.admins.dashboard', compact('admins', 'users', 'orders', 'feedback',
            'service', 'period'));
    }

    public function showSchedules()
    {
        $schedules = Schedule::all();

        return view('pages.admins.schedules', compact('schedules'));
    }

    public function createSchedules(Request $request)
    {
        $schedule = Schedule::create([
            'start' => $request->start,
            'end' => $request->end,
            'judul' => $request->judul,
            'deskripsi' => $request->description,
        ]);

        $date = Carbon::parse($schedule->start)->format('j F Y') . ' - ' . Carbon::parse($schedule->end)->format('j F Y');

        return back()->with('success', 'Schedule (' . $schedule->judul . ') for ' . $date . ' is successfully created!');
    }

    public function updateSchedules(Request $request)
    {
        $schedule = Schedule::find($request->id);

        if ($schedule->pemesanan_id != null) {
            $schedule->getPemesanan->update([
                'start' => $request->start,
                'end' => $request->end,
            ]);

            $message = 'Order booking (' . $schedule->getPemesanan->judul . ') for ' .
                Carbon::parse($schedule->getPemesanan->start)->format('j F Y') . ' - ' .
                Carbon::parse($schedule->getPemesanan->end)->format('j F Y') . ' is successfully updated!';

        } else {
            $schedule->update([
                'start' => $request->start,
                'end' => $request->end,
                'judul' => $request->judul,
                'deskripsi' => $request->description,
            ]);

            $message = 'Schedule (' . $schedule->judul . ') for ' . Carbon::parse($schedule->start)->format('j F Y') .
                ' - ' . Carbon::parse($schedule->end)->format('j F Y') . ' is successfully updated!';
        }

        return back()->with('success', $message);
    }

    public function deleteSchedules(Request $request)
    {
        $schedule = Schedule::find($request->id);
        $schedule->delete();

        $date = Carbon::parse($schedule->start)->format('j F Y') . ' - ' . Carbon::parse($schedule->end)->format('j F Y');

        return back()->with('success', 'Schedule (' . $schedule->judul . ') for ' . $date . ' is successfully deleted!');
    }

    public function showInbox(Request $request)
    {
        $contacts = Contact::orderByDesc('id')->get();

        if ($request->has("id")) {
            $findMessage = $request->id;
        } else {
            $findMessage = null;
        }

        return view('pages.admins.inbox', compact('contacts', 'findMessage'));
    }

    public function composeInbox(Request $request)
    {
        $this->validate($request, [
            'inbox_to' => 'required|string|email|max:255',
            'inbox_subject' => 'string|min:3',
            'inbox_message' => 'required'
        ]);
        $data = array(
            'email' => $request->inbox_to,
            'subject' => $request->inbox_subject,
            'bodymessage' => $request->inbox_message
        );
        Mail::send('emails.admins.admin-mail', $data, function ($message) use ($data) {
            $message->from(env('MAIL_USERNAME'), 'Rabbit Media – Digital Creative Service');
            $message->to($data['email']);
            $message->subject($data['subject']);
        });

        return back()->with('success', 'Berhasil mengirimkan pesan ke ' . $data['email'] . '!');
    }

    public function deleteInbox(Request $request)
    {
        $contact = Contact::find(decrypt($request->id));
        $contact->delete();

        return back()->with('success', 'Pesan dari ' . $contact->name . ' (' . $contact->email . ') berhasil dihapus!');
    }

    public function editProfile()
    {
        $admin = Auth::guard('admin')->user();

        return view('pages.admins.editProfile', compact('admin'));
    }

    public function updateProfile(Request $request)
    {
        $admin = Admin::find(Auth::guard('admin')->id());
        if ($request->check_form == 'personal_data') {
            if ($request->hasfile('ava')) {
                $this->validate($request, [
                    'ava' => 'image|mimes:jpg,jpeg,gif,png|max:2048',
                ]);

                $name = $request->file('ava')->getClientOriginalName();
                if ($admin->ava != '') {
                    Storage::delete('public/admins/ava/' . $admin->ava);
                }
                $request->file('ava')->storeAs('public/admins/ava', $name);

            } else {
                $name = $admin->ava;
            }

            $admin->update([
                'ava' => $name,
                'name' => $request->name,
                'deskripsi' => $request->deskripsi,
            ]);

        } else {
            $admin->update([
                'facebook' => $request->facebook,
                'twitter' => $request->twitter,
                'instagram' => $request->instagram,
                'whatsapp' => $request->whatsapp,
            ]);
        }

        return back()->with('success', 'Successfully update your profile!');
    }

    public function accountSettings()
    {
        $admin = Auth::guard('admin')->user();

        return view('pages.admins.accountSettings', compact('admin'));
    }

    public function updateAccount(Request $request)
    {
        $admin = Admin::find(Auth::guard('admin')->id());

        if (!Hash::check($request->password, $admin->password)) {
            return back()->with('error', 'Your current password is incorrect!');

        } else {
            if ($request->new_password != $request->password_confirmation) {
                return back()->with('error', 'Your password confirmation doesn\'t match!');

            } else {
                $admin->update([
                    'email' => $request->email,
                    'password' => bcrypt($request->new_password)
                ]);
                return back()->with('success', 'Successfully update your account!');
            }
        }
    }
}
