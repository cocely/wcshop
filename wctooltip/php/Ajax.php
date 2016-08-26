<?php

/*
    www.wowcore.com.br
*/

require_once "Database.php";

$item_id = (isset($_POST["item_id"])) ? $_POST["item_id"] : null;

if(isset($item_id))
{
    $db = new Database();
    $json = json_encode($db->get_item_data($item_id));
    exit($json);
}
else
{
    header("Location: /");
}
