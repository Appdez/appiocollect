<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToBenificiaryBenefitTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('benificiary_benefit', function (Blueprint $table) {
            $table->foreign('benefit_uuid', 'fk_benificiaries_has_benefits_benefits1')->references('uuid')->on('benefits')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->foreign('benificiary_uuid', 'fk_benificiaries_has_benefits_benificiaries1')->references('uuid')->on('benificiaries')->onUpdate('NO ACTION')->onDelete('NO ACTION');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('benificiary_benefit', function (Blueprint $table) {
            $table->dropForeign('fk_benificiaries_has_benefits_benefits1');
            $table->dropForeign('fk_benificiaries_has_benefits_benificiaries1');
        });
    }
}
