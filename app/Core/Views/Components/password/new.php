<div class="container border mb-2 p-4 bg-body shadow">
    <div class="row">
        <div class="col-3 mx-auto text-center">
            <h5><?= __('new_password') ?></h5>
            <form action="/<?= $language ?>/password/update" method="POST">
                <input type="hidden" name="token" value="<?= htmlspecialchars($_GET['token'] ?? '') ?>">
                <div class="mb-3 row">
                    <input type="password" class="form-control" name="password" placeholder="<?= __('enter_new_password') ?>" required>
                </div>
                <div class="mb-3 row">
                    <button type="submit" class="btn btn-secondary"><?= __('update_password') ?></button>
                </div>
            </form>
        </div>
    </div>
</div>