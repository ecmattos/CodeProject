<?php

namespace CodeProject\Http\Controllers;

use Illuminate\Http\Request;
use CodeProject\Repositories\ProjectFileRepository;
use CodeProject\Services\ProjectFileService;
use CodeProject\Services\ProjectService;

class ProjectFileController extends Controller
{
    private $repository;
    private $service;
    private $projectService;

    public function __construct(ProjectFileRepository $repository, ProjectFileService $service, ProjectService $projectService)
    {
        $this->repository = $repository;
        $this->service = $service;
        $this->projectService = $projectService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        return $this->repository->findWhere(['project_id' => $id]);
    }

    /**\CodeProject\Http\Middleware\VerifyCsrfToken::class,
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $file = $request->file('file');
        $extension = $file->getClientOriginalExtension();

        $data['file'] = $file;
        $data['extension'] = $extension;
        $data['name'] = $request->name;
        $data['project_id'] = $request->project_id;
        $data['description'] = $request->description;

        $this->service->create($data);
    }

    public function showFile($id)
    {
        if ($this->service->checkProjectPermissions($id) == false)
        {
            return ['error' => 'Access Forbidden'];
        }

        $filePath = $this->service->getFilePath($id);
        $fileContent = file_get_contents($filePath);
        $file64 = base64_encode($fileContent);

        return [
            'file' => $file64,
            'size' => filesize($filePath),
            'name' => $this->service->getFileName($id)
        ];
    }

    public function show($projectId, $fileId)
    {
        #if ($this->service->checkProjectPermissions($id) == false)
        #{
        #    return ['error' => 'Access Forbidden'];
        #}

        return $this->repository->find($fileId);
    }

    public function update(Request $request, $id, $idFile)
    {
        $data = $request->all();
        
        $data['project_id'] = $id;
        
        if ($this->projectService->checkProjectPermissions($id) == false) 
        {
            return ['error' => 'Access Forbidden'];
        }
        
        return $this->service->update($data, $idFile);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if ($this->service->checkProjectOwner($id) == false)
        {
            return ['error' => 'Access Forbidden'];
        }

        $this->service->delete($id);
    }
}
