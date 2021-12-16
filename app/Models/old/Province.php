<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use App\Traits\Uuids;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Province
 *
 * @property string|null $deleted_at
 * @property string $uuid
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $name
 *
 * @property Collection|Neighborhood[] $neighborhoods
 *
 * @package App\Models
 */
class Province extends Model
{
	use Uuids,HasFactory,SoftDeletes;
	protected $table = 'provinces';
	protected $primaryKey = 'uuid';
	public $incrementing = false;

	protected $fillable = [
		'name'
	];

	public function neighborhoods()
	{
		return $this->hasMany(Neighborhood::class, 'province_uuid');
	}
}
