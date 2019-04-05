<?php

namespace App\Http\Controllers\Pages;

use App\Admin;
use App\Models\About;
use App\Models\Faq;
use App\Models\Galeri;
use App\Models\JenisLayanan;
use App\Models\JenisPortofolio;
use App\Models\layanan;
use App\Models\Pemesanan;
use App\Models\Portofolio;
use App\Models\Feedback;
use App\Support\Role;
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

    public function info()
    {
        $info = About::first();

        return view('pages.info', compact('info'));
    }

    public function faq()
    {
        $faqs = Faq::all();

        return view('pages.faq', compact('faqs'));
    }

    public function showPortfolio(Request $request)
    {
        $types = JenisPortofolio::orderBy('nama')->get();
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
            $jenis = array('jenis' => strtolower(str_replace(' ', '-',
                JenisPortofolio::find($portfolio['jenis_id'])->nama)));
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

    public function showService()
    {
        $types = JenisLayanan::orderBy('nama')->get();

        return view('pages.service', compact('types'));
    }

    public function showServicePricing($jenis, $id)
    {
        $data = JenisLayanan::find(decrypt($id));

        return view('pages.service-plan', compact('data', 'jenis'));
    }

    public function about()
    {
        $about = About::first();
        $crews = Admin::where('role', '!=', Role::ROOT)->orderBy('role')->get();

        return view('pages.about', compact('about', 'crews'));
    }

    public function feedback()
    {
        $feedback = Feedback::orderByDesc('id')->get();
        $average = Feedback::avg('rate');
        $star5 = Feedback::whereBetween('rate', [4.5, 5])->count() * 100 / count($feedback);
        $star4 = Feedback::whereBetween('rate', [3.5, 4])->count() * 100 / count($feedback);
        $star3 = Feedback::whereBetween('rate', [2.5, 3])->count() * 100 / count($feedback);
        $star2 = Feedback::whereBetween('rate', [1.5, 2])->count() * 100 / count($feedback);
        $star1 = Feedback::whereBetween('rate', [0.5, 1])->count() * 100 / count($feedback);

        return view('pages.feedback', compact('feedback', 'average',
            'star5', 'star4', 'star3', 'star2', 'star1'));
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
            Feedback::find($request->check_form)->update([
                'rate' => $request->rating,
                'comment' => $request->comment,
            ]);

            return back()->with('update', 'Ulasan Anda berhasil diperbarui!');
        }
    }
}
