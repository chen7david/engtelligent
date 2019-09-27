<?php
namespace App\Model\Learn;
use \Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;


/**
 * 
 */
class LessonTextQuestion extends Model
{

	protected $fillable = [
		'lesson_text_id',
		'question',
		'rank',
		'answer',
	];

	protected $table ='lesson_text_questions';

	public function getUpdatedAttribute(){
		$date = new Carbon($this->updated_at);
		return $date->toDateString();
	}

	public function getCreatedAttribute(){
		$date = new Carbon($this->created_at);
		return $date->toDateString();
	}

	public function lessontext(){
		return $this->belongsTo(LessonText::class);
	}

}