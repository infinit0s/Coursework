<?php

echo form_open('auth/login');
?>
<h2>Please login</h2>
<?php echo form_error('login', '<div class="alert alert-block">', '</div>') ?>
<label for="login">Login</label>
<input id="login" type="text" name="login"><br>

<?php echo form_error('pass', '<div class="alert alert-block">', '</div>') ?>
<label for="pass">Password</label>
<input id="pass" type="password" name="pass"><br>


<button class="btn btn-primary btn-large" type="submit" name="submit">Login</button>
</form>
