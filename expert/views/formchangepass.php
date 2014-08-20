<form action="index.php?action=changepassword" method="POST" name="changepassword">
  <fieldset>
    <legend>Change password</legend>
    <p><label>Enter your password:  
        <input type="password" name="oldpass" size="25" maxlength="30">
       </label>
    </p>
    <p><label>Enter new password:
        <input type="password" name="newpass1" size="25" maxlength="30"/>
      </label>
    </p>
    <p><label>Repeat new password:
        <input type="password" name="newpass2" size="25" maxlength="30"/>
      </label>
    </p>
  </fieldset>
  <p><input type="submit" name="Confirm"/>
</p>
</form>