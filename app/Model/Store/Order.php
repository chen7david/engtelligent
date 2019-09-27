<?php
namespace App\Model\Store;
use \Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;
use App\Model\User\User;
use App\Model\Store\Batch;
/**
 * 
 */
class Order extends Model
{

	protected $fillable = [
		'user_id',
		'batch_id',
		'amount',
		'code',
		'redeemed'
	];

	public function getUpdatedAttribute(){
		$date = new Carbon($this->updated_at);
		return $date->toDateString();
	}

	public function getCreatedAttribute(){
		$date = new Carbon($this->created_at);
		return $date->toDateString();
	}

	public function setRedeemedTo(bool $bool){
		$this->redeemed = $bool;
	}

	public function redeemed(){
		return $this->redeemed;
	}
	
	public function batch(){
		return $this->belongsTo(Batch::class);
	}

	public function user(){
		return $this->belongsTo(User::class);
	}
	




}