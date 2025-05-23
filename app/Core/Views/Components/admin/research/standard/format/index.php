<div class="container border mb-2 p-4 bg-body shadow">
    <div class="row">
        <?php if (!empty($groupedPosts)): ?>
            <div class="col">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th scope="col">Author</th>
                            <th scope="col">ID</th>
                            <th scope="col">Title</th>
                            <th scope="col" class="col-1">Type</th>
                            <th scope="col" class="col-1">Created</th>
                            <th scope="col" class="col-1">Updated</th>
                            <th scope="col" class="col-1">Locked</th>
                            <th scope="col" class="col-1">Edit</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($groupedPosts as $group): ?>
                            <?php $username = '' ?>
                            <?php foreach ($group['post'] as $post): ?>
                                <tr>
                                    <td>
                                        <?php if ($group['username'] !== $username): ?>
                                            <a class="text-decoration-none" href="/<?= $language ?>/admin/users/edit/<?= $group['user_id']; ?>"><?= htmlspecialchars($group['name']) ?> <?= htmlspecialchars($group['surname']) ?></a>
                                        <?php endif; ?>
                                    </td>
                                    <td><?= htmlspecialchars($post['id']) ?></td>
                                    <td><?= htmlspecialchars($post['title']) ?></td>
                                    <td><?= htmlspecialchars($post['type_id']) ?></td>
                                    <td><?= htmlspecialchars($post['created_at']) ?></td>
                                    <td><?= htmlspecialchars($post['updated_at']) ?></td>
                                    <td>
                                        <form method="POST" action="/<?= $language ?>/admin/research/lock/<?= $post['id'] ?>" class="ajax-lock-form d-inline-block" data-post-id="<?= $post['id'] ?>">
                                            <div class="form-check form-switch">
                                                <input class="form-check-input lock-toggle" type="checkbox" <?= !empty($post['locked']) ? 'checked' : '' ?>>
                                            </div>
                                        </form>
                                    </td>
                                    <td>
                                        <a href="/<?= $language ?>/admin/research/<?= $post['id'] ?>/edit" class="btn btn-outline-warning btn-sm" title="<?= __('edit') ?>"><i class="bi bi-pencil-fill"></i></a>
                                    </td>
                                </tr>
                                <?php $username = $group['username'] ?>
                            <?php endforeach; ?>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <div class="h-auto mx-auto text-center p-5">
                <h3 class="text-muted"><?= __('no_publications_here_yet') ?></h3>
            </div>
        <?php endif; ?>
    </div>
</div>