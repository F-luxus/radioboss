<?php

namespace RadioBoss\Object;

class Encoder {

    private $index;
    private $status;
    private $error;

    /**
     * Encoder constructor.
     * @param $index
     * @param $status
     * @param $error
     */
    public function __construct($index, $status, $error) {
        $this->index = $index;
        $this->status = $status;
        $this->error = $error;
    }

    /**
     * Creates a encoder instance from json.
     * @param array $json
     * @return Encoder
     */
    public static function fromJson($json) {
        return new self($json["index"], $json["status"], $json["error"]);
    }

    /**
     * @return mixed
     */
    public function getIndex()
    {
        return $this->index;
    }

    /**
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @return mixed
     */
    public function getError()
    {
        return $this->error;
    }

}