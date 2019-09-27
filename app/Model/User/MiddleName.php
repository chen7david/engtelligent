<?php
namespace App\Model\User;
use \Illuminate\Database\Eloquent\Model;
use App\Model\User;
/**
* 
*/
class MiddleName extends Model
{
	protected $fillable =[
		'middle_name',
		'user_id'
	];
	
	public function users(){
		return $this->belongsTo(User::class);
	}

}

