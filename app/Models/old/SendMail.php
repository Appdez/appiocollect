<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SendMail extends Model
{
    use HasFactory,Uuids;
    protected $table = 'send_mails';
    protected $primaryKey = 'uuid';
	public $incrementing = false;

	protected $fillable = [
		'email'
	];

    public function neighborhoods()
    {
        return $this->belongsToMany(Neighborhood::class,'send_mail_neighborhoods')->as('send_mail_neighborhoods');
    }
}
