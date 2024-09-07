<?php require ("partials/header.php")?>
<?php require ("partials/nav.php")?>
<?php require ("partials/banner.php")?>
<main>
    <div class="mx-auto flex flex-col items-start justify-center p-6">
       <?php foreach ($notes as $note) : ?>
            <li class="">
                <a class="text-lg font-bold hover:text-blue-500" href="/noteDetail?id=<?= $note['id'] ?>"><?= $note['body'] ?></a>
            </li>
        <?php endforeach;?>
    </div>
</main>
<?php require ("partials/footer.php")?>
