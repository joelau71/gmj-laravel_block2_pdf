<?php

namespace GMJ\LaravelBlock2Pdf\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\Translatable\HasTranslations;

class Category extends Model implements HasMedia
{

    use InteractsWithMedia;
    use HasTranslations;

    protected $guarded = [];
    public $translatable = ['title'];
    protected $table = "laravel_block2_pdf_categories";

    public function registerMediaCollections(Media $media = null): void
    {
        $this->addMediaCollection("laravel_block2_pdf_category")
            ->singleFile();

        $this->addMediaCollection("laravel_block2_pdf_category_original")
            ->singleFile();
    }

    public function children()
    {
        return $this->hasMany(Block::class)->orderBy("display_order");
    }
}
