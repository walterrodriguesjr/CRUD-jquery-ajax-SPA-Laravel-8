@extends('layouts.app')

@section('content')
    <!-- AddStudentModal -->
    <div class="modal fade" id="AddStudentModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add Student</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <ul id="saveform_errList"></ul>

                    <div class="form-group mb-3">
                        <label for="">Name</label>
                        <input type="text" class="name form-control">
                    </div>
                    <div class="form-group mb-3">
                        <label for="">E-mail</label>
                        <input type="text" class="email form-control">
                    </div>
                    <div class="form-group mb-3">
                        <label for="">Phone</label>
                        <input type="text" class="phone form-control">
                    </div>
                    <div class="form-group mb-3">
                        <label for="">Course</label>
                        <input type="text" class="course form-control">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary add_student">Save</button>
                </div>
            </div>
        </div>
    </div>
    {{-- End-AddStudentModal --}}
    
    
    {{-- EditStudentModal--}}
    <div class="modal fade" id="EditStudentModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit & Update Student</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <ul id="updateform_errList"></ul>

                    {{-- input que traz o id dos dados buscados está ocultado --}}
                    <input type="hidden" id="edit_stud_id">

                    <div class="form-group mb-3">
                        <label for="">Name</label>
                        <input type="text" id="edit_name" class="name form-control">
                    </div>
                    <div class="form-group mb-3">
                        <label for="">E-mail</label>
                        <input type="text" id="edit_email" class="email form-control">
                    </div>
                    <div class="form-group mb-3">
                        <label for="">Phone</label>
                        <input type="text" id="edit_phone" class="phone form-control">
                    </div>
                    <div class="form-group mb-3">
                        <label for="">Course</label>
                        <input type="text" id="edit_course" class="course form-control">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary update_student">Update</button>
                </div>
            </div>
        </div>
    </div>
    
    {{-- End-EditStudentModal--}}

    <div class="container py-5">
        <div class="row">
            <div class="col-md-12">

                {{-- recebe a mesagem que vem do controller de sucesso da ação via ID --}}
                <div id="success_message"></div>

                <div class="card">
                    <div class="card-header">
                        <h4>Students Data
                            {{-- responsável por abrir o modal, o 'data-bs-target="#AddStudentModal"' comunica com o 'id' principal do 'modal' --}}
                            <a href="#" data-bs-toggle="modal" data-bs-target="#AddStudentModal"
                                class="btn btn-primary float-end btn-sm">Add Student</a>
                        </h4>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>E-mail</th>
                                    <th>Phone</th>
                                    <th>Course</th>
                                    <th>Edit</th>
                                    <th>Delete</th>
                                </tr>
                            </thead>
                            <tbody>
                                
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    
    <script>
        $(document).ready(function () {

            /* chama a função criada abaixo para trazer os respectivos dados */
            fetchstudent();

            /* cria a função de buscar dados já salvos no banco e trazer para o usuário */
            function fetchstudent(){

                /* GET */
            /* a função fetchstudent() realiza um ajax de GET, trazendo os dados do banco para uso */
                $.ajax({
                    type: "GET",                /* ação */
                    url: "/fetch-students",     /* caminho */
                    dataType: "json",           /* tipo de dado gerado */
                    /* o 'response traz os dados enviados pelo back-end' */
                    success: function (response) {
                        /* console.log(response.students); */

                    /* limpa a tabela para que, quando os dados cheguem do back-end, não fique repetido,
                    limpando a tabela, trazendo o que já tem, mais o que foi adicionado */
                    $('tbody').html("");
            
            /* criado a função 'each' que utiliza os dados enviados pelo back-end via 'response' e, através 
    de um loop, traz os dados direto na tabela, usando os objetos de 'response.students' dentro de 'item' */
                        $.each(response.students, function (key, item) { 
                             $('tbody').append('<tr>\
                                <td>'+item.id+'</td>\
                                <td>'+item.name+'</td>\
                                <td>'+item.email+'</td>\
                                <td>'+item.phone+'</td>\
                                <td>'+item.course+'</td>\
                                <td><button type="button" value="'+item.id+'" class="edit_student btn btn-primary btn-sm">Edit</button></td>\
                                <td><button type="button" value="'+item.id+'" class="delete_student btn btn-danger btn-sm">Delete</button></td>\
                                </tr>');
                        });
                    }
                });
            }

            /* EDIT */
            /* função de 'click' do button com a class 'edit_student'. */
            $(document).on('click', '.edit_student', function (e) {
                e.preventDefault();  
            /* cria a var 'stud_id' que, recebe o 'val' da linha clicada. (o button tem como 'value' o 
            item.id) desta linha */
                var stud_id = $(this).val();
                
                /* abre o modal de 'edit' */
                $('#EditStudentModal').modal('show');

                /* ajax que busca o objeto pelo 'id' para serem editados*/
                $.ajax({
                    type: "GET",                    /* ação */
                    url: "/edit-student/"+stud_id,  /* caminho, com parametro 'id' */

                    /* se a ação do ajax for bem sucedida, prossegue com esta resposta */
                    success: function (response) {
                        /* console.log(response); */
                    
                    /* se a resposta for erro 404 */
                        if(response.status ==404){

                            /* a tag com id '#success_message' tem o conteúdo esvaziado*/
                            $('#success_message').html("");
                            
                            /* a tag com id '#success_message' recebe a class alert alert-danger */
                            $('#success_message').addClass('alert alert-danger');
                            
                            /* a tag com id '#success_message' recebe o texto recebido via response de erro do back-end*/
                            $('#success_message').text(response.message);

                         /* se não */   
                        }else{
                            /* os inputs com os respectivos 'id', seus 'val' recebem, via response, 
                            e os parametros trazidos via ajax do controller */

                          /* input */  /* conteudo */ /* dados trazidos via response por ajax do controller */
                            $('#edit_name').val(response.student.name);
                            $('#edit_email').val(response.student.email);
                            $('#edit_phone').val(response.student.phone);
                            $('#edit_course').val(response.student.course);
                            $('#edit_stud_id').val(response.student.id);
                        }
                    }
                });

            });

            /* UPDATE */
            /* função de 'click' do button com a class 'update_student'. */
            $(document).on('click', '.update_student', function (e) {
                e.preventDefault(); 

            /* varial 'stud_id' recebe o dado contido na tag '#edit_stud_id' (id do objeto) */
                var stud_id = $('#edit_stud_id').val();

            /* a var 'data' cria um array em que seus objetos recebem os valores dos 
            respectivos inputs do modal após o click */
                var data = {
                /* objeto   -  input do modal  */
                   'name' : $('#edit_name').val(),
                   'email' : $('#edit_email').val(),
                   'phone' : $('#edit_phone').val(),
                   'course' : $('#edit_course').val(),
                }

                $.ajax({
                    type: "PUT",                        /* ação */
                    url: "/update-student/"+stud_id,     /* caminho */
                    data: data,                         /* variavel utilizada */
                    dataType: "json",                   /* tipo de dado gerado */
                    success: function (response) {
                        
                    }
                });

                
            });

            /* função de 'click' que comunica com o 'button' de save em 'AddStudentModal' */
            $(document).on('click', '.add_student', function (e) {
                e.preventDefault();
            
            /* a var 'data' cria um array em que seus objetos recebem os valores dos 
            respectivos inputs do modal após o click */
                var data = {
                 /* objeto   -  input do modal  */
                    'name': $('.name').val(), 
                    'email': $('.email').val(),
                    'phone': $('.phone').val(),
                    'course': $('.course').val(),
                }

                /* TOKEN padrão do laravel para transportar dados via ajax */
                $.ajaxSetup({
                     headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                     }
                });

                /* POST */
                $.ajax({
                    type: "POST",      /* ação */
                    url: "/students",  /* caminho */
                    data: data,      /* variavel utilizada */ /* BUG RESOLVIDO- data estava entre aspas duplas */
                    dataType: "json",  /* tipo de dado gerado */

                    /* se a ação do ajax for bem sucedida, prossegue com esta resposta */
                    success: function (response) {

                        /* caso ocorra erro no trafego dos dados */
                        if(response.status == 400){

                            /* ação que limpa a lista sempre antes de mostrar erros */
                            $('#saveform_errList').html("");

                            /* ação que adiciona a esta 'ul' a class de alert (css) */
                            $('#saveform_errList').addClass('alert alert-danger');

                            /* este 'each' gera um loop para listar os erros */
                            /* os parametros 'status' e 'erros' vem do controller, da classe 'Validator' */
                            $.each(response.errors, function (key, err_values) { 

                                /* este append é gerado dentro do corpo do AddModal listando os erros */
                                 $('#saveform_errList').append('<li>' + err_values +'</li>');
                            });

                            
                        /* se não */    
                        }else{

                            /* esvazia a tag HTML que contém este ID */
                            $('#saveform_errList').html("");

                            console.log('teste');

                            /* a tag HTML que contem este ID recebe a class de alert success */
                            $('#success_message').addClass('alert alert-success');

                            /* a tag HTML que contem este ID recebe em seu text, via 
                            response do controller, a 'message' de sucesso da ação
                            em seguida envia para a tag HTML que contem este ID */
                            $('#success_message').text(response.message);

                            /* esconde o modal que contem este ID */
                            $('#AddStudentModal').modal('hide');

                            /* limpa os campos dos inputs deste modal */
                            $('#AddStudentModal').find('input').val("");

                            /* aciona a função 'fetchstudent' que atualiza a tabela com o que foi adicionado 
                            , mas sem dar refresh. (na parte de cima, há uma ação que limpa a tabela antes 
                            de trazer os dados com a ação desta função, para não repetir dados) */
                            fetchstudent();
                        }
                    }
                });
                
            });
        });
    </script>

@endsection
