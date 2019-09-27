<?php
namespace Core\Model;
use \Illuminate\Database\Eloquent\Model;

use Core\Model\User;
/**
 * 
 */
class Username extends Model
{

	protected $fillable = [
		'username',
		'user_id'
	];

	public function getUserAttribute(){
		return $this->user()->latest()->first();
	}

	public function user(){
		return $this->belongsTo(User::class);
	}

	public function makePrimary(){

	}

}