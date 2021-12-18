<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBenificiaryBenefitTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('benificiary_benefit', function (Blueprint $table) {
            $table->string('benificiary_uuid')->index('fk_benificiaries_has_benefit1_idx');
            $table->string('benefit_uuid')->index('fk_benificiaries1_idx');
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
        Schema::dropIfExists('benificiary_benefit');
    }
}
