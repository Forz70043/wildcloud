<div class="form-row">
    [+include file="forms/input.tpl" name="email" label="Email Address" required=1+]
</div>
<div class="form-row">
    [+include file="forms/input.tpl" type="password" name="password" label="Password" 
    ariadescribe=1 ariadescribeName="passwordHelp" 
    ariadescribeText="Your password must be 8-20 characters long, contain letters and numbers, and must not contain spaces, special characters, or emoji. " 
    required=1+]
</div>
<div class="form-row">
    [+include file="forms/select.tpl" name="role" label="Ruolo" choices=$roles required=1+]
</div>
<div class="form-row">
    [+include file="forms/select.tpl" name="company" label="Azienda" choices=$companies+]
</div>
<div class="form-row">
    [+include file="forms/select.tpl" name="site" label="Sede" choices=$sites+]
</div>