<?php

namespace CodeProject\Http\Controllers;

use Illuminate\Http\Request;
use CodeProject\Repositories\ProjectFileRepository;
use CodeProject\Services\ProjectFileService;

use Prettus\Validator\Exceptions\ValidatorException;

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

    
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, $fileId)
    {
        try 
        {
            $file = $this->repository->find($fileId);
            
            $this->service->destroy($fileId, $file->extension);

            $this->repository->delete($fileId);
            
            return 
            [
                'success' => true, 
                'messsage' => 'Documento excluído com sucesso !'
            ];
        } 
        catch (ModelNotFoundException $e) 
        {
            return 
            [
                'error' => true, 
                'message' => 'Opss... Não encontramos o Documento informado.'
            ];
        }
        catch (\Exception $e) 
        {
            return 
            [
                'error' => true, 
                'message' => 'Opss... Houve algum problema e não foi possível excluir o Documento desejado.'
            ];
        }
    }
}
