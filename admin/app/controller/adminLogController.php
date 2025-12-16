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
    $page  = isset($_GET['p']) ? (int)$_GET['p'] : 1;
    $limit = 50;
    $offset = ($page - 1) * $limit;

    $tableFilter  = $_GET['table']  ?? '';
    $actionFilter = $_GET['action'] ?? '';

    $this->data = [];

    if ($tableFilter) {
        $this->data['logs'] = $this->logModel->getLogsByTable($tableFilter, $limit, $offset);
        $totalLogs = $this->logModel->getTotalLogsByTable($tableFilter);
    } elseif ($actionFilter) {
        $this->data['logs'] = $this->logModel->getLogsByAction($actionFilter, $limit, $offset);
        $totalLogs = $this->logModel->getTotalLogsByAction($actionFilter);
    } else {
        $this->data['logs'] = $this->logModel->getLogsPaginated($page, $limit);
        $totalLogs = $this->logModel->getTotalLogs();
    }

    $this->data['totalLogs']   = $totalLogs;
    $this->data['currentPage'] = $page;
    $this->data['totalPages']  = ceil($totalLogs / $limit);
    $this->data['tableFilter'] = $tableFilter;
    $this->data['actionFilter'] = $actionFilter;

    $this->renderView('log', $this->data);
}



}
