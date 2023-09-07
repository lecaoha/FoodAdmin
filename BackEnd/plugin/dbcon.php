<?php
require __DIR__.'/vendor/autoload.php';
use Kreait\Firebase\Factory;
use Kreait\Firebase\Contract\Auth;
use Kreait\Firebase\Exception\Auth\FailedToVerifyToken;





$factory = (new Factory)
    ->withServiceAccount('foodMain.json')
    ->withDatabaseUri('https://appfood-9abc2-default-rtdb.asia-southeast1.firebasedatabase.app/');

$database = $factory->createDatabase();
$auth = $factory->createAuth();

?>