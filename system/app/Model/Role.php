<?php 
namespace Core\Model;
use \Illuminate\Database\Eloquent\Model;

use Core\Model\User;

class Role extends Model
{
	public function delete() {
		return null;
	}

	public function users(){
		return $this->belongsToMany(User::class)->withTimestamps();
	}


}