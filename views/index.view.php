<?php require ("partials/header.php")?>
<?php require ("partials/nav.php")?>
<?php require ("partials/banner.php")?>

<main>
    <div class="flex items-center justify-center">
        <p class="text-xl p-4">Welcome <span class="text-bold text-blue-800"> <?= $_SESSION['user']['user_name'] ?? 'Guest' ?> </span> to <span class="text-green-500">Home page</span> !!</p>
    </div>
</main>
<?php require ("partials/main-script-section.php")?>

    <script>

    </script>

<?php require ("partials/footer.php")?>