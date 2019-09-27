<?php
namespace App\Model\Group;
use \Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;
use App\Model\User\User;
use App\Model\Learn\Lesson;
/**
 * 
 */
class Session extends Model
{

	protected $fillable = [
		'name',
		'duration',
		'objective',
		'address_id',
		'group_id',
		'description',
	];

	public function getUpdatedAttribute(){
		$date = new Carbon($this->updated_at);
		return $date->toDateString();
	}

	public function getCreatedAttribute(){
		$date = new Carbon($this->created_at);
		return $date->toDateString();
	}

	// public function delete() {
	//     $this->users()->detach();
	//     // $this->results()->delete();
	//     parent::delete();
	// }

	public function getGroupAttribute(){
		return $this->group()->get();
	}

	public function group(){
		return $this->belongsTo(Group::class);
	}

	public function lessons(){
		return $this->belongsToMany(Lesson::class);
	}




}