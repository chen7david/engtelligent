<?php
namespace Core\Model;
use \Illuminate\Database\Eloquent\Model;

class Media extends Model
{

	protected $fillable = [
		'name',
		'file_name',
		'type',
		'size',
	];

	protected $table = 'media';

}