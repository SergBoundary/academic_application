<?php

namespace App\Core\Views;

class View
{
    protected string $module;
    protected string $layout;
    protected string $view;
    protected array $data = [];

    public function __construct(string $module, string $layout, string $view, array $data = [])
    {
        $this->module = $module;
        $this->layout = !empty($layout) ? $layout : 'default';
        $this->view = !empty($view) ? $view : 'index';
        $this->data = $data;
    }

    public function render(): void
    {        
        $viewFile = !empty($this->module) 
            ? MODULES . "/{$this->module}/Views/Layouts/{$this->view}.php"
            : CORE . "/Views/Layouts/{$this->view}.php"; 
        
        if (file_exists($viewFile)) {
            extract($this->data); // Делаем переменные доступными в шаблоне
            ob_start();
            require $viewFile;
            $content = ob_get_clean();

            require CORE . "/Views/Layouts/{$this->layout}.php"; // Загружаем общий шаблон
        } else {
            echo "Контент '<b>{$viewFile}</b>' не найден!";
        }
    }
}