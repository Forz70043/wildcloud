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
                [+assign var='actions' value=$form->getActions()+]

                <button class="btn btn-primary" type="submit" name="submit">Invia</button>
            </form>
        </div>
        <div class="card-footer text-muted">
        </div>
    </div>
</div>