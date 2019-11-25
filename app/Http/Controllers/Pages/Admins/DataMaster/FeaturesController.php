<?php

namespace App\Http\Controllers\Pages\Admins\DataMaster;

use App\Models\JenisLayanan;
use App\Models\JenisStudio;
use App\Models\layanan;
use App\Models\PaymentCategory;
use App\Models\PaymentMethod;
use App\Models\Studio;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FeaturesController extends Controller
{
    public function showPaymentCategoriesTable()
    {
        $categories = PaymentCategory::all();

        return view('pages.admins.dataMaster.features.paymentCategories-table', compact('categories'));
    }

    public function createPaymentCategories(Request $request)
    {
        PaymentCategory::create([
            'name' => $request->name,
            'caption' => $request->caption
        ]);

        return back()->with('success', 'Payment category (' . $request->name . ') is successfully created!');
    }

    public function updatePaymentCategories(Request $request)
    {
        $category = PaymentCategory::find($request->id);
        $category->update([
            'name' => $request->name,
            'caption' => $request->caption
        ]);

        return back()->with('success', 'Payment category (' . $category->name . ') is successfully updated!');
    }

    public function deletePaymentCategories($id)
    {
        $category = PaymentCategory::find(decrypt($id));
        $category->delete();

        return back()->with('success', 'Payment category (' . $category->name . ') is successfully deleted!');
    }

    public function massDeletePaymentCategories(Request $request)
    {
        $categories = PaymentCategory::whereIn('id', explode(",", $request->category_ids))->get();
        foreach ($categories as $category) {
            $category->delete();
        }
        $message = count($categories) > 1 ? count($categories) . ' payment categories are ' :
            count($categories) . ' category is ';

        return back()->with('success', $message . 'successfully deleted!');
    }

    public function showPaymentMethodsTable()
    {
        $methods = PaymentMethod::all();

        return view('pages.admins.dataMaster.features.paymentMethods-table', compact('methods'));
    }

    public function createPaymentMethods(Request $request)
    {
        $this->validate($request, ['logo' => 'required|image|mimes:jpg,jpeg,gif,png|max:1024']);

        $name = $request->file('logo')->getClientOriginalName();
        $request->file('logo')->move(public_path('images\paymentMethod'), $name);

        PaymentMethod::create([
            'logo' => $name,
            'name' => $request->name,
            'payment_category_id' => $request->category_id,
            'account_name' => $request->account_name,
            'account_number' => $request->account_number,
        ]);

        return back()->with('success', 'Payment method (' . $request->name . ') is successfully created!');
    }

    public function updatePaymentMethods(Request $request)
    {
        $method = PaymentMethod::find($request->id);

        $this->validate($request, ['logo' => 'image|mimes:jpg,jpeg,gif,png|max:1024']);

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

        return back()->with('success', 'Payment method (' . $method->name . ') is successfully updated!');
    }

    public function deletePaymentMethods($id)
    {
        $method = PaymentMethod::find(decrypt($id));
        if ($method->logo != '') {
            unlink(public_path('images\paymentMethod/' . $method->logo));
        }
        $method->delete();

        return back()->with('success', 'Payment method (' . $method->name . ') is successfully deleted!');
    }

    public function massDeletePaymentMethods(Request $request)
    {
        $methods = PaymentMethod::whereIn('id', explode(",", $request->method_ids))->get();
        foreach ($methods as $method) {
            if ($method->logo != '') {
                unlink(public_path('images\paymentMethod/' . $method->logo));
            }

            $method->delete();
        }
        $message = count($methods) > 1 ? count($methods) . ' payment methods are ' : count($methods) . ' method is ';

        return back()->with('success', $message . 'successfully deleted!');
    }

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
        /*if ($type->icon != '') {
            unlink(public_path('images\services/' . $type->icon));
        }*/
        $type->delete();

        return back()->with('success', 'Service type (' . $type->nama . ') is successfully deleted!');
    }

    public function massDeleteServiceTypes(Request $request)
    {
        $types = JenisLayanan::whereIn('id', explode(",", $request->type_ids))->get();
        foreach ($types as $type) {
            if ($type->icon != '') {
                unlink(public_path('images\services/' . $type->icon));
            }

            $type->delete();
        }
        $message = count($types) > 1 ? count($types) . ' service types are ' : count($types) . ' service type is ';

        return back()->with('success', $message . 'successfully deleted!');
    }

    public function showServicesTable()
    {
        $services = layanan::all();

        return view('pages.admins.dataMaster.features.services-table', compact('services'));
    }

    public function createServices(Request $request)
    {
        $service = layanan::create([
            'jenis_id' => $request->jenis_id,
            'paket' => $request->paket,
            'harga' => str_replace('.', '', $request->harga),
            'diskon' => $request->diskon,
            'isHours' => $request->hours == null ? false : true,
            'hours' => $request->hours == null ? null : $request->hours,
            'price_per_hours' => $request->price_per_hours == null ? null :
                str_replace('.', '', $request->price_per_hours),
            'isQty' => $request->qty == null ? false : true,
            'qty' => $request->qty == null ? null : $request->qty,
            'price_per_qty' => $request->price_per_qty == null ? null :
                str_replace('.', '', $request->price_per_qty),
            'isStudio' => $request->isStudio,
            'keuntungan' => $request->keuntungan,
        ]);

        return back()->with('success', 'Service (' . $service->paket . ') is successfully created!');
    }

    public function updateServices(Request $request)
    {
        $service = layanan::find($request->id);
        $service->update([
            'jenis_id' => $request->jenis_id,
            'paket' => $request->paket,
            'harga' => str_replace('.', '', $request->harga),
            'diskon' => $request->diskon,
            'isHours' => $request->hours == null ? $service->isHours : true,
            'hours' => $request->hours == null ? $service->hours : $request->hours,
            'price_per_hours' => $request->price_per_hours == null ? $service->price_per_hours :
                str_replace('.', '', $request->price_per_hours),
            'isQty' => $request->qty == null ? $service->isQty : true,
            'qty' => $request->qty == null ? $service->qty : $request->qty,
            'price_per_qty' => $request->price_per_qty == null ? $service->price_per_qty :
                str_replace('.', '', $request->price_per_qty),
            'isStudio' => $request->isStudio,
            'keuntungan' => $request->keuntungan,
        ]);

        return back()->with('success', 'Service (' . $service->paket . ') is successfully updated!');
    }

    public function deleteServices($id)
    {
        $service = layanan::find(decrypt($id));
        $service->delete();

        return back()->with('success', 'Service (' . $service->paket . ') is successfully deleted!');
    }

    public function massDeleteServices(Request $request)
    {
        $services = layanan::whereIn('id', explode(",", $request->service_ids))->get();
        foreach ($services as $service) {
            $service->delete();
        }
        $message = count($services) > 1 ? count($services) . ' services are ' : count($services) . ' service is ';

        return back()->with('success', $message . 'successfully deleted!');
    }

    public function showStudioTypesTable()
    {
        $types = JenisStudio::all();

        return view('pages.admins.dataMaster.features.studioTypes-table', compact('types'));
    }

    public function createStudioTypes(Request $request)
    {
        $type = JenisStudio::create(['nama' => $request->nama]);

        return back()->with('success', 'Studio type (' . $type->nama . ') is successfully created!');
    }

    public function updateStudioTypes(Request $request)
    {
        $type = JenisStudio::find($request->id);
        $type->update(['nama' => $request->nama]);

        return back()->with('success', 'Studio type (' . $type->nama . ') is successfully updated!');
    }

    public function deleteStudioTypes($id)
    {
        $type = JenisStudio::find(decrypt($id));
        $type->delete();

        return back()->with('success', 'Studio type (' . $type->nama . ') is successfully deleted!');
    }

    public function massDeleteStudioTypes(Request $request)
    {
        $types = JenisStudio::whereIn('id', explode(",", $request->type_ids))->get();
        foreach ($types as $type) {
            $type->delete();
        }
        $message = count($types) > 1 ? count($types) . ' studio types are ' : count($types) . ' studio type is ';

        return back()->with('success', $message . 'successfully deleted!');
    }

    public function showStudiosTable()
    {
        $studios = Studio::all();

        return view('pages.admins.dataMaster.features.studios-table', compact('studios'));
    }

    public function createStudios(Request $request)
    {
        $studio = Studio::create([
            'jenis_id' => $request->jenis_id,
            'nama' => $request->nama,
            'harga' => str_replace('.', '', $request->harga),
        ]);

        return back()->with('success', 'Studio (' . $studio->nama . ') is successfully created!');
    }

    public function updateStudios(Request $request)
    {
        $studio = Studio::find($request->id);
        $studio->update([
            'jenis_id' => $request->jenis_id,
            'nama' => $request->nama,
            'harga' => str_replace('.', '', $request->harga),
        ]);

        return back()->with('success', 'Studio (' . $studio->nama . ') is successfully updated!');
    }

    public function deleteStudios($id)
    {
        $studio = Studio::find(decrypt($id));
        $studio->delete();

        return back()->with('success', 'Studio (' . $studio->nama . ') is successfully deleted!');
    }

    public function massDeleteStudios(Request $request)
    {
        $studios = Studio::whereIn('id', explode(",", $request->studio_ids))->get();
        foreach ($studios as $studio) {
            $studio->delete();
        }
        $message = count($studios) > 1 ? count($studios) . ' studios are ' : count($studios) . ' studio is ';

        return back()->with('success', $message . 'successfully deleted!');
    }
}
