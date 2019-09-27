<?php 
namespace Core\Model;
use \Illuminate\Database\Eloquent\Model;

use Carbon\Carbon;
use Core\Model\Config;
use App\Model\User\User;
use Core\Model\Hash;

class Token extends Model
{
	protected $fillable = [
		'user_id',
		'auth',
		'active',
		'hash',
		'calls',
		'refresh_at'
	];

	public function delete() {
		$this->active = false;
		$this->update();
	}

	public static function get($hash){
		return self::where('hash',$hash)->latest()->first();
	}



	public function user(){
		return $this->belongsTo(User::class);
	}

	public function getUserAttribute(){
		return $this->user()->latest()->first();
	}

	public function users(){
		return $this->belongsTo(User::class);
	}

	public function logCallCount(){
		$this->increment('calls');
	}

	public function hasExpired(){
		return Carbon::parse($this->updated_at)->addSeconds(Config::get('cookie.duration'))->isPast();
	}

	public function isActive(){
		return $this->active;
	}

	public function refreshAt(){
		$this->refresh_at = Carbon::NOW()->addSeconds(Config::get('cookie.duration'));
		return $this->update();
	}

	public function refreshIn(){
		$startTime = Carbon::parse($this->refresh_at);
		$diff =  $startTime->diffInSeconds(Carbon::NOW());	
		return $diff;
	}

}