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
        Schema::create('documents', function (Blueprint $table) {
            $table->id();
            $table->string('document_number');
            $table->string('file_number');
            $table->string('subject');
            $table->foreignId('document_type_id')->constrained('document_types');
            $table->foreignId('priority_id')->constrained('priorities');
            $table->foreignId('administration_id')->constrained('administrations');
            $table->string('sender_type');
            $table->foreignId('sender_user_id')->constrained('users');
            $table->foreignId('destination_office_id')->constrained('offices');
            $table->foreignId('destination_user_id')->constrained('users');
            $table->text('content');
            $table->date('document_date');
            $table->date('response_deadline');
            $table->string('status');
            $table->foreignId('reference_document_id')->nullable()->constrained('documents');
            $table->foreignId('registered_by_user_id')->constrained('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('documents');
    }
};
