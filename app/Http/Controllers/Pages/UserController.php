<?php

namespace App\Http\Controllers\Pages;

use App\Models\Galeri;
use App\Models\JenisPortofolio;
use App\Models\layanan;
use App\Models\Pemesanan;
use App\Models\Portofolio;
use App\Models\Feedback;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->only('postFeedback');
    }

    public function index()
    {
        $portfolios = Portofolio::take(12)->get()->shuffle()->all();

        return view('pages.beranda', compact('portfolios'));
    }

    public function showPortfolio(Request $request)
    {
        $types = JenisPortofolio::orderBy('nama')->get();
        $portfolios = Portofolio::orderByDesc('id')->get();
        $keyword = $request->q;
        $page = $request->page;

        return view('pages.portofolio', compact('portfolios', 'types', 'keyword', 'page'));
    }

    public function getPortfolios(Request $request)
    {
        if ($request->q == 'all') {
            $portfolios = Portofolio::orderByDesc('id')->paginate(12)->toArray();
        } else {
            $portfolios = Portofolio::orderByDesc('id')->where('jenis_id', $request->q)->paginate(20)->toArray();
        }

        $i = 0;
        foreach ($portfolios['data'] as $portfolio) {
            $galleries = array('galleries' => Galeri::where('portofolio_id', $portfolio['id'])->count());
            $jenis = array('jenis' => strtolower(JenisPortofolio::find($portfolio['jenis_id'])->nama));
            $encrypt = array('enc_id' => encrypt($portfolio['id']));
            $cover = array('cover' => $portfolio['cover'] == 'img_1.jpg' || $portfolio['cover'] == 'img_2.jpg' ||
            $portfolio['cover'] == 'img_3.jpg' || $portfolio['cover'] == 'img_4.jpg' ||
            $portfolio['cover'] == 'img_5.jpg' || $portfolio['cover'] == 'img_6.jpg' ||
            $portfolio['cover'] == 'img_7.jpg' ? asset('images/' . $portfolio['cover']) :
                asset('storage/portofolio/' . strtolower(str_replace
                        (' ', '_', JenisPortofolio::find($portfolio['jenis_id'])->nama)
                        . '/' . $portfolio['id'] . '/' . $portfolio['cover'])));

            $portfolios['data'][$i] = array_replace($jenis, $portfolios['data'][$i], $galleries, $encrypt, $cover);
            $i = $i + 1;
        }

        return $portfolios;
    }

    public function showPortfolioGalleries($jenis, $id)
    {
        $data = Portofolio::find(decrypt($id));

        return view('pages.portofolio-galeri', compact('data', 'jenis'));
    }

    public function feedback()
    {
        $feedback = Feedback::where('rate', '>', 2)->orderByDesc('id')->get();

        return view('pages.feedback', compact('portfolios', 'feedback'));
    }

    public function postFeedback(Request $request)
    {
        if ($request->check_form == 'create') {
            Feedback::create([
                'user_id' => Auth::id(),
                'rate' => $request->rating,
                'comment' => $request->comment,
            ]);

            return back()->with('update', 'Terima kasih ' . Auth::user()->name . ' atas ulasannya! ' .
                'Dengan begitu kami dapat berpotensi menjadi perusahaan yang lebih baik lagi.');

        } else {
            $find = Feedback::find($request->check_form);
            $find->update([
                'rate' => $request->rating,
                'comment' => $request->comment,
            ]);

            return back()->with('update', 'Ulasan Anda berhasil diperbarui!');
        }
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
}
