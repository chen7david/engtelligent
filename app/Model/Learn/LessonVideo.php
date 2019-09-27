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
class LessonVideo extends Model
{

	protected $fillable = [
		'name',
		'lesson_id',
		'rank',
		'type',
		'description',
		'file_name'
	];
	protected $table = "lesson_videos";

	public function getPathAttribute(){
		return config('path.video.lesson.file').'/'.$this->file_name;
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