<?php
require "services/CategoryService.php";
require_once 'vendor/autoload.php';
use Twig\Environment;
use Twig\Loader\FilesystemLoader;
class CategoryController
{
    // Hàm xử lý hành động index
    public function index()
    {
        // Nhiệm vụ 1: Tương tác với Category/Models
        echo "Tương tác với Services/Models from Category";
        // Nhiệm vụ 2: Tương tác với View
        echo "Tương tác với View from Category";
    }

    public function add()
    {
        // Nhiệm vụ 1: Tương tác với Category/Models
        // echo "Tương tác với Category/Models from Category";
        // Nhiệm vụ 2: Tương tác với View
        $CategoryService = new CategoryService();
        if(isset($_POST['submit'])) {
            $result=$CategoryService->addCategory($_POST['ten_tloai']);
            if($result) {
                header('location:/CSE485_2023_BTTH03/bai_3/index.php?controller=category&action=list');
            }
        }

        $loader = new FilesystemLoader('views');
        $twig = new Environment($loader);
        $content = $twig->load('category/add_category.html.twig');
        echo $content->render();
    }

    public function list()
    {
        // Nhiệm vụ 1: Tương tác với Category/Models
        // echo "Tương tác với Category/Models from Category";
        // Nhiệm vụ 2: Tương tác với View
        $CategoryService = new CategoryService();
        $categories = $CategoryService ->getAllCategory();
        $loader = new FilesystemLoader('views');
        $twig = new Environment($loader);
        $content = $twig->load('category/list_category.html.twig');
        echo $content->render(array(
            'categories' => $categories,
        ));
    
    }

    public function edit()
    {
        // Nhiệm vụ 1: Tương tác với Category/Models
        // echo "Tương tác với Category/Models from Category";
        // Nhiệm vụ 2: Tương tác với View
        $CategoryService = new CategoryService();
        $findCategory=$CategoryService->findCategoryById($_GET['id']);
        if(isset($_POST['submit'])) {
            $result=$CategoryService->editCategory($_GET['id'], $_POST['ten_tloai']);
            if($result) {
                header('location:/CSE485_2023_BTTH03/bai_3/index.php?controller=category&action=list');
            }
        }
        $loader = new FilesystemLoader('views');
        $twig = new Environment($loader);
        $content = $twig->load('category/edit_category.html.twig');
        echo $content->render(array(
             'findCategory' =>$findCategory
            ));
    }

    public function delete()
    {
        // Nhiệm vụ 1: Tương tác với Category/Models
        // echo "Tương tác với Category/Models from Category";
        // Nhiệm vụ 2: Tương tác với View
        $CategoryService = new CategoryService();
        if(isset($_GET['id'])) {
            $result=$CategoryService->deleteCategory($_GET['id']);
            if($result) {
                header('location:/CSE485_2023_BTTH03/bai_3/index.php?controller=category&action=list');
            }
        }
        return $this->list();
    }
}
