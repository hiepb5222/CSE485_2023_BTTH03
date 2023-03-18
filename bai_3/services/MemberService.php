<?php
    
require_once "configs/DBConnection.php";
require "models/Member.php";
class MemberService
{
    public function checkLogin($username)
    {
        $dbConn = new DBConnection();
        $conn = $dbConn->getConnection();

        $sql = "SELECT * FROM users WHERE username = '$username'";
        $result = $conn ->query($sql);
        $users = [];
        while($row = $result->fetch()){
            $user = new Member($row['id'], $row['name'], $row['email'], $row['username'], $row['password'], $row['is_admin']);
            array_push($users, $user);
        }


        return $users;
    }
    public function countUser()
    {
        $dbConn = new DBConnection();
        $conn = $dbConn->getConnection();

        $sql = "SELECT COUNT(id) as count FROM users";
        $result = $conn ->query($sql);
        while ($row = $result->fetch()) {
            $count = strval($row['count']);
        }
        return $count;
    }
    public function getAllMember()
    {
        // 4 bước thực hiện
        $dbConn = new DBConnection();
        $conn = $dbConn->getConnection();

        // B2. Truy vấn
        $sql = "SELECT * FROM users";
        $stmt = $conn->query($sql);

        // B3. Xử lý kết quả
        $members = [];
        while ($row = $stmt->fetch()) {
            $member = new Member($row['id'], $row['name'], $row['email'], $row['username'], $row['password'], $row['is_admin']);
            array_push($members, $member);
        }
        // Mảng (danh sách) các đối tượng Article Model

        return $members;
    }

    public function addMember($name, $email, $user, $pass,$is_admin)
    {
        $dbConn = new DBConnection();
        $conn = $dbConn->getConnection();

        // B2. Truy vấn
        $sql = "INSERT INTO users VALUES ('','$name','$email','$user','$pass','$is_admin')";
        $stmt = $conn->query($sql);
        if ($stmt) {
            return true;
        }
        else{
            echo "lỗi";
        }
    }

    public function deleteMember($id)
    {
        $dbConn = new DBConnection();
        $conn = $dbConn->getConnection();
        $sql = "DELETE from users where id = '$id';";
        $stmt = $conn->query($sql);
        if($stmt) {
            return true;
        }
        return false; 
    }
    public function CheckEmail($code_hash){
        $dbConn = new DBConnection();
        $conn = $dbConn->getConnection();
        $sqlCheck="SELECT * FROM users WHERE user_hash='$code_hash'";
        $resultCheck=mysqli_query($conn,$sqlCheck);
        if(mysqli_num_rows($resultCheck)<0){
                return false;
        }
        else{
        $sql="UPDATE users SET active=1 WHERE user_hash='$code_hash'";
        $result=mysqli_query($conn,$sql);
        return true;
        }

    }
    public function signupMember($name, $user, $email, $pass,$user_hash,$pass_hash)
    {
        
        $dbConn = new DBConnection();
        $conn = $dbConn->getConnection();
        $sql = "INSERT INTO users(name_user,user_name, user_email ,user_pass,user_hash,pass_hash) VALUES ('$name','$user','$email','$pass','$user_hash','$pass_hash')";
        $stmt = $conn->query($sql);
        if ($stmt) {
            return true;
        }
        else{
            echo "lỗi";
        }

    }
    public function findMemberId($id)
    {
        $dbConn = new DBConnection();
        $conn = $dbConn->getConnection();

        // B2. Truy vấn
        $sql = "SELECT * FROM users WHERE id = '$id'";
        $stmt = $conn->query($sql);

    
        while($row = $stmt->fetch()){
            $member = new Member($row['id'], $row['name'], $row['email'], $row['username'], $row['password'], $row['is_admin']);
         
        }
        // Mảng (danh sách) các đối tượng Author Model

        return $member;
    }

    public function editMember($id, $name, $email, $user, $pass,$is_admin)
    {
        $dbConn = new DBConnection();
        $conn = $dbConn->getConnection();
        $sql = "UPDATE users SET  name='$name' , email='$email', username='$user', password='$pass',is_admin='$is_admin' WHERE id='$id'";
        $stmt = $conn->query($sql);
        if ($stmt) {
            return true;
        }
        else{
            echo "lỗi";
        }
    }
}
