<?php

namespace GMJ\LaravelBlock2Pdf\Http\Controllers;

use App\Http\Controllers\Controller;
use Alert;
use App\Models\Element;
use App\Models\Page;
use GMJ\LaravelBlock2Pdf\Models\Block;
use GMJ\LaravelBlock2Pdf\Models\Category;
use GMJ\LaravelBlock2Pdf\Models\Config;
use Illuminate\Validation\Rule;
use phpDocumentor\Reflection\Types\Boolean;
use PDF;

class BlockController extends Controller
{
    public function index($element_id, $cat_id)
    {
        $element = Element::findOrFail($element_id);
        $collection = Block::where("cat_id", $cat_id)->orderBy("display_order")->get();
        $category = Category::findOrFail($cat_id);
        return view('LaravelBlock2Pdf::item.index', compact("element_id", "element", "collection", "cat_id", "category"));
    }

    public function create($element_id, $cat_id)
    {
        $element = Element::findOrFail($element_id);
        $category = Category::findOrFail($cat_id);
        return view('LaravelBlock2Pdf::item.create', compact("element_id", "element", "category", "cat_id"));
    }

    public function store($element_id, $cat_id)
    {


        //dd(request()->image->getClientOriginalName());

        $element = Element::findOrFail($element_id);

        request()->validate(
            [
                "image" => ["required", "image", "mimes:jpeg,jpg,png,webp"],
            ]
        );

        $display_order = Block::where("cat_id", $cat_id)->max("display_order");
        $display_order++;

        $collection = Block::create([
            "element_id" => $element_id,
            "cat_id" => $cat_id,
            "display_order" => $display_order
        ]);

        $collection->addMediaFromRequest('image')
            ->usingFileName(request()->image->getClientOriginalName())
            ->toMediaCollection('laravel_block2_pdf_original');

        //$collection->addMediaFromBase64(request()->uic_base64_image, ["image/jpeg", "image/png", "image/webp"])->withResponsiveImages()->toMediaCollection('laravel_block2_pdf');

        $collection->addMediaFromBase64(request()->uic_base64_image, ["image/jpeg", "image/png", "image/webp"])
            ->usingFileName(request()->image->getClientOriginalName())
            ->toMediaCollection('laravel_block2_pdf');

        $element->active();

        $this->generat_download_file($cat_id);

        Alert::success("Add Element {$element->title} Pdf success");
        return back();
    }

    public function edit($element_id, $cat_id, $id)
    {
        $element = Element::findOrFail($element_id);
        $collection = Block::findOrFail($id);
        $category = Category::findOrFail($cat_id);

        return view('LaravelBlock2Pdf::item.edit', compact("element_id", "element", "collection", "category", "cat_id", "id"));
    }

    public function update($element_id, $cat_id, $id)
    {
        $element = Element::findOrFail($element_id);

        request()->validate(
            [
                "image" => ["image", "mimes:jpeg,jpg,png,webp"],
            ]
        );

        $collection = Block::findOrFail($id);

        //dd(request()->image->getClientOriginalName());

        if (request()->image) {
            $collection->addMediaFromRequest('image')
                ->usingFileName(request()->image->getClientOriginalName())
                ->toMediaCollection('laravel_block2_pdf_original');
        }

        if (request()->uic_base64_image) {
            //$collection->addMediaFromBase64(request()->uic_base64_image, ["image/jpeg", "image/png", "image/webp"])->withResponsiveImages()->toMediaCollection('laravel_block2_pdf');
            $collection->addMediaFromBase64(request()->uic_base64_image, ["image/jpeg", "image/png", "image/webp"])
                //                ->usingFileName($this->name)
                ->toMediaCollection('laravel_block2_pdf');
        }


        //$collection->elementLinkPage()->sync(request()->page_id);
        $this->generat_download_file($cat_id);

        Alert::success("Edit Element {$element->title} Pdf success");
        return redirect()->route('LaravelBlock2Pdf.item.index', compact("element_id", "cat_id"));
    }

    public function order($element_id, $cat_id)
    {
        $element = Element::find($element_id);
        $collection = Block::where("element_id", $element_id)->orderBy("display_order")->get();
        $category = Category::findOrFail($cat_id);

        return view("LaravelBlock2Pdf::item.order", compact("element_id", "element", "collection", "cat_id", "category"));
    }

    public function order2($element_id, $cat_id)
    {
        foreach (request()->id as $key => $item) {
            $collection = Block::find($item);
            $num = $key + 1;
            $collection->display_order = $num;
            $collection->save();
        }
        $element = Element::find($element_id);
        $this->generat_download_file($cat_id);

        Alert::success("Edit Element {$element->title} Pdf Order success");
        return redirect()->route('LaravelBlock2Pdf.item.index', compact("element_id", "cat_id"));
    }

    public function destroy($element_id, $cat_id, $id)
    {
        $element = Element::findOrFail($element_id);
        $collection = Block::findOrFail($id);

        $collection->delete();

        if ($collection->count() < 1) {
            $element->inactive();
        }
        $this->generat_download_file($cat_id);

        Alert::success("Delete Element {$element->title} Pdf success");
        return redirect()->route('LaravelBlock2Pdf.item.index', compact("element_id", "cat_id"));
    }

    public function generat_download_file($cat_id)
    {
        $collection = Block::where("cat_id", $cat_id)->orderBy("display_order")->get();

        $html = "<html>";
        $html .= "<head>";
        $html .= "<style>
            @page { margin: 0px; }
            body{
                margin: 0;
            }
            img{
                position:relative;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                page-break-after: always;
            }
        </style>";
        $html .= "</head>";
        $html .= "<body>";

        foreach ($collection as $item) {
            $url = "storage/{$item->getMedia('laravel_block2_pdf')->first()->id}/{$item->getMedia('laravel_block2_pdf')->first()->file_name}";
            $html .= "<img src='{$url}' />";
        }

        $html .= "</body>";
        $html .= "</html>";

        PDF::loadHTML($html)
            ->setPaper('a4', 'portrait')
            ->setWarnings(false)
            ->save(public_path() . "/pdf/{$cat_id}.pdf");
    }
}
