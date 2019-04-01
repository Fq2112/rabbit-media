<?php

namespace App\Http\Controllers\Pages;

use App\Models\JenisPortofolio;
use App\Models\layanan;
use App\Models\Pemesanan;
use App\Models\Portofolio;
use App\Models\Feedback;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

class UserController extends Controller
{
    public function index()
    {
        $portofolios = Portofolio::take(12)->get()->shuffle()->all();

        return view('pages.beranda', compact('portofolios'));
    }

    public function showPortfolio()
    {
        $types = JenisPortofolio::orderBy('nama')->get();
        $portfolios = Portofolio::orderByDesc('id')->get();

        return view('pages.portofolio', compact('portfolios', 'types'));
    }

    public function showPortfolioGalleries($jenis, $id)
    {
        $data = Portofolio::find(decrypt($id));

        return view('pages.portofolio-galeri', compact('data', 'jenis'));
    }

    public function info()
    {
        return view('pages.info');
    }

    public function about()
    {
        return view('pages.user.about');
    }

    public function detailService($id)
    {
        $jenislayanan = layanan::find($id);
        $layanans = layanan::where('jenislayanan_id', $jenislayanan->id)->get();
        return view('pages.user.service', compact('jenislayanan', 'layanans'));
    }

    public function order()
    {
        $types = layanan::all();
        $detail = null;
        $user = User::all();
        return view('pages.user.order', compact('types', 'detail', 'user'));
    }

    public function orderid(Request $request)
    {

        $detail = layanan::find(decrypt($request->id));
        $types = layanan::all();
        $user = User::all();
        return view('pages.user.order', compact('types', 'detail', 'user'));
    }

    public function postOrder(Request $request)
    {
        $array = $request->toArray();
//        dd($array);
        Pemesanan::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'service' => $request->service,
            'description' => $request->description
        ]);
        return redirect()->route('home')->withSuccess('Wait for any further confirmation from us via email/phone. Thanks for using our services! :)');
    }

    public function contact()
    {
        return view('pages.user.contact');
    }

    public function feedback()
    {
        return view('pages.user.feedback');
    }

    public function postFeedback(Request $request)
    {
        Feedback::create($request->all());
        return view('pages.user.beranda')->withSuccess('Thanks for reviewing us! Because of it, we`re potentially become a better company :)');
    }
}
