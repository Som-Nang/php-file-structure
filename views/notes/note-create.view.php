<?php require base_path("views/partials/header.php") ?>
<?php require base_path("views/partials/nav.php") ?>
<?php require base_path("views/partials/banner.php") ?>
<main>
    <div class="mx-auto flex flex-col items-start justify-center p-6">
        <form action="" method="POST">
            <label for="body">Description</label>
            <div class="">
                <textarea class="bg-gray-500" name="body" id="body" cols="30" rows="10"><?= $_POST['body'] ?? '' ?></textarea>
            </div>
            <?php if (isset($error['body'])) : ?>
                <p class="text-red-500 text-sm"><?= $error['body'] ?></p>
            <?php endif; ?>
            <button type="submit" class="button bg-blue-500 p-4 hover:bg-blue-600 text-white rounded-md" name="submit">
                Submit
            </button>
        </form>
    </div>
</main>
<?php require base_path("views/partials/footer.php") ?>