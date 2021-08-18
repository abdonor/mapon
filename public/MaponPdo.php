<?php

use OAuth2\Storage\Pdo;

class MaponPdo extends Pdo
{
    public function __construct($connection, $config = array())
    {
        parent::__construct($connection, $config);
    }
}