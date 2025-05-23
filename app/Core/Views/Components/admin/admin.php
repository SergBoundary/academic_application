<div class="container border mb-2 p-4 bg-body shadow">
    <div class="row">
        <h3 class="mb-4"><?= htmlspecialchars(__($title)) ?></h3>
        <h6>User group</h6>
        <div class="btn-group-vertical mb-2" role="group" aria-label="User group">
            <a class="btn btn-outline-secondary text-start" href="/<?= $language ?>/admin/users">+ <?= __('users') ?></a>
            <a class="btn btn-outline-secondary text-start" href="/<?= $language ?>/admin/messages">+ <?= __('messages') ?></a>
            <a class="btn btn-outline-secondary text-start disabled" href=""><?= __('user_statistics') ?></a>
        </div>
        <h6>Research group</h6>
        <div class="btn-group-vertical mb-2" role="group" aria-label="Research group">
            <a class="btn btn-outline-secondary text-start" href="/<?= $language ?>/admin/research">+ <?= __('authors_research_table') ?></a>
            <a class="btn btn-outline-secondary text-start" href="/<?= $language ?>/admin/research/standard/design">- <?= __('research_design_standards') ?></a>
            <a class="btn btn-outline-secondary text-start disabled" href="/<?= $language ?>/admin/research/standard/implementation"><?= __('research_implementation_standards') ?></a>
            <a class="btn btn-outline-secondary text-start disabled" href="/<?= $language ?>/admin/research/standard/publication"><?= __('research_publication_standards') ?></a>
        </div>
        <h6>Devops group</h6>
        <div class="btn-group-vertical mb-2" role="group" aria-label="Devops group">
            <a class="btn btn-outline-secondary text-start" href="/<?= $language ?>/admin/translations">+ <?= __('translation_table') ?></a>
            <a class="btn btn-outline-secondary text-start disabled" href=""><?= __('performance_analysis') ?></a>
            <a class="btn btn-outline-secondary text-start disabled" href=""><?= __('log_analysis') ?></a>
        </div>
    </div>
</div>