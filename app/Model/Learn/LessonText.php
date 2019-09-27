<?php
namespace App\Model\Learn;
use \Illuminate\Database\Eloquent\Model;
use App\Model\User\User;
use Carbon\Carbon;
use App\Model\Group\Session;
use App\Model\Learn\LessonTextQuestion;
/**
 * 
 */
class LessonText extends Model
{

	protected $fillable = [
		'title',
		'subtitle',
		'author',
		'image',
		'audio',
		'rank',
		'body',
	];

	protected $table ='lesson_texts';

	public function getUpdatedAttribute(){
		$date = new Carbon($this->updated_at);
		return $date->toDateString();
	}

	public function getCreatedAttribute(){
		$date = new Carbon($this->created_at);
		return $date->toDateString();
	}

	public function getAudioPathAttribute(){
		return config('path.lesson.text.audio').'/'.$this->audio;
	}

	public function getImagePathAttribute(){
		return config('path.lesson.text.image').'/'.$this->image;
	}

	public function lesson(){
		return $this->belongsTo(Lesson::class);
	}

	public function lessontextquestions(){
		return $this->hasMany(LessonTextQuestion::class);
	}

}