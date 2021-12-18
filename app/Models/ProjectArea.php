<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class ProjectArea
 *
 * @property string|null $deleted_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $name
 * @property string $uuid
 *
 * @property Collection|Benificiary[] $benificiaries
 *
 * @package App\Models
 */
class ProjectArea extends Model
{

    use Uuids,HasFactory,SoftDeletes;
	protected $table = 'project_areas';
	protected $primaryKey = 'uuid';
	public $incrementing = false;

	protected $fillable = [
		'name'
	];

	public function benificiaries()
	{
		return $this->belongsToMany(Benificiary::class, 'benificiary_project_area', 'project_area_uuid', 'benificiary_uuid');
	}
}
