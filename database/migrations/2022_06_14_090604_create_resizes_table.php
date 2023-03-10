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
        Schema::create('resizes', function (Blueprint $table) {
            $table->id();
            $table->string('file_id');
            $table->string('name');
            $table->string('path');
            $table->string('extension');
            $table->string('mime_type');
            $table->string('size');
            $table->string('disk');
            $table->string('url');
            $table->string('width')->default(0);
            $table->string('height')->default(0);
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
        Schema::dropIfExists('resizes');
    }
};
