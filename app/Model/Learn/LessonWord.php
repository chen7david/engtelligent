<?php
namespace App\Model\Learn;
use \Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class LessonWord extends Model
{

	protected $fillable = [
		'word',
		'rank',
		'phonetic',
		'hanzi',
	];

	protected $table ='lesson_words';

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