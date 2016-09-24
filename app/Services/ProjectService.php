<?php

namespace CodeProject\Services;

use Prettus\Validator\Contracts\ValidatorInterface;
use CodeProject\Repositories\ProjectRepository;
use CodeProject\Validators\ProjectValidator;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Contracts\Filesystem\Factory as Storage;

class ProjectService
{
	protected $repository;
	protected $validator;
	protected $filesystem;
	protected $storage;

	public function __construct(ProjectRepository $repository, ProjectValidator $validator, FileSystem $filesystem, Storage $storage)
	{
		$this->repository = $repository;
		$this->validator = $validator;
		$this->filesystem = $filesystem;
		$this->storage = $storage;
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

	public function createFile(array $data)
	{
		$project = $this->repository->skipPresenter()->find($data['project_id']);
		$projectFile = $project->files()->create($data);

		$this->storage->put($projectFile->id . "." . $data['extension'], $this->filesystem->get($data['file'])); 
	}
}