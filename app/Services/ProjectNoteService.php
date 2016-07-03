<?php

namespace CodeProject\Services;

use CodeProject\Repositories\ProjectNoteRepository;
use CodeProject\Validators\ProjectNoteValidator;

class ProjectNoteService
{
	protected $repository;
	protected $validator;

	public function __construct(ProjectNoteRepository $repository, ProjectNoteValidator $validator)
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