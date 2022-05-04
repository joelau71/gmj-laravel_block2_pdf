<?php

namespace GMJ\LaravelBlock2Pdf\View\Components;

use App\Traits\LocaleTrait;
use GMJ\LaravelBlock2Pdf\Models\Block;
use GMJ\LaravelBlock2Pdf\Models\Category;
use GMJ\LaravelBlock2Pdf\Models\Config;
use Illuminate\View\Component;

class Frontend extends Component
{
    use LocaleTrait;

    public $element_id;
    public $page_element_id;
    public $collection;
    public $locale;
    public $config;

    public function __construct($pageElementId, $elementId)
    {
        $this->page_element_id = $pageElementId;
        $this->element_id = $elementId;
        $this->collection = Category::with("media")->orderBy("display_order")->get();
        $this->locale = $this->getLocale();
    }

    public function render()
    {
        return view("LaravelBlock2Pdf::components.frontend");
    }
}
