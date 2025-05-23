<!-- Discipline list -->
<div class="container border mb-2 p-4 bg-body shadow">
    <div class="row">
        <div class="col">
            <div class="float-start">
                <h5><?= __('research_disciplines') ?></h5>
            </div>
            <div class="float-end">
                <a href="/<?= $language ?>/admin/research/standard/structure/create/discipline" class="btn btn-outline-secondary btn-sm rounded-pill" title="<?= __('add_discipline') ?>"><i class="bi bi-plus-lg"></i> <?= __('add_discipline') ?></a>
            </div>
            <?php if (!empty($disciplines)): ?>
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th scope="col">Id</th>
                            <th scope="col">EN</th>
                            <th scope="col">PL</th>
                            <th scope="col">UK</th>
                            <th scope="col">RU</th>
                            <th scope="col" class="col-1"><?= __('actions') ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($disciplines as $discipline): ?>
                            <tr>
                                <td><?= htmlspecialchars($discipline['id']) ?></td>
                                <td><?= htmlspecialchars($discipline['en']) ?></td>
                                <td><?= htmlspecialchars($discipline['pl']) ?></td>
                                <td><?= htmlspecialchars($discipline['uk']) ?></td>
                                <td><?= htmlspecialchars($discipline['ru']) ?></td>
                                <td>
                                    <a href="/<?= $language ?>/admin/translations/edit/<?= urlencode($discipline['id']) ?>" class="btn btn-outline-warning btn-sm" title="<?= __('edit') ?>"><i class="bi bi-pencil-fill"></i></a>
                                    <form method="POST" action="/<?= $language ?>/admin/translations/delete" class="d-inline-block">
                                        <input type="hidden" name="key" value="<?= htmlspecialchars($discipline['id']) ?>">
                                        <button type="submit" class="btn btn-outline-danger btn-sm" onclick="return confirm('<?= __('delete_translation') ?> \'<?= htmlspecialchars($discipline[$language]) ?>\'?');" title="<?= __('delete') ?>"><i class="bi bi-trash3-fill"></i></button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <div class="h-auto mx-auto text-center p-5">
                    <h3 class="text-muted"><?= __('no_research_disciplines_here_yet') ?></h3>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
<!-- Field list -->
<div class="container border mb-2 p-4 bg-body shadow">
    <div class="row">
        <div class="col">
            <div class="float-start">
                <h5><?= __('research_fields') ?></h5>
            </div>
            <div class="float-end">
                <a href="/<?= $language ?>/admin/research/standard/structure/create/field" class="btn btn-outline-secondary btn-sm rounded-pill" title="<?= __('add_field') ?>"><i class="bi bi-plus-lg"></i> <?= __('add_field') ?></a>
            </div>
            <?php if (!empty($fields)): ?>
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th scope="col">Id</th>
                            <th scope="col">Discipline</th>
                            <th scope="col">EN</th>
                            <th scope="col">PL</th>
                            <th scope="col">UK</th>
                            <th scope="col">RU</th>
                            <th scope="col" class="col-1"><?= __('actions') ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($fields as $field): ?>
                            <tr>
                                <td><?= htmlspecialchars($field['id']) ?></td>
                                <td><?= htmlspecialchars($field['discipline']) ?></td>
                                <td><?= htmlspecialchars($field['en']) ?></td>
                                <td><?= htmlspecialchars($field['pl']) ?></td>
                                <td><?= htmlspecialchars($field['uk']) ?></td>
                                <td><?= htmlspecialchars($field['ru']) ?></td>
                                <td>
                                    <a href="/<?= $language ?>/admin/translations/edit/<?= urlencode($field['id']) ?>" class="btn btn-outline-warning btn-sm" title="<?= __('edit') ?>"><i class="bi bi-pencil-fill"></i></a>
                                    <form method="POST" action="/<?= $language ?>/admin/translations/delete" class="d-inline-block">
                                        <input type="hidden" name="key" value="<?= htmlspecialchars($field['id']) ?>">
                                        <button type="submit" class="btn btn-outline-danger btn-sm" onclick="return confirm('<?= __('delete_translation') ?> \'<?= htmlspecialchars($field[$language]) ?>\'?');" title="<?= __('delete') ?>"><i class="bi bi-trash3-fill"></i></button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <div class="h-auto mx-auto text-center p-5">
                    <h3 class="text-muted"><?= __('no_research_fields_here_yet') ?></h3>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
