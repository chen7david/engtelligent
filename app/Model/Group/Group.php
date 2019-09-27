<?php
namespace App\Model\Group;
use \Illuminate\Database\Eloquent\Model;
use App\Model\User\User;
use Carbon\Carbon;
use App\Model\Group\Session;
/**
 * 
 */
class Group extends Model
{

	protected $fillable = [
		'name',
		'objective',
		'duration',
		'description',
		'group_id'
	];

	public function getUpdatedAttribute(){
		$date = new Carbon($this->updated_at);
		return $date->toDateString();
	}

	public function getCreatedAttribute(){
		$date = new Carbon($this->created_at);
		return $date->toDateString();
	}

	public function delete() {
	    $this->users()->detach();
	    // $this->events()->delete();
	    parent::delete();
	}

	public function getUsersAttribute(){
		return $this->users()->get();
	}

	public function users(){
		return $this->belongsToMany(User::class);
	}

	public function sessions(){
		return $this->hasMany(Session::class)->orderBy('created_at','desc');
	}

	public function lessons(){
		return $this->belongsToMany(Lesson::class)->withTimestamps();
	}




}