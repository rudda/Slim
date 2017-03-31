<?php
namespace Beltrao\model;
/**
 * Created by Rudda Beltrao
 * Date: 17/03/2017
 * Time: 20:21
 * Lab312 developer android  & php backend
 * www.lab312-icetufam.com.br
 * beltrao.rudah@gmail.com
 */
class Academico
{
    public $nome;
    public $cpf;
    public $telefone;
    public $email;
    public $rg;
    public $curso;
    public $conta;
    public $agencia;
    public $universidade;


    function __construct()
    {
        $this->nome= '';
        $this->cpf= '';
        $this->telefone= '';
        $this->email='';
        $this->rg= '';
        $this->curso= '';
        $this->conta= '';
        $this->agencia= '';
        $this->universidade= '';

    }

}