<?php

namespace App\Exception;

use App\Renderable;

class NotFoundException extends HttpException implements Renderable
{
    public function render(string $exceptionMsg = ''): void
    {
        require VIEW_DIR . 'error/404.php';
    }
}
