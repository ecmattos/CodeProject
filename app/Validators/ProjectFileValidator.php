<?php

namespace CodeProject\Validators;

use Prettus\Validator\LaravelValidator;

class ProjectFileValidator extends LaravelValidator
{
	protected $rules = [
		'file' 			=> 'required',
		'project_id'	=> 'required',
		'name'			=> 'required',
    	'description'	=> 'required'
	];
}