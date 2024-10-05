<?php require base_path("views/partials/header.php") ?>
<?php require base_path("views/partials/nav.php") ?>
<?php require base_path("views/partials/banner.php") ?>
<main>
    <div class="mx-auto flex flex-col items-start justify-center p-6">
        <form class="w-full " action="" method="">
            <label for="body" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Your Notes</label>
            <textarea name="body" id="body" rows="4"
                      class="mb-4 block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Write your thoughts here..."><?= $_POST['body'] ?? '' ?></textarea>

            <?php if (isset($error['body'])) : ?>
                <p class="text-red-500 text-sm"><?= $error['body'] ?></p>
            <?php endif; ?>
            <button type="button" id="submit" class="button bg-blue-500 p-4 hover:bg-blue-600 text-white rounded-md" name="submit">
                Submit
            </button>
        </form>
    </div>
</main>
<?php require base_path("views/partials/main-script-section.php") ?>
    <script>
        $("#submit").click(function(){
            let body = $("#body").val();
            console.log(body);
            $.ajax({
                type: 'POST',
                url: '<?= '/note/store' ?>',
                data:{
                    body: body,
                },
                success: function(result){
                    console.log(result.status)
                }
            });
        });
    </script>
<?php require base_path("views/partials/footer.php") ?>