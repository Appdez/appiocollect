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
 * Class Neighborhood
 *
 * @property string|null $deleted_at
 * @property string $uuid
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $name
 * @property string|null $province_uuid
 *
 * @property Province|null $province
 * @property Collection|Benificiary[] $benificiaries
 * @property Collection|User[] $users
 *
 * @package App\Models
 */
class Neighborhood extends Model
{	use Uuids,HasFactory,SoftDeletes;
	protected $table = 'neighborhoods';
	protected $primaryKey = 'uuid';
	public $incrementing = false;

	protected $fillable = [
		'name',
		'province_uuid'
	];

	public function province()
	{
		return $this->belongsTo(Province::class, 'province_uuid');
	}

	public function benificiaries()
	{
		return $this->hasMany(Benificiary::class, 'neighborhood_uuid');
	}

	public function users()
	{
		return $this->hasMany(User::class, 'neighborhood_uuid');
	}
}
