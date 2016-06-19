<?php

namespace CodeProject\Http\Controllers;

use Illuminate\Http\Request;
use CodeProject\Repositories\ClientRepository;
use CodeProject\Services\ClientService;

class ClientController extends Controller
{
    private $repository;
    private $service;

    public function __construct(ClientRepository $repository, ClientService $service)
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
        return $this->repository->all();
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
        $input = $request->all();

        $this->service->create($input);

        return ['success' => true, 'msg' => 'Cliente incluído com sucesso !'];
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try 
        {
            $this->repository->find($id);
        } 
        catch (\Exception $e) 
        {
            return ['error' => true, 'msg' => 'Opss... Houve algum problema e não foi possível localizar o Cliente desejado.'];
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
    public function update(Request $request, $id)
    {
        $input = $request->all();

        try 
        {
            $this->service->update($input, $id);
            return ['success' => true, 'Cliente alterado com sucesso !'];
        } 
        catch (ModelNotFoundException $e) 
        {
            return ['error' => true, 'msg' => 'Opss... Não encontramos o Cliente informado.'];
        }

        catch (\Exception $e) 
        {
            return ['error' => true, 'msg' => 'Opss... Houve algum problema e não foi possível alterar os dados do Cliente desejado.'];
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
        try 
        {
            $this->repository->delete($id);
            return ['success' => true, 'msg' => 'Cliente excluído com sucesso !'];
        } 
        catch (ModelNotFoundException $e) 
        {
            return ['error' => true, 'msg' => 'Opss... Não encontramos o Cliente informado.'];
        }

        catch (\Exception $e) 
        {
            return ['error' => true, 'msg' => 'Opss... Houve algum problema e não foi possível excluir o Cliente desejado.'];
        }
    }
}
