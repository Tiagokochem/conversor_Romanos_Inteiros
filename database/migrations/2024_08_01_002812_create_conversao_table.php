<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create(
            'conversao',

            function (Blueprint $table) {
                $table->id();
                $table->string('ip')->nonullable();
                $table->string('numero_romano')->nullable();
                $table->string('numero_decimal')->nullable();
                $table->timestamps();
            }
        );
    }

    public function down()
    {
        Schema::dropIfExists('conversao');
    }
};
