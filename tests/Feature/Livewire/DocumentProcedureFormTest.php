<?php

declare(strict_types=1);

use App\Livewire\DocumentProcedureForm;
use Livewire\Livewire;

it('renders successfully', function () {
    Livewire::test(DocumentProcedureForm::class)
        ->assertStatus(200);
});
