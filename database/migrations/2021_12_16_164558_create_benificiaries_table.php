<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBenificiariesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('benificiaries', function (Blueprint $table) {
            $table->string('uuid')->unique('uuid_UNIQUE');
            $table->string('full_name')->nullable();
            $table->integer('age')->nullable()->default(0);
            $table->string('qualification')->nullable();
            $table->integer('form_number')->nullable();
            $table->string('zone')->nullable();
            $table->string('location')->nullable();
            $table->timestamps(6);
            $table->softDeletes('deleted_at', 6);
            $table->string('district_uuid')->index('fk_benificiaries_districts1_idx');
            $table->string('benefit_uuid')->index('fk_benificiaries_benefits1_idx');
            $table->string('project_area_uuid')->index('fk_benificiaries_project_areas1_idx');
            $table->string('genre_uuid')->index('fk_benificiaries_genres1_idx');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('benificiaries');
    }
}
