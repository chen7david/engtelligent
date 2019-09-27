<?php
namespace App\Model\Store;
use \Illuminate\Database\Eloquent\Model;
use App\Model\User\User;
use Carbon\Carbon;
/**
 * 
 */

use App\Model\Store\Batch;

class Product extends Model
{

	protected $fillable = [
		'name',
		'description',
		'file_name',

	];

	public function getPathAttribute(){
		return config('path.image.product')."/".$this->file_name;
	}

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

	public function batches(){
		return $this->hasMany(Batch::class);
	}
	




}