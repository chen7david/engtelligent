<?php
namespace App\Model\User;
use \Illuminate\Database\Eloquent\Model;
use App\Model\User;
use App\Model\User\Conobj;
/**
* 
*/
class Conapp extends Model
{
	protected $fillable =[
		'name',
	];

	public function conobjs(){
		return $this->hasMany(Conobj::class);
	}
}

