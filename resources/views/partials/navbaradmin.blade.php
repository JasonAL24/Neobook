<div class="container-fluid">
    <div class="row flex-nowrap">
        <div class="col-auto min-vh-100 d-flex flex-column position-fixed bg-color-grey d-none d-lg-flex" style="top: 0; left: 0; z-index: 100;" id="sidebar">
            <div class=" p-2 " >
                <a class="d-flex text-decoration-none mt-1 align-items-center text-white" href="/admin/dashboard">
                    <span class="fs-4 d-none d-sm-inline"> <img class="size-img" src="/img/OIG2_RemoveBG.png" alt="Logo Neobook"> </span>
                </a>
            </div>
            <div class="border-end border-3 d-flex flex-column" style="height: 85vh;">
                <div class="p-2">
                    <ul class="nav nav-pills flex-column mt-4 ">
                        <li class="nav-item mb-4">
                            <a href="/admin/dashboard" class="nav-link text-white {{ ($title === "Admin") ? 'active' : '' }} ms-3" aria-current="page">
                                <div class="d-flex flex-row align-items-center">
                                    <div class="fs-4 d-none d-sm-inline">
                                        <img src="/img/svg/Home_light.svg">
                                    </div>
                                    <div class="text">Beranda</div>
                                </div>
                            </a>
                        </li>

                        <li class="nav-item mb-4">
                            <a href="/admin/uploadedbooks" class="nav-link text-white {{ ($title === "Buku yang diunggah") ? 'active' : '' }} ms-3">
                                <div class="d-flex flex-row align-items-center">
                                    <div class="fs-4 d-none d-sm-inline">
                                        <img src="/img/svg/book_uploaded.svg" alt="buku yang diunggah" class="image-setting">
                                    </div>
                                    <div class="text">Buku yang diunggah</div>
                                </div>
                            </a>
                        </li>

                        <li class="nav-item mb-4">
                            <a href="/admin/userlist" class="nav-link text-white {{ ($title === "Daftar Pengguna") ? 'active' : '' }} ms-3">
                                <div class="d-flex flex-row align-items-center">
                                    <div class="fs-4 d-none d-sm-inline">
                                        <img src="/img/svg/user_lists.svg" alt="daftar pengguna" class="image-setting">

                                    </div>
                                    <div class="text">Daftar Pengguna</div>
                                </div>
                            </a>
                        </li>

                        <li class="nav-item mb-4">
                            <a href="/admin/communitylist" class="nav-link text-white {{ ($title === "Daftar Komunitas") ? 'active' : '' }} ms-3">
                                <div class="d-flex flex-row align-items-center">
                                    <div class="fs-4 d-none d-sm-inline">
                                        <img src="/img/svg/community_lists.svg" alt="daftar komunitas" class="image-setting">
                                    </div>
                                    <div class="text">Daftar Komunitas</div>
                                </div>
                            </a>
                        </li>

                        <li class="nav-item mb-4">
                            <a href="/admin/booklist" class="nav-link text-white {{ ($title === "Daftar Buku") ? 'active' : '' }} ms-3">
                                <div class="d-flex flex-row align-items-center">
                                    <div class="fs-4 d-none d-sm-inline">
                                        <img src="/img/svg/book_lists.svg" alt="daftar buku" class="image-setting">
                                    </div>
                                    <div class="text">Daftar Buku</div>
                                </div>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="/admin/adminlist" class="nav-link text-white {{ ($title === "Daftar Admin") ? 'active' : '' }} ms-3">
                                <div class="d-flex flex-row align-items-center">
                                    <div class="fs-4 d-none d-sm-inline">
                                        <img src="/img/svg/admin_lists.svg" alt="daftar admin" class="image-setting">
                                    </div>
                                    <div class="text">Daftar Admin</div>
                                </div>
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="p-2 mt-auto">
                    <ul class="nav nav-pills d-flex flex-column">
                        <li class="nav-item margin-setting">
                            <a href="/admin/pengaturan" class="nav-link text-white {{ ($title === "Pengaturan") ? 'active' : '' }} ms-3">
                                <div class="d-flex flex-row align-items-center">
                                    <div class="fs-4 d-none d-sm-inline">
                                        <img class="image-setting" src="/img/svg/Setting_line_light.svg">
                                    </div>
                                    <div class="text">Pengaturan</div>
                                </div>
                            </a>
                        </li>
                        <li class="nav-item margin-setting">
                            <div class="nav-link">
                                <button type="button" class="btn border-0" data-bs-toggle="modal" data-bs-target="#logout">
                                    <div class="d-flex flex-row align-items-center">
                                        <div class="fs-4 d-none d-sm-inline">
                                            <img class="image-setting" src="/img/svg/logout.svg" alt="logout">
                                        </div>
                                        <div class="text">Logout</div>
                                    </div>
                                </button>
                            </div>
                        </li>

                    </ul>
                </div>
            </div>
        </div>
        <div class="modal fade" id="logout" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="confirmModalLabel">Keluar dari Aplikasi</h5>
                        <button type="button" class="btn-close ms-auto" data-bs-dismiss="modal" aria-label="Close">
                        </button>
                    </div>
                    <div class="modal-body">
                        Apakah Anda yakin untuk keluar dari aplikasi?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <form method="POST" action="{{ route('admin.logout') }}" class="nav-link">
                            @csrf
                            <button type="submit" class="btn btn-danger">
                                Ya
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="col">
            <!-- Main Content -->
            <button class="btn btn-primary d-lg-none mt-3" type="button" id="sidebarToggle" aria-expanded="false" aria-controls="sidebar">
                Toggle Sidebar
            </button>
        </div>
    </div>

</div>
<script>
    var sidebar = document.getElementById('sidebar');
    var sidebarToggle = document.getElementById('sidebarToggle');

    sidebarToggle.addEventListener('click', function() {
        sidebar.classList.toggle('d-none');
    });
</script>
