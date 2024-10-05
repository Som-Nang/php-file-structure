<?php require base_path("views/partials/header.php") ?>
<?php require base_path("views/partials/nav.php") ?>
<?php require base_path("views/partials/banner.php") ?>
<main>
    <div class="mx-auto flex flex-col items-start justify-center p-6">
        <a class="hover:text-blue-500 my-6 underline" href="/notes"> <-Go Back </a>

        <p class="font-bold "><?=  $note['body']?>..... <span class="text-red-500"> <?= $note['body'] ?></span> </p>

        <footer class="mt-6">
            <a href="/note/edit?id=<?= $note['id'] ?>" class="inline-flex justify-center rounded-md border border-transparent bg-gray-500 py-2 px-4 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">Edit</a>
        </footer>
    </div>
</main>
<?php require base_path("views/partials/footer.php") ?>
