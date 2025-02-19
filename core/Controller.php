<?php
class Controller
{
    public function view($view, $data = [])
    {
        extract($data);

        $file = __DIR__ . "/../app/Views/$view.php";

        if (!file_exists($file)) {
            die("Xatolik: '$file' fayli topilmadi!");
        }

        require_once $file;
    }
}
