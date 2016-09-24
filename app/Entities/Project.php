<?php

namespace CodeProject\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class Project extends Model implements Transformable
{
    use TransformableTrait;

    protected $fillable = [
    	'owner_id',
    	'client_id',
    	'name',
    	'description',
    	'progress',
    	'status',
    	'due_date'
    ];

    public function client()
	{
		return $this->belongsTo('CodeProject\Entities\Client'); 
	}

	public function owner()
	{
		return $this->belongsTo('CodeProject\Entities\User'); 
	}

	public function notes()
    {
    	return $this->hasMany('CodeProject\Entities\ProjectNote');
    }

    public function members()
    {
        return $this->belongsToMany('CodeProject\Entities\User', 'project_members', 'project_id', 'member_id');
    }

    public function tasks()
    {
        return $this->hasMany('CodeProject\Entities\ProjectTask');
    }

    public function files()
    {
        return $this->hasMany('CodeProject\Entities\ProjectFile');
    }

}

