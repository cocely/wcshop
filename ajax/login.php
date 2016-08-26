<?php

require_once "../libraries/Loader.php";

$user = isset($_POST["username"]) ? $_POST["username"] : null;
$pass = isset($_POST["password"]) ? $_POST["password"] : null;

if(!$user || !$pass)
{
    header("Location: /wcshop");
}

$util = new Util();

$sha_pass = $util->generate_hash($user, $pass);

$wcshop = new WCShop_model();

if($wcshop->is_login_valid($user, $sha_pass))
{
    $session = new Session();

    $session->set_session("username", $user);

    exit("1");
}
else
{
    exit("0");
}
