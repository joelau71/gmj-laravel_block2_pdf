<?php

namespace GMJ\LaravelBlock2Pdf\Models;

use App\Traits\DeleteAllChildrenTrait;
use App\Traits\DeleteElementLinkPageTrait;
use App\Traits\GrabImageFromUnsplashTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Block extends Model implements HasMedia
{
    use HasFactory;
    use InteractsWithMedia;
    use DeleteAllChildrenTrait;
    use GrabImageFromUnsplashTrait;

    protected $guarded = [];
    public $table = "laravel_block2_pdfs";

    public function registerMediaCollections(Media $media = null): void
    {
        $this->addMediaCollection("laravel_block2_pdf")
            ->singleFile();

        $this->addMediaCollection("laravel_block2_pdf_original")
            ->singleFile();
    }

    public function parent()
    {
        return $this->belongsTo(Category::class);
    }
}
