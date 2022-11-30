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


    // индексы выбраны по полям, которые могут быть реально проблемными тип трансмиссии и т. п. - без индекса.
    // Однако нужно увидеть, как пользователи реально ищут эти машины.
    // Предположу, что самое частая комбинация - это модель & год - поэтому тут составной индекс

    public function up()


        Schema::create('data', function (Blueprint $table) {
            $table->unsignedInteger('id')->unique();
            $table->string('mark');
            $table->string('model');
            $table->string('generation')->nullable()->default(null);
            $table->year('year')->nullable()->default(null);
            $table->unsignedMediumInteger('run')->nullable()->default(null);
            $table->string('color')->nullable()->default(null);
            $table->string('body_type')->nullable()->default(null);
            $table->string('engine_type')->nullable()->default(null);
            $table->string('transmission')->nullable()->default(null);
            $table->string('gear_type')->nullable()->default(null);
            $table->unsignedInteger('generation_id')->nullable()->default(null);
            $table->unsignedTinyInteger('in_xml')->nullable()->default(0);
            $table->index('mark');
            $table->index('model');
            $table->index(['model', 'year']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('data');
    }
};
