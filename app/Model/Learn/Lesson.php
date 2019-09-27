<?php
namespace App\Model\Learn;
use \Illuminate\Database\Eloquent\Model;
use App\Model\User\User;
use Carbon\Carbon;
use App\Model\Group\Session;

/**
 * 
 */
class Lesson extends Model
{

	protected $fillable = [
		'name',
		'objective',
		'duration',
		'description',
		'file_name'
	];

	public function getPathAttribute(){
		return config('path.image.lesson').'/'.$this->file_name;
	}

	public function getUpdatedAttribute(){
		$date = new Carbon($this->updated_at);
		return $date->toDateString();
	}

	public function getCreatedAttribute(){
		$date = new Carbon($this->created_at);
		return $date->toDateString();
	}

	public function delete() {
	    $this->lessonvideos()->delete();
	    $this->lessonaudios()->delete();
	    parent::delete();
	}

	public function getUsersAttribute(){
		return $this->users()->get();
	}

	public function users(){
		return $this->belongsToMany(User::class);
	}

	public function sessions(){
		return $this->belongsToMany(Session::class);
	}

	public function lessonvideos(){
		return $this->hasMany(LessonVideo::class)->orderBy('rank');
	}

	public function lessonaudios(){
		return $this->hasMany(LessonAudio::class)->orderBy('rank');
	}

	public function lessonquestions(){
		return $this->hasMany(LessonQuestion::class)->orderBy('rank');
	}

	public function lessontexts(){
		return $this->hasMany(LessonText::class)->orderBy('rank');
	}

	public function lessonobjectives(){
		return $this->hasMany(LessonObjective::class)->orderBy('rank');
	}

	public function lessonwords(){
		return $this->hasMany(LessonWord::class)->orderBy('rank');
	}




}