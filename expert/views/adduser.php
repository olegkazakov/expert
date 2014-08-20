<form action="index.php?action=newuser" method="POST" name="form1">
  <fieldset>
    <legend>Registration</legend>
    <p><label>Enter Login: 
        <input type="text" name="name" size="15" maxlength="15">
       </label>
    </p>
    <p><label>Enter your password:  
        <input type="password" name="password" size="25" maxlength="30">
       </label>
    </p>
    <p><label>Repeat password:
        <input type="password" name="repass" size="25" maxlength="30"/>
      </label>
    </p>
    <p><label>Enter your E-mail:  
        <input type="email" name="email" size="20" maxlength="20">
       </label>
    </p>
  </fieldset>
<p><input type="submit" />
</p>
</form>
<?php
if (!empty($this->view->error)) {
  echo "<div>{$this->view->error}</div>";
} 
?>