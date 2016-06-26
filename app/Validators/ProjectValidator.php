<?php

namespace CodeProject\Validators;

use Prettus\Validator\LaravelValidator;

class ProjectValidator extends LaravelValidator
{
	protected $rules = [
		'owner_id'		=> 'required|integer',
		'client_id' 	=> 'required|integer',
		'name'          => 'required',
        'description'   => 'required',
        'progress'      => 'required',
        'status'        => 'required',
        'due_date'      => 'required|date'
	];
}