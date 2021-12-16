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
 * Class PurposeOfVisit
 *
 * @property string|null $deleted_at
 * @property string $uuid
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $name
 *
 * @property Collection|Benificiary[] $benificiaries
 *
 * @package App\Models
 */
class PurposeOfVisit extends Model
{
    use Uuids,HasFactory,SoftDeletes;
	protected $table = 'purpose_of_visits';
	protected $primaryKey = 'uuid';
	public $incrementing = false;

	protected $fillable = [
		'name'
	];

	public function benificiaries()
	{
		return $this->hasMany(Benificiary::class, 'purpose_of_visit_uuid');
	}
}
