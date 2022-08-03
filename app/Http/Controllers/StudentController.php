<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class StudentController extends Controller
{
    /* método que executa a função 'index' */
    public function index()
    {
        return view('student.index');
    }


    /* método que executa a função 'store' */
    public function store(Request $request)
    {
        /* a variável '$validator' recebe a classe 'Validator' e os métodos dela, que faz requisição
        a todos os dados listados abaixo */
        $validator = Validator::make($request->all(), [

       /* parametro */   /* requisitos da validação */
            'name'=>'required|max:191',
            'email'=>'required|email|max:191',
            'phone'=>'required|max:191',
            'course'=>'required|max:191',
        ]);

        /* se a validação falhar */
        if($validator->fails()){
        /* retorna uma resposta ao usuário em formato de json, usando os parametros abaixo */
            return response()->json([
                'status'=>400,
                'errors'=>$validator->messages()
            ]);

        /* se não */    
        }else{
        /* criada a var '$student' que recebe a classe 'Student' e seus objetos*/
            $student = new Student;

       /* var */ /* objeto */ /* recebe via ajax do input com o respectivo name */
            $student->name = $request->input('name');
            $student->email = $request->input('email');
            $student->phone = $request->input('phone');
            $student->course = $request->input('course');

            /* var '$student' executa o método 'save() para salvar os dados no banco' */
            $student->save();

            /* retorna para o ajax que efetuou o post, no formato json, os referidos dados
            para serem usados na 'view' */
            return response()->json([
                /* status '200' é que deu certo a ação */
                'status'=>200,
                'message'=>'Student Added Successfully',   
            ]);
        }
    }
}
