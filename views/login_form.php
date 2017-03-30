<form action="login" method="POST">
    <?php
        if (isset($error_msg))
        {
    ?>
    <div class="error-msg"><?= $error_msg ?></div>
    <?php
        }
    ?>
    <input type="email" placeholder="Enter Email" name="email" required><br>
    <input type="password" placeholder="Enter Password" name="password" required><br>
    <input type="submit" value="Log In">
</form>