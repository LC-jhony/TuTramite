<?php

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
            $table->string('transaction_number');
            $table->unsignedBigInteger('origin_office_id');
            $table->unsignedBigInteger('origin_user_id');
            $table->unsignedBigInteger('destination_office_id');
            $table->unsignedBigInteger('destination_user_id');
            $table->string('action');
            $table->string('indication');
            $table->string('observation');
            $table->string('urgent_priority');
            $table->date('movement_date');
            $table->date('receipt_date');
            $table->date('service_date');
            $table->boolean('status');
            $table->boolean('requires_response');
            $table->boolean('is_copy');
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
