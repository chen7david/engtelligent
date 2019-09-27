<?php
namespace App\Model\User;
use Core\Model\User as BluePrint;
use App\Model\User\MiddleName;
use App\Model\User\NativeName;
use App\Model\User\NickName;
use App\Model\User\Conobj;
use App\Model\User\Referral;
use App\Model\User\Avatar;
use App\Model\Reward\Point;
use App\Model\Group\Group;
use App\Model\Store\Order;
use App\Model\Authorize\Authorization;
/**
* 
*/
class User extends BluePrint
{

	public function delete(){
		$this->middlenames()->delete();
		$this->nativenames()->delete();
		$this->nicknames()->delete();
		$this->points()->delete();
		$this->authorizations()->delete();
		$this->maidennames()->delete();
		$this->conobjs()->delete();
		parent::delete();

	}
	
	public function getMiddleNameAttribute(){
		return $this->middlename()->middle_name;
	}

	public function middlename(){
		return $this->middlenames()->latest()->first();
	}

	public function middlenames(){
		return $this->hasMany(MiddleName::class);
	}

	public function getNativeNameAttribute(){
		return $this->nativename()->native_name;
	}

	public function nativename(){
		return $this->nativenames()->latest()->first();
	}

	public function nativenames(){
		return $this->hasMany(NativeName::class);
	}

	public function getNickNameAttribute(){
		return $this->nickname()->nick_name;
	}

	public function nickname(){
		return $this->nicknames()->latest()->first();
	}

	public function nicknames(){
		return $this->hasMany(NickName::class);
	}

	public function getMaidenNameAttribute(){
		return $this->maidenname()->maiden_name;
	}

	public function maidenname(){
		return $this->maidennames()->latest()->first();
	}

	public function maidennames(){
		return $this->hasMany(MaidenName::class);
	}

	public function getConobjNumberAttribute(){
		return $this->conobj()->number;
	}

	public function conobj(){
		return $this->conobjs()->latest()->first();
	}

	public function conobjs(){
		return $this->hasMany(Conobj::class);
	}

	public function referral(){
		return $this->belongsTo(Referral::class);
	}

	public function getPointsAttribute(){
		return $this->points()->where('user_id', $this->id)->sum('amount');
	}

	public function hasFunds(int $amount){
		$wallet = $this->points()->where('user_id', $this->id)->sum('amount');
		if ($wallet>=$amount) {
			return true;
		}
	}

	public function pay(int $amount){
		$point = Point::create([
			'user_id'=>$this->id,
			'amount'=>"-".$amount
		]);
		if ($point) {
			return $this;
		}
	}

	public function deposit(int $amount){
		$point = Point::create([
			'user_id'=>$this->id,
			'amount'=>$amount
		]);
		if ($point) {
			return $this;
		}
	}

	public function points(){
		return $this->hasMany(Point::class);
	}

	public function orders(){
		return $this->allOrders()->where('redeemed',null)->orderBy('created_at','desc');
	}

	public function allOrders(){
		return $this->hasMany(Order::class);
	}

	public function redeemedOrders(){
		return $this->allOrders()->where('redeemed',1);
	}

	public function getSessionCountAttribute(){
		$count = 0;
		foreach ($this->groups as $group) {
			$count += $group->sessions()->count();
		}
		return $count;
	}

	public function groups(){
		return $this->belongsToMany(Group::class);
	}

	public function getAvatarAttribute(){
		return config('path.image.avatar').'/'.$this->avatar()->name;
	}

	public function avatar(){
		return $this->avatars()->latest()->first();
	}

	public function avatars(){
		return $this->hasMany(Avatar::class);
	}

	public function authorizations(){
		return $this->hasMany(Authorization::class);
	}
}