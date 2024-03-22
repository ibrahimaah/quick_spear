<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\Category;
use App\Models\Product;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware(['super_admin']);
    }
    public function index()
    {
        $products = Product::get();
        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::get();
        return view('admin.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $rules = [
            'name_ar' => 'required',
            'name_en' => 'required',
            'name_ku' => 'required',
            'desc_ar' => 'required',
            'desc_en' => 'required',
            'desc_ku' => 'required',
            'category'=> 'required',
            'company_made'=> 'required',
            'photo'   => 'required|image',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return back()->withErrors($validator)
                        ->withInput($request->all());
        }
        $photos= [];
        if ($request->hasFile('photo')) {
                foreach ($request->file('photo') as $file) {
                    $photos[] = uploadImage('products', $file);
                }
        }
        $name = [
                'ar' => $request->name_ar,
                'en' => $request->name_en,
                'ku' => $request->name_ku,
            ];
        $desc = [
                'ar' => $request->desc_ar,
                'en' => $request->desc_en,
                'ku' => $request->desc_ku,
            ];
        Product::create([
            'name' => $name,
            'desc' => $desc,
            'unit' => $request->unit,
            'company_made' => $request->company_made,
            'category_id' => $request->category,
            'photo'      => implode(',', $photos),
        ]);
        return redirect()->route('admin.products.index')->with("success","تم اضافة البيانات بنجاح");
    }

    public function edit(Product $product)
    {
        $categories = Category::get();
        return view('admin.products.edit', compact(['categories', 'product']));
    }

    public function update(Request $request, Product $product)
    {
        $rules = [
            'name_ar' => 'required',
            'name_en' => 'required',
            'name_ku' => 'required',
            'desc_ar' => 'required',
            'desc_en' => 'required',
            'desc_ku' => 'required',
            'category'=> 'required',
            'company_made' => 'nullable',
            'photo'   => 'nullable|image',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return back()->withErrors($validator)
                        ->withInput($request->all());
        }
        $photos = [];
        if ($request->hasFile('photo')) {
            foreach ($request->file('photo') as $file) {
                $photos[] = uploadImage('products', $file);
            }
        }
        $name = [
                'ar' => $request->name_ar,
                'en' => $request->name_en,
                'ku' => $request->name_ku,
            ];
        $desc = [
                'ar' => $request->desc_ar,
                'en' => $request->desc_en,
                'ku' => $request->desc_ku,
            ];
        $product->update([
            'name' => $name,
            'desc' => $desc,
            'unit' => $request->unit,
            'company_made' => $request->company_made ?? $product->company_made,
            'category_id' => $request->category,
            'photo'      => $request->hasFile('photo') ? implode(',', $photos) : $product->photo,
        ]);
        return redirect()->route('admin.products.index')->with("success","تم تعديل البيانات بنجاح");
    }

    public function destroy(Product $product)
    {

        if ($product->photo !== 'images/default.png') {
            Storage::delete($product->photo);
        }
        $product->delete();
        return redirect()->route('admin.products.index')->with("success","تم حذف البيانات بنجاح");
    }
}
