<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

/**
 * Модель управления подписками
 * Class Subscribe
 * @property mixed|string mail
 * @package App\Model
 */
class Subscribe extends Model
{
    public $timestamps = false;

    /**
     * @param string $mail
     * @return $this
     */
    public function setMail(string $mail): Subscribe
    {
        $this->mail = $mail;
        return $this;
    }
}
