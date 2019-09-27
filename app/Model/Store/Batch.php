<?php
namespace App\Model\Store;
use \Illuminate\Database\Eloquent\Model;
use App\Model\User\User;
use Carbon\Carbon;
use App\Model\Store\Product;
/**
 * 
 */
class Batch extends Model
{

	protected $fillable = [
		'product_id',
		'amount',
		'price',
		'expiration_date',
		'is_published'
	];

	public function getUpdatedAttribute(){
		$date = new Carbon($this->updated_at);
		return $date->toDateString();
	}

	public function getCreatedAttribute(){
		$date = new Carbon($this->created_at);
		return $date->toDateString();
	}

	public function product(){
		return $this->belongsTo(Product::class);
	}

	public function reduceAmount($amount = 1){
		if ($this->amount >= $amount) {
			$amount = $this->amount - $amount;
			$this->amount = $amount;
			$this->update();
			return $this;
		}
	}
	




}