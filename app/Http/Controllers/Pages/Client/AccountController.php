<?php

namespace App\Http\Controllers\Pages\Client;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class AccountController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function editProfile()
    {
        $user = Auth::user();

        return view('pages.clients.editProfile', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        $user = User::findOrFail(Auth::id());

        if ($request->check_form == 'personal_data') {
            $user->update([
                'name' => $request->name,
                'jk' => $request->jk,
                'tgl_lahir' => $request->tgl_lahir,
                'no_telp' => $request->no_telp,
            ]);

        } elseif ($request->check_form == 'address') {
            $address = str_replace(" ", "+", $request->alamat);
            $json = file_get_contents("https://maps.googleapis.com/maps/api/geocode/json?address=" .
                $address . "&key=AIzaSyBIljHbKjgtTrpZhEiHum734tF1tolxI68");

            $request->request->add([
                'lat' => json_decode($json)->{'results'}[0]->{'geometry'}->{'location'}->{'lat'},
                'long' => json_decode($json)->{'results'}[0]->{'geometry'}->{'location'}->{'lng'}
            ]);

            $user->update([
                'alamat' => $request->alamat,
                'lat' => $request->lat,
                'long' => $request->long,
            ]);
        }

        return back()->with('update', 'Profil Anda berhasil diperbarui!');
    }

    public function accountSettings()
    {
        $user = Auth::user();

        return view('pages.clients.accountSettings', compact('user'));
    }

    public function updateAccount(Request $request)
    {
        $user = User::findOrFail(Auth::id());
        $img = $request->file('ava');

        $this->validate($request, [
            'ava' => 'image|mimes:jpg,jpeg,gif,png|max:2048',
        ]);

        if ($img == null) {
            $input = $request->all();
            if (!Hash::check($input['password'], $user->password)) {
                return 0;
            } else {
                if ($input['new_password'] != $input['password_confirmation']) {
                    return 1;
                } else {
                    $user->update(['password' => bcrypt($input['new_password'])]);
                    return 2;
                }
            }
        } else {
            $name = $img->getClientOriginalName();

            if ($user->ava != '' || $user->ava != 'agency.png') {
                Storage::delete('public/users/ava/' . $user->ava);
            }

            if ($img->isValid()) {
                $request->ava->storeAs('public/users/ava', $name);
                $user->update(['ava' => $name]);
                return asset('storage/users/ava/' . $name);
            }

        }
    }
}
