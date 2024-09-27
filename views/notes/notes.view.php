<?php require base_path("views/partials/header.php") ?>
<?php require base_path("views/partials/nav.php") ?>
<?php require base_path("views/partials/banner.php") ?>
<main>
    <div class="mx-auto flex flex-col items-start justify-center p-6">
        <?php foreach ($notes as $note) : ?>
            <li class="">
                <a class="text-lg font-bold hover:text-blue-500" href="/note/show?id=<?= $note['id'] ?>"><?= $note['body'] ?></a>
            </li>
        <?php endforeach; ?>


        <div class="m-6">
            <a class="button bg-blue-500 p-4 hover:bg-blue-600 text-white rounded-md" href="/note/create"> Create Note</a>
        </div>
    </div>
</main>
<?php require base_path("views/partials/footer.php") ?>