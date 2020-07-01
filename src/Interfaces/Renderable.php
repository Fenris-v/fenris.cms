<?php

namespace App\Interfaces;

/**
 * Интерфейс рендеринга объектов
 * Interface Renderable
 * @package App\Interfaces
 */
interface Renderable
{
    public function render(string $file): void;
}
