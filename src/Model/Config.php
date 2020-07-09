<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Config extends Model
{
    public $timestamps = false;

    /**
     * Устанавливает размер страницы
     */
    public function setPageSize()
    {
        $perPage = $this::all()->where('name', 'per_page')->first();
        $perPage->val = $_POST['per_page'];
        $perPage->save();
    }
}
