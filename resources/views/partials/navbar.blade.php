<div class="container-fluid">
    <div class="row flex-nowrap">
        <div class="col-auto min-vh-100 d-flex flex-column position-fixed bg-color-grey d-none d-lg-flex" style="top: 0; left: 0; z-index: 100;" id="sidebar">
            <div class=" p-2 " >
                <a class="d-flex text-decoration-none mt-1 align-items-center text-white" href="/home">
                    <span class="fs-4 d-none d-sm-inline"> <img class="size-img" src="/img/OIG2_RemoveBG.png" alt="Logo Neobook"> </span>
                </a>
            </div>
            <div class="border-end border-3 d-flex flex-column" style="height: 85vh;">
                <div class="p-2">
                    <ul class="nav nav-pills flex-column mt-4 ">
                        <li class="nav-item mb-4">
                            <a href="/home" class="nav-link text-white {{ ($title === "Home") ? 'active' : '' }} ms-3" aria-current="page">
                                <div class="d-flex flex-row align-items-center">
                                    <div class="fs-4 d-none d-sm-inline">
                                        <img src="/img/svg/Home_light.svg">
                                    </div>
                                    <div class="text">Beranda</div>
                                </div>
                            </a>
                        </li>

                        <li class="nav-item mb-4">
                            <a href="/forumdiskusi" class="nav-link text-white {{ ($title === "Forum Diskusi" || $title === "Forum Saya" || $title === "Buat Forum") ? 'active' : '' }} ms-3">
                                <div class="d-flex flex-row align-items-center">
                                    <div class="fs-4 d-none d-sm-inline">
                                        <img src="/img/svg/Chat_plus_light.svg">
                                    </div>
                                    <div class="text">Forum</div>
                                </div>
                            </a>
                        </li>

                        <li class="nav-item mb-4">
                            <a href="/koleksi" class="nav-link text-white {{ ($title === "Koleksi") ? 'active' : '' }} ms-3">
                                <div class="d-flex flex-row align-items-center">
                                    <div class="fs-4 d-none d-sm-inline">
                                        <img src="/img/svg/Book_open_alt_light.svg">
                                    </div>
                                    <div class="text">Koleksi</div>
                                </div>
                            </a>
                        </li>

                        <li class="nav-item mb-4">
                            <a href="/unggah" class="nav-link text-white {{ ($title === "Unggah") ? 'active' : '' }} ms-3">
                                <div class="d-flex flex-row align-items-center">
                                    <div class="fs-4 d-none d-sm-inline">
                                        <img src="/img/svg/Upload_light.svg">
                                    </div>
                                    <div class="text">Unggah</div>
                                </div>
                            </a>
                        </li>

                        <li class="nav-item mb-4">
                            <a href="/komunitas" class="nav-link text-white {{ ($title === "Komunitas") ? 'active' : '' }} ms-3">
                                <div class="d-flex flex-row align-items-center">
                                    <div class="fs-4 d-none d-sm-inline">
                                        <img src="/img/svg/Group_light.svg">
                                    </div>
                                    <div class="text">Komunitas</div>
                                </div>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="/langganan" class="nav-link text-white {{ ($title === "Langganan") ? 'active' : '' }} ms-3">
                                <div class="d-flex flex-row align-items-center">
                                    <div class="fs-4 d-none d-sm-inline">
                                        <img src="/img/svg/Dimond_alt_light.svg">
                                    </div>
                                    <div class="text">Langganan</div>
                                </div>
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="p-2 mt-auto">
                    <ul class="nav nav-pills">
                        <li class="nav-item margin-setting">
                            <a href="/profile" class="nav-link text-white {{ ($title === "Pengaturan") ? 'active' : '' }} ms-3">
                                <div class="d-flex flex-row align-items-center">
                                    <div class="fs-4 d-none d-sm-inline">
                                        <img class="image-setting" src="/img/svg/Setting_line_light.svg">
                                    </div>
                                    <div class="text">Pengaturan</div>
                                </div>
                            </a>
                        </li>
                    </ul>
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
