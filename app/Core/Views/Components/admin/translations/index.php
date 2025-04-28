<div class="container mt-2 p-4 bg-light shadow-lg">
    <div class="row">
        <div class="col">
            <div class="float-end">
                <a href="/<?= $language ?>/admin/translations/create" class="btn btn-outline-secondary btn-sm rounded-pill" title="<?= __('add_translation') ?>"><i class="bi bi-plus-lg"></i> <?= __('add_translation') ?></a>
            </div>
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th scope="col"><?= __('key') ?></th>
                        <th scope="col">EN</th>
                        <th scope="col">PL</th>
                        <th scope="col">UK</th>
                        <th scope="col">RU</th>
                        <th scope="col" class="col-1"><?= __('actions') ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($translations as $translate): ?>
                        <tr>
                            <td><?= htmlspecialchars($translate['key_name']) ?></td>
                            <td><?= htmlspecialchars($translate['en']) ?></td>
                            <td><?= htmlspecialchars($translate['pl']) ?></td>
                            <td><?= htmlspecialchars($translate['uk']) ?></td>
                            <td><?= htmlspecialchars($translate['ru']) ?></td>
                            <td>
                                <a href="/<?= $language ?>/admin/translations/edit/<?= urlencode($translate['key_name']) ?>" class="btn btn-outline-warning btn-sm" title="<?= __('edit') ?>"><i class="bi bi-pencil-fill"></i></a>
                                <form method="POST" action="/<?= $language ?>/admin/translations/delete" class="d-inline-block">
                                    <input type="hidden" name="key" value="<?= htmlspecialchars($translate['key_name']) ?>">
                                    <button type="submit" class="btn btn-outline-danger btn-sm" onclick="return confirm('<?= __('delete_translation') ?> \'<?= htmlspecialchars($translate['key_name']) ?>\'?');" title="<?= __('delete') ?>"><i class="bi bi-trash3-fill"></i></button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>