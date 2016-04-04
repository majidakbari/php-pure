
<html>
<head>
<script src="http://ajax.aspnetcdn.com/ajax/jQuery/jquery-1.12.0.min.js"> </script>
<script>
    function checkUserExist()
    {

        $('#emailMessage').html('');
        var email = $('#email').val();

        $.ajax({
            url: "user-exist?email="+email,
            success: function(result){



                //user exists
                if(result == 1){
                    $('#emailMessage').html('user already exist');
                }
                //user doesn't exist
                else{
                    //do nothing
                }
            },
            error: function() {
                $('#notification-bar').text('An error occurred');
            }
        });
    }
</script>
</head>
<body>
<form action="" method="post">
    <input type="hidden" name="csrf" value="<?php echo $_SESSION['token'] = md5(uniqid(mt_rand(), true)); ?>">
    Name <input name="name" placeholder="First Name" required /><br>
    Email<input id="email" name="email" placeholder="someone@example.com" onblur="checkUserExist()" required />  <span id="emailMessage" style="color:red;"></span>
    <br>
    Website<input type="url" name="website" required /><br>
    Gender<select name="gender" required><br>
        <option>Male</option>
        <option>Female</option>
    </select>
    <input type="submit" name="submit" value="Submit" />
</form>
<a href="/show-user"> Show All Users</a>

</body>
</html>