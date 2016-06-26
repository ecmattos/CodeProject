<?php

namespace CodeProject\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class Project extends Model implements Transformable
{
    use TransformableTrait;

    protected $fillable = [];

    public function client()
	{
		return $this->belongsTo('CodeProject\Entities\Client'); 
	}

	public function owner()
	{
		return $this->belongsTo('CodeProject\Entities\User'); 
	}

}

