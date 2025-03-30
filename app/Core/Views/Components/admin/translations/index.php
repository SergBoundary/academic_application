<h2><?= htmlspecialchars(__($title)) ?></h2>
<p><a href="/<?= $language ?>/admin/translations/create"><?= __('add_translation') ?></a></p>
<table border="1" cellspacing="0" cellpadding="5">
    <thead>
        <tr>
            <th><?= __('key') ?></th>
            <th>RU</th>
            <th>EN</th>
            <th>PL</th>
            <th>UK</th>
            <th><?= __('actions') ?></th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($translations as $trans): ?>
        <tr>
            <td><?= htmlspecialchars($trans['key_name']) ?></td>
            <td><?= htmlspecialchars($trans['en']) ?></td>
            <td><?= htmlspecialchars($trans['pl']) ?></td>
            <td><?= htmlspecialchars($trans['uk']) ?></td>
            <td><?= htmlspecialchars($trans['ru']) ?></td>
            <td>
                <a href="/<?= $language ?>/admin/translations/edit/<?= urlencode($trans['key_name']) ?>"><?= __('edit') ?></a>
                <form action="/<?= $language ?>/admin/translations/delete" method="POST" style="display:inline;">
                    <input type="hidden" name="key" value="<?= htmlspecialchars($trans['key_name']) ?>">
                    <button type="submit" onclick="return confirm('<?= __('delete_translation') ?> \'<?= htmlspecialchars($trans['key_name']) ?>\'?')"><?= __('delete') ?></button>
                </form>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
