<?php

/*
    www.wowcore.com.br
*/

class Database
{
    protected $db = null;
    private $connected = false;

    public function __construct()
    {
        $db_host = "127.0.0.1";
        $db_port = "3306";
        $db_user = "trinity";
        $db_pass = "trinity";
        $db_charset = "utf8";

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

    public function get_item_data($item_id)
    {
        $stmt = $this->db->prepare("SELECT * FROM world.item_template WHERE entry = ?");
        $stmt->bindParam(1, $item_id);
        $stmt->execute();

        if($stmt->rowCount() > 0)
        {
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }
        else
        {
            return array();
        }
    }
}
