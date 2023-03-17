<?php
require_once "configs/DBConnection.php";
require "models/Category.php";

class CategoryService
{
    public function getAllCategory()
    {
        // 4 bước thực hiện
        $dbConn = new DBConnection();
        $conn = $dbConn->getConnection();

        // B2. Truy vấn
        $sql = "SELECT * FROM theloai" ;
        $stmt = $conn->query($sql);

        // B3. Xử lý kết quả
        $categories = [];
        while($row = $stmt->fetch()){
            $category = new Category($row['ma_tloai'], $row['ten_tloai'],  $row['SLBaiViet']);
            array_push($categories, $category);
        }
        // Mảng (danh sách) các đối tượng Category Model

        return $categories;
    }
    public function addCategory($ten_tloai)
    {
        $dbConn = new DBConnection();
        $conn = $dbConn->getConnection();

        $sql="INSERT INTO theloai (ten_tloai) VALUES('$ten_tloai');";
        $stmt = $conn->query($sql);
        
        return true;
    }
    public function deleteCategory($ma_tloai)
    {
        $dbConn = new DBConnection();
        $conn = $dbConn->getConnection();

        $sql="DELETE FROM theloai WHERE ma_tloai='$ma_tloai';";
        $stmt = $conn->query($sql);
        
        return true;
    }

    public function findCategoryById($ma_tloai)
    {
        $dbConn = new DBConnection();
        $conn = $dbConn->getConnection();

        $sql="SELECT * FROM theloai WHERE ma_tloai='$ma_tloai';";
        $stmt = $conn->query($sql);
        
        return $stmt;
    }

    public function editCategory($ma_tloai, $ten_tloai)
    {
        $dbConn = new DBConnection();
        $conn = $dbConn->getConnection();

        $sql="UPDATE theloai set ten_tloai='$ten_tloai' WHERE ma_tloai='$ma_tloai';";
        $stmt = $conn->query($sql);
        
        return true;
    }
    public function countCategory()
    {
        $dbConn = new DBConnection();
        $conn = $dbConn->getConnection();

        $sql = "SELECT COUNT(ma_tloai) as count FROM theloai";
        $result = $conn ->query($sql);
        while ($row = $result->fetch()) {
            $count = strval($row['count']);
        }
        return $count;
    }
}
