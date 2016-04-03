
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
</head>


<body>
<table class="table">
    <tr>
        <td>Name</td>
        <td>Email</td>
        <td>Website</td>
        <td>Gender</td>
        <td>actions</td>
    </tr>

    <?php foreach($users as $user) :?>
        <tr>
            <td><?= $user['name']; ?></td>
            <td><?= $user['email']; ?></td>
            <td><?= $user['website']; ?></td>
            <td><?= $user['gender']; ?></td>
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
</body>
</html>
