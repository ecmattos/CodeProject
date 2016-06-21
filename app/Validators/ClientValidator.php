<?php

namespace CodeProject\Validators;

use Prettus\Validator\LaravelValidator;

class ClientValidator extends LaravelValidator
{
	protected $rules = [
		'name'	=> 'required|max:255',
		'resposible' => 'required|max:255',
		'email' => 'required|email',
		'phone' => 'required',
		'address' => 'required'
	];
}