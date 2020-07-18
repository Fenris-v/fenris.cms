<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int|mixed val
 */
class Config extends Model
{
    public $timestamps = false;

    /**
     * @param int $size
     * @return $this
     */
    public function setVal(int $size): Config
    {
        $this->val = $size;
        return $this;
    }
}
