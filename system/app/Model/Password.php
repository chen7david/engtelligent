<?php
namespace Core\Model;
use \Illuminate\Database\Eloquent\Model;

use Core\Model\User;
/**
 * 
 */
class Password extends Model
{

	protected $fillable = [
		'password',
		'salt',
		'hash',
	];

	public function getUserAttribute(){
		return $this->user()->latest()->first();
	}

	public function user(){
		return $this->belongsTo(User::class);
	}


}