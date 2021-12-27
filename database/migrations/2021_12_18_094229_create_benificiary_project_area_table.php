<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBenificiaryProjectAreaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('benificiary_project_area', function (Blueprint $table) {
            $table->string('benificiary_uuid')->index('fk_benfs_has_prjt_areas_benfs1_idx');
            $table->string('project_area_uuid')->index('fk_benfs_has_prjt_areas_project_ars1_idx');
            $table->bigIncrements('id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('benificiary_project_area');
    }
}
