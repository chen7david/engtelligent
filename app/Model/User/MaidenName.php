<?php
namespace App\Model\User;
use \Illuminate\Database\Eloquent\Model;
use App\Model\User;
/**
* 
*/
class MaidenName extends Model
{
	protected $fillable =[
		'maiden_name',
		'user_id'
	];
	
	public function users(){
		return $this->belongsTo(User::class);
	}

}

