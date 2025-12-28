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
        Schema::create('documents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->constrained('customers')->onDelete('cascade');
            $table->string('document_number')->unique(); // número de trámite único
            $table->string('case_number')->unique();
            $table->string('subject');
            $table->string('origen'); // interno / externo
            $table->foreignId('document_type_id')->constrained('document_types')->onDelete('cascade');
            $table->foreignId('area_origen_id')->constrained('offices')->onDelete('cascade'); // ✅ corregido
            $table->foreignId('gestion_id')->constrained('administrations')->onDelete('cascade');
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('cascade');
            $table->string('folio')->nullable();
            $table->date('reception_date');
            $table->date('response_deadline')->nullable();
            $table->string('condition')->nullable(); // o elimínalo si no es necesario
            $table->string('status');
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
