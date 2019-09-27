<?php
namespace App\Model\Learn;
use \Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class LessonQuestion extends Model
{

	protected $fillable = [
		'lesson_id',
		'rank',
		'question',
		'answer',
	];

	protected $table ='lesson_questions';

	public function getUpdatedAttribute(){
		$date = new Carbon($this->updated_at);
		return $date->toDateString();
	}

	public function getCreatedAttribute(){
		$date = new Carbon($this->created_at);
		return $date->toDateString();
	}

	public function lesson(){
		return $this->belongsTo(Lesson::class);
	}

}