<div class="container p-5 bg-light shadow-lg border">
    <?php if (!empty($error)): ?>
        <div class="alert alert-danger text-center col-8 mx-auto " role="alert">
            <?= $error ?>
        </div>
    <?php endif; ?>
    <div class="row">
        <div class="col-3 mx-auto text-center">
            <h5><?= __($title) ?></h5>
            <form method="POST">
                <div class="mb-3 row">
                    <input type="text" class="form-control" name="name" placeholder="<?= __('name') ?>" required>
                </div>
                <div class="mb-3 row">
                    <input type="text" class="form-control" name="surname" placeholder="<?= __('surname') ?>">
                </div>
                <div class="mb-3 row">
                    <input type="email" class="form-control" name="email" placeholder="<?= __('email') ?>" required>
                </div>
                <div class="mb-3 row">
                    <input type="password" class="form-control" name="password" placeholder="<?= __('password') ?>" required>
                </div>
                <div class="mb-3 row">
                    <button type="submit" class="btn btn-secondary"><?= __('sign_up') ?></button>
                </div>
            </form>
            <a class="text-decoration-none" href="/<?= $language ?>/login"><?= __('authorization') ?></a>
        </div>
    </div>
</div>