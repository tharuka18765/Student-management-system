
<?php
  $dbhost='loacalhost';
  $dbuser='root';
  $dbpass='';
  $dbname='newpro';

  $connection=mysqli_connect('localhost','root','','newpro');
  if(mysqli_connect_errno()){
    die ('Database connection error'.mysqli_connect_error());
  }
?>