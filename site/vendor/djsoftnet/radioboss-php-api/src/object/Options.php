<?php

namespace RadioBoss\Object;

class Options {

    private $repeat_list;
    private $shuffle;

    /**
     * Options constructor.
     * @param $repeat_list
     * @param $shuffle
     */
    public function __construct($repeat_list, $shuffle) {
        $this->repeat_list = $repeat_list;
        $this->shuffle = $shuffle;
    }

    /**
     * Creates a options instance from json.
     * @param array $json
     * @return Options
     */
    public static function fromJson($json) {
        return new self($json["repeat_list"], $json["shuffle"]);
    }

    /**
     * @return mixed
     */
    public function getRepeatList()
    {
        return $this->repeat_list;
    }

    /**
     * @return mixed
     */
    public function getShuffle()
    {
        return $this->shuffle;
    }

}