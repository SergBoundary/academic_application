<div class="container border mb-2 p-4 bg-body shadow">
    <div class="row">
        <h3><?= htmlspecialchars(__($title)) ?></h3>
        <ul class="list-group">
            <li class="list-group-item"><a class="text-decoration-none" href="/<?= $language ?>/admin/messages"><?= __('messages_from_users') ?></a></li>
            <li class="list-group-item"><a class="text-decoration-none" href="/<?= $language ?>/admin/users"><?= __('users') ?></a></li>
            <li class="list-group-item"><a class="text-decoration-none" href="/<?= $language ?>/admin/translations"><?= __('translation_table') ?></a></li>
            <li class="list-group-item"><a class="text-decoration-none" href=""><?= __('performance_analysis') ?></a></li>
            <li class="list-group-item"><a class="text-decoration-none" href=""><?= __('log_analysis') ?></a></li>
            <li class="list-group-item"><a class="text-decoration-none" href=""><?= __('user_statistics') ?></a></li>
        </ul>
    </div>
</div>