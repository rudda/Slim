<?php
namespace Beltrao\teste;

/**
 * Created by Rudda Beltrao
 * Date: 17/03/2017
 * Time: 04:02
 * Lab312 developer android  & php backend
 * www.lab312-icetufam.com.br
 * beltrao.rudah@gmail.com
 */
require '../../vendor/autoload.php';

use Beltrao\v1\Database\Database;

$db = new Database();
$res = $db->login('01109801238', 'softwarelivre123');
var_dump($res);
$json = json_decode($res);
var_dump($json);
echo $json->cod;




