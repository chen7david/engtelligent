<?php
namespace App\Model\Media;
use \Illuminate\Database\Eloquent\Model;

class Season extends Model
{
	protected $fillable = [
		'tv_show_id',
		'rank',
		'description',
	];

	public function episodes(){
		return $this->hasMany(Episode::class)->orderBy('rank');
	}

	public function tvshow(){
		return $this->belongsTo(TvShow::class,'tv_show_id');
	}

}