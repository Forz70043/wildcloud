<div class='container-form'>
  <div class='row justify-content-md-center'>
  <form class="form-signin" action='elogin.php' method="POST">
    <img class="mb-4" src="" alt="" width="72" height="72">
    <h1 class="h3 mb-3 font-weight-normal">Please sign in</h1>
    [+include file='forms/input.tpl' name='email' type='email' label='EmailAddress' required=1 +]
    
    [+include file='forms/input.tpl' type='password' name='password' label='Password' required=1 +]

    <img id="captcha" src="../includes/securimage/securimage_show.php" alt="CAPTCHA Image" />
    [+include file='forms/input.tpl' name='captcha_code' label='' placeholder='write code here'+]
    <!--<input type="text" name="captcha_code" size="10" maxlength="6" />-->
    <div class="form-group col">
    <a href="#" onclick="document.getElementById('captcha').src='../includes/securimage/securimage_show.php?' + Math.random(); return false"><span class="fas fa-sync-alt"></span> Reload </a></div>
    [+include file='forms/checkbox.tpl' label='Remember me' value=0 required=0 +]
    <!--<div class="checkbox mb-3">
      <label>
        <input type="checkbox" value="remember-me"> Remember me
      </label>
    </div>-->
    <button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
    <p class="mt-5 mb-3 text-muted align-center">&copy; [+$dateTime|date_format:"%Y"+]</p>
  </form>
</div>
</div>