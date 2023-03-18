<?php
// require "./configs/sendmail.php";
require "./configs/MyEmailServer.php";
require "services/MemberService.php";
require_once 'vendor/autoload.php';
require './configs/EmailSender.php';
use Twig\Environment;
use Twig\Loader\FilesystemLoader;
class MemberController
{

    // Hàm xử lý hành động index
    public function index()
    {
        // Nhiệm vụ 1: Tương tác với Services/Models
        echo "Tương tác với Services/Models from Member";
        // Nhiệm vụ 2: Tương tác với View
        echo "Tương tác với View from Member";
    }

    function home()
    {
        $memberService = new MemberService();
        $loader = new FilesystemLoader('views');
        $twig = new Environment($loader);
        $content = $twig->load('home/login.html.twig');
        echo $content->render();
    }
    function signup()
    {
        $memberService = new MemberService();
        $loader = new FilesystemLoader('views');
        $twig = new Environment($loader);
        $content = $twig->load('home/signup.html.twig');
        echo $content->render();
    }function signin()
    {   
        $memberService = new MemberService();
        $loader = new FilesystemLoader('views');
        $twig = new Environment($loader);
        $content = $twig->load('home/signup.html.twig');
        echo $content->render();
    }
    public function CheckEmail(){
        $memberService = new MemberService();
        if (isset($_GET['code'])) {
            $result = $memberService->CheckEmail($_GET['code']);
        }
    }
    public function resigter()
    {


        $memberService = new MemberService();
        function html_escape($text): string
        {

            $text = $text ?? '';

            return htmlspecialchars($text, ENT_QUOTES, 'UTF-8', false); // Return escaped string
        }
        if (isset($_POST['signbtn'])) {
            // Lay tu FORM
            $name = html_escape($_POST['txtName']);
            $user = html_escape($_POST['txtUser']);
            $email = html_escape($_POST['txtEmail']);
            $pass = html_escape($_POST['txtPass']);
            $user_hash = md5(uniqid(rand(), true));
            $pass_hash = password_hash($pass, PASSWORD_DEFAULT);

            try {
                if ($_POST['txtPass'] !== $_POST['txtResetPass']) {
                    echo "Mật khẩu xác nhận không khớp.";
                    exit();
                } else {
                    if (preg_match('/[^\x00-\x7F]/', $_POST['txtUser'])) {
                        $message = "Không được nhập dấu!";
                        echo "<script>alert('$message');</script>";
                    } else {
                        if (strlen($name) > 50) {
                            $message = "Tài khoản không quá 50 ký tự";
                            echo "<script>alert('$message');</script>";
                        } else {
                            if (strlen($email) > 50) {
                                $message = "Email không quá 50 ký tự";
                                echo "<script>alert('$message');</script>";
                            } else {
                                if (strlen($user) > 20) {
                                    $message = "User không quá 20 ký tự";
                                    echo "<script>alert('$message');</script>";
                                } else {
                                    if (strlen($pass) > 255) {
                                        $message = "Pass không quá 255 ký tự";
                                        echo "<script>alert('$message');</script>";
                                    } else {
                                        $emailServer = new MyEmailServer();
                                        $emailSender = new EmailSender($emailServer);
                                        $emailSender->send("hatbaynd01@gmail.com", "Activation", "http://localhost/cse485_2023_btth03/bai_3/index.php?controller=member&action=CheckEmail?code=".$user_hash);
                                        $result = $memberService->signupMember($name, $user, $email,$pass, $user_hash, $pass_hash);
                                            if ($result) {
                                                echo $emailSender;
                                            } else {
                                                echo "Email could not be sent.";
                                            }
                                        }
                                    
                                }
                            }
                        }
                    }
                }
            } catch (Exception $e) {
                echo "Tồn tại!";
            }
        }

        include "views/member/add_member.php";
    }
    public function add()
    {
        $dbConn = new DBConnection();
        $conn = $dbConn->getConnection();
        $memberService = new MemberService();
        function html_escape($text): string
        {

            $text = $text ?? '';

            return htmlspecialchars($text, ENT_QUOTES, 'UTF-8', false); // Return escaped string
        }
        if (isset($_POST['signbtn'])) {
            $name = html_escape($_POST['txtName']);
            $user = html_escape($_POST['txtUser']);
            $email = html_escape($_POST['txtEmail']);
            $pass = html_escape($_POST['txtPass']);
            if (isset($_POST['is_admin']) && $_POST['is_admin'] == 1) {
                $is_admin = 1;
            } else {
                $is_admin = 0;
            }
            try {
                if ($_POST['txtPass'] !== $_POST['txtResetPass']) {
                    echo "Mật khẩu xác nhận không khớp.";
                    exit();
                } else {
                    if (preg_match('/[^\x00-\x7F]/', $_POST['txtUser'])) {
                        $message = "User Không được nhập dấu!";
                        echo "<script>alert('$message');</script>";
                    } else {
                        if (strlen($name) > 50) {
                            $message = "Tài khoản không quá 50 ký tự";
                            echo "<script>alert('$message');</script>";
                        } else {
                            if (strlen($email) > 50) {
                                $message = "Email không quá 50 ký tự";
                                echo "<script>alert('$message');</script>";
                            } else {
                                if (strlen($user) > 20) {
                                    $message = "User không quá 20 ký tự";
                                    echo "<script>alert('$message');</script>";
                                } else {
                                    if (strlen($pass) > 255) {
                                        $message = "Pass không quá 255 ký tự";
                                        echo "<script>alert('$message');</script>";
                                    } else {
                                        $hashed_password = password_hash($_POST['txtPass'], PASSWORD_DEFAULT);
                                        $result = $memberService->addMember($name, $email, $user,  $hashed_password, $is_admin);

                                        if ($result) {
                                            header('location:/CSE485_2023_BTTH02/index.php?controller=member&action=list');
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            } catch (Exception $e) {
                $e = "Tài khoản đã tồn tại!";
                echo "<script>alert('$e');</script>";
            }
        }

        include "views/member/add_member.php";
    }
    public function list()
    {

        $memberService = new MemberService();
        $members = $memberService->getAllMember();
        include "views/member/list_member.php";
    }
    public function view_edit()
    {
        $memberService = new MemberService();
        $findMember = $memberService->findMemberId($_GET['id']);
        include "views/member/edit_member.php";
    }
    public function edit()
    {
        $memberService = new MemberService();
        function html_escape($text): string
        {

            $text = $text ?? '';

            return htmlspecialchars($text, ENT_QUOTES, 'UTF-8', false); // Return escaped string
        }

        if (isset($_POST['signbtn'])) {
            $id = html_escape($_POST['txtID']);
            $name = html_escape($_POST['txtName']);
            $user = html_escape($_POST['txtUser']);
            $email = html_escape($_POST['txtEmail']);
            $is_admin = html_escape($_POST['txtIs_admin']);
            $pass = html_escape($_POST['txtPass']);

            try {
                if ($is_admin == 1 || $is_admin == 0) {
                    if ($_POST['txtPass'] !== $_POST['txtResetPass']) {
                        $message = "Mật khẩu xác nhận không khớp.";
                        echo "<script>alert('$message');</script>";
                    } else {
                        if (preg_match('/[^\x00-\x7F]/', $_POST['txtUser'])) {
                            $message = "Không được nhập dấu!";
                            echo "<script>alert('$message');</script>";
                        } else {
                            if (strlen($name) > 50) {
                                $message = "Tài khoản không quá 50 ký tự";
                                echo "<script>alert('$message');</script>";
                            } else {
                                if (strlen($email) > 50) {
                                    $message = "Email không quá 50 ký tự";
                                    echo "<script>alert('$message');</script>";
                                } else {
                                    if (strlen($user) > 20) {
                                        $message = "User không quá 20 ký tự";
                                        echo "<script>alert('$message');</script>";
                                    } else {
                                        if (strlen($pass) > 255) {
                                            $message = "Pass không quá 255 ký tự";
                                            echo "<script>alert('$message');</script>";
                                        } else {
                                            $hashed_password = password_hash($_POST['txtPass'], PASSWORD_DEFAULT);
                                            $result = $memberService->editMember($id, $name, $email, $user,  $hashed_password, $is_admin);

                                            if ($result) {
                                                header('location:/CSE485_2023_BTTH02/index.php?controller=member&action=list');
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                } else {
                    $message = "Is admin chỉ nhận 0 hoặc 1!";
                    echo "<script>alert('$message');</script>";
                }
            } catch (Exception $e) {
                echo "Tồn tại";
            }
        }
        include "views/member/edit_member.php";
    }


    public function delete()
    {
        $memberService = new MemberService();
        if (isset($_GET['id'])) {
            $result = $memberService->deleteMember($_GET['id']);
            if ($result) {
                header('location:index.php?controller=member&action=list');
            }
        }
        $members = $memberService->getAllMember();
        include "views/member/list_member.php";
    }
}
