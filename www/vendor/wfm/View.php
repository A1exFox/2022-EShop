<?php

namespace wfm;

class View
{
    public string $content = '';
    public function __construct(
        public $route,
        public $layout = '',
        public $view = '',
        public $meta = [],
    )
    {
        if ($this->layout !== false) {
            $this->layout = $this->layout ?: LAYOUT;
        }
    }
    public function render($data)
    {
        if (is_array($data))
            extract($data);
        $prefix = str_replace('\\', '/', $this->route['admin_prefix']);
        $view_file = APP . "/views/{$prefix}{$this->route['controller']}/{$this->view}.php";
        if (is_file($view_file)) {
            ob_start();
            require_once $view_file;
            $this->content = ob_get_clean();
        } else {
            throw new \Exception("View file: <b>{$view_file}</b> is not found", 500);
        }
        if ($this->layout !== false) {
            $layout_file = APP . "/views/layouts/{$this->layout}.php";
            if (is_file($layout_file)) {
                require_once $layout_file;
            } else {
                throw new \Exception("Layout file: <b>{$layout_file}</b> is not found", 500);
            }
        }
    }
}














