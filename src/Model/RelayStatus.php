<?php
/**
 * Created by PhpStorm.
 * User: mr
 * Date: 10/21/16
 * Time: 12:13 PM
 */

namespace Codeninjas\API\MyStrom\REST\Model;


class RelayStatus
{
    /** @var  bool */
    protected $power;

    /**
     * @return boolean
     */
    public function getPower(): bool
    {
        return $this->power;
    }

    /**
     * @param boolean $power
     */
    public function setPower(bool $power)
    {
        $this->power = $power;
    }
}
