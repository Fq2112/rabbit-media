<?php

namespace App\Http\Controllers\Pages;

use App\Admin;
use App\Models\About;
use App\Models\Contact;
use App\Models\Faq;
use App\Models\Galeri;
use App\Models\JenisLayanan;
use App\Models\JenisPortofolio;
use App\Models\Portofolio;
use App\Models\Feedback;
use App\Support\Role;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index()
    {
        $portfolios = Portofolio::take(12)->get()->shuffle()->all();

        return view('pages.main.beranda', compact('portfolios'));
    }

    public function about()
    {
        $about = About::first();
        $crews = Admin::where('role', '!=', Role::ROOT)->orderBy('id')->get();

        return view('pages.main.about', compact('about', 'crews'));
    }

    public function postContact(Request $request)
    {
        $contact = Contact::create([
            'name' => $request->contact_name,
            'email' => $request->contact_email,
            'subject' => $request->subject,
            'message' => $request->message
        ]);

        return back()->with('update', 'Terima kasih ' . $contact->name . ' telah meninggalkan kami pesan! ' .
            'Kami akan membalasnya melalui email Anda (' . $contact->email . ').');
    }

    public function info()
    {
        $info = About::first();

        return view('pages.main.info', compact('info'));
    }

    public function faq()
    {
        $faqs = Faq::all();

        return view('pages.main.faq', compact('faqs'));
    }

    public function showPortfolio(Request $request)
    {
        $types = JenisPortofolio::orderBy('nama')->get();
        $keyword = $request->q;
        $category = $request->category;
        $page = $request->page;

        return view('pages.main.portofolio', compact('portfolios', 'types', 'keyword', 'category', 'page'));
    }

    public function getPortfolios(Request $request)
    {
        if ($request->category == 'all') {
            $portfolios = Portofolio::where('nama', 'LIKE', '%' . $request->q . '%')
                ->orderByDesc('id')->paginate(12)->toArray();
        } else {
            $portfolios = Portofolio::where('nama', 'LIKE', '%' . $request->q . '%')
                ->where('jenis_id', $request->category)->orderByDesc('id')->paginate(12)->toArray();
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

        return view('pages.main.portofolio-galeri', compact('data', 'jenis'));
    }

    public function showService()
    {
        $types = JenisLayanan::where('isPack', false)->orderBy('nama')->get();
        $packs = JenisLayanan::where('isPack', true)->orderBy('nama')->get();

        return view('pages.main.service', compact('types', 'packs'));
    }

    public function showServicePricing($jenis, $id)
    {
        $data = JenisLayanan::find(decrypt($id));

        return view('pages.main.service-plan', compact('data', 'jenis'));
    }

    public function feedback()
    {
        $feedback = Feedback::orderByDesc('id')->get();
        $average = Feedback::avg('rate');
        $star5 = number_format(Feedback::whereBetween('rate', [4.5, 5])->count() * 100 / count($feedback),
            2, '.', ',');
        $star4 = number_format(Feedback::whereBetween('rate', [3.5, 4])->count() * 100 / count($feedback),
            2, '.', ',');
        $star3 = number_format(Feedback::whereBetween('rate', [2.5, 3])->count() * 100 / count($feedback),
            2, '.', ',');
        $star2 = number_format(Feedback::whereBetween('rate', [1.5, 2])->count() * 100 / count($feedback),
            2, '.', ',');
        $star1 = number_format(Feedback::whereBetween('rate', [0.5, 1])->count() * 100 / count($feedback),
            2, '.', ',');

        return view('pages.main.feedback', compact('feedback', 'average',
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

    public function deleteFeedback($id)
    {
        Feedback::destroy(decrypt($id));

        return back()->with('delete', 'Ulasan Anda berhasil dihapus!');
    }
}
