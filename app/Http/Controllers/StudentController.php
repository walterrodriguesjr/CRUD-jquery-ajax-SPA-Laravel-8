<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class StudentController extends Controller
{
    /* GET */
    /* método que executa a função 'index' */
    public function index()
    {
        return view('student.index');
    }

    /* método que chama a função 'fetchstudent', cria uma variavel para recebel a classe 'Student', e utiliza 
    seu método 'all()' para trazer todos os dados do banco para a variável em questão */
    public function fetchstudent()
    {
        $students = Student::all();
        
        /* retorna usando o método 'reponse()', em formato json, o response envia pelo ajax os dados,
        o parametro 'students' do response(), recebe os dados contidos na var '$students', que recebeu 
        todos os dados da classe 'Student' */
        return response()->json([
            'students'=>$students,
        ]);
    }

    /* POST (STORE) */
    /* método que executa a função 'store' */
    public function store(Request $request)
    {
       /*  print_r($_POST);
        print_r($_FILES); */
        /* a variável '$validator' recebe a classe 'Validator' e os métodos dela, que faz requisição
        a todos os dados listados abaixo */
        $validator = Validator::make($request->all(), [

            /* parametro */   /* requisitos da validação */
            'name' => 'required|max:191',
            'email' => 'required|email|max:191',
            'phone' => 'required|max:191',
            'course' => 'required|max:191',
            'profile_image' => 'required',
            
        ]);

        /* se a validação falhar */
        if ($validator->fails()) {
            /* retorna uma resposta ao usuário em formato de json, usando os parametros abaixo */
            return response()->json([
                'status' => 400,
                'errors' => $validator->messages()
            ]);

            /* se não */
        } else {
            /* criada a var '$student' que recebe a classe 'Student' e seus objetos*/
            $student = new Student;

            /* var */ /* objeto */ /* recebe via ajax do input com o respectivo name */
            $student->name = $request->input('name');
            $student->email = $request->input('email');
            $student->phone = $request->input('phone');
            $student->course = $request->input('course');
            
            /* se o array de dados enviados pelo ajax, conter um 'file'. executa */
            if($request->hasFile('profile_image')){

            $file = $request->file('profile_image');
            $fileName = time() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('public/images', $fileName);
            $student->profile_image = $fileName;
            }
          
             /* var '$student' executa o método 'save() para salvar os dados no banco' */
             $student->save();

            /* retorna para o ajax que efetuou o post, no formato json, os referidos dados
            para serem usados na 'view' */
            return response()->json([
                /* status '200' é que deu certo a ação */
                'status' => 200,
                'message' => 'Student Added Successfully',
            ]);
        }
    }

    /* EDIT */
    /* função que busca os dados por 'id' */
    public function edit($id){

    /* a variavel '$student' recebe os dados da classe 'Student' usando o método 'find' buscando por 'id' */
        $student = Student::find($id);

        /* se os dados existirem */
        if($student){

            /* retorna usando o 'response' os dados em json, com resposta '200' e o ibjeto 'student' 
            que é enviado para a view por ajax, com os dados da variável '$student' */
           return response()->json([
            'status'=>200,
            'student'=>$student,
           ]); 

           /* se não */
        }else{

            /* retorna através do 'response' via json por ajax, que ouve status 404(erro) e a mensagem 
            que não encontrou o dado */
            return response()->json([
             'status'=>404,
             'message' => 'Student Not Found',
            ]);
        }
    }

    /* UPDATE */
    public function update(Request $request, $id){
        /* a variável '$validator' recebe a classe 'Validator' e os métodos dela, que faz requisição
        a todos os dados listados abaixo */
        $validator = Validator::make($request->all(), [

            /* parametro */   /* requisitos da validação */
            'name' => 'required|max:191',
            'email' => 'required|email|max:191',
            'phone' => 'required|max:191',
            'course' => 'required|max:191',
        ]);

        /* se a validação falhar */
        if ($validator->fails()) {
            /* retorna uma resposta ao usuário em formato de json, usando os parametros abaixo */
            return response()->json([
                'status' => 400,
                'errors' => $validator->messages()
            ]);

            /* se não */
        } else {
            /* criada a var '$student' que recebe a classe 'Student' (não new) e seus objetos por $id*/
            $student = Student::find($id);

            /* se os dados existirem */
        if($student){

            /* var */ /* objeto */ /* recebe via ajax do input com o respectivo name para o update */
            $student->name = $request->input('name');
            $student->email = $request->input('email');
            $student->phone = $request->input('phone');
            $student->course = $request->input('course');

            /* var '$student' executa o método 'update() para atualizar os dados no banco deste $id' */
            $student->update();

            /* retorna para o ajax que efetuou o put, no formato json, os referidos dados
            para serem usados na 'view' */
            return response()->json([
                /* status '200' é que deu certo a ação */
                'status' => 200,
                'message' => 'Student Updated Successfully',
            ]);

            /* retorna usando o 'response' os dados em json, com resposta '200' e o ibjeto 'student' 
            que é enviado para a view por ajax, com os dados da variável '$student' */
           return response()->json([
            'status'=>200,
            'student'=>$student,
           ]); 

           /* se não */
        }else{

            /* retorna através do 'response' via json por ajax, que ouve status 404(erro) e a mensagem 
            que não encontrou o dado */
            return response()->json([
             'status'=>404,
             'message' => 'Student Not Found',
            ]); 
          }
        }
    }

    /* DELETE */
    public function destroy($id){
        /* criada a var '$student' que recebe a classe 'Student' (não new) e seus objetos por $id*/
        $student = Student::find($id);

        /* variável '$student' utiliza o método 'delete' */
        $student->delete();

        /* retorna através do 'response' via json por ajax, sucesso na ação (200) e a mensagem 
            que foi apagado com sucesso */
            return response()->json([
                'status'=>200,
                'message' => 'Student Deleted Successfully',
               ]); 
        
    }
}
