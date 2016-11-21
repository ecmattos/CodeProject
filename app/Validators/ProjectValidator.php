<?php

namespace CodeProject\Validators;

use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\LaravelValidator;

class ProjectValidator extends LaravelValidator
{
	protected $id;

	protected $rules = [
        'owner_id'  => 'required|integer',
        'client_id' => 'required|integer',
        'name'      => 'required',
        'progress'  => 'required|integer',
        'status'    => 'required|integer',
        'due_date'  => 'required'
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