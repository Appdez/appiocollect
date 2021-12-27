<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class BenificiaryBenefit
 *
 * @property string $benificiary_uuid
 * @property string $benefit_uuid
 *
 * @property Benefit $benefit
 * @property Benificiary $benificiary
 *
 * @package App\Models
 */
class BenificiaryBenefit extends Model
{
	protected $table = 'benificiary_benefit';
	public $incrementing = false;
	public $timestamps = false;

    protected $fillable = [
		'benefit_uuid',
		'benificiary_uuid',
	];
    
	public function benefit()
	{
		return $this->belongsTo(Benefit::class, 'benefit_uuid');
	}

	public function benificiary()
	{
		return $this->belongsTo(Benificiary::class, 'benificiary_uuid');
	}
}
