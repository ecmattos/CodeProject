<?php

namespace CodeProject\Services;

use CodeProject\Repositories\ProjectTaskRepository;
use CodeProject\Validators\ProjectTaskValidator;

class ProjectTaskService
{
	protected $repository;
	protected $validator;

	public function __construct(ProjectTaskRepository $repository, ProjectTaskValidator $validator)
	{
		$this->repository = $repository;
		$this->validator = $validator;
	}	

	public function create(array $data)
	{
		$this->validator->with($data)->passesOrFail();
		return $this->repository->create($data);
	}

	public function update($id, array $data)
	{
		$this->validator->with($data)->passesOrFail();
		return $this->repository->update($data, $id);
	}
}