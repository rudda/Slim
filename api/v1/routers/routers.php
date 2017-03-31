<?php
namespace Beltrao\v1\routers;


/**
 * Created by Rudda Beltrao
 * Date: 14/03/2017
 * Time: 18:56
 * Lab312 developer android  & php backend
 * www.lab312-icetufam.com.br
 * beltrao.rudah@gmail.com
 */

   use Beltrao\v1\app\Auth;
   use Beltrao\v1\Database\Database;
   use Slim\Http\Request;
   use Slim\Http\Response;
   use Beltrao\model\Academico;
   use Beltrao\model\Informe;
   
   $app = new \Slim\App();

   
   $app->get('/', function($request, $response, $args){

        $data[] = array("log" =>"acesso indevido");
        echo json_encode($data);

    });

    $app->get('/usuarios/{id}', function($request, $response, $args){

       if( Auth::authentication($request->getParam('token')) ){

           $db = new Database();
           $response->write($db->getUser($request->getAttribute('id')));

       }
       else{

           $data[] = array("cod"=> 500,
                            "message" => "acesso negado"
               );

       }
        

    });

    $app->post('/usuarios/{id}', function(Request $request, Response $response, $args){

        if( Auth::authentication($request->getParam('token')) ){

            $q = $request->getParam('q');
            $pass = $request->getParam('pass');
            if(strcmp($q, 'definepass')==0){

                $db = new Database();
                $response->write($db->updateUserPass($request->getAttribute('id'), $pass));

            }

        }
        else{

            $data[] = array("cod"=> 500,
                "message" => "acesso negado"
            );

        }

    });

    $app->get('/login', function(Request $request, Response $response, $args){

        $token = ($request->getQueryParam('token'));
        
      
      if( Auth::authentication($token) ){
         
           $uid = $request->getQueryParam('uid');
           $upass = $request->getQueryParam('upass');

           $db = new Database();
           $body = $db->login($uid, $upass);
           $response->write($body);
           
       }




   });

   
   
   
   /*informes*/
    $app->get('/informes[/{q}]', function (Request $request, Response $response, $args){

        $token = $request->getQueryParam('token');
        
        if($request->getAttribute('q')!= null || strcmp('search', $request->getAttribute('q'))==0){

            $db = new Database();
            $response->write( $db->getInfo($request->getParam('str')));

            
        }
        
        else if( Auth::authentication($token) ) {
        
            $db = new Database();
            $response->write( $db->getInfo());
        
        }

        });

    $app->post('/update-informe', function(Request $request, Response $response, $args){



       if(Auth::authentication($request->getParam('token')) ){

           $info = new Informe();
           $info->body = $request->getParam('body');
           $info->titulo = $request->getParam('titulo');
           $info->tipo = $request->getParam('type');
           $info->id = $request->getParam('id');

            

            $db = new Database();
           $response->write( $db->updateInfo($info));


       }


   });

    $app->put('/add-informe', function(Request $request, Response $response, $args){

                $data = $request->getParams();
               
        if(Auth::authentication($data['token']) ){
            
            $info = new Informe();
            $info->body = $data['body'];
            $info->titulo = $data['titulo'];
            $info->tipo = $data['type'];

            $db = new Database();

            
            $response->write($db->addInfo($info));

        }
    });
    
   $app->delete('/informe', function (Request $request, Response $response, $args){
       
        $data= $request->getParams();

       if(Auth::authentication($data['token'])){
           
           $db = new Database();
           $response->write($db->delInfo($data['id']));
           
       }
        
    });

   
   
    /*academicos*/
   $app->get('/academicos[/{id}]', function (Request $request, Response $response, $args){

       $token = $request->getQueryParam('token');
       $id = $request->getAttribute('id');

       if(Auth::authentication($token)){

           $db = new Database();
           $response->write( $db->getAcademicos($id) );

       }

   });

   $app->post('/academicos[/{id}]', function (Request $request, Response $response, $args){

       $token = $request->getParam('token');
       $academico = new Academico();

       $academico->nome= $request->getParam('nome');
       $academico->universidade= $request->getParam('universidade');
       $academico->cpf= $request->getParam('cpf');
       $academico->rg= $request->getParam('rg');
       $academico->conta= $request->getParam('conta');
       $academico->agencia= $request->getParam('agencia');
       $academico->curso= $request->getParam('curso');
       $academico->email= $request->getParam('email') ;
       $academico->telefone= $request->getParam('telefone');

       // $response->write('nome '.$academico->nome);

       if(Auth::authentication($token)){

           $db = new Database();
           $response->write( $db->updateAcademico($academico) );

       }

   });

   

   
   /*doc is last think to be done*/

   $app->get('/docs[/{id}]', function (Request $request, Response $response, $args){

        $token = $request->getQueryParam('token');
        $status = $request->getQueryParam('status');
        $id = $request->getAttribute('id');

        $db = new Database();
        echo $db->getDocs('1', 1);

        if(Auth::authentication($token)){

            $db = new Database();
            $db->getDocs($id, $status);


        }


    });

    



    $app->run();