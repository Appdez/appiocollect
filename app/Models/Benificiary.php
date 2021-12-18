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
use Illuminate\Support\Facades\DB;

/**
 * Class Benificiary
 *
 * @property string $uuid
 * @property string|null $full_name
 * @property int|null $age
 * @property string|null $qualification
 * @property int|null $form_number
 * @property string|null $zone
 * @property string|null $location
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property string $district_uuid
 * @property string $genre_uuid
 *
 * @property District $district
 * @property Genre $genre
 * @property Collection|Benefit[] $benefits
 * @property Collection|ProjectArea[] $project_areas
 *
 * @package App\Models
 */
class Benificiary extends Model
{
    use Uuids,HasFactory,SoftDeletes;
	protected $table = 'benificiaries';
	protected $primaryKey = 'uuid';
	public $incrementing = false;

    protected function asDateTime($value)
    {
        try {
            return parent::asDateTime($value);
        } catch (\InvalidArgumentException $e) {
            return parent::asDateTime(new \DateTimeImmutable($value));
        }
    }

      public function newQuery()
    {
        $query = parent::newQuery();

        if($this->usesTimestamps()) {
            $table = $this->getTable();

            $createdAt = $this->getCreatedAtColumn();
            $updatedAt = $this->getUpdatedAtColumn();

            $query
                ->select()
                ->addSelect(DB::raw("$table.$updatedAt  as $updatedAt"))
                ->addSelect(DB::raw("$table.$createdAt  as $createdAt"));
            ; // Using CAST instead of CONCAT as it is compatible with SQLite database
        }

        return $query;
    }

	protected $casts = [
		'age' => 'int',
		'form_number' => 'int'
	];

	protected $fillable = [
		'full_name',
		'age',
		'qualification',
		'form_number',
		'zone',
		'location',
		'district_uuid',
		'genre_uuid'
	];

	public function district()
	{
		return $this->belongsTo(District::class, 'district_uuid');
	}

	public function genre()
	{
		return $this->belongsTo(Genre::class, 'genre_uuid');
	}

	public function benefits()
	{
		return $this->belongsToMany(Benefit::class, 'benificiary_benefit', 'benificiary_uuid', 'benefit_uuid');
	}

	public function project_areas()
	{
		return $this->belongsToMany(ProjectArea::class, 'benificiary_project_area', 'benificiary_uuid', 'project_area_uuid');
	}
}
