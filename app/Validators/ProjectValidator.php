<?php

namespace CodeProject\Validators;

use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\LaravelValidator;

class ProjectValidator extends LaravelValidator
{
	protected $id;

	protected $rules = 
	[
		ValidatorInterface::RULE_CREATE => 
		[ // REGRAS PARA O CREATE
	        'owner_id'		=> 'required|integer',
			'client_id' 	=> 'required|integer',
			'name'          => 'required|unique:projects,name',
	        'description'   => 'required',
	        'progress'      => 'required',
	        'status'        => 'required',
	        'due_date'      => 'required|date'
	    ],

	    ValidatorInterface::RULE_UPDATE => 
	    [  // REGRAS PARA O UPDATE
	        'owner_id'		=> 'required|integer',
			'client_id' 	=> 'required|integer',
			'name'          => 'required|unique:projects,name',
	        'description'   => 'required',
	        'progress'      => 'required',
	        'status'        => 'required',
	        'due_date'      => 'required|date'
	    ]
	];

	public function setId($id)
	{
        $this->id = $id;
    }

	protected $messages = [
	    'required'	=> '<b>:attribute</b> >> Preenchimento obrigatório.',
        'integer' 	=> '<b>:attribute</b> >> Deve ser inteiro.',
        'unique' 	=> '<b>:attribute</b> >> Indisponível.',
        'date' 		=> '<b>:attribute</b> >> Inválido.'
    ];

    protected $attributes =
    [
    	'owner_id'		=> 'Proprietário',
		'client_id' 	=> 'Cliente',
		'name'          => 'Nome',
	    'description'   => 'Descrição',
	    'progress'      => 'Progresso',
	    'status'        => 'Situação',
	    'due_date'      => 'Data Conclusão'
    ];
}