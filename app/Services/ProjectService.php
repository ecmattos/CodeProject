<?php

namespace CodeProject\Services;

use Prettus\Validator\Contracts\ValidatorInterface;
use CodeProject\Repositories\ProjectRepository;
use CodeProject\Validators\ProjectValidator;

class ProjectService
{
	protected $repository;
	protected $validator;

	public function __construct(ProjectRepository $repository, ProjectValidator $validator)
	{
		$this->repository = $repository;
		$this->validator = $validator;
	}	

	public function create(array $data)
	{
		$this->validator->with($data)->passesOrFail(ValidatorInterface::RULE_CREATE);
		return $this->repository->create($data);
	}

	public function update($id, array $data)
	{
		$this->validator->setId($id); //funcao q set id para regra do update
		$this->validator->with($data)->passesOrFail(ValidatorInterface::RULE_UPDATE);
		return $this->repository->update($data, $id);
	}

	public function addMember(array $data)
	{
		$this->validator->with($data)->passesOrFail();
		return $this->repository->create($data);
	}

	public function removeMember(array $data)
	{
		$this->validator->with($data)->passesOrFail();
		return $this->repository->create($data);
	}
}