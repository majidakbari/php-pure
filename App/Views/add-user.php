

<form action="" method="post">
    <input type="hidden" name="csrf" value="<?php echo $_SESSION['token'] = md5(uniqid(mt_rand(), true)); ?>">
       Name <input name="name" placeholder="First Name" required /><br>
       Email<input name="email" placeholder="someone@example.com" required /><br>
     Website<input type="url" name="website" required /><br>
      Gender<select name="gender" required><br>
        <option>Male</option>
        <option>Female</option>
    </select>
    <input type="submit" name="submit" value="Submit" />
</form>
<a href="/show-user"> Show All Users</a>