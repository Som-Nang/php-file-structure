<?php require ("partials/header.php")?>
<?php require ("partials/nav.php")?>
<?php require ("partials/banner.php")?>

<main>
    <div class="flex items-center justify-center flex-col p-8">
        <p class="text-xl p-4">Welcome to <span class="text-green-500">About page</span> !!</p>

        <div>
            <?php
            echo '<pre>';
                var_dump($_SERVER);
            echo '</pre>';
                ?>

        </div>
    </div>
</main>
<?php require ("partials/footer.php")?>