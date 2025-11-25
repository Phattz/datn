<?php
class PostCateAdminController{
    private $postCateModel;
    function __construct()
    {
        $this->postCateModel = new PostCateModel();
    }
}
?>