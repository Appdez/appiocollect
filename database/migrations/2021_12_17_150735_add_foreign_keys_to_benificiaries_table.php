<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToBenificiariesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('benificiaries', function (Blueprint $table) {
            $table->foreign('benefit_uuid', 'fk_benificiaries_benefits1')->references('uuid')->on('benefits')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->foreign('district_uuid', 'fk_benificiaries_districts1')->references('uuid')->on('districts')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->foreign('genre_uuid', 'fk_benificiaries_genres1')->references('uuid')->on('genres')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->foreign('project_area_uuid', 'fk_benificiaries_project_areas1')->references('uuid')->on('project_areas')->onUpdate('NO ACTION')->onDelete('NO ACTION');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('benificiaries', function (Blueprint $table) {
            $table->dropForeign('fk_benificiaries_benefits1');
            $table->dropForeign('fk_benificiaries_districts1');
            $table->dropForeign('fk_benificiaries_genres1');
            $table->dropForeign('fk_benificiaries_project_areas1');
        });
    }
}
