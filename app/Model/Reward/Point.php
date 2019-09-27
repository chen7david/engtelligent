<?php
namespace App\Model\Reward;
use \Illuminate\Database\Eloquent\Model;
use App\Model\User\User;
use Carbon\Carbon;
/**
 * 
 */
class Point extends Model
{

	protected $fillable = [
		'creator_id',
		'order_id',
		'amount',
		'user_id',
		'group_id',
	];

	public function getUpdatedAttribute(){
		$date = new Carbon($this->updated_at);
		return $date->toDateString();
	}

	public function getCreatedAttribute(){
		$date = new Carbon($this->created_at);
		return $date->toDateString();
	}

	public function user(){
		return $this->belongsTo(User::class);
	}
	




}