<?php
namespace Core\Model;
use \Illuminate\Database\Eloquent\Model;

use Core\Model\User;
/**
 * 
 */
class PhoneNumber extends Model
{

	protected $fillable = [
		'phone_number',
		'is_verified',
		'is_primary',
		'hash'
	];

	public function getUserAttribute(){
		return $this->user()->latest()->first();
	}

	public function user(){
		return $this->belongsTo(User::class);
	}

	public function is_primary(){
		return $this->is_primary;
	}

	public function makePrimary(){

	}

}