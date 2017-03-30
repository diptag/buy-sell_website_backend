
<form action="change_password" method="POST">
    <?php
        if (!empty($error_msg))
        {
            // display msg
    ?>
            <div class="error_msg"><?= $error_msg ?></div>
    <?php
        }
    ?>
	<input type="password" name="old" placeholder="Old Password" required><br>
    <input type="password" name="new" placeholder="New Password" required><br>
    <input type="password" name="renew" placeholder="Re-Type Password" required><br>
    <input type="submit" value="Change Password">
</form>