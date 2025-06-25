<?php

namespace RadioBoss;

use RadioBoss\Exception\APIUnavailableException;
use RadioBoss\Exception\RadioBossException;
use RadioBoss\Exception\UnknownAPIException;

class RadioBossAPIClient {

    private $ip;
    private $port;
    private $password;
    private $timeout;

    /**
     * RadioBossAPIClient constructor.
     * @param string $ip
     * @param int $port
     * @param string $password
     * @param int $timeout
     */
    public function __construct($ip, $port, $password = "", $timeout = 2) {
        $this->ip = $ip;
        $this->port = $port;
        $this->password = $password;
        $this->timeout = $timeout;
    }

    /**
     * @param $action
     * @return bool|string
     * @throws APIUnavailableException
     * @throws RadioBossException
     * @throws UnknownAPIException
     */
    public function request($action) {
        $curl = curl_init();
        $path = "http://" . $this->ip . ":" . $this->port . "/?pass=" . rawurlencode($this->password) . "&action=" . $action;
        curl_setopt($curl, CURLOPT_URL, $path);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, $this->timeout);
        curl_setopt($curl, CURLOPT_TIMEOUT, $this->timeout);
        $output = curl_exec($curl);

        if(curl_errno($curl)) {
            if (curl_errno($curl) == 28) {
                throw new APIUnavailableException("RadioBoss API timed out. Wrong IP/Port?");
            } else {
                throw new UnknownAPIException("Unknown error occurred.xxx".curl_errno($curl));
            }
        }
        curl_close($curl);

        if (substr($output, 0, 1) === "E") {
            throw new RadioBossException(substr(explode(":", $output)[1], 1), intval(preg_replace("/[^a-zA-Z]+/", "", explode(":", $output)[0])));
        }

        return $output;
    }
    public function cmd($action) {
        $curl = curl_init();
        $path = "http://" . $this->ip . ":" . $this->port . "/?pass=" . rawurlencode($this->password) . "&cmd=" . $action;
        curl_setopt($curl, CURLOPT_URL, $path);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, $this->timeout);
        curl_setopt($curl, CURLOPT_TIMEOUT, $this->timeout);
        $output = curl_exec($curl);

        if(curl_errno($curl)) {
            if (curl_errno($curl) == 28) {
                throw new APIUnavailableException("RadioBoss API timed out. Wrong IP/Port?");
            } else {
                throw new UnknownAPIException("Unknown error occurred.xxx".curl_errno($curl));
            }
        }
        curl_close($curl);

        if (substr($output, 0, 1) === "E") {
            throw new RadioBossException(substr(explode(":", $output)[1], 1), intval(preg_replace("/[^a-zA-Z]+/", "", explode(":", $output)[0])));
        }

        return $output;
    }
}