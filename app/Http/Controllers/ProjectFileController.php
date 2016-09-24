<?php

namespace CodeProject\Http\Controllers;

use Illuminate\Http\Request;
use CodeProject\Repositories\ProjectRepository;
use CodeProject\Services\ProjectService;

use Prettus\Validator\Exceptions\ValidatorException;

class ProjectFileController extends Controller
{
    private $repository;
    private $service;

    public function __construct(ProjectRepository $repository, ProjectService $service)
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
        return $this->repository->findWhere(['owner_id' => \Authorizer::getResourceOwnerId()]);
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

       $this->service->createFile($data);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if($this->checkProjectPermissions($id) == false)
        {
            return ['error' => 'Access Denied'];
        }

        return $this->repository->find($id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if($this->checkProjectOwner($id) == false)
        {
            return ['error' => 'Access Denied'];
        }

        try
        {
            $input = $request->all();
            $this->service->update($id, $input);
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

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if($this->checkProjectPermissions($id) == false)
        {
            return ['error' => 'Access Denied'];
        }

        try 
        {
            $this->repository->delete($id);
            return 
            [
                'success' => true, 
                'messsage' => 'Projeto excluído com sucesso !'
            ];
        } 
        catch (ModelNotFoundException $e) 
        {
            return 
            [
                'error' => true, 
                'message' => 'Opss... Não encontramos o Projeto informado.'
            ];
        }

        catch (\Exception $e) 
        {
            return 
            [
                'error' => true, 
                'message' => 'Opss... Houve algum problema e não foi possível excluir o Projeto desejado.'
            ];
        }
    }

    private function checkProjectOwner($projectId)
    {
        $userId = \Authorizer::getResourceOwnerId();

        return $this->repository->isOwner($projectId, $userId);
    }
 
    private function checkProjectMember($projectId)
    {
        $userId = \Authorizer::getResourceOwnerId();

        return $this->repository->hasMember($projectId, $userId);
    }

    private function checkProjectPermissions($projectId)
    {
        if ($this->checkProjectOwner($projectId) or $this->checkProjectMember($projectId))
        {
            return true;
        }

        return false;
    }
}
