<?php
namespace Beltrao\v1\app;
/**
 * Created by Rudda Beltrao
 * Date: 15/03/2017
 * Time: 03:35
 * Lab312 developer android  & php backend
 * www.lab312-icetufam.com.br
 * beltrao.rudah@gmail.com
 */
    
/*TABELAS DO BANCO DE DADOS*/
$TABLE_AUTHENTICATION = "authentication";
$TABLE_ACADEMICO = "academico";
$TABLE_DOCUMENTOS = "documentos";
$TABLE_INFORMES = "informes";
$TABLE_TELEFONE = "telefone";
$TABLE_USUARIO = "usuario";
$TABLE_USUARIO_DOCUMENTOS = "usuario_has_documentos";


$QUERY_GET_TOKEN = 'select token from authentication where token = :tk';

$QUERY_ALL_ACADEMICOS_ACTIVOS = "select * from usuario inner join academico where usuario.status = 1 and usuario.idusuario = academico.usuario_idusuario order by usuario.nome asc";
$QUERY_ACADEMICO_BY_ID = "select * from usuario inner join academico where usuario.idusuario = :q and usuario.idusuario = academico.usuario_idusuario";
$QUERY_ACADEMICOS_BY_NAME = "select * from usuario inner join academico where usuario.nome = :q and usuario.idusuario = academico.usuario_idusuario";

$QUERY_ALL_INFORMES="select * from $TABLE_INFORMES order by data-criacao desc";
$QUERY_INFORME_BY_NAME_OR_BODY =" select * from $TABLE_INFORMES where title = :q or body = :q ";

$QUERY_ALL_OPENED_DOCS = "select * from $TABLE_DOCUMENTOS where status = 0";
$QUERY_ALL_CLOSED_DOCS = "select * from $TABLE_DOCUMENTOS where status = 1";





