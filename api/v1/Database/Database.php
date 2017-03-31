<?php
namespace Beltrao\v1\Database;


/**
 * Created by Rudda Beltrao
 * Date: 15/03/2017
 * Time: 05:14
 * Lab312 developer android  & php backend
 * www.lab312-icetufam.com.br
 * beltrao.rudah@gmail.com
 */

use Beltrao\v1\app\DBSettings;
use PDO;
use Beltrao\model\Academico;
use Beltrao\model\Informe;
use Beltrao\model\Doc;
use Beltrao\model\User;

include (__DIR__.'/../app/Query.php');
require __DIR__.'/../../../vendor/autoload.php';
    class Database
    {
        private $db;

        function __construct()
        {

            $this->db = self::db_connect();

        }

        private static function db_connect()
        {


            try {
               $setup = new DBSettings();
               $dns = 'mysql:host='.$setup->getSettings()["host"].';dbname='.$setup->getSettings()["db-name"];
                $conn = new PDO($dns, $setup->getSettings()["user"], $setup->getSettings()["pass"], array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\''));
                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                return $conn;
            } catch (PDOException $e) {
                return false;
            }

        }

        /*usuario*/
        public function getUser($cpf)
        {

            $smt = $this->db->prepare("select * from usuario  where cpf = :cpf");
            $smt->bindValue(':cpf', $cpf);
            $smt->execute();

            if ($smt->rowCount() > 0) {
                $data = array();
                while (($result = $smt->fetch(PDO::FETCH_ASSOC)) !== false) {

                    $user = array(
                        "id" => $result['idusuario'],
                        "nome" => $result['nome'],
                        "cpf" => $result['cpf'],
                        "senha" => $result['senha'],
                        "tipo" => $result['tipo'],
                        "status" => $result['status'],
                        "cod" => 200,
                        "log" => "sucess"
                    );

                    array_push($data, $user);

                }

                $json = stripslashes(json_encode($data));
                return $json;

            } else {

                $data[] = array(
                    "cod" => "100",
                    "log" => "Nenhum usuario encontrado"
                );

                return stripslashes(json_encode($data));

            }


        }
        public function updateUserPass($cpf, $pass){

            $smt = $this->db->prepare("update usuario set senha = :pass where cpf = $cpf");
            $smt->bindValue(':pass', $pass);
            if($smt->execute()){
                
                $data[] = array("cod"=>200,
                    "log"=>"sucess"
                    ) ;
                
                return stripslashes(json_encode($data));
            }
            
            else{


                $data[] = array("cod"=>100,
                    "log"=>"error"
                ) ;

                return stripslashes(json_encode($data));
                
                
            }
            
            
        }
        public function login($user, $pass){

            $smt = $this->db->prepare("select tipo, status, nome, senha, cpf from usuario where cpf = :cpf and senha = :pass and status = 1");
            $smt->bindValue(':cpf', $user);
            $smt->bindValue(':pass', $pass);

            if($smt->execute()){
             
                if( ($result = $smt->fetch(PDO::FETCH_ASSOC) )!= false && $smt->rowCount()==1 ){

                    $data = array("cod"=> 200,
                        "log"=>"sucess",
                        'cpf'=>$result['cpf'],
                        "tipo"=> $result['tipo'],
                        "status"=> $result['status']
                    );
                    
                    return (json_encode($data));
                    
                }
               

            }else{

                $data = array("cod"=> 100,
                    "log"=>"error",
                );

                return stripcslashes(json_encode($data));
                
            }




        }
        public function putUser(User $user){
            
            
        }
        /*informes*/

        public function getInfo($id='', $tipo=1){
            $query = strcmp($id, '') !=0 ? 'where tipo =$tipo and id = $id': '';
            $smt = $this->db->query("select * from informes  $query  order by `data-criacao` desc");

            if( $smt->rowCount()>0 ) {

                while ( ($result = $smt->fetch(PDO::FETCH_ASSOC) ) != false) {

                    $data[] = $result;

                }
               /* $json = array();
                $body = array("log" => "sucess", "cod" => "100");

                array_push($json, $body);
                array_push($json, $data);*/

                return (json_encode($data));
            } 
            elseif ($smt->rowCount() ==0){

                $body = array("log" => "not results", "cod" => "200");
                return stripcslashes(json_encode($body));

            }
            else{
                $body = array("log" => "erro", "cod" => "200");
                return stripcslashes(json_encode($body));    
            }
            
        }

        public function getInfoByTitleORBody($query){

            $sql = "select * from informes where titulo like '%".$query."%' or body like '%".$query."%'";

            $smt = $this->db->prepare($sql);

            while($row = $smt->fetch(PDO::FETCH_ASSOC)){

                $data[] = $row;


            }

            return json_encode($data);



        }
        public function addInfo(Informe $new){

            $sql = 'insert into informes (titulo, body, tipo) values ( :titulo, :body, :tipo)';

            $smt = $this->db->prepare($sql);
            $smt->bindParam(':titulo', $new->titulo);
            $smt->bindParam(':body', $new->body);
            $smt->bindParam(':tipo', $new->tipo, PDO::PARAM_INT);

            if($smt->execute()){

                $data = array("log"=>'sucess', 'cod'=>200);
                return json_encode($data);

            } else{

                $data = array("log"=>'sucess', 'cod'=>200);
                return json_encode($data);
            }



        }
        public function updateInfo(Informe $informe){
            //$data = $this->getInfo($informe->id, $informe->tipo);

            $sql = "update informes set body = '$informe->body', titulo = '$informe->titulo', tipo = $informe->tipo where id = $informe->id";


            $smt = $this->db->prepare($sql);

            if($smt->execute()){

                $data = array("code"=> 200, "log"=> "sucess");

                return json_encode($data);
            }else{

                $data = array("code"=> 100, "log"=> "error");

                return json_encode($data);
            }

        }

        public function delInfo($id){

            $sql = 'delete from `portal-aluno`.`informes` where id = '.$id;
            $smt = $this->db->prepare($sql);

            if($smt->execute()){

                $data = array("cod"=> 200, "log"=> "sucess");

                return json_encode($data);
            }else{

                $data = array("cod"=> 100, "log"=> "error");

                return json_encode($data);
            }

        }
       
        
        /*academico*/
        public function getAcademicos($id = ''){

            $sql = "select * from usuario inner join academico where usuario.cpf = academico.usuario_cpf";
            $sqlID = "select * from usuario inner join academico where usuario.cpf = academico.usuario_cpf and usuario.cpf = $id";

            $query = strcmp($id , '') ==0 ? $sql : $sqlID;
            
            $smt = $this->db->query($query);

            if($smt->rowCount()>0){

                while (($result = $smt->fetch(PDO::FETCH_ASSOC)) !== false) {

                   $data[]= $result;

                }

               /* $response= array();
                $body = array("log"=> 'sucess', "cod"=>"100");
                array_push($response, $data);
                array_push( $response, $body);*/

                return json_encode($data);
            }

        }
        public function updateAcademico( Academico $academico  ){
            
            $data = json_decode($this->getAcademicos($academico->cpf));


           $academico->agencia = strcmp($academico->agencia, '')==0 || $academico->agencia == null  ? $data[0]->agencia: $academico->agencia;
           $academico->conta = strcmp($academico->conta, '')==0 || $academico->conta == null ? $data[0]->conta: $academico->conta;
           $academico->nome = strcmp($academico->nome, '')==0 ||  $academico->nome == null? $data[0]->nome: $academico->nome;
           $academico->universidade = strcmp($academico->universidade, '')==0 || $academico->universidade == null? $data[0]->universidade: $academico->universidade;
           $academico->rg = strcmp($academico->rg, '')==0 || $academico->rg == null? $data[0]->rg: $academico->rg;
           $academico->curso = strcmp($academico->curso, '')==0 || $academico->curso == null ? $data[0]->curso: $academico->curso;
           $academico->email = strcmp($academico->email, '')==0 ||  $academico->email == null ? $data[0]->email: $academico->email;


            $sqlUser = "UPDATE usuario set nome = :nome where cpf = :cpf";

            $sqlAC = 'UPDATE academico set rg = :rg, universidade = :universidade,curso = :curso, agencia = :agencia, conta = :conta, email= :email WHERE  usuario_cpf = :cpf';

            $stm = $this->db->prepare($sqlUser);
            $stm2 = $this->db->prepare($sqlAC);

            $this->db->beginTransaction();

            /*user update */
            $stm->bindParam(':cpf', $academico->cpf);
            $stm->bindParam(':nome', $academico->nome);
            $stm->execute();

            /*acd update*/
            $stm2->bindParam(':rg',$academico->rg);
            $stm2->bindParam(':universidade',$academico->universidade);
            $stm2->bindParam(':agencia',$academico->agencia);
            $stm2->bindParam(':conta',$academico->conta);
            $stm2->bindParam(':email',$academico->email);
            $stm2->bindParam(':cpf',$academico->cpf);
            $stm2->bindParam(':curso',$academico->curso);

            $stm2->execute();

            /*commit da transação, gatante que atualiza as duas tabelas ou nenhuma*/
            if( $this->db->commit() )
            {
                
                $a = array("log"=> "sucess", "cod"=>200);  
                 return json_encode($a);   
            }

            /*end*/
            else{
                
                $a = array("log"=> "error", "cod"=>100);
                return json_encode($a);
            }
                
        }
        
        /*docs*/
        public function getDocs($id='', $status= 1){

            $sql = "select * from documentos order by data_criacao desc ";
            $sqlID = "select * from documentos where status = $status order by data_criacao desc";
            $query = strcmp($id, '')==0 ? $sql : $sqlID;
            
            $smt = $this->db->query($query);
            
            if($smt->rowCount()>0 ){


                while (($result = $smt->fetch(PDO::FETCH_ASSOC)) !== false) {
                    
                    $data[] = $result;
                    var_dump($result);
                }

                $response= array();
                $body = array("log"=> 'sucess', "cod"=>"100");
                array_push($response, $data);
                array_push( $response, $body);

                return stripcslashes(json_encode($response));
                
                
            } else{
                $response= array();
                $body = array("log"=> 'error', "cod"=>"200");
                array_push( $response, $body);

                return stripcslashes(json_encode($response));

            }
            
            
        }
        public function addDoc(Doc $doc){

            $sql = 'insert into documentos(ano, titulo, descricao, arquivo ) values (:aa, :bb, :cc, :dd)';

            $smt = $this->db->prepare($sql);
            $smt->bindParam(':aa', $doc->ano);
            $smt->bindParam(':bb', $doc->titulo);
            $smt->bindParam(':cc', $doc->descricao);
            $smt->bindParam(':dd', $doc->arquivo);

            if($smt->execute()){

                $data = array("log"=>"sucess", "cod"=>200);
                return json_encode($data);
            }else{
                $data = array("log"=>"error", "cod"=>100);
                return json_encode($data);

            }



        }

        
        
    }
