<!-- <div class="w-full bg-gray-200 p-6">
    <h1 class="text-2xl font-bold text-blue-800"> <?= $heading ?? '' ?></h1>
</div> -->

<?php
// Render the breadcrumbs
$breadcrumbs = getBreadcrumbs();
?>
<nav class="flex mb-2" aria-label="Breadcrumb">
    <ol class="inline-flex items-center space-x-1 md:space-x-2 rtl:space-x-reverse">
        <?php foreach ($breadcrumbs as $breadcrumb): ?>
            <a href="<?= htmlspecialchars($breadcrumb['url']) ?>" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600 dark:text-gray-400 dark:hover:text-white">
                <svg class="rtl:rotate-180 w-3 h-3 text-gray-400 mx-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4" />
                </svg>
                <?= htmlspecialchars($breadcrumb['name']) ?>
            </a>
        <?php endforeach; ?>
    </ol>
</nav>