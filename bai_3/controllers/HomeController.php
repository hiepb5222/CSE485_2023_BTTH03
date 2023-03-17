<?php
require_once "services/ArticleService.php";
require_once "services/MemberService.php";
require "controllers/BaseController.php";
class HomeController extends BaseController
{
    // Hàm xử lý hành động index
    public function index()
    {
        // Nhiệm vụ 1: Tương tác với Services/Models
        $articelService = new ArticleService();
        $articles = $articelService->getAllArticles();
        // Nhiệm vụ 2: Tương tác với View
        return $this->view(
            "home.index", [
            'articles'=>$articles,
            ]
        );
    }
    public function detail()
    {
        // Nhiệm vụ 1: Tương tác với Services/Models
        $id=$_GET["sid"];
        $articelService = new ArticleService();
        $articleA = $articelService->getArticlebyID($id);
        // Nhiệm vụ 2: Tương tác với View
        return $this->view(
            "home.detail", [
            'articleA'=>$articleA,
            ]
        );
    }

    public function login()
    {
        session_start();
        $this->userService = new MemberService();
        if (isset($_POST['button'])) {
            $username = $_POST['username'];
            $password = $_POST['password'];
            $users = $this->userService->checkLogin($username);
            if ($users > 0) {
                $pass_hash = $users[0]->getPass();
                $role = $users[0]->getIs_admin();
                if ($pass_hash = $password) {
                    if ($role == '1') {
                        $_SESSION['admin'] = $_POST['username'];
                        header('location:/CSE485_2023_BTTH02/index.php?controller=admin&action=list');
                    } else {
                        echo 'mật khẩu không chính xác';
                        // echo $users[0]->getPass();
                    }
                }
            }

        }
        include "views/home/login.php";
    }
    public function logout()
    {
        session_start();
        unset($_SESSION['admin']);
        session_destroy();
        header("Location:/CSE485_2023_BTTH02/index.php?controller=home&action=login");
        exit;
    }
}
