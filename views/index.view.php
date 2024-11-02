<?php require base_path("views/partials/header.php") ?>
<?php require base_path("views/partials/sidebar.php") ?>


<div class="p-4 sm:ml-64 h-screen  bg-gray-100 dark:bg-gray-900">
    <div class="p-2 mt-14">
        <?php require base_path("views/partials/banner.php") ?>
        <main>
            <div class="flex items-center justify-center">
                <p class="text-xl p-4">Welcome <span class="text-bold text-blue-800"> <?= $_SESSION['user']['user_name'] ?? 'Guest' ?> </span> to <span class="text-green-500">Home page</span> !!</p>
            </div>
        </main>
    </div>
</div>
<?php require base_path("views/partials/main-script-section.php") ?>
<?php require base_path("views/partials/footer.php") ?>