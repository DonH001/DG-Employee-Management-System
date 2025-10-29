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
        Schema::create('employee_documents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->constrained()->onDelete('cascade');
            $table->string('document_name');
            $table->string('document_type'); // contract, resume, certificate, id_copy, etc.
            $table->string('file_path');
            $table->string('file_name');
            $table->string('mime_type');
            $table->unsignedBigInteger('file_size');
            $table->date('expiry_date')->nullable(); // For documents that expire
            $table->boolean('is_confidential')->default(false);
            $table->unsignedBigInteger('uploaded_by');
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->index(['employee_id', 'document_type']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employee_documents');
    }
};