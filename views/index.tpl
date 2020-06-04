<!DOCTYPE html>
<html>
  <head>
      [+include file="header.tpl" app_name=$app_name +]
  </head>
  <body onload="splash(1000)">
    [+if isset($PAGE_CONTENT)+]
      <div class="container">
        [+include file=$PAGE_CONTENT +]
      </div>
    [+else+]
      [+include file="navbar.tpl"+]
      [+include file="notice.tpl"+]
      [+if isset($view)+]
        [+include file=$view +]
      [+/if+]
      [+include file="footer.tpl"+]
    [+/if+]
  </body>
</html>