<?php

use GMJ\LaravelBlock2Pdf\Http\Controllers\BlockController;
use GMJ\LaravelBlock2Pdf\Http\Controllers\CategoryController;
use Illuminate\Support\Facades\Route;

Route::group([
    "middleware" => ["web", "auth"],
    "prefix" => "admin/element/{element_id}/gmj/laravel_block2_pdf",
    "as" => "LaravelBlock2Pdf."
], function () {
    Route::get("index", [CategoryController::class, "index"])->name("index");
    Route::get("create", [CategoryController::class, "create"])->name("create");
    Route::post("store", [CategoryController::class, "store"])->name("store");
    Route::get("edit/{id}", [CategoryController::class, "edit"])->name("edit");
    Route::patch("update/{id}", [CategoryController::class, "update"])->name("update");
    Route::get("order", [CategoryController::class, "order"])->name("order");
    Route::post("order2", [CategoryController::class, "order2"])->name("order2");
    Route::delete("delete/{id}", [CategoryController::class, "destroy"])->name("delete");
    Route::group(["prefix" => "item/{cat_id}", "as" => "item."], function () {
        Route::get("index", [BlockController::class, "index"])->name("index");
        Route::get("create", [BlockController::class, "create"])->name("create");
        Route::post("store", [BlockController::class, "store"])->name("store");
        Route::get("edit/{id}", [BlockController::class, "edit"])->name("edit");
        Route::patch("update/{id}", [BlockController::class, "update"])->name("update");
        Route::get("order", [BlockController::class, "order"])->name("order");
        Route::post("order2", [BlockController::class, "order2"])->name("order2");
        Route::delete("delete/{id}", [BlockController::class, "destroy"])->name("delete");
    });
});

Route::group([
    "middleware" => ["web"],
    "prefix" => "pdf/preview/{cat_id}",
    "as" => "LaravelBlock2Pdf.preview."
], function () {
    Route::get("index", [CategoryController::class, "preview"])->name("index");
});
