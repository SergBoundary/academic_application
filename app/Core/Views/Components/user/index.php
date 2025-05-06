<div class="container border mb-2 p-4 bg-body shadow">
    <div class="row">
        <div class="col">
            <?php
            $avatarFile = !empty($user['avatar']) ? "/uploads/avatars/" . htmlspecialchars($user['avatar']) : "/img/default-avatar.jpg";
            $avatarUrl = $avatarFile . "?v=" . time(); // Добавляем timestamp
            ?>
            <div class="float-start">
                <img class="rounded-circle border" src="<?= $avatarUrl ?>" alt="Аватар пользователя" width="40">
                <span class="fs-5 mx-3 my-0"><strong><?= htmlspecialchars($user['name'] . ' ' . $user['surname']) ?></strong></span>
            </div>
            <div class="float-end">
                <a class="btn btn-sm btn-outline-secondary" href="/<?= $language ?>/<?= $user['username']; ?>/profile" role="button"><?= __('user_profile') ?></a>
            </div>
        </div>
    </div>
</div>
<div class="container border mb-2 p-3 bg-body shadow">
    <div class="row">
        <div class="d-flex flex-wrap justify-content-between">
            <div class="card m-2" style="width: 18rem;">
                <img src="https://dummyimage.com/250x150" alt="250x150" class="card-img-top">
                <div class="card-body">
                    <h5 class="card-title">Card title</h5>
                    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                    <a href="#" class="btn btn-primary">Go somewhere</a>
                </div>
            </div>
            <div class="card m-2" style="width: 18rem;">
                <img src="https://dummyimage.com/250x150" alt="250x150" class="card-img-top">
                <div class="card-body">
                    <h5 class="card-title">Card title</h5>
                    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                    <a href="#" class="btn btn-primary">Go somewhere</a>
                </div>
            </div>
            <div class="card m-2" style="width: 18rem;">
                <img src="https://dummyimage.com/250x150" alt="250x150" class="card-img-top">
                <div class="card-body">
                    <h5 class="card-title">Card title</h5>
                    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                    <a href="#" class="btn btn-primary">Go somewhere</a>
                </div>
            </div>
            <div class="card m-2" style="width: 18rem;">
                <img src="https://dummyimage.com/250x150" alt="250x150" class="card-img-top">
                <div class="card-body">
                    <h5 class="card-title">Card title</h5>
                    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                    <a href="#" class="btn btn-primary">Go somewhere</a>
                </div>
            </div>
            <div class="card m-2" style="width: 18rem;">
                <img src="https://dummyimage.com/250x150" alt="250x150" class="card-img-top">
                <div class="card-body">
                    <h5 class="card-title">Card title</h5>
                    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                    <a href="#" class="btn btn-primary">Go somewhere</a>
                </div>
            </div>
            <div class="card m-2" style="width: 18rem;">
                <img src="https://dummyimage.com/250x150" alt="250x150" class="card-img-top">
                <div class="card-body">
                    <h5 class="card-title">Card title</h5>
                    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                    <a href="#" class="btn btn-primary">Go somewhere</a>
                </div>
            </div>
            <div class="card m-2" style="width: 18rem;">
                <img src="https://dummyimage.com/250x150" alt="250x150" class="card-img-top">
                <div class="card-body">
                    <h5 class="card-title">Card title</h5>
                    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                    <a href="#" class="btn btn-primary">Go somewhere</a>
                </div>
            </div>
            <div class="card m-2" style="width: 18rem;">
                <img src="https://dummyimage.com/250x150" alt="250x150" class="card-img-top">
                <div class="card-body">
                    <h5 class="card-title">Card title</h5>
                    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                    <a href="#" class="btn btn-primary">Go somewhere</a>
                </div>
            </div>
            <div class="card m-2" style="width: 18rem;">
                <img src="https://dummyimage.com/250x150" alt="250x150" class="card-img-top">
                <div class="card-body">
                    <h5 class="card-title">Card title</h5>
                    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                    <a href="#" class="btn btn-primary">Go somewhere</a>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="container border mb-2 p-4 bg-body shadow">
    <div class="row">
        <div class="col">
            ...
        </div>
    </div>
</div>