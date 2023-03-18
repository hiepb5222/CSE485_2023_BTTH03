<?php
require_once "services/ArticleService.php";
require_once "services/MemberService.php";
require "controllers/BaseController.php";
require_once 'vendor/autoload.php';
use Twig\Environment;
use Twig\Loader\FilesystemLoader;
class HomeController
{
    // Hàm xử lý hành động index
    public function index()
    {
        // Nhiệm vụ 1: Tương tác với Services/Models
        $articelService = new ArticleService();
        $articles = $articelService->getAllArticles();
        // Nhiệm vụ 2: Tương tác với View
        $loader = new FilesystemLoader('views');
        $twig = new Environment($loader);
        $content = $twig->load('home/index.html.twig');
        echo $content->render(array(            
            'articles' => $articles
            ));
    }
    public function detail()
    {
        // Nhiệm vụ 1: Tương tác với Services/Models
        $id=$_GET["sid"];
        $articelService = new ArticleService();
        $findArticle = $articelService->getArticlebyID($id);
        // Nhiệm vụ 2: Tương tác với View
        $loader = new FilesystemLoader('views');
        $twig = new Environment($loader);
        $content = $twig->load('home/detail.html.twig');
        echo $content->render(array(            
            'findArticle' => $findArticle
            ));
    
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
                        header('location:/CSE485_2023_BTTH03/bai_3/index.php?controller=admin&action=list');
                    } else {
                        echo 'mật khẩu không chính xác';
                        // echo $users[0]->getPass();
                    }
                }
            }

        }
        $loader = new FilesystemLoader('views');
        $twig = new Environment($loader);
        $content = $twig->load('home/login.html.twig');
       
    }
    public function logout()
    {
        session_start();
        unset($_SESSION['admin']);
        session_destroy();
        header("Location:/CSE485_2023_BTTH03/bai_3/index.php?controller=home&action=login");
        exit;
    }
}
