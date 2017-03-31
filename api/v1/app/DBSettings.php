<?php
namespace Beltrao\v1\app;

/**
 * Created by Rudda Beltrao
 * Date: 15/03/2017
 * Time: 03:02
 * Lab312 developer android  & php backend
 * www.lab312-icetufam.com.br
 * beltrao.rudah@gmail.com
 */
  /*configurações do servidor*/

Class DBSettings{
    
    public function getSettings(){
        
        return array(
            "host"=>'localhost',
            "user"=>"root",
            "pass"=>'',
            "db-name"=> "portal-aluno",
            "port"=>"80"
        );    
    }
}


