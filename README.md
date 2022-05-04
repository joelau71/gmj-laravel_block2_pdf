# gmj-laravel_block2_pdf

Laravel Block for backend and frontend - need tailwindcss support

**composer require gmj/laravel_block2_pdf**

package for test<br>
composer.json#autoload-dev#psr-4: "GMJ\\LaravelBlock2Pdf\\": "package/laravel_block2_pdf/src/",<br>
config > app.php > providers: GMJ\LaravelBlock2Pdf\LaravelBlock2PdfServiceProvider::class,
in terminal run: composer dump-autoload

---

in terminal run:

```
php artisan vendor:publish --provider="GMJ\LaravelBlock2Pdf\LaravelBlock2PdfServiceProvider" --force
php artisan migrate
php artisan db:seed --class=LaravelBlock2PdfSeeder
```
