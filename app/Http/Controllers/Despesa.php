<?php

namespace App\Http\Controllers;

use App\Http\Resources\DespesaResource;
use App\Models\Despesas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\api\responseController as responseController;
use App\Mail\despesaEmail;
use Illuminate\Support\Facades\Mail;

class Despesa extends responseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $despesas = Despesas::where('user_id', Auth::user()->id)->get();

        return $this->sendResponse(DespesaResource::collection($despesas), 'Listagem de despesas.');
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

        $validator = Validator::make($input, [
            'description' => 'required|max:191',
            'data' => 'required|before:today',
            'value' => 'required|numeric|integer'
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $input['user_id'] = Auth::user()->id;

        $despesas = Despesas::create($input);
        Mail::to(Auth::user()->email)->send(new despesaEmail($input));

        return $this->sendResponse(new DespesaResource($despesas), 'Despesa Cadastrada com sucesso');
    }


 /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $despesa = Despesas::find($id);

        if (is_null($despesa)) {
            return $this->sendError('Nenhuma despesa encontrada');
        }

        return $this->sendResponse(new DespesaResource($despesa), 'Visualize com mais detalhes sua despesa');
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

        $validator = Validator::make($input, [
            'description' => 'required|max:191',
            'data' => 'required|before:today',
            'value' => 'required|numeric|integer'
        ]);


        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $despesas = new Despesas();
        $despesas->description = $input['description'];
        $despesas->value = $input['value'];
        $despesas->data = $input['data'];
        $despesas->user_id = Auth::user()->id;

        return $this->sendResponse(new DespesaResource($despesas), 'Despesa atualizada com sucesso');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Despesas $despesas)
    {
        $despesas->delete();

        return $this->sendResponse([], 'dDespesa removida.');
    }
}
