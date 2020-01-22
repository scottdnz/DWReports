<?php
namespace App\LibMongo;

require_once __DIR__ . "/../../vendor/autoload.php";

class InitialiseDatabase {
    public function mainExec() {
        Helpers::createTestData();
    }
}

//$init = new InitialiseDatabase();
//$init->mainExec();
