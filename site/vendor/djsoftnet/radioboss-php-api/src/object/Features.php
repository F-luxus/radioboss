<?php

namespace RadioBoss\Object;

class Features {

    private $scheduler;

    /**
     * Features constructor.
     * @param $scheduler
     */
    public function __construct($scheduler) {
        $this->scheduler = $scheduler;
    }

    /**
     * Creates a features instance from json.
     * @param array $json
     * @return Features
     */
    public static function fromJson($json) {
        return new self($json["scheduler"]);
    }

    /**
     * @return mixed
     */
    public function getScheduler()
    {
        return $this->scheduler;
    }

}