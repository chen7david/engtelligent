<?php
namespace App\Model\Authorize;
use \Illuminate\Database\Eloquent\Model;
use App\Model\User\User;

class Authorization extends model
{
	protected $fillable = [
		'user_id',
		'code',
		'type'
	];

	protected $table = 'authorizations';

	public function getUpdatedAttribute(){
		$date = new Carbon($this->updated_at);
		return $date->toDateString();
	}

	public function getCreatedAttribute(){
		$date = new Carbon($this->created_at);
		return $date->toDateString();
	}

	public function user(){
		return $this->belongsTo(User::class);
	}
}