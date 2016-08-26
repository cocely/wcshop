<?php

defined("BASE_PATH") OR exit("No direct script access allowed");

class Config
{
    private static $config = array
    (
        // HTML
        "html_lang"        => "pt-br",
        "html_charset"     => "utf-8",
        "html_viewport"    => "width=device-width, initial-scale=1.0",
        "html_description" => "Online shop for World Of Warcraft private servers",
        "html_keywords"    => "wow shop, wow donate, shop, store, wow core, mthsena",
        "html_author"      => "WoW Core",
        "html_robots"      => "index, follow",
        "html_title"       => "WC Shop - Online shop for World Of Warcraft",

        // DATABASE
        "db_host"    => "127.0.0.1",
        "db_port"    => "3306",
        "db_user"    => "trinity",
        "db_pass"    => "trinity",
        "db_charset" => "utf8",

        // VIEW
        "view_default" => "login",

        // SOAP - Set [SOAP.Enabled = 1] in the worldserver.conf file
        "soap_host" => "127.0.0.1",
        "soap_port" => "7878",
        "soap_user" => "account",
        "soap_pass" => "password"
    );

    public static function load($config)
    {
        return self::$config[$config];
    }
}
