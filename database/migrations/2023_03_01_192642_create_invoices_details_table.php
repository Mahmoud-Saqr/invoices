<?php

//use Illuminate\Database\Migrations;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Illuminate\Database\Migrations\Migration
{
    /*
    * Run the migrations.
    */
    public function up(): void
    {
        Schema::create('invoices_details', function (Blueprint $table) {
            $table -> bigIncrements('id');
            $table -> unsignedBigInteger('id_invoices');
            $table -> string('invoice_number', 50);
            $table -> foreign('id_invoices') -> references('id') -> on('invoices') -> onDelete('cascade');
            $table -> string('section');
            $table -> string('product');
            $table -> string('status', 50);
            $table -> integer('value_status');
            $table -> text('note') -> nullable();
            $table -> date('payment_date') -> nullable();
            $table -> string('user');
            $table -> timestamps();
        });
    }

    /*
    * Reverse the migrations.
    php artisan migrate:status
    */
    public function down(): void
    {
        Schema::dropIfExists('invoices_details');
    }

};



