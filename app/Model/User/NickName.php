<?php
namespace App\Model\User;
use \Illuminate\Database\Eloquent\Model;
use App\Model\User;
/**
* 
*/
class NickName extends Model
{
	protected $fillable =[
		'nick_name',
		'user_id'
	];

	public function users(){
		return $this->belongsTo(User::class);
	}

}

