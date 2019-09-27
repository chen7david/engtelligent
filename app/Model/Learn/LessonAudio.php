<?php
namespace App\Model\Learn;
use \Illuminate\Database\Eloquent\Model;
use App\Model\User\User;
use Carbon\Carbon;
use App\Model\Group\Session;
use App\Model\Learn\Lesson;
/**
 * 
 */
class LessonAudio extends Model
{

	protected $fillable = [
		'name',
		'lesson_id',
		'rank',
		'image',
		'type',
		'description',
		'file_name'
	];
	protected $table = "lesson_audios";

	public function getPathAttribute(){
		return config('path.audio.lesson.file').'/'.$this->file_name;
	}

	public function getImagePathAttribute(){
		return config('path.audio.lesson.image').'/'.$this->image;
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
	    // $this->users()->detach();
	    // $this->events()->delete();
	    parent::delete();
	}

	public function lesson(){
		return $this->belongsTo(Lesson::class);
	}




}