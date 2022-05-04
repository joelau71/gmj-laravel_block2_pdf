<?php

namespace Database\Seeders;

use App\Models\Element;
use App\Models\ElementTemplate;
use Illuminate\Database\Seeder;
use Faker\Factory;
use App\Models\Page;
use GMJ\LaravelBlock2Pdf\Models\Block;
use GMJ\LaravelBlock2Pdf\Models\Config;
use Illuminate\Support\Arr;
use Image;

class LaravelBlock2PdfSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $template = ElementTemplate::where("component", "LaravelBlock2Pdf")->first();

        if ($template) {
            return false;
        }

        $template = ElementTemplate::create(
            [
                "title" => "Laravel Block2 Pdf",
                "component" => "LaravelBlock2Pdf",
            ]
        );
    }
}
