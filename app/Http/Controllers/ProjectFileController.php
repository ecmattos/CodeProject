<?php

namespace CodeProject\Http\Controllers;

use Illuminate\Http\Request;
use CodeProject\Repositories\ProjectFileRepository;
use CodeProject\Services\ProjectFileService;

class ProjectFileController extends Controller
{
    private $repository;
    private $service;

    public function __construct(ProjectFileRepository $repository, ProjectFileService $service)
    {
        $this->repository = $repository;
        $this->service = $service;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
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
            return 
            [
                'error' => 'Access Denied';
            ];

            return response()->download($this->service->getFilePath($id));
        }
    }

    public function show($id)
    {
        if ($this->service->checkProjectPermissions($id) == false)
        {
            return 
            [
                'error' => 'Access Denied';
            ];

            return $this->repository->find($id);
        }
    }

    public function update($id)
    {
        if ($this->service->checkProjectOwner($id) == false)
        {
            return 
            [
                'error' => 'Access Denied';
            ];

            return $this->service->update($data, $id);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, $fileId)
    {
        if ($this->service->checkProjectOwner($id) == false)
        {
            return 
            [
                'error' => 'Access Denied';
            ];

            return $this->service->update($data, $id);
        }
    }
}
