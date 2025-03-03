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
        $modulePath = $this->module ? MODULES . "/{$this->module}/Views" : CORE . "/Views";
        $componentPath = $modulePath . "/Components/{$this->view}.php";
        $layoutPath = $modulePath . "/Layouts/{$this->layout}.php";

        // var_dump($componentPath);die;
        
        if (file_exists($componentPath)) {
            extract($this->data); // Делаем переменные доступными в шаблоне
            ob_start();
            require $componentPath;
            $content = ob_get_clean();

            require $layoutPath; // Загружаем шаблон
        } else {
            echo "Контент '<b>{$viewFile}</b>' не найден!";
        }
    }
}