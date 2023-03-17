<?php
require 'vendor/autoload.php';
require 'Utils/MyEmailServer.php';
require 'Utils/EmailSender.php';
$emailServer = new MyEmailServer();
$emailSender = new EmailSender($emailServer);
// $emailSender->send("thichthihoc.ai@gmail.com", "Điểm Danh", "Hoàng Quốc Hiệp điểm danh");
