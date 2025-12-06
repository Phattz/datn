<?php
class AdminLogController {
    private $logModel;
    private $data;

    function __construct() {
        $this->logModel = new AdminLogModel();
    }

    function renderView($view, $data = null) {
        if ($data !== null) {
            extract($data);
        }
        $view = './app/view/' . $view . '.php';
        require_once $view;
    }

    function viewLogs() {
        $page = isset($_GET['p']) ? (int)$_GET['p'] : 1;
        $limit = 50;
        
        // Lọc theo bảng nếu có
        $tableFilter = isset($_GET['table']) ? $_GET['table'] : '';
        // Lọc theo hành động nếu có
        $actionFilter = isset($_GET['action']) ? $_GET['action'] : '';
        
        // Khởi tạo mảng data
        $this->data = [];
        
        try {
            if ($tableFilter) {
                $this->data['logs'] = $this->logModel->getLogsByTable($tableFilter, $limit);
            } elseif ($actionFilter) {
                $this->data['logs'] = $this->logModel->getLogsByAction($actionFilter, $limit);
            } else {
                $this->data['logs'] = $this->logModel->getLogsPaginated($page, $limit);
            }
            
            $this->data['totalLogs'] = $this->logModel->getTotalLogs();
            $this->data['currentPage'] = $page;
            $this->data['totalPages'] = ceil($this->data['totalLogs'] / $limit);
            $this->data['tableFilter'] = $tableFilter;
            $this->data['actionFilter'] = $actionFilter;
        } catch (Exception $e) {
            // Xử lý lỗi
            $this->data['logs'] = [];
            $this->data['totalLogs'] = 0;
            $this->data['currentPage'] = 1;
            $this->data['totalPages'] = 1;
            $this->data['tableFilter'] = $tableFilter;
            $this->data['actionFilter'] = $actionFilter;
            $this->data['error'] = $e->getMessage();
        }
        
        $this->renderView('log', $this->data);
    }
}
