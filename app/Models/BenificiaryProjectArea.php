<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class BenificiaryProjectArea
 *
 * @property string $benificiary_uuid
 * @property string $project_area_uuid
 *
 * @property Benificiary $benificiary
 * @property ProjectArea $project_area
 *
 * @package App\Models
 */
class BenificiaryProjectArea extends Model
{
	protected $table = 'benificiary_project_area';
	public $incrementing = false;
	public $timestamps = false;
    protected $fillable = [
		'project_area_uuid',
		'benificiary_uuid',
	];

	public function benificiary()
	{
		return $this->belongsTo(Benificiary::class, 'benificiary_uuid');
	}

	public function project_area()
	{
		return $this->belongsTo(ProjectArea::class, 'project_area_uuid');
	}
}
