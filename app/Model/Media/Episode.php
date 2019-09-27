<?php
namespace App\Model\Media;
use \Illuminate\Database\Eloquent\Model;

class Episode extends Model
{
	protected $fillable = [
		'name',
		'description',
		'season_id',
		'rank',
		'video_file',
	];

	public function getPathAttribute(){
		return config('path.tvshow.video').'/'.$this->video_file;
	}

	public function season(){
		return $this->belongsTo(Season::class);
	}

	public function tvshow(){
		return $this->season()->tvshow();
	}

}