<form action="register" method="POST">
    <?php
        if (isset($error_msg))
        {
    ?>
    <div id="error-msg"><?= $error_msg ?></div>
    <?php
        }
    ?>
    <input type="text" placeholder="Enter Name" name="name"><br>
    <input type="email" placeholder="Enter Email" name="email"><br>
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
    <input type="password" placeholder="Enter Password" name="password"><br>
    <input type="password" placeholder="Re - Enter Password" name="password_2"><br>
    <input type="submit" value="Register">
</form>
