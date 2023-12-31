<?php

namespace App\Http\Controllers;

use App\Mail\NovaTarefaMail;
use App\Models\Tarefa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Barryvdh\DomPDF\Facade\Pdf;

class TarefaController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        
        /*Essa é uma das formas de utilizar(Helper)
        if(auth()->check()){
            $id = auth()->user()->id;
            $name = auth()->user()->name;
            $email = auth()->user()->email;

            return "ID: $id | nome: $name | email: $email";
        }else{
            return 'Não está logado';
        }*/

        /*if(Auth::check()){
            $id = Auth::user()->id;
            $name = Auth::user()->name;
            $email = Auth::user()->email;

            return "ID: $id | nome: $name | email: $email";
        }else{
            return 'Não está logado';
        }*/

        // $id = Auth::user()->id;
        // $name = Auth::user()->name;
        // $email = Auth::user()->email;

        // return "ID: $id | nome: $name | email: $email";

        $user_id = auth()->user()->id;
        // dd($user_id);
        // $tarefas = Tarefa::where('user_id', $user_id)->get();
        $tarefas = Tarefa::where('user_id', $user_id)->paginate(10);
        return view('tarefa.index', ['tarefas'=>$tarefas]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('tarefa.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $dados = $request->all('tarefa', 'data_limite_conclusao');
        $dados['user_id'] = auth()->user()->id;
        // dd($dados);
        $tarefa = Tarefa::create($dados);
        // dd($tarefa);
        $destinatario = auth()->user()->email;
        Mail::to($destinatario)->send(new NovaTarefaMail($tarefa));
        return redirect()->route('tarefa.show', ['tarefa' => $tarefa->id]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Tarefa $tarefa)
    {
        // dd($tarefa);
        // dd($tarefa->getAttributes());
        return view('tarefa.show', ['tarefa' => $tarefa]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Tarefa $tarefa)
    {
        // dd($tarefa);
        $user_id = auth()->user()->id;
        // dd($tarefa);
        if($tarefa->user_id == $user_id){
            return view('tarefa.edit', ['tarefa' => $tarefa]);
        }

        return view('acesso-negado');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Tarefa $tarefa)
    {
        // print_r($request->all());
        // echo '<hr>';
        // print_r($tarefa->getAttributes());

        if(!$tarefa->user_id ==  auth()->user()->id){
            return view('acesso-negado');
        }

        $tarefa->update($request->all());
        return redirect()->route('tarefa.show', ['tarefa' => $tarefa->id]);
        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tarefa $tarefa)
    {
        if(!$tarefa->user_id ==  auth()->user()->id){
            return view('acesso-negado');
        }

        $tarefa->delete();
        return redirect()->route('tarefa.index');

    }

    public function exportar(){
        
        $tarefas = auth()->user()->tarefas()->get();
        $pdf = Pdf::loadView('tarefa.pdf', ['tarefas' => $tarefas]);
        return $pdf->download('lista_de_tarefas.pdf');
    }
}
