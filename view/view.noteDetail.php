<?php require ("partials/header.php")?>
<?php require ("partials/nav.php")?>
<?php require ("partials/banner.php")?>
<main>
    <div class="mx-auto flex flex-col items-start justify-center p-6">
        <a class="hover:text-blue-500 my-6 underline" href="/note"> <-Go Back </a>

        <p class="font-bold "><?=  $note['body']?>..... <span class="text-red-500"> <?= $note['name'] ?></span> </p>

    </div>
</main>
<?php require ("partials/footer.php")?>
