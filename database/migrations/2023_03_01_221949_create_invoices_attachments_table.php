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
        Schema::create('invoices_attachments', function (Blueprint $table) {
            $table -> bigIncrements('id');
            $table -> string('file_name');
            $table -> string('invoice_number', 50);
            $table -> string('created_by');
            $table -> unsignedBigInteger('invoices_id') -> nullable();
            $table -> foreign('invoices_id') -> references('id') -> on('invoices') ->onDelete('cascade');
            $table -> timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices_attachments');
    }
};
