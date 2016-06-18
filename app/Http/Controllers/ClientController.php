<?php

namespace CodeProject\Http\Controllers;

use Illuminate\Http\Request;

use CodeProject\Http\Requests;
use CodeProject\Http\Controllers\Controller;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return \CodeProject\Client::all();
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

        $client = \CodeProject\Client::create($input);

        return ['success' => true, 'Cliente incluído com sucesso !'];
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
            \CodeProject\Client::findOrFail($id);
        } 
        catch (\Exception $e) 
        {
            return ['error' => true, 'Opss... Houve algum problema e não foi possível localizar o Cliente desejado.'];
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
            \CodeProject\Client::findOrFail($id)->update($input);
            return ['success' => true, 'Cliente alterado com sucesso !'];
        } 
        catch (ModelNotFoundException $e) 
        {
            return ['error' => true, 'Opss... Não encontramos o Cliente informado.'];
        }

        catch (\Exception $e) 
        {
            return ['error' => true, 'Opss... Houve algum problema e não foi possível alterar os dados do Cliente desejado.'];
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
            \CodeProject\Client::findOrFail($id)->delete();
            return ['success' => true, 'Cliente excluído com sucesso !'];
        } 
        catch (ModelNotFoundException $e) 
        {
            return ['error' => true, 'Opss... Não encontramos o Cliente informado.'];
        }

        catch (\Exception $e) 
        {
            return ['error' => true, 'Opss... Houve algum problema e não foi possível excluir o Cliente desejado.'];
        }
    }
}
