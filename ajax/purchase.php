<?php

require_once "../libraries/Loader.php";

$item = isset($_POST["item"]) ? $_POST["item"] : null;
$price = isset($_POST["price"]) ? $_POST["price"] : null;
$amount = isset($_POST["amount"]) ? $_POST["amount"] : null;
$character = isset($_POST["character"]) ? $_POST["character"] : null;

$session = new Session();

if(!$session->has_session("username") || !$item || !$price || !$amount)
{
    header("Location: /wcshop");
}

$total = $price * $amount;

$username = $session->get_session("username");

$wcshop = new WCShop_model();

$account_id = $wcshop->get_account_id($username);

$cur_dp = $wcshop->get_dp($account_id);

if($cur_dp < $total)
{
    exit("2");
}

$command = '.send items ' . $character . ' "|CFFFF0000Donation Reward|r" "Thank you for your donation, enjoy!" ' . $item . ':' . $amount;

$util = new Util();

if($util->soap_connect($command))
{
    $new_dp = $cur_dp - $total;

    $wcshop->set_dp($account_id, $new_dp);

    exit("1");
}

exit("0");
