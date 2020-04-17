<div class='container'>
  <div class='row justify-content-md-center'>
  <form class="form-signin" action='elogin.php' method="POST">
    <img class="mb-4" src="{{ site.baseurl }}/docs/{{ site.docs_version }}/assets/brand/bootstrap-solid.svg" alt="" width="72" height="72">
    <h1 class="h3 mb-3 font-weight-normal">Please sign in</h1>
    <label for="inputEmail" class="sr-only">Email address</label>
    <input type="email" id="inputEmail" class="form-control" placeholder="Email address" required autofocus>
    <label for="inputPassword" class="sr-only">Password</label>
    <input type="password" id="inputPassword" class="form-control" placeholder="Password" required>
    <img id="captcha" src="../includes/securimage/securimage_show.php" alt="CAPTCHA Image" />
    <input type="text" name="captcha_code" size="10" maxlength="6" />
    <a href="#" onclick="document.getElementById('captcha').src='../includes/securimage/securimage_show.php?' + Math.random(); return false">[ Different Image ]</a>
    <div class="checkbox mb-3">
      <label>
        <input type="checkbox" value="remember-me"> Remember me
      </label>
    </div>
    <button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
    <p class="mt-5 mb-3 text-muted align-center">&copy; [+$dateTime|date_format:"%Y"+]</p>
  </form>
</div>
</div>