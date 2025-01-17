<div class="container-fluid">
    <div class="row flex-nowrap">
        <div class="bg-color-grey col-auto min-vh-100 d-flex flex-column justify-content-between">
            <div class="bg-color-grey p-2">
                <a class="d-flex text-decoration-none mt-1 align-items-center text-white">
                    <span class="fs-4 d-none d-sm-inline"> <img class="size-img" src="img/OIG2_RemoveBG.png"> </span>
                </a>
            </div>

            <div class="bg-color-grey p-2 border-end border-3">
                <ul class="nav nav-pills flex-column mt-4">
                    <li class="nav-item mb-4">
                        <a href="/" class="nav-link text-white {{ ($title === "Home") ? 'active' : '' }} ms-3" aria-current="page">
                            <div class="d-flex flex-row align-items-center">
                                <div class="fs-4 d-none d-sm-inline">
                                    <img src="img/svg/Home_light.svg">
                                </div>
                                <div class="text">Beranda</div>
                            </div>
                        </a>
                    </li>

                    <li class="nav-item mb-4">
                        <a href="/forum" class="nav-link text-white {{ ($title === "Forum") ? 'active' : '' }} ms-3">
                            <div class="d-flex flex-row align-items-center">
                                <div class="fs-4 d-none d-sm-inline">
                                    <img src="img/svg/Chat_plus_light.svg">
                                </div>
                                <div class="text">Forum</div>
                            </div>
                        </a>
                    </li>

                    <li class="nav-item mb-4">
                        <a href="/koleksi" class="nav-link text-white {{ ($title === "Koleksi") ? 'active' : '' }} ms-3">
                            <div class="d-flex flex-row align-items-center">
                                <div class="fs-4 d-none d-sm-inline">
                                    <img src="img/svg/Book_open_alt_light.svg">
                                </div>
                                <div class="text">Koleksi</div>
                            </div>
                        </a>
                    </li>

                    <li class="nav-item mb-4">
                        <a href="/unggah" class="nav-link text-white {{ ($title === "Unggah") ? 'active' : '' }} ms-3">
                            <div class="d-flex flex-row align-items-center">
                                <div class="fs-4 d-none d-sm-inline">
                                    <img src="img/svg/Upload_light.svg">
                                </div>
                                <div class="text">Unggah</div>
                            </div>
                        </a>
                    </li>

                    <li class="nav-item mb-4">
                        <a href="/komunitas" class="nav-link text-white {{ ($title === "Komunitas") ? 'active' : '' }} ms-3">
                            <div class="d-flex flex-row align-items-center">
                                <div class="fs-4 d-none d-sm-inline">
                                    <img src="img/svg/Group_light.svg">
                                </div>
                                <div class="text">Komunitas</div>
                            </div>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="/langganan" class="nav-link text-white {{ ($title === "Langganan") ? 'active' : '' }} ms-3">
                            <div class="d-flex flex-row align-items-center">
                                <div class="fs-4 d-none d-sm-inline">
                                    <img src="img/svg/Dimond_alt_light.svg">
                                </div>
                                <div class="text">Langganan</div>
                            </div>
                        </a>
                    </li>
                </ul>
            </div>

            <div class="bg-color-grey p-2">
                <ul class="nav nav-pills flex-column mt-4">
                    <li class="nav-item margin-setting">
                        <a href="#" class="nav-link text-white">
                            <span class="fs-4 ms-3 d-none d-sm-inline"> <img class="image-setting" src="img/svg/Setting_line_light.svg">  </span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
