<?php
namespace App\Model\Learn;
use \Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class LessonObjective extends Model
{

	protected $fillable = [
		'lesson_id',
		'objective',
		'reasoning',
		'rank',
	];

	protected $table ='lesson_objectives';

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