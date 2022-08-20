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
        Schema::create('addresses', function (Blueprint $table) {
            $table->id();
            $table->string("rua");
            $table->string("bairro");
            $table->string("cidade");
            $table->string("uf");
            $table->string("cep");
            $table->string("complemento");
            $table->unsignedBigInteger("id_customer");
            $table->timestamps();
        });

        Schema::table("addresses", function (Blueprint $table) {
            $table->foreign("id_customer")->references("id")->on("customers")->onDelete("cascade");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('addresses');
    }
};
