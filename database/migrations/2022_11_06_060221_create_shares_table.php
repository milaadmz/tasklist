<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('shares', function (Blueprint $table) {
//            polymorphic relation to connect task to many users

            $table->id();
            $table->integer('task_id')->unsigned();
            $table->integer('shareable_id')->unsigned();
            $table->string('shareable_type');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('shares');
    }
};
