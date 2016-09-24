<?php

namespace CodeProject\Services;

use CodeProject\Repositories\ProjectFileRepository;
use CodeProject\Validators\ProjectFileValidator;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Contracts\Filesystem\Factory as Storage;



class ProjectFileService
{
	protected $repository;
	protected $validator;
	protected $filesystem;
	protected $storage;

	public function __construct(ProjectFileRepository $repository, ProjectFileValidator $validator, FileSystem $filesystem, Storage $storage)
	{
		$this->repository = $repository;
		$this->validator = $validator;
		$this->filesystem = $filesystem;
		$this->storage = $storage;
	}	

	public function create(array $data)
	{
		#$project = $this->repository->skipPresenter()->find($data['project_id']);
		#$projectFile = $project->files()->create($data);

		$this->validator->with($data)->passesOrFail();
		$projectFile = $this->repository->create($data);

		$this->storage->put($projectFile->id . "." . $data['extension'], $this->filesystem->get($data['file'])); 
	}

	public function destroy($fileId, $extension)
	{
		$this->storage->delete($fileId . "." . $extension); 
	}
}