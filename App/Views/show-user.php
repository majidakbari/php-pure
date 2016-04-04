
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
</head>


<body>
<div class="container">
<table class="table">
    <tr>
        <td><b>Name</b></td>
        <td><b>Email</b></td>
        <td><b>Website</b></td>
        <td><b>Gender</b></td>
        <td><b>actions</b></td>
    </tr>

    <?php foreach($users as $user) :?>
        <tr>
            <td><?= $escape ->escape($user['name']); ?></td>
            <td><?= $escape ->escape($user['email']); ?></td>
            <td><?= $escape ->escape($user['website']); ?></td>
            <td><?= $escape ->escape($user['gender']); ?></td>
            <td><a href="/update-user/<?php echo $user['id'] ?>">Update</a> <a href="/delete-user/<?php echo $user['id'] ?>"> Delete</a> </td>
        </tr>

    <?php  endforeach; ?>
</table>


<?php

for($i=1;$i<$pages_count+1; $i++){
    echo '<a href="http://localhost:8080/show-user?page='.$i. '">'.$i.'</a>';
}

?>
<br><a href="/admin-logout"> Admin Log out</a>
<br><a href="/add-user"> Add user</a>
</div>
</body>
</html>
