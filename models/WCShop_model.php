<?php

defined("BASE_PATH") OR exit("No direct script access allowed");

class WCShop_model extends Database
{
    public function is_login_valid($username, $sha_pass)
    {
        $stmt = $this->db->prepare("SELECT id FROM auth.account WHERE username = :username AND sha_pass_hash = :sha_pass");
        $stmt->bindParam(":username", $username);
        $stmt->bindParam(":sha_pass", $sha_pass);
        $stmt->execute();

        if($stmt->rowCount() > 0)
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    public function get_account_id($username)
    {
        $stmt = $this->db->prepare("SELECT id FROM auth.account WHERE username = :username");
        $stmt->bindParam(":username", $username);
        $stmt->execute();

        if($stmt->rowCount() > 0)
        {
            return $stmt->fetch(PDO::FETCH_COLUMN);
        }
        else
        {
            return 0;
        }
    }

    public function get_dp($account_id)
    {
        $stmt = $this->db->prepare("SELECT dp FROM wcshop.account_data WHERE account_id = :account_id");
        $stmt->bindParam(":account_id", $account_id);
        $stmt->execute();

        if($stmt->rowCount() > 0)
        {
            return $stmt->fetch(PDO::FETCH_COLUMN);
        }
        else
        {
            return 0;
        }
    }

    public function set_dp($account_id, $dp)
    {
        $stmt = $this->db->prepare("UPDATE wcshop.account_data SET dp = :dp WHERE account_id = :account_id");
        $stmt->bindParam(":dp", $dp);
        $stmt->bindParam(":account_id", $account_id);
        $stmt->execute();
    }

    public function get_items_store()
    {
        $stmt = $this->db->prepare("SELECT a1.item AS id, a2.name AS name, a1.price AS price FROM wcshop.item_store AS a1 LEFT JOIN world.item_template AS a2 ON a1.item = a2.entry");
        $stmt->execute();

        if($stmt->rowCount() > 0)
        {
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        else
        {
            return array();
        }
    }

    public function get_account_characters($account_id)
    {
        $stmt = $this->db->prepare("SELECT name FROM characters.characters WHERE account = :account_id");
        $stmt->bindParam(":account_id", $account_id);
        $stmt->execute();

        if($stmt->rowCount() > 0)
        {
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        else
        {
            return array();
        }
    }
}
