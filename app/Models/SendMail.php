<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use App\Traits\Uuids;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class SendMail
 *
 * @property string $uuid
 * @property string $email
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class SendMail extends Model
{
    use Uuids,HasFactory;
	protected $table = 'send_mails';
	protected $primaryKey = 'uuid';
	public $incrementing = false;

	protected $fillable = [
		'email'
	];
}
