<?php

namespace RadioBoss\Object;

class Player {

    private $version;
    private $uptime;

    /**
     * Player constructor.
     * @param $version
     * @param $uptime
     */
    public function __construct($version, $uptime) {
        $this->version = $version;
        $this->uptime = $uptime;
    }

    /**
     * Creates a player instance from json.
     * @param array $json
     * @return Player
     */
    public static function fromJson($json) {
        return new self($json["version"], $json["uptime"]);
    }

    /**
     * @return mixed
     */
    public function getVersion()
    {
        return $this->version;
    }

    /**
     * @return mixed
     */
    public function getUptime()
    {
        return $this->uptime;
    }

}