<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->string('inv_code')->unique();
            $table->string('no_sj')->unique();
            $table->unsignedBigInteger('store_id');
            $table->string('status')->default('on created');
            $table->string('status_pembayaran')->default('Belum Lunas');
            $table->string('tgl_lunas')->nullable(true);
            $table->bigInteger('total_price')->default(0);
            $table->unsignedBigInteger("created_by")->nullable();
            $table->unsignedBigInteger("updated_by")->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('invoices');
    }
}
