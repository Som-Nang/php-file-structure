<?php require base_path("views/partials/header.php") ?>
<?php require base_path("views/partials/nav.php") ?>
<?php require base_path("views/partials/banner.php") ?>
<main>
    <div class="mx-auto flex flex-col items-start justify-center p-6">
        <a class="hover:text-blue-500 my-6 underline" href="/notes"> <-Go Back </a>

        <p class="font-bold "><?=  $note['body']?>..... <span class="text-red-500"> <?= $note['name'] ?></span> </p>

        <form method="POST">
            <input type="hidden" name="id" value="<?= $note['id'] ?>">
            <input type="hidden" name="_method" value="DELETE">
            <button  class="text-red-500 bg-red-200 py-1 px-2 rounded-md">Delete</button>
        </form>
    </div>
</main>
<?php require base_path("views/partials/footer.php") ?>
