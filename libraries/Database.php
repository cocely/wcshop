<?php

defined("BASE_PATH") OR exit("No direct script access allowed");

class Database
{
    protected $db = null;
    private $connected = false;

    public function __construct()
    {
        $db_host = Config::load("db_host");
        $db_port = Config::load("db_port");
        $db_user = Config::load("db_user");
        $db_pass = Config::load("db_pass");
        $db_charset = Config::load("db_charset");

        $dsn = "mysql:host=" . $db_host . ";port=" . $db_port . ";charset=" . $db_charset;

        if(!$this->db && !$this->connected)
        {
            try
            {
                $this->db = new PDO($dsn, $db_user, $db_pass);
                $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $this->connected = true;
            }
            catch (PDOException $e)
            {
                exit("DB ERROR: " . $e->getMessage());
            }
        }
    }

    public function __destruct()
    {
        $this->db = null;
        $this->connected = false;
    }
}
