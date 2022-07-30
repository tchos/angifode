 <?php
 /*
  @Author: DDPP
  @Project: PHP & MySQLi How To Add Export Buttons To DataTable Tutorial
  @Email: onlinewebtutorhub@gmail.com
  @Website: https://angifode.minfi.com/
 */

 // Database configuration
 $host   = "localhost";
 $dbuser = "root";
 $dbpass = "TKL@wS0CF";
 $dbname = "angifode_db";

 // Create database connection
 $conn = new mysqli($host, $dbuser, $dbpass, $dbname);

 // Check connection
 if ($conn->connect_error) {
     die("Connection failed: " . $conn->connect_error);
 }
