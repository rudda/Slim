<?php
namespace Beltrao\v1\app;

/**
 * Created by Rudda Beltrao
 * Date: 15/03/2017
 * Time: 03:20
 * Lab312 developer android  & php backend
 * www.lab312-icetufam.com.br
 * beltrao.rudah@gmail.com
 */

include 'query.php';
use Beltrao\v1\app\DBSettings;
use PDO;

class Auth
{

    private static function connect(){

        $settings = new DBSettings();

        try {
            $conn = new PDO('mysql:host=localhost'.';dbname=portal-aluno', 'root','');
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $conn;
        }
        
        catch(PDOException $e)
        {
            return false;
        }

    }
    
    public static  function  authentication($token)
    {
        global $QUERY_GET_TOKEN;
        $conn = Auth::connect();
        if($conn){

            $smt = $conn->prepare('select token from authentication where token = :tk');
            $smt->bindValue(':tk', $token);
            $smt->execute();

            $count = $smt->rowCount();


            if ($count == 1) {

                return true;

                die;

            }

        }

        
        return false;

    }





}
