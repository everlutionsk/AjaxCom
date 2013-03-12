<?php

require_once('../vendor/autoload.php');
use DM\AjaxCom\Handler;

$query = '';

if (!empty($_GET['q'])) {
   $query = strtolower($_GET['q']); 
}

if (!empty($_GET['id'])) {
    $id = $_GET['id'];
}

$handler = new Handler();

/**
 * Normally, you would get the new row from partial
 */
$newRowId = rand(4,100);
$newRow = " <tr id='row{$newRowId}'>
                <td>{$newRowId}</td>
                <td>". (!empty($_POST['firstname'])?$_POST['firstname']:'Test') ."</td>
                <td>". (!empty($_POST['lastname'])?$_POST['lastname']:'Row') ."</td>
                <td>".  (!empty($_POST['username'])?$_POST['username']:'Love it yet?') ."</td>
                <td>
                   <a href='/example/backend.php?q=edit&id=row{$newRowId}' class='btn' data-ajaxcom>Edit</a>
                   <a href='/example/backend.php?q=delete-by-id&id=row{$newRowId}' class='btn btn-danger' data-ajaxcom>Delete</a>
                </td>
            </tr>
            ";


switch ($query) {
    case "edit":
        $handler->modal();
    break;
    case "append":
        $handler->container('#example-table tbody')->append($newRow);
    break;
    case "delete-by-id":
        $handler->container('#'.$id)->remove();       
    break;    
    case "change-url":
        $handler->changeUrl('/example/new-url');
    break;
    case "delete-by-class":
        $handler->container('.delete-me')->remove();
    break;
    case "callback":
        $handler->callback('yup');
    break;
}


echo json_encode($handler->respond());
