<?php

namespace App\Exception;

use App\Interfaces\Renderable;

/**
 * Для ошибок связаных с проблемами рендера
 * Class NotFoundException
 * @package App\Exception
 */
class NotFoundException extends HttpException implements Renderable
{
    public function render(string $exceptionMsg = ''): void
    {
        require VIEW_DIR . 'error/404.php';
    }
}
