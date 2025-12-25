<?php
class VoucherController {
    private $voucher;
    private $data;

    function __construct() {
        $this->voucher = new VoucherModel();
    }

    function renderView($view, $data = null){
        require_once './app/view/' . $view . '.php';
    }

    function viewVoucher() {
        $action = $_GET['action'] ?? '';
        $id     = $_GET['id'] ?? null;

        if ($action === 'add') {
            $this->renderView('voucherAdd');
            return;
        }

        if ($action === 'edit' && $id) {
            $voucher = $this->voucher->getById($id);
            $this->data['voucher'] = $voucher;
            $this->renderView('voucherEdit', $this->data);
            return;
        }

        if ($action == 'hide' && isset($_GET['id'])) {
    $this->voucher->setStatus($_GET['id'], 0);
    header("Location: ?page=voucher");
    exit;
}

if ($action == 'show' && isset($_GET['id'])) {
    $this->voucher->setStatus($_GET['id'], 1);
    header("Location: ?page=voucher");
    exit;
}


        if ($action === 'saveAdd' && $_POST) {
            $this->voucher->insert($_POST);
            header("Location: ?page=voucher");
            exit;
        }

        if ($action === 'saveEdit' && $id && $_POST) {
            $this->voucher->update($id, $_POST);
            header("Location: ?page=voucher");
            exit;
        }

        // mặc định: danh sách
        $this->data['vouchers'] = $this->voucher->getAll();
        $this->renderView('voucher', $this->data);
    }
}

