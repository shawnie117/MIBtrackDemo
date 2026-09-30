<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
|------------------------------------------------------------------------------
|     Redis 
|------------------------------------------------------------------------------
*/
$pass_file =  APP_STORAGE_PATH . '/redis_pass.txt';

$config['socket_type'] = 'tcp';
$config['host']        = '192.168.0.139';
$config['port']        = 4529;
$config['password']    = trim(file_get_contents($pass_file));
$config['timeout']     = 2;
$config['database']    = 0;

// $config['redis'] = array(
//     'host' => '192.168.0.139',
//     'port' => 4529,
//     'timeout' => 0,
//     'password' => 'Ab(83xnz#', // Set if Redis requires authentication
//     'database' => 0,
//     'persistent' => false
// );