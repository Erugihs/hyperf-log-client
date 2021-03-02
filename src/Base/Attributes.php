<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2020/10/24
 * Time: 14:36
 */

namespace STK\Client\Log\Base;

trait Attributes
{


    public function fromInt($data)
    {
        if (!is_array($data)) {
            $data = (int)$data;
        } else {
            foreach ($data as &$value) {
                $value = (int)$value;
            }
        }
        return $data;
    }

    public function fromIdObj($data)
    {
        if (!is_array($data)) {
            $data = new \MongoDB\BSON\ObjectId($data);
        } else {
            foreach ($data as &$value) {
                $data = new \MongoDB\BSON\ObjectId($value);
            }
        }
        return $data;
    }

    public function fromString($data)
    {
        if (!is_array($data)) {
            $data = (string)$data;
        } else {
            foreach ($data as &$value) {
                $data = (string)$data;
            }
        }
        return $data;
    }

    public function fromBool($data)
    {
        if (!is_array($data)) {
            $data = (bool)$data;
        } else {
            foreach ($data as &$value) {
                $data = (bool)$data;
            }
        }
        return $data;
    }
}
