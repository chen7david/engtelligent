<?php
namespace App\Model\Media;
use \Illuminate\Database\Eloquent\Model;

class TvShow extends Model
{
	protected $fillable = [
		'name',
		'description',
		'image',
		'is_published'
	];

	protected $table = 'tv_shows';

	public function getPathAttribute(){
		return config('path.tvshow.image').'/'.$this->image;
	}

	public function seasons(){
		return $this->hasMany(Season::class)->orderBy('rank');
	}

}