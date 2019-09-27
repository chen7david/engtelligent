<?php
namespace App\Model\User;
use \Illuminate\Database\Eloquent\Model;
use App\Model\User;
/**
* 
*/
class Avatar extends Model
{
	protected $fillable =[
		'name',
		'user_id',
		'type',
	];

	public function user(){
		return $this->belongsTo(User::class);
	}
}

