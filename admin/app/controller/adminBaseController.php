<?php
class adminBaseController {
    protected function renderView($view, $data = []) {
        // Giải nén mảng $data thành biến
        extract($data);

        // Load file view
        include "app/view/$view.php";
    }
}
