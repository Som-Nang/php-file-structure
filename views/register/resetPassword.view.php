<?php require base_path('views/partials/header.php') ?>
<main>
    <div class="flex min-h-full items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
        <div class="w-full max-w-md space-y-8">
            <div>
                <img class="mx-auto h-12 w-auto" src="https://play-lh.googleusercontent.com/DTzWtkxfnKwFO3ruybY1SKjJQnLYeuK3KmQmwV5OQ3dULr5iXxeEtzBLceultrKTIUTr"
                    alt="Your Company">
                <h2 class="mt-6 text-center text-3xl font-bold tracking-tight text-gray-900">Your New Password</h2>
            </div>
            <form class="mt-8 space-y-6" action="/updatePassword" method="POST">
                <div class="space-y-4 rounded-md shadow-sm">
                    <label class="hidden">
                        <input name="selector" autocomplete="" value='<?= $selector ?? '' ?>' />
                    </label>
                    <label class="hidden">
                        <input name="token" autocomplete="" value='<?= $token ?? '' ?>' />
                    </label>
                    <div>
                        <label for="password" class="sr-only">Password</label>
                        <input id="password" name="password" type="password" autocomplete="" required
                            class="relative block w-full appearance-none rounded-none rounded-t-md border border-gray-300 px-3 py-2 text-gray-900 placeholder-gray-500 focus:z-10 focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 sm:text-sm"
                            placeholder="Password">
                    </div>
                    <div>
                        <label for="confirm-password" class="sr-only">confirm-password</label>
                        <input id="confirm-password" name="confirm-password" type="password" autocomplete="" required
                            class="relative block w-full appearance-none rounded-none rounded-t-md border border-gray-300 px-3 py-2 text-gray-900 placeholder-gray-500 focus:z-10 focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 sm:text-sm"
                            placeholder="confirm-password">
                    </div>
                </div>
                <div>
                    <button type="submit"
                        class="group relative flex w-full justify-center rounded-md border border-transparent bg-indigo-600 py-2 px-4 text-sm font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                        Update
                    </button>
                </div>
                <ul>

                    <?php if (isset($errors['errors'])) : ?>
                        <li class="text-red-500 text-xs mt-2"><?= $errors['errors'] ?></li>
                    <?php endif; ?>

                </ul>
            </form>
        </div>
    </div>
</main>
<?php require base_path('views/partials/footer.php') ?>