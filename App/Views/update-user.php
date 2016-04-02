<html>
<body>

<form action="" method="post">
    Name    :  <input type="text" name="name" value="<?php echo !empty($result['name']) ? $result['name'] : '' ?>"><br>
    Email   : <input type="text" name="email" value="<?php echo !empty($result['email']) ? $result['email'] : '' ?>"><br>
    Website : <input type="text" name="website" value="<?php echo !empty($result['website']) ? $result['website'] : '' ?>"><br>
    Gender:
    <input type="radio" name="gender" value="female">Female
    <input type="radio" name="gender" value="male">Male


   <br> <input type="submit">

</form>
<br> <a href="/add-user"> Sign up page</a>
</body>
</html>
