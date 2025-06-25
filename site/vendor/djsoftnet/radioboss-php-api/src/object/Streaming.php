<?php

namespace RadioBoss\Object;

class Streaming {

    public $listeners;

    /**
     * Features constructor.
     * @param $listeners
     */
    public function __construct($listeners) {
        $this->listeners = $listeners;
    }

    /**
     * Creates a features instance from json.
     * @param array $json
     * @return Streaming
     */
    public static function fromJson($json) {
        return new self($json["listeners"]);
    }

    /**
     * @return mixed
     */
    public function getListeners()
    {
        return $this->listeners;
    }

}