<?php
namespace Beltrao\v1;

/**
 * Created by Rudda Beltrao
 * Date: 14/03/2017
 * Time: 18:44
 * Lab312 developer android  & php backend
 * www.lab312-icetufam.com.br
 * beltrao.rudah@gmail.com
 */

    require '../../vendor/autoload.php';
    
    require 'routers/routers.php';

   use Slim\App;
    use Slim\Http\Request;
    use Slim\Http\Response;

    $a = new App();
    
    $a->get('/', function (Request $r, Response $p){
        
        
        
    });


    
    
    
