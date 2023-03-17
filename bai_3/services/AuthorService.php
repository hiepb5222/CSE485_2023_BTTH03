<?php
require_once "configs/DBConnection.php";
require "models/Author.php";
class AuthorService
{
    public function getAllAuthors()
    {
        // 4 bước thực hiện
        $dbConn = new DBConnection();
        $conn = $dbConn->getConnection();

        // B2. Truy vấn
        $sql = "SELECT * FROM tacgia";
        $stmt = $conn->query($sql);

        // B3. Xử lý kết quả
        $authors = [];
        while($row = $stmt->fetch()){
            $author = new Author($row['ma_tgia'], $row['ten_tgia'], $row['hinh_tgia']);
            array_push($authors, $author);
        }
        // Mảng (danh sách) các đối tượng Author Model

        return $authors;
    }

    public function addAuthor($author_name, $author_pic)
    {
        $dbConn = new DBConnection();
        $conn = $dbConn->getConnection();

        // B2. Truy vấn
        $sql = "INSERT INTO tacgia (ten_tgia, hinh_tgia) VALUES ('$author_name','$author_pic')";
        $stmt = $conn->query($sql);

        return true;




    }

    public function deleteAuthor($author_id)
    {
        $dbConn = new DBConnection();
        $conn = $dbConn->getConnection();

        // B2. Truy vấn
        $sql = "DELETE FROM tacgia WHERE ma_tgia = '$author_id'";
        $stmt = $conn->query($sql);

        return true;



    }

    public function getAuthorbyID($author_id)
    {
        $dbConn = new DBConnection();
        $conn = $dbConn->getConnection();

         // B2. Truy vấn
         $sql = "SELECT * FROM tacgia WHERE ma_tgia = '$author_id'";
         $stmt = $conn->query($sql);


        while($row = $stmt->fetch()){
            $author = new Author($row['ma_tgia'], $row['ten_tgia'], $row['hinh_tgia']);

        }
        // Mảng (danh sách) các đối tượng Author Model

        return $author;
    }

    public function editAuthor($author_id, $author_name, $author_pic)
    {
        $dbConn = new DBConnection();
        $conn = $dbConn->getConnection();

        // B2. Truy vấn
        $sql = "UPDATE tacgia SET ten_tgia = '$author_name', hinh_tgia = '$author_pic' WHERE ma_tgia = '$author_id'";
        $stmt = $conn->query($sql);

        return true;



    }
    public function countAuthor()
    {
        $dbConn = new DBConnection();
        $conn = $dbConn->getConnection();

        $sql = "SELECT COUNT(ma_tgia) as count FROM tacgia";
        $result = $conn ->query($sql);
        while ($row = $result->fetch()) {
            $count = strval($row['count']);
        }
        return $count;
    }
}
