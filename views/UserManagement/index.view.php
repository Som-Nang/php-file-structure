<?php require base_path("views/partials/header.php") ?>
<?php require base_path("views/partials/sidebar.php") ?>


<div class="p-4 sm:ml-64">
    <div class="p-2 mt-14">
        <?php require base_path("views/partials/banner.php") ?>
        <main>
            <div id="large-modal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                <div class="relative p-4 w-full  max-w-7xl max-h-full">
                    <!-- Modal content -->
                    <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                        <!-- Modal header -->
                        <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                                Create New Staff
                            </h3>
                            <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-toggle="large-modal">
                                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                                </svg>
                                <span class="sr-only">Close modal</span>
                            </button>
                        </div>
                        <!-- Modal body -->
                        <form class="p-4 md:p-5">
                            <div class="flex">
                                <div class="w-1/3 flex items-start justify-center">
                                    <div class="profile-pic">
                                        <label class="-label" for="file">
                                            <span class="glyphicon glyphicon-camera"></span>
                                            <span>Change Image</span>
                                        </label>
                                        <input id="file" name="propic" type="file" onchange="loadFile(event)" accept="image/*" />
                                        <img src="https://media.istockphoto.com/id/1337144146/vector/default-avatar-profile-icon-vector.jpg?s=612x612&w=0&k=20&c=BIbFwuv7FxTWvh5S3vB6bkT0Qv8Vn8N5Ffseq84ClGI=" id="output" width="200" />
                                    </div>
                                </div>

                                <div class="grid gap-4 mb-4 grid-cols-2 w-full">
                                    <div class="col-span-2">
                                        <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Username</label>
                                        <input type="text" name="name" id="username" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Username" required="">
                                        <label for="name" id="error_username" class="text-red-500 text-sm hidden"></label>
                                    </div>
                                    <div class="col-span-2">
                                        <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Phone Number</label>
                                        <input type="number" name="name" id="phone_number" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Phone Number" required="">
                                    </div>
                                    <div class="col-span-2 sm:col-span-1">
                                        <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Email</label>
                                        <input type="text" name="email" id="email" class="bg-gray-50 border border-danger-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Email" required="">
                                        <label for="email" id="error_email" class="text-red-500 text-sm hidden"></label>
                                    </div>
                                    <div class="col-span-2 sm:col-span-1">
                                        <label for="price" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Password</label>
                                        <input type="password" name="price" id="password" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Password" required="">
                                        <label for="password" id="error_password" class="text-red-500 text-sm hidden"></label>
                                    </div>
                                    <div class="col-span-2 sm:col-span-1">
                                        <label for="role" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Role</label>
                                        <select id="role" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                                            <option value="">Select category</option>
                                            <option value="EMPLOYEE">EMPLOYEE</option>
                                            <option value="MANAGER">MANAGER</option>
                                            <option value="ADMIN">ADMIN</option>

                                        </select>
                                        <label for="role" id="error_role" class="text-red-500 text-sm hidden"></label>
                                    </div>
                                    <div class="col-span-2 sm:col-span-1">
                                        <label for="dpt_id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Department</label>
                                        <select id="dpt_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                                            <option value="">Select Department</option>
                                            <?php foreach ($dpt as $key => $item): ?>
                                                <option value="<?= $item['ID'] ?>"><?= $item['dpt_name'] ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                        <label for="dpt_id" id="error_function" class="text-red-500 text-sm hidden"></label>
                                    </div>
                                    <div class="col-span-2">
                                        <label for="description" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Description</label>
                                        <textarea id="description" rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Write description here"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="w-full flex items-end justify-end">
                                <button type="button" id="submit" class="text-white inline-flex items-center bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                                    <svg class="me-1 -ms-1 w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd"></path>
                                    </svg>
                                    Add New Staff
                                </button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>

            <div id="edit-modal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">

            </div>
            <!-- component -->
            <div class="relative flex flex-col w-full h-full overflow-y-auto text-slate-700 bg-white shadow-md rounded-xl bg-clip-border">
                <div class="relative mx-4 mt-4 overflow-hidden text-slate-700 bg-white rounded-none bg-clip-border">
                    <div class="flex items-center justify-between ">
                        <div>
                            <h3 class="text-lg font-semibold text-slate-800">Employees List</h3>
                            <p class="text-slate-500">Review each person before edit</p>
                        </div>
                        <div class="flex flex-col gap-2 shrink-0 sm:flex-row">

                            <button
                                data-modal-target="large-modal" data-modal-toggle="large-modal"
                                class="flex select-none items-center gap-2 rounded bg-gray-800 py-2.5 px-4 text-xs font-semibold text-white shadow-md shadow-slate-900/10 transition-all hover:shadow-lg hover:shadow-slate-900/20 focus:opacity-[0.85] focus:shadow-none active:opacity-[0.85] active:shadow-none disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none"
                                type="button">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"
                                    stroke-width="2" class="w-4 h-4">
                                    <path
                                        d="M6.25 6.375a4.125 4.125 0 118.25 0 4.125 4.125 0 01-8.25 0zM3.25 19.125a7.125 7.125 0 0114.25 0v.003l-.001.119a.75.75 0 01-.363.63 13.067 13.067 0 01-6.761 1.873c-2.472 0-4.786-.684-6.76-1.873a.75.75 0 01-.364-.63l-.001-.122zM19.75 7.5a.75.75 0 00-1.5 0v2.25H16a.75.75 0 000 1.5h2.25v2.25a.75.75 0 001.5 0v-2.25H22a.75.75 0 000-1.5h-2.25V7.5z">
                                    </path>
                                </svg>
                                Add member
                            </button>
                        </div>
                    </div>

                </div>
                <div class="p-0 overflow-auto">
                    <table class="w-full mt-4 text-left table-auto min-w-max ">
                        <thead>
                            <tr>
                                <th
                                    class="p-4 transition-colors cursor-pointer border-y border-slate-200 bg-slate-50 hover:bg-slate-100">
                                    <p
                                        class="flex items-center justify-between gap-2 font-sans text-sm font-normal leading-none text-slate-500">
                                        Member
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                                            stroke="currentColor" aria-hidden="true" class="w-4 h-4">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M8.25 15L12 18.75 15.75 15m-7.5-6L12 5.25 15.75 9"></path>
                                        </svg>
                                    </p>
                                </th>
                                <th
                                    class="p-4 transition-colors cursor-pointer border-y border-slate-200 bg-slate-50 hover:bg-slate-100">
                                    <p
                                        class="flex items-center justify-between gap-2 font-sans text-sm font-normal leading-none text-slate-500">
                                        Function
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                                            stroke="currentColor" aria-hidden="true" class="w-4 h-4">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M8.25 15L12 18.75 15.75 15m-7.5-6L12 5.25 15.75 9"></path>
                                        </svg>
                                    </p>
                                </th>
                                <th
                                    class="p-4 transition-colors cursor-pointer border-y border-slate-200 bg-slate-50 hover:bg-slate-100">
                                    <p
                                        class="flex items-center justify-between gap-2 font-sans text-sm  font-normal leading-none text-slate-500">
                                        Status
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                                            stroke="currentColor" aria-hidden="true" class="w-4 h-4">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M8.25 15L12 18.75 15.75 15m-7.5-6L12 5.25 15.75 9"></path>
                                        </svg>
                                    </p>
                                </th>
                                <th
                                    class="p-4 transition-colors cursor-pointer border-y border-slate-200 bg-slate-50 hover:bg-slate-100">
                                    <p
                                        class="flex items-center justify-between gap-2 font-sans text-sm  font-normal leading-none text-slate-500">
                                        Employed
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                                            stroke="currentColor" aria-hidden="true" class="w-4 h-4">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M8.25 15L12 18.75 15.75 15m-7.5-6L12 5.25 15.75 9"></path>
                                        </svg>
                                    </p>
                                </th>
                                <th
                                    class="p-4 transition-colors cursor-pointer border-y border-slate-200 bg-slate-50 hover:bg-slate-100">
                                    <p
                                        class="flex items-center justify-between gap-2 font-sans text-sm  font-normal leading-none text-slate-500">
                                    </p>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($users as $key => $value) :
                                $roles = auth()->admin()->getRolesForUserById($value['id']);
                                $isConfirmed = (bool) $value['verified'];
                                $isBanned = ($value['status'] === 'banned');
                            ?>
                                <tr>
                                    <td class="p-4 border-b border-slate-200">
                                        <div class="flex items-center gap-3">
                                            <img src="<?php echo $value['profile_pic'] != NULL ? '/public/profile-uploaded/' . $value['profile_pic']
                                                            : 'https://media.istockphoto.com/id/1337144146/vector/default-avatar-profile-icon-vector.jpg?s=612x612&w=0&k=20&c=BIbFwuv7FxTWvh5S3vB6bkT0Qv8Vn8N5Ffseq84ClGI=' ?>"
                                                alt="John Michael" class="relative inline-block h-9 w-9 !rounded-full object-cover object-center" />
                                            <div class="flex flex-col">
                                                <p class="text-sm font-semibold text-slate-700">
                                                    <?= $value['username'] ?>
                                                </p>
                                                <p
                                                    class="text-sm text-slate-500">
                                                    <?= $value['email'] ?>
                                                </p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="p-4 border-b border-slate-200">
                                        <div class="flex flex-col">

                                            <?php foreach ($roles as $key => $role): ?>
                                                <p class="text-sm font-semibold text-slate-700"> <?= $role ?> </p>
                                            <?php endforeach; ?>

                                            <p
                                                class="text-sm text-slate-500">
                                                <?= $value['dpt_name'] ?>
                                            </p>
                                        </div>
                                    </td>
                                    <td class="p-4 border-b border-slate-200">
                                        <div class="w-max">
                                            <?php if ($isConfirmed && !$isBanned): ?>
                                                <div
                                                    class="relative grid items-center px-2 py-1 font-sans text-xs font-bold text-green-900 uppercase rounded-md select-none whitespace-nowrap bg-green-500/20">
                                                    <span class="">active</span>
                                                </div>
                                            <?php else: ?>
                                                <div
                                                    class="relative grid items-center px-2 py-1 font-sans text-xs font-bold text-red-900 uppercase rounded-md select-none whitespace-nowrap bg-red-500/20">
                                                    <span class="">inactive</span>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                    <td class="p-4 border-b border-slate-200">
                                        <p class="text-sm text-slate-500">
                                            <?= date("Y-m-d", $value['registered']); ?>
                                        </p>
                                    </td>
                                    <td class="p-4 border-b border-slate-200 flex gap-2">
                                        <button
                                            id="<?= $value['id'] ?>"
                                            class="editBtn relative h-10 max-h-[40px] w-10 max-w-[40px] select-none rounded-lg text-center align-middle font-sans text-xs font-medium uppercase bg-gray-100 text-slate-900 transition-all hover:bg-slate-900/10 active:bg-slate-900/20 disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none"
                                            type="button">
                                            <span class="absolute transform -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="2em" height="2em" viewBox="0 0 20 20" class="text-blue-800">
                                                    <path fill="currentColor" d="M9 2a4 4 0 1 0 0 8a4 4 0 0 0 0-8m-4.991 9A2 2 0 0 0 2 13c0 1.691.833 2.966 2.135 3.797C5.417 17.614 7.145 18 9 18q.617 0 1.21-.057A5.48 5.48 0 0 1 9 14.5c0-1.33.472-2.55 1.257-3.5zm6.626 2.92a2 2 0 0 0 1.43-2.478l-.155-.557q.382-.293.821-.497l.338.358a2 2 0 0 0 2.91.001l.324-.344q.448.212.835.518l-.126.423a2 2 0 0 0 1.456 2.519l.349.082a4.7 4.7 0 0 1 .01 1.017l-.46.117a2 2 0 0 0-1.431 2.479l.156.556q-.383.294-.822.498l-.338-.358a2 2 0 0 0-2.909-.002l-.325.344a4.3 4.3 0 0 1-.835-.518l.127-.422a2 2 0 0 0-1.456-2.52l-.35-.082a4.7 4.7 0 0 1-.01-1.016zm4.865.58a1 1 0 1 0-2 0a1 1 0 0 0 2 0" />
                                                </svg>
                                            </span>
                                        </button>

                                        <button
                                            id="<?= $value['id'] ?>"
                                            class="deleteBtn relative h-10 max-h-[40px] w-10 max-w-[40px] select-none rounded-lg text-center align-middle font-sans text-xs font-medium uppercase bg-gray-100 text-slate-900 transition-all hover:bg-slate-900/10 active:bg-slate-900/20 disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none"
                                            type="button">
                                            <span class="absolute transform -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="2em" height="2em" viewBox="0 0 48 48" class="text-red-600">
                                                    <g fill="none" stroke="currentColor" stroke-linejoin="round" stroke-width="4">
                                                        <path stroke-linecap="round" d="M8 11h32M18 5h12" />
                                                        <path fill="currentColor" d="M12 17h24v23a3 3 0 0 1-3 3H15a3 3 0 0 1-3-3z" />
                                                    </g>
                                                </svg>
                                            </span>
                                        </button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <div class="flex items-center justify-between p-3">
                    <p class="block text-sm text-slate-500">
                        Page 1 of 10
                    </p>
                    <div class="flex gap-1">
                        <button

                            class="rounded border border-slate-300 py-2.5 px-3 text-center text-xs font-semibold text-slate-600 transition-all hover:opacity-75 focus:ring focus:ring-slate-300 active:opacity-[0.85] disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none"
                            type="button">
                            Previous
                        </button>
                        <button
                            class="rounded border border-slate-300 py-2.5 px-3 text-center text-xs font-semibold text-slate-600 transition-all hover:opacity-75 focus:ring focus:ring-slate-300 active:opacity-[0.85] disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none"
                            type="button">
                            Next
                        </button>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>
<?php require base_path("views/partials/main-script-section.php") ?>
<script src="/views/UserManagement/UserManagement.js"></script>
<script>
    let url = '<?= '/user-management/store' ?>';
    let editUrl = '<?= '/user-management/edit' ?>';

    $(".deleteBtn").click(function() {
        let staffId = this.id;
        let deleteUrl = '<?= '/user-management/destroy' ?>';
        deleteData(staffId, deleteUrl)
    })

    userManagement();
    editStaff();
</script>
<?php require base_path("views/partials/footer.php") ?>