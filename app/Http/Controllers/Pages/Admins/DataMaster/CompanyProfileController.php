<?php

namespace App\Http\Controllers\Pages\Admins\DataMaster;

use App\Models\About;
use App\Models\Faq;
use App\Models\Galeri;
use App\Models\HowItWorks;
use App\Models\JenisPortofolio;
use App\Models\Portofolio;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class CompanyProfileController extends Controller
{
    public function showCompanyProfile()
    {
        $about = About::first();

        return view('pages.admins.dataMaster.company.about', compact('about'));
    }

    public function updateCompanyProfile(Request $request)
    {
        $about = About::find($request->id);
        if ($request->check_form == 'gs') {
            $this->validate($request, ['icon' => 'image|mimes:jpg,jpeg,gif,png|max:2048']);

            if ($request->hasfile('icon')) {
                $name = $request->file('icon')->getClientOriginalName();
                if ($about->icon != '') {
                    unlink(public_path('images/' . $about->icon));
                }
                $request->file('icon')->move(public_path('images'), $name);

            } else {
                $name = $about->icon;
            }

            $about->update([
                'icon' => $name,
                'tagline' => $request->tagline,
                'deskripsi' => $request->deskripsi
            ]);

            return back()->with('success', 'Rabbit\'s profile is successfully updated!');

        } elseif ($request->check_form == 'vs') {
            $about->update([
                'visi' => $request->visi,
                'misi' => $request->misi
            ]);

            return back()->with('success', 'Rabbit\'s mission is successfully updated!');

        } else {
            $about->update(['terms_conditions' => $request->terms_conditions]);

            return back()->with('success', 'Rabbit\'s terms & conditions is successfully updated!');
        }
    }

    public function showFaqTable()
    {
        $faqs = Faq::all();

        return view('pages.admins.dataMaster.company.faq-table', compact('faqs'));
    }

    public function createFaq(Request $request)
    {
        $faq = Faq::create([
            'pertanyaan' => $request->pertanyaan,
            'jawaban' => $request->jawaban,
        ]);

        return back()->with('success', 'FAQ (' . $faq->pertanyaan . ') is successfully created!');
    }

    public function updateFaq(Request $request)
    {
        $faq = Faq::find($request->id);
        $faq->update([
            'pertanyaan' => $request->pertanyaan,
            'jawaban' => $request->jawaban,
        ]);

        return back()->with('success', 'FAQ (' . $faq->pertanyaan . ') is successfully updated!');
    }

    public function deleteFaq($id)
    {
        $faq = Faq::find(decrypt($id));
        $faq->delete();

        return back()->with('success', 'FAQ (' . $faq->pertanyaan . ') is successfully deleted!');
    }

    public function showHowItWorksTable()
    {
        $works = HowItWorks::all();

        return view('pages.admins.dataMaster.company.howItWorks-table', compact('works'));
    }

    public function createHowItWorks(Request $request)
    {
        $this->validate($request, ['icon' => 'required|image|mimes:jpg,jpeg,gif,png|max:2048']);
        if ($request->hasfile('icon')) {
            $name = $request->file('icon')->getClientOriginalName();
            $request->file('icon')->move(public_path('images\how-it-works'), $name);

        } else {
            $name = null;
        }

        $work = HowItWorks::create([
            'icon' => $name,
            'stem_color' => $request->stem_color,
            'title' => $request->title,
            'caption' => $request->caption,
            'description' => $request->description,
        ]);

        return back()->with('success', 'Step (' . $work->title . ') is successfully added to "How It Works" page!');
    }

    public function updateHowItWorks(Request $request)
    {
        $work = HowItWorks::find($request->id);

        if ($request->hasfile('icon')) {
            $this->validate($request, ['icon' => 'required|image|mimes:jpg,jpeg,gif,png|max:2048']);
            $name = $request->file('icon')->getClientOriginalName();
            if ($work->icon != '') {
                unlink(public_path('images/how-it-works/' . $work->icon));
            }
            $request->file('icon')->move(public_path('images\how-it-works'), $name);

        } else {
            $name = $work->icon;
        }

        $work->update([
            'icon' => $name,
            'stem_color' => $request->stem_color,
            'title' => $request->title,
            'caption' => $request->caption,
            'description' => $request->description,
        ]);

        return back()->with('success', 'How it works step (' . $work->title . ') is successfully updated!');
    }

    public function deleteHowItWorks($id)
    {
        $work = HowItWorks::find(decrypt($id));
        if ($work->icon != '') {
            unlink(public_path('images\how-it-works/' . $work->icon));
        }
        $work->delete();

        return back()->with('success', 'How it works step (' . $work->title . ') is successfully deleted!');
    }

    public function showPortfolioTypesTable()
    {
        $types = JenisPortofolio::all();

        return view('pages.admins.dataMaster.company.portfolioTypes-table', compact('types'));
    }

    public function createPortfolioTypes(Request $request)
    {
        $type = JenisPortofolio::create([
            'icon' => $request->icon,
            'nama' => $request->nama,
        ]);

        return back()->with('success', 'Portfolio type (' . $type->nama . ') is successfully created!');
    }

    public function updatePortfolioTypes(Request $request)
    {
        $type = JenisPortofolio::find($request->id);
        $type->update([
            'icon' => $request->icon,
            'nama' => $request->nama,
        ]);

        return back()->with('success', 'Portfolio type (' . $type->nama . ') is successfully updated!');
    }

    public function deletePortfolioTypes($id)
    {
        $type = JenisPortofolio::find(decrypt($id));
        $type->delete();

        return back()->with('success', 'Portfolio type (' . $type->nama . ') is successfully deleted!');
    }

    public function showPortfoliosTable()
    {
        $portfolios = Portofolio::all();

        return view('pages.admins.dataMaster.company.portfolios-table', compact('portfolios'));
    }

    public function createPortfolios(Request $request)
    {
        $type = JenisPortofolio::find($request->jenis_id);
        $this->validate($request, ['cover' => 'required|image|mimes:jpg,jpeg,gif,png|max:2048']);

        if ($request->hasfile('cover')) {
            $name = $request->file('cover')->getClientOriginalName();

            $request->file('cover')->storeAs('public/portofolio/cover', $name);

        } else {
            $name = null;
        }

        $portfolio = Portofolio::create([
            'jenis_id' => $type->id,
            'nama' => $request->nama,
            'deskripsi' => $request->deskripsi,
            'cover' => $name,
        ]);

        return back()->with('success', 'Portfolio (' . $portfolio->nama . ') is successfully created!');
    }

    public function updatePortfolios(Request $request)
    {
        $portfolio = Portofolio::find($request->id);
        if ($request->hasFile('cover')) {
            $this->validate($request, ['cover' => 'image|mimes:jpg,jpeg,gif,png|max:2048']);
            $name = $request->file('cover')->getClientOriginalName();
            if ($portfolio->cover != 'img_1.jpg' || $portfolio->cover != 'img_2.jpg' ||
                $portfolio->cover != 'img_3.jpg' || $portfolio->cover != 'img_4.jpg' ||
                $portfolio->cover != 'img_5.jpg' || $portfolio->cover != 'img_6.jpg' ||
                $portfolio->cover != 'img_7.jpg') {
                Storage::delete('public/portofolio/cover/' . $portfolio->cover);
            }
            $request->file('cover')->storeAs('public/portofolio/cover', $name);

        } else {
            $name = $portfolio->cover;
        }

        $portfolio->update([
            'jenis_id' => $request->jenis_id,
            'nama' => $request->nama,
            'deskripsi' => $request->deskripsi,
            'cover' => $name,
        ]);

        return back()->with('success', 'Portfolio (' . $portfolio->nama . ') is successfully updated!');
    }

    public function deletePortfolios($id)
    {
        $portfolio = Portofolio::find(decrypt($id));
        if ($portfolio->cover != 'img_1.jpg' || $portfolio->cover != 'img_2.jpg' ||
            $portfolio->cover != 'img_3.jpg' || $portfolio->cover != 'img_4.jpg' ||
            $portfolio->cover != 'img_5.jpg' || $portfolio->cover != 'img_6.jpg' || $portfolio->cover != 'img_7.jpg') {
            Storage::delete('public/portofolio/cover/' . $portfolio->cover);
        }
        $portfolio->delete();

        return back()->with('success', 'Portfolio (' . $portfolio->nama . ') is successfully deleted!');
    }

    public function showPortfolioGalleriesTable()
    {
        $galleries = Galeri::all();

        return view('pages.admins.dataMaster.company.portfolioGalleries-table', compact('galleries'));
    }

    public function createPortfolioGalleries(Request $request)
    {
        $portfolio = Portofolio::find($request->portofolio_id);

        if ($request->hasFile('photo')) {
            $this->validate($request, ['photo' => 'required|image|mimes:jpg,jpeg,gif,png|max:5120']);
            $photo = $request->file('photo')->getClientOriginalName();
            $request->file('photo')->storeAs('public/portofolio/gallery', $photo);

            $video = null;
            $thumbnail = null;

        } elseif ($request->hasFile('thumbnail')) {
            $this->validate($request, ['thumbnail' => 'required|image|mimes:jpg,jpeg,gif,png|max:2048']);
            $thumbnail = $request->file('thumbnail')->getClientOriginalName();
            $request->file('thumbnail')->storeAs('public/portofolio/thumbnail', $thumbnail);

            $photo = null;
            $video = $request->video;

        } else {
            $photo = null;
            $thumbnail = null;
            $video = null;
        }

        $gallery = Galeri::create([
            'portofolio_id' => $portfolio->id,
            'nama' => $request->nama,
            'deskripsi' => $request->deskripsi,
            'photo' => $photo,
            'video' => $video,
            'thumbnail' => $thumbnail,
        ]);

        return back()->with('success', 'Gallery (' . $gallery->nama . ') is successfully added to portfolio (' .
            $portfolio->nama . ')!');
    }

    public function updatePortfolioGalleries(Request $request)
    {
        $gallery = Galeri::find($request->id);
        if ($request->hasFile('photo')) {
            $this->validate($request, ['photo' => 'required|image|mimes:jpg,jpeg,gif,png|max:5120']);
            $photo = $request->file('photo')->getClientOriginalName();
            if ($gallery->photo != 'nature_big_1.jpg' || $gallery->photo != 'nature_big_2.jpg' ||
                $gallery->photo != 'nature_big_3.jpg' || $gallery->photo != 'nature_big_4.jpg' ||
                $gallery->photo != 'nature_big_5.jpg' || $gallery->photo != 'nature_big_6.jpg' ||
                $gallery->photo != 'nature_big_7.jpg' || $gallery->photo != 'nature_big_8.jpg' ||
                $gallery->photo != 'nature_big_9.jpg') {
                Storage::delete('public/portofolio/gallery/' . $gallery->photo);
            }
            $request->file('photo')->storeAs('public/portofolio/gallery', $photo);

            $video = $gallery->video;
            $thumbnail = $gallery->thumbnail;

        } elseif ($request->hasFile('thumbnail')) {
            $this->validate($request, ['thumbnail' => 'required|image|mimes:jpg,jpeg,gif,png|max:2048']);
            $thumbnail = $request->file('thumbnail')->getClientOriginalName();
            if ($gallery->thumbnail != 'nature_big_1.jpg' || $gallery->thumbnail != 'nature_big_2.jpg' ||
                $gallery->thumbnail != 'nature_big_3.jpg' || $gallery->thumbnail != 'nature_big_4.jpg' ||
                $gallery->thumbnail != 'nature_big_5.jpg' || $gallery->thumbnail != 'nature_big_6.jpg' ||
                $gallery->thumbnail != 'nature_big_7.jpg' || $gallery->thumbnail != 'nature_big_8.jpg' ||
                $gallery->thumbnail != 'nature_big_9.jpg') {
                Storage::delete('public/portofolio/thumbnail/' . $gallery->thumbnail);
            }
            $request->file('thumbnail')->storeAs('public/portofolio/thumbnail', $thumbnail);

            $photo = $gallery->photo;
            $video = $request->video;

        } else {
            $photo = $gallery->photo;
            $thumbnail = $gallery->thumbnail;
            $video = $gallery->video;
        }

        $gallery->update([
            'portofolio_id' => $request->portofolio_id,
            'nama' => $request->nama,
            'deskripsi' => $request->deskripsi,
            'photo' => $photo,
            'video' => $video,
            'thumbnail' => $thumbnail,
        ]);

        return back()->with('success', 'Portfolio (' . $gallery->nama . ') is successfully updated!');
    }

    public function deletePortfolioGalleries($id)
    {
        $gallery = Galeri::find(decrypt($id));
        if ($gallery->photo != 'nature_big_1.jpg' || $gallery->photo != 'nature_big_2.jpg' ||
            $gallery->photo != 'nature_big_3.jpg' || $gallery->photo != 'nature_big_4.jpg' ||
            $gallery->photo != 'nature_big_5.jpg' || $gallery->photo != 'nature_big_6.jpg' ||
            $gallery->photo != 'nature_big_7.jpg' || $gallery->photo != 'nature_big_8.jpg' ||
            $gallery->photo != 'nature_big_9.jpg') {
            Storage::delete('public/portofolio/gallery/' . $gallery->photo);

        } elseif ($gallery->thumbnail != 'nature_big_1.jpg' || $gallery->thumbnail != 'nature_big_2.jpg' ||
            $gallery->thumbnail != 'nature_big_3.jpg' || $gallery->thumbnail != 'nature_big_4.jpg' ||
            $gallery->thumbnail != 'nature_big_5.jpg' || $gallery->thumbnail != 'nature_big_6.jpg' ||
            $gallery->thumbnail != 'nature_big_7.jpg' || $gallery->thumbnail != 'nature_big_8.jpg' ||
            $gallery->thumbnail != 'nature_big_9.jpg') {
            Storage::delete('public/portofolio/thumbnail/' . $gallery->thumbnail);
        }

        $gallery->delete();

        return back()->with('success', 'Gallery (' . $gallery->nama . ') is successfully deleted from portfolio (' .
            $gallery->getPortofolio->nama . ')!');
    }
}
