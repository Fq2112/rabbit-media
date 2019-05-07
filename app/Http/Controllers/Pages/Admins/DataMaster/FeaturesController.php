<?php

namespace App\Http\Controllers\Pages\Admins\DataMaster;

use App\Models\JenisLayanan;
use App\Models\layanan;
use App\Models\PaymentCategory;
use App\Models\PaymentMethod;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FeaturesController extends Controller
{
    public function showServiceTypesTable()
    {
        $types = JenisLayanan::all();

        return view('pages.admins.dataMaster.features.serviceTypes-table', compact('types'));
    }

    public function createServiceTypes(Request $request)
    {
        $this->validate($request, ['icon' => 'required|image|mimes:jpg,jpeg,gif,png|max:2048']);
        if ($request->hasfile('icon')) {
            $name = $request->file('icon')->getClientOriginalName();
            $request->file('icon')->move(public_path('images\services'), $name);

        } else {
            $name = null;
        }

        $type = JenisLayanan::create([
            'icon' => $name,
            'nama' => $request->nama,
            'deskripsi' => $request->deskripsi,
            'isPack' => $request->isPack
        ]);

        return back()->with('success', 'Service type (' . $type->nama . ') is successfully created!');
    }

    public function updateServiceTypes(Request $request)
    {
        $type = JenisLayanan::find($request->id);

        if ($request->hasfile('icon')) {
            $this->validate($request, ['icon' => 'required|image|mimes:jpg,jpeg,gif,png|max:2048']);
            $name = $request->file('icon')->getClientOriginalName();
            if ($type->icon != '') {
                unlink(public_path('images/services/' . $type->icon));
            }
            $request->file('icon')->move(public_path('images\services'), $name);

        } else {
            $name = $type->icon;
        }

        $type->update([
            'icon' => $name,
            'nama' => $request->nama,
            'deskripsi' => $request->deskripsi,
            'isPack' => $request->isPack
        ]);

        return back()->with('success', 'Service type (' . $type->nama . ') is successfully updated!');
    }

    public function deleteServiceTypes($id)
    {
        $type = JenisLayanan::find(decrypt($id));
        if ($type->icon != '') {
            unlink(public_path('images\services/' . $type->icon));
        }
        $type->delete();

        return back()->with('success', 'Service type (' . $type->nama . ') is successfully deleted!');
    }

    public function showPaymentCategoriesTable()
    {
        $categories = PaymentCategory::all();

        return view('_admins.tables.webContents.paymentCategory-table', compact('categories'));
    }

    public function createPaymentCategories(Request $request)
    {
        PaymentCategory::create([
            'name' => $request->name,
            'caption' => $request->caption
        ]);

        return back()->with('success', '' . $request->name . ' is successfully created!');
    }

    public function updatePaymentCategories(Request $request)
    {
        $category = PaymentCategory::find($request->id);
        $category->update([
            'name' => $request->name,
            'caption' => $request->caption
        ]);

        return back()->with('success', '' . $category->name . ' is successfully updated!');
    }

    public function deletePaymentCategories($id)
    {
        $category = PaymentCategory::find(decrypt($id));
        $category->delete();

        return back()->with('success', '' . $category->name . ' is successfully deleted!');
    }

    public function showPaymentMethodsTable()
    {
        $methods = PaymentMethod::all();

        return view('_admins.tables.webContents.paymentMethod-table', compact('methods'));
    }

    public function createPaymentMethods(Request $request)
    {
        $this->validate($request, [
            'logo' => 'required|image|mimes:jpg,jpeg,gif,png|max:1024',
        ]);

        $name = $request->file('logo')->getClientOriginalName();
        $request->file('logo')->move(public_path('images\paymentMethod'), $name);

        PaymentMethod::create([
            'logo' => $name,
            'name' => $request->name,
            'payment_category_id' => $request->category_id,
            'account_name' => $request->account_name,
            'account_number' => $request->account_number,
        ]);

        return back()->with('success', '' . $request->name . ' is successfully created!');
    }

    public function updatePaymentMethods(Request $request)
    {
        $method = PaymentMethod::find($request->id);

        $this->validate($request, [
            'logo' => 'image|mimes:jpg,jpeg,gif,png|max:1024',
        ]);

        if ($request->hasfile('logo')) {
            $name = $request->file('logo')->getClientOriginalName();
            if ($method->logo != '') {
                unlink(public_path('images\paymentMethod/' . $method->logo));
            }
            $request->file('logo')->move(public_path('images\paymentMethod'), $name);

        } else {
            $name = $method->logo;
        }

        $method->update([
            'logo' => $name,
            'name' => $request->name,
            'payment_category_id' => $request->category_id,
            'account_name' => $request->account_name,
            'account_number' => $request->account_number,
        ]);

        return back()->with('success', '' . $method->name . ' is successfully updated!');
    }

    public function deletePaymentMethods($id)
    {
        $method = PaymentMethod::find(decrypt($id));
        if ($method->logo != '') {
            unlink(public_path('images\paymentMethod/' . $method->logo));
        }
        $method->delete();

        return back()->with('success', '' . $method->name . ' is successfully deleted!');
    }

    public function showPlansTable()
    {
        $plans = layanan::all();

        return view('_admins.tables.webContents.plan-table', compact('plans'));
    }

    public function createPlans(Request $request)
    {
        $checkIsBest = layanan::where('isBest', true)->count();
        if ($checkIsBest > 0 && $request->isBest == true) {
            foreach (layanan::where('isBest', true)->get() as $row) {
                $row->update([
                    'caption' => 'Job Posting ' . $row->name . ' Package',
                    'isBest' => false
                ]);
            }
        }

        layanan::create([
            'name' => $request->name,
            'caption' => $request->caption,
            'price' => $request->price,
            'discount' => $request->discount,
            'job_ads' => $request->job_ads,
            'isQuiz' => $request->isQuiz == 1 ? true : false,
            'quiz_applicant' => $request->quiz_applicant == null ? 0 : $request->quiz_applicant,
            'price_quiz_applicant' => $request->price_quiz_applicant == null ? 0 : $request->price_quiz_applicant,
            'isPsychoTest' => $request->isPsychoTest == 1 ? true : false,
            'psychoTest_applicant' => $request->psychoTest_applicant == null ? 0 : $request->psychoTest_applicant,
            'price_psychoTest_applicant' => $request->price_psychoTest_applicant == null ? 0 :
                $request->price_psychoTest_applicant,
            'benefit' => preg_replace('/\s+/', ' ', trim($request->benefit)),
            'isBest' => $request->isBest,
        ]);

        return back()->with('success', '' . $request->name . ' is successfully created!');
    }

    public function updatePlans(Request $request)
    {
        $checkIsBest = layanan::where('isBest', true)->count();
        if ($checkIsBest > 0 && $request->isBest == true) {
            foreach (layanan::where('isBest', true)->get() as $row) {
                $row->update([
                    'caption' => 'Job Posting ' . $row->name . ' Package',
                    'isBest' => false
                ]);
            }
        }

        $plan = layanan::find($request->id);
        $plan->update([
            'name' => $request->name,
            'caption' => $request->caption,
            'price' => $request->price,
            'discount' => $request->discount,
            'job_ads' => $request->job_ads,
            'isQuiz' => $request->isQuiz == 1 ? true : false,
            'quiz_applicant' => $request->quiz_applicant == null ? 0 : $request->quiz_applicant,
            'price_quiz_applicant' => $request->price_quiz_applicant == null ? 0 : $request->price_quiz_applicant,
            'isPsychoTest' => $request->isPsychoTest == 1 ? true : false,
            'psychoTest_applicant' => $request->psychoTest_applicant == null ? 0 : $request->psychoTest_applicant,
            'price_psychoTest_applicant' => $request->price_psychoTest_applicant == null ? 0 :
                $request->price_psychoTest_applicant,
            'benefit' => preg_replace('/\s+/', ' ', trim($request->benefit)),
            'isBest' => $request->isBest,
        ]);

        return back()->with('success', '' . $plan->name . ' is successfully updated!');
    }

    public function deletePlans($id)
    {
        $plan = layanan::find(decrypt($id));
        $plan->delete();

        return back()->with('success', '' . $plan->name . ' is successfully deleted!');
    }
}
