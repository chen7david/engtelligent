<?php
namespace Core\Model;
use \Illuminate\Database\Eloquent\Model;


use Core\Model\User;
/**
 * 
 */
class Email  extends Model
{
	protected $fillable = [
		'email',
		'is_verified',
		'is_primary',
		'hash'
	];


	public function user(){
		return $this->belongsTo(User::class);
	}

	public function getUserAttribute(){
		return $this->user()->latest()->first();
	}

	public function is_verified(){
		if ($this->is_verified == true) {
			return true;
		}
	}

	public function makePrimary($email){

	}

	public function is_primary(){
		return $this->is_primary;
	}


}