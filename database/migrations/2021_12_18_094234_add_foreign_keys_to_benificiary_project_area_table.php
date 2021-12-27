<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToBenificiaryProjectAreaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('benificiary_project_area', function (Blueprint $table) {
            $table->foreign('benificiary_uuid', 'fk_benificiaries_has_project_areas_benificiaries1')->references('uuid')->on('benificiaries')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->foreign('project_area_uuid', 'fk_benificiaries_has_project_areas_project_areas1')->references('uuid')->on('project_areas')->onUpdate('NO ACTION')->onDelete('NO ACTION');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('benificiary_project_area', function (Blueprint $table) {
            $table->dropForeign('fk_benificiaries_has_project_areas_benificiaries1');
            $table->dropForeign('fk_benificiaries_has_project_areas_project_areas1');
        });
    }
}
