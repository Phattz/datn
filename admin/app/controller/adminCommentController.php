    <?php
    class CommentAdminController
    {
        private $comment;
        private $data;

        function __construct()
        {
            $this->comment = new ProductCommentModel();
        }

        function renderView($view, $data = null)
        {
            $view = './app/view/' . $view . '.php';
            require_once $view;
        }

        function viewCmt()
        {
            $this->data['listcmt'] = $this->comment->getCommentAndNameUser();
            $this->renderView('comment', $this->data);
        }

        function CmtDetail()
        {
            if (isset($_GET['page']) && $_GET['page'] === 'commentDetail' && isset($_GET['id'])) {
                $id = $_GET['id'];
                $this->data['cmtct'] = $this->comment->getCommentDetail($id);
            }
            return $this->renderView('commentDetail', $this->data);
        }
    }
