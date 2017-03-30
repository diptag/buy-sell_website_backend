<form action="register" method="POST">
    <?php
        if (isset($error_msg))
        {
    ?>
    <div class="error-msg"><?= $error_msg ?></div>
    <?php
        }
    ?>
    <input type="text" placeholder="Enter Name" name="name" required><br>
    <input type="email" placeholder="Enter Email" name="email" required><br>
    <select name="college">
        <?php
            foreach ($colleges as $college)
            {
        ?>
        <option value="<?= $college["id"] ?>"><?= $college["name"] ?></option>
        <?php
            }
        ?>
    </select><br>
    <input type="password" placeholder="Enter Password" name="password" required><br>
    <input type="password" placeholder="Re - Enter Password" name="password_2" required><br>
    <input type="submit" value="Register">
</form>