<div class="container border mb-2 p-4 bg-body shadow">
    <div class="row">
        <div class="col-3 mx-auto text-center">
            <h5><?= __($title) ?></h5>
            <form action="/<?= $language ?>/password/reset-request" method="POST">
                <div class="mb-3 row">
                    <input type="email" class="form-control" name="email" placeholder="<?= __('email') ?>" required>
                </div>
                <div class="mb-3 row">
                    <button type="submit" class="btn btn-secondary"><?= __('to_reset_password') ?></button>
                </div>
            </form>
        </div>
    </div>
</div>