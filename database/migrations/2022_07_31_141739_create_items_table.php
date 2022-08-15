<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('brand_id');
            $table->string('name');
            $table->char('type',4);
            $table->char('category',4);
            $table->decimal('price',10,2);
            $table->integer('expiry');
            $table->longText('photo');
            $table->longText('description');
            $table->bigInteger('created_by');
            $table->bigInteger('modified_by')->nullable();
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
        Schema::dropIfExists('items');
    }
};
