<?php
namespace App\Model\User;
use \Illuminate\Database\Eloquent\Model;
use App\Model\User;
use App\Model\User\Conapp;
/**
* 
*/
class Conobj extends Model
{
	protected $fillable =[
		'text',
		'user_id',
		'conapp_id'
	];
	
	public function users(){
		return $this->belongsTo(User::class);
	}

	public function getNameAttribute(){
		return $this->conapp()->name;
	}

	public function conapp(){
		return $this->conapps()->latest()->first();
	}

	public function conapps(){
		return $this->belongsTo(Conapp::class, 'conapp_id');
	}

}

