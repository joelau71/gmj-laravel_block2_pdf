<?php

namespace GMJ\LaravelBlock2Pdf\Http\Controllers;

use App\Http\Controllers\Controller;
use Alert;
use App\Models\Element;
use GMJ\LaravelBlock2Pdf\Models\Block;
use GMJ\LaravelBlock2Pdf\Models\Category;
use PDF;

class CategoryController extends Controller
{
    public function index($element_id)
    {
        $element = Element::findOrFail($element_id);
        $collection = Category::with("media")->orderBy("display_order")->get();
        return view("LaravelBlock2Pdf::index", compact("collection", "element", "element_id"));
    }

    public function create($element_id)
    {
        $element = Element::findOrFail($element_id);
        return view('LaravelBlock2Pdf::create', compact("element_id", "element"));
    }

    public function store($element_id)
    {
        $element = Element::findOrFail($element_id);

        request()->validate([
            "image" => ["required", "image", "mimes:jpeg,jpg,png,webp"],
            "title.*" => ["required"],
        ]);

        $display_order = Category::where("element_id", $element_id)->max("display_order");
        $display_order++;

        $collection = Category::create([
            "element_id" => $element->id,
            "title" => request()->title,
            "display_order" => $display_order
        ]);

        $collection->addMediaFromRequest('image')->toMediaCollection('laravel_block2_pdf_category_original');

        $collection->addMediaFromBase64(request()->uic_base64_image, ["image/jpeg", "image/png", "image/webp"])->toMediaCollection('laravel_block2_pdf_category');

        alert()->success("Add Element {$element->title} Pdf Category success");
        return back();
    }

    public function edit($element_id, $id)
    {
        $element = Element::findOrFail($element_id);
        $collection = Category::findOrFail($id);
        return view('LaravelBlock2Pdf::edit', compact("element_id", "element", "collection"));
    }

    public function update($element_id, $id)
    {

        $element = Element::findOrFail($element_id);

        request()->validate([
            "image" => ["image", "mimes:jpeg,jpg,png,webp"],
            "title.*" => ["required"],
        ]);

        $collection = Category::findOrFail($id);

        $collection->update([
            "title" => request()->title,
        ]);

        if (request()->image) {
            $collection->addMediaFromRequest('image')->toMediaCollection('laravel_block2_pdf_category_original');
        }

        if (request()->uic_base64_image) {
            $collection->addMediaFromBase64(request()->uic_base64_image, ["image/jpeg", "image/png", "image/webp"])->toMediaCollection('laravel_block2_pdf_category');
        }

        Alert::success("Edit Element {$element->title} Pdf Config success");
        return redirect()->route("LaravelBlock2Pdf.index", $element_id);
    }

    public function order($element_id)
    {
        $element = Element::find($element_id);
        $collection = Category::where("element_id", $element_id)->orderBy("display_order")->get();
        return view("LaravelBlock2Pdf::order", compact("element_id", "element", "collection"));
    }

    public function order2($element_id)
    {
        foreach (request()->id as $key => $item) {
            $collection = Category::find($item);
            $num = $key + 1;
            $collection->display_order = $num;
            $collection->save();
        }
        $element = Element::find($element_id);
        Alert::success("Edit Element {$element->title} Pdf Order success");
        return redirect()->route('LaravelBlock2Pdf.index', $element_id);
    }

    public function destroy($element_id, $id)
    {
        $element = Element::findOrFail($element_id);
        $collection = Category::findOrFail($id);

        $collection->delete();

        if ($collection->count() < 1) {
            $element->inactive();
        }
        Alert::success("Delete Element {$element->title} Pdf Category success");
        return redirect()->route('LaravelBlock2Pdf.index', $element_id);
    }

    public function preview($cat_id)
    {
        $collection = Block::where("cat_id", $cat_id)->orderBy("display_order")->get();
        return view("LaravelBlock2Pdf::preview.index", compact("collection"));
    }
}
