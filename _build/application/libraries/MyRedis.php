<?php
require 'vendor/autoload.php';

use Predis\Client as PredisClient;

class MyRedis {
    protected $client;

    public function __construct() {
        $CI =& get_instance();
        $CI->load->config('redis');
        $redisConfig = $CI->config->item('redis');

        try {
            $this->client = new PredisClient([
                'scheme' => 'tcp',
                'host' => $redisConfig['host'],
                'port' => $redisConfig['port'],
                'timeout' => $redisConfig['timeout'],
                'password' => $redisConfig['password'],
            ]);
        } catch (Exception $e) {
            log_message('error', 'Predis connection error: ' . $e->getMessage());
        }
    }

    public function get_instance() {
        return $this->client;
    }

    // public function testRedis($key, $value) {
    //     try {
    //         // echo 'redis0001';die;
    //         $this->client->set($key, $value);
    //         return $this->client->get($key);
    //     } catch (Exception $e) {
    //         return "Error: " . $e->getMessage();
    //     }
    // }

    public function testRedis($key, $value = null) {
        try {
            if ($value === null) {
                // Get operation
                echo 'redis1111';die;
                return $this->client->get($key);
            } else {
                // Set operation
                echo 'redis0002';die;
                $this->client->set($key, $value);
                return $this->client->get($key);
            }
        } catch (Exception $e) {
            echo 'redis0003';
            return "Error: " . $e->getMessage();
        }
    }

    // Other methods can be defined here as needed
    public function set($key, $value, $expiration = 3600) {
        $this->client->set($key, $value);
        $this->client->expire($key, $expiration);
    }

    public function get($key) {
        return $this->client->get($key);
    }

    public function delete($key) {
        $this->client->del($key);
    }
}
?>