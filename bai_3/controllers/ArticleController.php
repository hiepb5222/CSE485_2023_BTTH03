<?php
require_once "services/ArticleService.php";
require_once "services/AuthorService.php";
require_once "services/CategoryService.php";
require "controllers/BaseController.php";
require_once 'vendor/autoload.php';
use Twig\Environment;
use Twig\Loader\FilesystemLoader;
class ArticleController 
{
    // Hàm xử lý hành động index
    public function index()
    {
        // Nhiệm vụ 1: Tương tác với Services/Models
        echo "Tương tác với Services/Models from Article";
        // Nhiệm vụ 2: Tương tác với View
        echo "Tương tác với View from Article";
    }

    public function add()
    {
        $authorService = new AuthorService();
        $authors = $authorService->getAllAuthors();

        $categoryService = new CategoryService();
        $categories = $categoryService->getAllCategory();


        $loader = new FilesystemLoader('views');
        $twig = new Environment($loader);
        $content = $twig->load('article/add_article.html.twig');
        echo $content->render(array(
            'categories'=>$categories,
            'authors'=>$authors
        )
        );
    }   
    public function edit()
    {
        // Nhiệm vụ 1: Tương tác với Services/Models
        // echo "Tương tác với Services/Models from Article";
        // Nhiệm vụ 2: Tương tác với View
        $id=$_GET["sid"];
        $articleService = new ArticleService();
        $findArticle = $articleService->getArticlebyID($id);

        $authorService = new AuthorService();
        $authors = $authorService->getAllAuthors();

        $categoryService = new CategoryService();
        $categories = $categoryService->getAllCategory();


        $loader = new FilesystemLoader('views');
        $twig = new Environment($loader);
        $content = $twig->load('article/edit_article.html.twig');
        echo $content->render(array(
            'findArticle'=>$findArticle,
            'categories'=>$categories,
            'authors'=>$authors
        )
        );
    }
    public function update()
    {
        // Nhiệm vụ 1: Tương tác với Services/Models
        // echo "Tương tác với Services/Models from Article";
        // Nhiệm vụ 2: Tương tác với View
        function html_escape($text): string
        {

            $text = $text ?? ''; 

            return htmlspecialchars($text, ENT_QUOTES, 'UTF-8', false); // Return escaped string
        }
        $ma_bviet=html_escape($_POST["txtBaiviet"]);
        $tieude=html_escape($_POST["txtTieude"]);
        $baihat=html_escape($_POST["txtBaihat"]);
        $category_id=html_escape($_POST["txtTheloai"]);
        $tomtat=html_escape($_POST["txtTomtat"]);
        $noidung=html_escape($_POST["txtNoidung"]);
        $author_id=html_escape($_POST["txtTacgia"]);
        $current_time = html_escape($_POST["txtNgayviet"]);

        $articleService = new ArticleService();
        $resultHinhanh=$articleService->getArticlebyID($ma_bviet);
        if($_FILES['txtHinhanh']['name']=="") {
            $hinhanh=html_escape($resultHinhanh[0]->getImage());
        }
        else{ 
            $hinhanh=html_escape($_FILES['txtHinhanh']['name']);
            $hinhanh_tmp=html_escape($_FILES['txtHinhanh']['tmp_name']);
        }


        $result = $articleService->UpdateArticle($ma_bviet, $tieude, $baihat, $category_id, $tomtat, $noidung, $author_id, $current_time, $hinhanh);
        $target='C:/xampp/htdocs/CSE485_2023_BTTH03/bai_3/views/image/songs/'.basename($_FILES['txtHinhanh']['name']);
        move_uploaded_file($hinhanh_tmp, $target);
        if($result) {
            header("Location: ./index.php?controller=article&action=list");
        }
    }

    public function store()
    {
        // Nhiệm vụ 1: Tương tác với Services/Models
        // echo "Tương tác với Services/Models from Article";
        // Nhiệm vụ 2: Tương tác với View
        function html_escape($text): string
        {

            $text = $text ?? ''; 

            return htmlspecialchars($text, ENT_QUOTES, 'UTF-8', false); // Return escaped string
        }

        $tieude=html_escape($_POST["txtTieude"]);
        $baihat=html_escape($_POST["txtBaihat"]);
        $category_id=html_escape($_POST["txtTheloai"]);
        $tomtat=html_escape($_POST["txtTomtat"]);
        $noidung=html_escape($_POST["txtNoidung"]);
        $author_id=html_escape($_POST["txtTacgia"]);
        $current_time = date("Y-m-d");



        $hinhanh=html_escape($_FILES['txtHinhanh']['name']);
        $hinhanh_tmp=html_escape($_FILES['txtHinhanh']['tmp_name']);
        // if(empty($tieude)||empty($baihat)||empty($tomtat)||empty($category_id)||empty($author_id)||empty($current_time))
        // {
        //     return $this->view(
        //         "article.add_article", [
        //         'errors'=>'Không được để trống các ô nhập liệu',
        //         'tieude'=>$tieude,
        //         'baihat'=>$baihat,
        //         'tomtat'=>$tomtat,
        //         'category_id'=>$category_id,
        //         'author_id'=>$author_id,
        //         'current_time'=>$current_time,
        //         'noidung'=>$noidung,
        //         'hinhanh'=>$hinhanh
        //         ]
        //     );
        // }
        // else
        // {
        $articleService = new ArticleService();
        $result = $articleService->CreateArticle($tieude, $baihat, $category_id, $tomtat, $noidung, $author_id, $current_time, $hinhanh);
        $target='C:/xampp/htdocs/CSE485_2023_BTTH03/bai_3/views/image/songs/'.basename($_FILES['txtHinhanh']['name']);
        move_uploaded_file($hinhanh_tmp, $target);
        if($result) {
            header("Location: ./index.php?controller=article&action=list");
        }
        // }
    }


        // $articles = $articleService->getAllArticles();
        // return $this->view("article.list_article",['articles'=>$articles]);


    public function list()
    {
        $articleService = new ArticleService();
        $articles = $articleService->getAllArticles();
        // include("views/article/list_article.php");
        $loader = new FilesystemLoader('views');
        $twig = new Environment($loader);
        $content = $twig->load('article/list_article.html.twig');
        echo $content->render(array(
        'articles'=>$articles));
    }
    public function delete()
    {
        $id = $_GET['sid'];
        $articleService = new ArticleService();
        $result=$articleService->DestroyArticle($id);
        if($result) {
            header("Location: ./index.php?controller=article&action=list");
        }
        
    }
    
        // $articles = $articleService->getAllArticles();
        // return $this->view("article.list_article",['articles'=>$articles]);


}
