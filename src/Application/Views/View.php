<?php

namespace App\Application\Views;

abstract class View
{
    protected $content;
    protected $title;
    const templatesDir = __DIR__ . '\templates\\';

    public function __construct()
    {
        $this->title = null;
        $this->content = null;
    }

    public function render() {
        $title = $this->title;
        $content = $this->content;
        include(self::templatesDir . "htmlTemplate.php");
    }

    public function setData(array $data)
    {
        $this->data = $data;
    }
}