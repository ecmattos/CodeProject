<?php

namespace CodeProject\Services;

use CodeProject\Repositories\ProjectRepository;
use CodeProject\Repositories\ProjectFileRepository;
use CodeProject\Validators\ProjectFileValidator;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Contracts\Filesystem\Factory as Storage;



class ProjectFileService
{
	protected $repository;
	protected $projectRepository;
	protected $validator;
	protected $filesystem;
	protected $storage;

	public function __construct(ProjectFileRepository $repository, ProjectRepository $projectRepository,ProjectFileValidator $validator, FileSystem $filesystem, Storage $storage)
	{
		$this->repository = $repository;
		$this->projectRepository = $projectRepository;
		$this->validator = $validator;
		$this->filesystem = $filesystem;
		$this->storage = $storage;
	}	

	public function create(array $data)
	{
		try 
		{
			$this->validator->with($data)->passesOrFail();

			$project = $this->projectRepository->skipPresenter()->find($data['project_id']);
			$projectFile = $project->files()->create($data);

			$this->storage->put($projectFile->getFileName(), $this->filesystem->get($data['file']));

			return $projectFile;

		} 
		catch (ValidatorException $e)
		{
			return
			[
				'error' => true,
				'message' => $e->getMessageBag()
			];
		}
	}

	public function update(array $data)
	{
		try 
		{
			$this->validator->with($data)->passesOrFail();

			return $this->repository->update($data, $id);
		} 
		catch (ValidatorException $e)
		{
			return
			[
				'error' => true,
				'message' => $e->getMessageBag()
			];
		}
	}

	public function getFilePath($id)
	{
		$projectFile = $this->repository->skipPresenter()->find($id);

		return $this->getBaseURL($projectFile);
	}

	public function getFileName($id)
	{
		$projectFile = $this->repository->skipPresenter()->find($id);

		return $projectFile->getFileName();
	}

	private function getBaseURL($projectFile)
	{
		switch ($this->storage->getDefaultDriver())
		{
			case 'local':
				return $this->storage->getDriver()->getAdapter()->getPathPrefix().'/'.$projectFile->getFileName();
		}
	}

	public function checkProjectOwner($projectFileId)
	{
		$userId = \Authorizer::getResourceOwnerId();
		$projectId = $this->repository->skipPresenter()->find($projectFileId)->project_id;

		return $this->projectRepository->isOwner($projectId, $userId);
	}

	public function checkProjectMember($projectFileId)
	{
		$userId = \Authorizer::getResourceOwnerId();
		$projectId = $this->repository->skipPresenter()->find($projectFileId)->project_id;

		return $this->projectRepository->hasMember($projectId, $userId);
	}

	public function checkProjectPermissions($projectFileId)
	{
		if ($this->checkProjectOwner($projectFileId) or $this->checkProjectMember($projectFileId))
		{
			return true;
		}

		return false;
	}

	public function delete($id)
	{
		$projectFileId = $this->repository->skipPresenter()->find($id);

		if ($this->storage->exists($projectFile->getFileName()))
		{
			$this->storage->delete($projectFile->getFileName());
			return $projectFile->delete();
		}
	}
}