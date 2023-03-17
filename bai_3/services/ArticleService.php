<?php
require_once "configs/DBConnection.php";
require "models/Article.php";
class ArticleService
{
    public function getAllArticles()
    {
        // 4 bước thực hiện
        $dbConn = new DBConnection();
        $conn = $dbConn->getConnection();

        // B2. Truy vấn
        $sql="SELECT ma_bviet,tieude,ten_bhat,".'theloai.ten_tloai as theloai'.",tomtat,noidung,".'tacgia.ten_tgia as tacgia'.",ngayviet,hinhanh FROM baiviet,tacgia,theloai where tacgia.ma_tgia=baiviet.ma_tgia and theloai.ma_tloai=baiviet.ma_tloai ORDER BY ngayviet DESC";
        $stmt = $conn->query($sql);

        // B3. Xử lý kết quả
        $articles = [];
        while($row = $stmt->fetch()){
            $article = new Article($row['ma_bviet'], $row['tieude'], $row['ten_bhat'], $row['theloai'], $row['tomtat'], $row['noidung'], $row['tacgia'], $row['ngayviet'], $row['hinhanh']);
            array_push($articles, $article);
        }
        // Mảng (danh sách) các đối tượng Article Model

        return $articles;
    }
    public function getArticlebyID($id)
    {
        // 4 bước thực hiện
        $dbConn = new DBConnection();
        $conn = $dbConn->getConnection();

        // B2. Truy vấn
        $sql="SELECT ma_bviet,tieude,ten_bhat,".'theloai.ten_tloai as theloai'.",tomtat,noidung,".'tacgia.ten_tgia as tacgia'.",ngayviet,hinhanh FROM baiviet,tacgia,theloai where tacgia.ma_tgia=baiviet.ma_tgia and theloai.ma_tloai=baiviet.ma_tloai
        AND ma_bviet='$id'";
        $stmt = $conn->query($sql);

        // B3. Xử lý kết quả
        $articleA = [];
        while($row = $stmt->fetch()){
            $article = new Article($row['ma_bviet'], $row['tieude'], $row['ten_bhat'], $row['theloai'], $row['tomtat'], $row['noidung'], $row['tacgia'], $row['ngayviet'], $row['hinhanh']);
            array_push($articleA, $article);
        }
        // Mảng (danh sách) các đối tượng Article Model

        return $articleA;
    }

    public function CreateArticle($tieude,$baihat,$category_id,$tomtat,$noidung,$author_id,$current_time,$hinhanh)
    {
        // 4 bước thực hiện
        $dbConn = new DBConnection();
        $conn = $dbConn->getConnection();
        // B2. Truy vấn
        $addBaivietsql="INSERT INTO baiviet(tieude,ten_bhat,ma_tloai,tomtat,noidung,ma_tgia,ngayviet,hinhanh) VALUES('$tieude','$baihat'
      ,'$category_id','$tomtat','$noidung','$author_id','$current_time','$hinhanh')";
        $stmt = $conn->query($addBaivietsql);
        if($stmt) {
            return true;
        }
        return false;    
    }
    public function DestroyArticle($id)
    {
        $dbConn = new DBConnection();
        $conn = $dbConn->getConnection();
        $sql = "DELETE from baiviet where ma_bviet = '$id'";
        $stmt = $conn->query($sql);
        if($stmt) {
            return true;
        }
        return false; 
    }
    public function UpdateArticle($ma_bviet,$tieude,$baihat,$category_id,$tomtat,$noidung,$author_id,$current_time,$hinhanh)
    {
        // 4 bước thực hiện
        $dbConn = new DBConnection();
        $conn = $dbConn->getConnection();
        // B2. Truy vấn
        $sql="UPDATE baiviet SET tieude='$tieude',ten_bhat='$baihat',ma_tloai='$category_id',tomtat='$tomtat',noidung='$noidung',ma_tgia='$author_id',ngayviet='$current_time',hinhanh='$hinhanh' WHERE ma_bviet='$ma_bviet'";
        $stmt = $conn->query($sql);
        if($stmt) {
            return true;
        }
        return false;    
    }
    public function countArticle()
    {
        $dbConn = new DBConnection();
        $conn = $dbConn->getConnection();

        $sql = "SELECT COUNT(ma_bviet) as count FROM baiviet";
        $result = $conn ->query($sql);
        while ($row = $result->fetch()) {
            $count = strval($row['count']);
        }
        return $count;
    }
    

}
