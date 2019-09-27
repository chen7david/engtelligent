<?php
namespace App\Model\User;
use \Illuminate\Database\Eloquent\Model;
use App\Model\User;
/**
* 
*/
class NativeName extends Model
{
	protected $fillable =[
		'native_name',
		'user_id'
	];

	public function users(){
		return $this->belongsTo(User::class);
	}

}

