<div class="col-md-10">
    <form action="<?=$form_action; ?>" class="form-horizontal" method="post" accept-charset="utf-8">
        <div class="form-group">
            <label for="genre_id" class="control-label col-sm-offset-1 col-sm-2">Žanr</label>
            <div class="col-sm-3">
                <select name="genre_id" id="genre_id" class="btn btn-default">
                    <?=$genres; ?>
                </select>
            </div>
            <div class="col-sm-6 text-danger"><?=form_error('genre_id'); ?></div>
        </div>
        <div class="form-group">
            <div class="btn-group col-sm-offset-3 col-sm-10">
                <input type="submit" name="submit" value="Lisa"  class="btn btn-primary btn-sm" />
                <a href="<?=$cancel_link; ?>" class="btn btn-warning btn-sm" role="button">Katkesta</a>
            </div>
        </div>
    </form>
</div>
</div>