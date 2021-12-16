<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SendMailNeighborhood extends Model
{
    use HasFactory,Uuids;
    protected $table = 'send_mail_neighborhoods';
    protected $primaryKey = 'uuid';
	public $incrementing = false;

	protected $fillable = [
		'neighborhood_uuid','send_mail_uuid'
	];
}
