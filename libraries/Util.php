<?php

defined("BASE_PATH") OR exit("No direct script access allowed");

class Util
{
    public function generate_hash($username, $password)
    {
        $password = sha1(strtoupper($username) . ":" . strtoupper($password));
        return strtoupper($password);
    }

    public function soap_connect($command)
    {
        try
        {
            $soap = new SoapClient(NULL, array(
                    "location" => "http://" . Loader::load_config("soap_host") . ":" . Loader::load_config("soap_port"),
                    "uri"      => "urn:TC",
                    "style"    => SOAP_RPC,
                    "login"    => Loader::load_config("soap_user"),
                    "password" => Loader::load_config("soap_pass")
                )
            );
            $soap->executeCommand(new SoapParam($command, "command"));
            return true;
        }
        catch (Exception $e)
        {
            return false;
        }
    }
}
