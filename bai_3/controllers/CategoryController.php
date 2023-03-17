<?php
require "services/CategoryService.php";
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
                header('location:/CSE485_2023_BTTH02/index.php?controller=category&action=list');
            }
        }

        include "views/category/add_category.php";
    }

    public function list()
    {
        // Nhiệm vụ 1: Tương tác với Category/Models
        // echo "Tương tác với Category/Models from Category";
        // Nhiệm vụ 2: Tương tác với View
        $CategoryService = new CategoryService();
        $categories = $CategoryService ->getAllCategory();
        include "views/category/list_category.php";
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
                header('location:/CSE485_2023_BTTH02/index.php?controller=category&action=list');
            }
        }
        include "views/category/edit_category.php";
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
                header('location:/CSE485_2023_BTTH02/index.php?controller=category&action=list');
            }
        }
        include "views/category/list_category.php";
    }
}
