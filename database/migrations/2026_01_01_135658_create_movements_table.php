<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('movements', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('document_id');
            // $table->string('transaction_number');
            $table->unsignedBigInteger('origin_office_id');
            $table->unsignedBigInteger('origin_user_id');
            $table->unsignedBigInteger('destination_office_id');
            $table->unsignedBigInteger('destination_user_id');
            $table->string('action');
            $table->text('indication');
            $table->text('observation');
            //  $table->boolean('urgent_priority')->default(false);
            //  $table->date('movement_date');
            $table->date('receipt_date');
            // $table->date('service_date');
            $table->string('status');
            // $table->boolean('requires_response')->default(false);
            // $table->boolean('is_copy')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('movements');
    }
};
