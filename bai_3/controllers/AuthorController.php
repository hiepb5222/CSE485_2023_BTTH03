<?php
require "services/AuthorService.php";
class AuthorController
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
        // Nhiệm vụ 1: Tương tác với Services/Models
        // echo "Tương tác với Services/Models from Article";
        // Nhiệm vụ 2: Tương tác với View
        function html_escape($text): string
        {

            $text = $text ?? ''; 

            return htmlspecialchars($text, ENT_QUOTES, 'UTF-8', false); // Return escaped string
        }
        $authorService = new AuthorService();
        if (isset($_POST['submit'])) {
            $hinhanh=html_escape($_FILES['hinh_tgia']['name']);
            $hinhanh_tmp=html_escape($_FILES['hinh_tgia']['tmp_name']);
            $result = $authorService -> addAuthor($_POST['ten_tgia'], $hinhanh);
            $target='C:/xampp/htdocs/CSE485_2023_BTTH02/views/image/songs/'.basename($_FILES['hinh_tgia']['name']);
            move_uploaded_file($hinhanh_tmp, $target);
            if($result) {
                header('location: index.php?controller=author&action=list');
            }
        }
        include "views/author/add_author.php";
    }

    public function list()
    {
        // Nhiệm vụ 1: Tương tác với Services/Models
        $authorService = new AuthorService();
        $authors = $authorService -> getAllAuthors();
        // echo "Tương tác với Services/Models from Article";
        // Nhiệm vụ 2: Tương tác với View
        include "views/author/list_author.php";
    }

    public function view_edit()
    {
        $authorService = new AuthorService();
        $author = $authorService->getAuthorbyID($_GET['id']);
        include "views/author/edit_author.php";
    }

    public function edit()
    {
        // Nhiệm vụ 1: Tương tác với Services/Models
        // echo "Tương tác với Services/Models from Article";
        // Nhiệm vụ 2: Tương tác với View
        function html_escape($text): string
        {

            $text = $text ?? ''; 

            return htmlspecialchars($text, ENT_QUOTES, 'UTF-8', false); // Return escaped string
        }
        $authorService = new AuthorService();
        $resultHinhanh=$authorService->getAuthorbyID($_POST['txtAuthorId']);
        if($_FILES['txtHinhanhtgia']['name']=="") {
            $hinhanh=html_escape($resultHinhanh->getAuthor_pic());
        }
        else{ 
            $hinhanh=html_escape($_FILES['txtHinhanhtgia']['name']);
            $hinhanh_tmp=html_escape($_FILES['txtHinhanhtgia']['tmp_name']);
        }
        if(isset($_POST['submit'])) {
            $result = $authorService -> editAuthor($_POST['txtAuthorId'], $_POST['txtAuthorName'], $hinhanh);
            if($result) {
                header('location:index.php?controller=author&action=list');
            }
        }

    }

    public function delete()
    {
        $authorService = new AuthorService();
        if (isset($_GET['id'])) {
            $result = $authorService -> deleteAuthor($_GET['id']);
            if($result) {
                header('location:index.php?controller=author&action=list');
            }
        }
        include "views/author/list_author.php";
    }


}
