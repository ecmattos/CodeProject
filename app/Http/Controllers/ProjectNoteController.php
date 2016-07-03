<?php

namespace CodeProject\Http\Controllers;

use Illuminate\Http\Request;
use CodeProject\Repositories\ProjectNoteRepository;
use CodeProject\Services\ProjectNoteService;

use Prettus\Validator\Exceptions\ValidatorException;

class ProjectNoteController extends Controller
{
    private $repository;
    private $service;

    public function __construct(ProjectNoteRepository $repository, ProjectNoteService $service)
    {
        $this->repository = $repository;
        $this->service = $service;
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

    /**\CodeProjectNote\Http\Middleware\VerifyCsrfToken::class,
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
        try
        {
            $input = $request->all();
            $this->service->create($input);
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
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id, $noteId)
    {
        try 
        {
            return $this->repository->findWhere(['project_id' => $id, 'id' => $noteId]);
        } 
        catch (\Exception $e) 
        {
            return 
            [
                'error' => true, 
                'message' => 'Opss... Houve algum problema e não foi possível localizar o Projeto desejado.'
            ];
        }
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
    public function update(Request $request, $id, $noteId)
    {
        try
        {
            $input = $request->all();
            $this->service->update($noteId, $input);
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
    public function destroy($noteId)
    {
        try 
        {
            $this->repository->delete($noteId);
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
}
