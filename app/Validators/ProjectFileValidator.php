<?php

namespace CodeProject\Validators;

use Prettus\Validator\LaravelValidator;

class ProjectFileValidator extends LaravelValidator
{
	protected $rules = [
		'file' 			=> 'required|mimes:jpeg,jpg,png,gif,pdf,zip,doc,docx,xls,xlsx',
		'project_id'	=> 'required',
		'name'			=> 'required',
    	'description'	=> 'required'
	];
}