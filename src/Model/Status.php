<?php
/**
 * Created by PhpStorm.
 * User: mr
 * Date: 10/21/16
 * Time: 12:13 PM
 */

namespace Codeninjas\API\MyStrom\REST\Model;


class Status
{
    /**
     * @var float
     */
    protected $power;

    /**
     * @var boolean
     */
    protected $relay;

    /**
     * @return float
     */
    public function getPower(): float
    {
        return $this->power;
    }

    /**
     * @param float $power
     * @return Status
     */
    public function setPower(float $power): Status
    {
        $this->power = $power;
        return $this;
    }

    /**
     * @return boolean
     */
    public function getRelay(): bool
    {
        return $this->relay;
    }

    /**
     * @param boolean $relay
     * @return Status
     */
    public function setRelay(bool $relay): Status
    {
        $this->relay = $relay;
        return $this;
    }
}
