<?php

namespace CodeProject\Validators;

use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\LaravelValidator;

class ProjectFileValidator extends LaravelValidator
{
    protected $rules = [
        ValidatorInterface::RULE_CREATE => [
            //'project_id'	=> 'required|integer',
            'name' 			=> 'required|max:255',
            'file'			=> 'required|max:2000|mimes:jpeg,jpg,png,gif,pdf,zip,doc,docx,xls,xlsx',
            'description' 	=> 'required',
        ],
        ValidatorInterface::RULE_UPDATE => [
            //'project_id'	=> 'required|integer',
            'name' 			=> 'required|max:255',
            'description' 	=> 'required',
        ]
    ];
}
