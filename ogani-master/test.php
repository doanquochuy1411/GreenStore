<?php
$password = "Long12345!";
$hashed_password = password_hash($password, PASSWORD_DEFAULT);
print_r('mk da duoc ma hoa: '. $hashed_password);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <form action="http://localhost/CNM/TN_Last/ogani-master/ogani-master/indexAdmin.php?deletePro=32" method="post">
        <label for="">Delete</label>
        <input type="submit">
    </form>
</body>

</html>