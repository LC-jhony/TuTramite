<?php

declare(strict_types=1);

use App\Livewire\DocumentProcedureForm;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });
Route::get('/', DocumentProcedureForm::class)
    ->name('document-procedure-form');
