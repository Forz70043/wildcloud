<div class="container">
    <div class="card">
        <div class="card-header">
            <h5 class="card-title">[+$form->getTitle()+]</h5>
        </div>
        <div class="card-body">
            <form method="[+$form->getMethod()+]" action="[+$form->getUrl()+]">
                <div class="form-group">
                    [+include file=$formTpl+]
                </div>
                <button class="btn btn-primary" type="submit" name="submit">Submit</button>
            </form>
        </div>
        <div class="card-footer text-muted">
            <!--<a href="#" class="btn btn-primary">Submit</a>-->
        </div>
    </div>
</div>