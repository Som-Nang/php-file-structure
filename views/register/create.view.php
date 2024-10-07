<?php require base_path('views/partials/header.php') ?>
<?php require base_path('views/partials/nav.php') ?>
    <main>
        <div class="flex min-h-full items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
            <div class="w-full max-w-md space-y-8">
                <div>
                    <img class="mx-auto h-12 w-auto" src="https://play-lh.googleusercontent.com/DTzWtkxfnKwFO3ruybY1SKjJQnLYeuK3KmQmwV5OQ3dULr5iXxeEtzBLceultrKTIUTr"
                         alt="Your Company">
                    <h2 class="mt-6 text-center text-3xl font-bold tracking-tight text-gray-900">Register for a new
                        account</h2>
                </div>
                <form class="mt-8 space-y-6" action="/register" method="POST">
                    <div class="space-y-4 rounded-md shadow-sm">
                        <div>
                            <label for="name" class="sr-only">Full Name</label>
                            <input id="name" name="username" required
                                   class="relative block w-full appearance-none rounded-none rounded-t-md border border-gray-300 px-3 py-2 text-gray-900 placeholder-gray-500 focus:z-10 focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 sm:text-sm"
                                   placeholder="Full Name">
                        </div>

                        <div>
                            <label for="email" class="sr-only">Email address</label>
                            <input id="email" name="email" type="email" autocomplete="email" required
                                   class="relative block w-full appearance-none rounded-none rounded-t-md border border-gray-300 px-3 py-2 text-gray-900 placeholder-gray-500 focus:z-10 focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 sm:text-sm"
                                   placeholder="Email address">
                        </div>
                        <div>
                            <label for="password" class="sr-only">Password</label>
                            <input id="password" name="password" type="password" autocomplete="current-password" required
                                   class="relative block w-full appearance-none rounded-none rounded-b-md border border-gray-300 px-3 py-2 text-gray-900 placeholder-gray-500 focus:z-10 focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 sm:text-sm"
                                   placeholder="Password">
                        </div>
                    </div>
                    <div>
                        <button type="submit"
                                class="group relative flex w-full justify-center rounded-md border border-transparent bg-indigo-600 py-2 px-4 text-sm font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
                        >
                            Register
                        </button>
                        <div class="w-full flex items-center justify-end ">
                            <a href="/forget-password" class="text-gray-800 my-2 text-secondary hover:text-blue-800">Forget Password?</a>
                        </div>
                    </div>
                    <ul>
                        <?php if (isset($errors['username'])) : ?>
                            <li class="text-red-500 text-xs mt-2"><?= $errors['username'] ?></li>
                        <?php endif; ?>
                        <?php if (isset($errors['email'])) : ?>
                            <li class="text-red-500 text-xs mt-2"><?= $errors['email'] ?></li>
                        <?php endif; ?>
                        <?php if (isset($errors['password'])) : ?>
                            <li class="text-red-500 text-xs mt-2"><?= $errors['password'] ?></li>
                        <?php endif; ?>
                    </ul>
                </form>
            </div>
        </div>
    </main>
<?php require base_path('views/partials/footer.php') ?>