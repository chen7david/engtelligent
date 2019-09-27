<?php
namespace App\Model\User;
use \Illuminate\Database\Eloquent\Model;
use App\Model\User;
/**
* 
*/
class Referral extends Model
{
	protected $fillable =[
		'referral_id',
		'user_id'
	];

	public function users(){
		return $this->belongsTo(User::class);
	}

	public function addReferral($id){
		return $this->users()->attach($id);
	}



}

