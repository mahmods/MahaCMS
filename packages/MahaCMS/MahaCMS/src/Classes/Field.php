<?php
namespace MahaCMS\MahaCMS\Classes;

class Field {
    public $name;
    public $value;

    public function name($name)
    {
        $this->name = $name;

        return $this;
    }

    public function value($value)
    {
        $this->value = $value;

        return $this;
    }
}