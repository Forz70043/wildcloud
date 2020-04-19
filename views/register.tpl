<div class='container-form'>
    <div class='row justify-content-md-center'>
        <form class="form-signin" action='register.php' method="POST">
            <img class="mb-4" src="" alt="" width="72" height="72">
            <h1 class="h3 mb-3 font-weight-normal">Please sign up</h1>
            [+include file="forms/input.tpl" name=email required=1 label="Email Address"+]
            [+include file="forms/input.tpl" type=password name=password label=password required=1+]
            <button class="btn btn-lg btn-primary btn-block" type="submit" name="send" value="submit">Sign up</button>
        </form>
    </div>
</div>