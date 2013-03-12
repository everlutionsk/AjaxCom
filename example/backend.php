<?php

require_once('../vendor/autoload.php');
use DM\AjaxCom\Handler;


$query = strtolower($_GET['q']);
$id = $_GET['id'];


$handler = new Handler();


$newRow = "
            <tr id='row4'>
                <td>4</td>
                <td>xxx</td>
                <td>xxx2</td>
                <td>xxx3</td>
                <td>
                dfads
                </td>
            </tr>
            ";


switch ($query) {

    case "edit":
        $handler->modal()
                    ->setTitle('test');
    break;
    case "append":
        $handler->container('#example-table tbody')->append($newRow);
    break;
    case "delete-by-id":
        $handler->container('#'.$id)->remove();       
    break;    
    case "delete-by-class":
        $handler->container('.delete-me')->remove();
    break;
}



#$handler->container('#1234')->append('fffffffffff');

#$handler->changeUrl('http://testurl.com', 10);
#$handler->callback('testfunction');
#$handler->modal()->setTitle('test')->setWidth('200');


echo json_encode($handler->respond());
