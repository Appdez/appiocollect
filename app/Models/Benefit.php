<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Benefit
 * 
 * @property string $uuid
 * @property string|null $deleted_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $name
 * 
 * @property Collection|Benificiary[] $benificiaries
 *
 * @package App\Models
 */
class Benefit extends Model
{
	use SoftDeletes;
	protected $table = 'benefits';
	protected $primaryKey = 'uuid';
	public $incrementing = false;

	protected $fillable = [
		'name'
	];

	public function benificiaries()
	{
		return $this->hasMany(Benificiary::class, 'benefit_uuid');
	}
}