<!-- Area list -->
<div class="container border mb-2 p-4 bg-body shadow">
    <div class="row">
        <div class="col">
            <div class="float-start">
                <h5><?= __('research_areas') ?></h5>
            </div>
            <div class="float-end">
                <a href="/<?= $language ?>/admin/research/standard/structure/create/area" class="btn btn-outline-secondary btn-sm rounded-pill" title="<?= __('add_area') ?>"><i class="bi bi-plus-lg"></i> <?= __('add_area') ?></a>
            </div>
            <?php if (!empty($areas)): ?>
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th scope="col">Id</th>
                            <th scope="col">Discipline</th>
                            <th scope="col">Field</th>
                            <th scope="col">EN</th>
                            <th scope="col">PL</th>
                            <th scope="col">UK</th>
                            <th scope="col">RU</th>
                            <th scope="col" class="col-1"><?= __('actions') ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($areas as $area): ?>
                            <tr>
                                <td><?= htmlspecialchars($area['id']) ?></td>
                                <td><?= htmlspecialchars($field['discipline']) ?></td>
                                <td><?= htmlspecialchars($field['field']) ?></td>
                                <td><?= htmlspecialchars($area['en']) ?></td>
                                <td><?= htmlspecialchars($area['pl']) ?></td>
                                <td><?= htmlspecialchars($area['uk']) ?></td>
                                <td><?= htmlspecialchars($area['ru']) ?></td>
                                <td>
                                    <a href="/<?= $language ?>/admin/translations/edit/<?= urlencode($area['id']) ?>" class="btn btn-outline-warning btn-sm" title="<?= __('edit') ?>"><i class="bi bi-pencil-fill"></i></a>
                                    <form method="POST" action="/<?= $language ?>/admin/translations/delete" class="d-inline-block">
                                        <input type="hidden" name="key" value="<?= htmlspecialchars($area['id']) ?>">
                                        <button type="submit" class="btn btn-outline-danger btn-sm" onclick="return confirm('<?= __('delete_translation') ?> \'<?= htmlspecialchars($area[$language]) ?>\'?');" title="<?= __('delete') ?>"><i class="bi bi-trash3-fill"></i></button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <div class="h-auto mx-auto text-center p-5">
                    <h3 class="text-muted"><?= __('no_research_areas_here_yet') ?></h3>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
<!-- Research types -->
<div class="container border mb-2 p-4 bg-body shadow">
    <div class="row">
        <div class="col">
            <div class="float-start">
                <h5><?= __('research_types') ?></h5>
            </div>
            <div class="float-end">
                <a href="/<?= $language ?>/admin/research/standard/structure/create/type" class="btn btn-outline-secondary btn-sm rounded-pill" title="<?= __('add_type') ?>"><i class="bi bi-plus-lg"></i> <?= __('add_type') ?></a>
            </div>
            <?php if (!empty($types)): ?>
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th scope="col">Id</th>
                            <th scope="col">EN</th>
                            <th scope="col">PL</th>
                            <th scope="col">UK</th>
                            <th scope="col">RU</th>
                            <th scope="col" class="col-1"><?= __('actions') ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($types as $type): ?>
                            <tr>
                                <td><?= htmlspecialchars($type['id']) ?></td>
                                <td><?= htmlspecialchars($type['en']) ?></td>
                                <td><?= htmlspecialchars($type['pl']) ?></td>
                                <td><?= htmlspecialchars($type['uk']) ?></td>
                                <td><?= htmlspecialchars($type['ru']) ?></td>
                                <td>
                                    <a href="/<?= $language ?>/admin/translations/edit/<?= urlencode($type['id']) ?>" class="btn btn-outline-warning btn-sm" title="<?= __('edit') ?>"><i class="bi bi-pencil-fill"></i></a>
                                    <form method="POST" action="/<?= $language ?>/admin/translations/delete" class="d-inline-block">
                                        <input type="hidden" name="key" value="<?= htmlspecialchars($type['id']) ?>">
                                        <button type="submit" class="btn btn-outline-danger btn-sm" onclick="return confirm('<?= __('delete_translation') ?> \'<?= htmlspecialchars($type[$language]) ?>\'?');" title="<?= __('delete') ?>"><i class="bi bi-trash3-fill"></i></button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <div class="h-auto mx-auto text-center p-5">
                    <h3 class="text-muted"><?= __('no_research_types_here_yet') ?></h3>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
<!-- Research elements -->
<div class="container border mb-2 p-4 bg-body shadow">
    <div class="row">
        <div class="col">
            <div class="float-start">
                <h5><?= __('research_elements') ?></h5>
            </div>
            <div class="float-end">
                <a href="/<?= $language ?>/admin/research/standard/structure/create/element" class="btn btn-outline-secondary btn-sm rounded-pill" title="<?= __('add_element') ?>"><i class="bi bi-plus-lg"></i> <?= __('add_element') ?></a>
            </div>
            <?php if (!empty($elements)): ?>
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th scope="col">Id</th>
                            <th scope="col">Type</th>
                            <th scope="col">EN</th>
                            <th scope="col">PL</th>
                            <th scope="col">UK</th>
                            <th scope="col">RU</th>
                            <th scope="col" class="col-1"><?= __('actions') ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($elements as $element): ?>
                            <tr>
                                <td><?= htmlspecialchars($element['id']) ?></td>
                                <td><?= htmlspecialchars($element['Type']) ?></td>
                                <td><?= htmlspecialchars($element['en']) ?></td>
                                <td><?= htmlspecialchars($element['pl']) ?></td>
                                <td><?= htmlspecialchars($element['uk']) ?></td>
                                <td><?= htmlspecialchars($element['ru']) ?></td>
                                <td>
                                    <a href="/<?= $language ?>/admin/translations/edit/<?= urlencode($element['id']) ?>" class="btn btn-outline-warning btn-sm" title="<?= __('edit') ?>"><i class="bi bi-pencil-fill"></i></a>
                                    <form method="POST" action="/<?= $language ?>/admin/translations/delete" class="d-inline-block">
                                        <input type="hidden" name="key" value="<?= htmlspecialchars($element['id']) ?>">
                                        <button type="submit" class="btn btn-outline-danger btn-sm" onclick="return confirm('<?= __('delete_translation') ?> \'<?= htmlspecialchars($element[$language]) ?>\'?');" title="<?= __('delete') ?>"><i class="bi bi-trash3-fill"></i></button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <div class="h-auto mx-auto text-center p-5">
                    <h3 class="text-muted"><?= __('no_research_elements_here_yet') ?></h3>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>