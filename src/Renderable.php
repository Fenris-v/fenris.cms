<?php

namespace App;

/**
 * Интерфейс рендеринга объектов
 * Interface Renderable
 * @package App
 */
interface Renderable
{
    public function render(string $file): void;
}
