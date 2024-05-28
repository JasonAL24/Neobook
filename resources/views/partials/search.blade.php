<nav class="navbar navbar-expand-lg">
    <div class="container-fluid p-4">
        <div class="navbar-collapse search-size" id="navbarSupportedContent">
            <ul class="navbar-nav mb-2 mb-lg-0">
                <li class="nav-item dropdown">
                    <a class="nav-link" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <img src="/img/svg/menu.svg" alt="menu">
                    </a>
                    <div class="dropdown-menu multi-column">
                        <div class="dropdown-header"><b>Kategori</b></div>
                        <div class="row">
                            <div class="col">
                                <a class="dropdown-item" href="/kategori/aksi">Aksi</a>
                                <a class="dropdown-item" href="/kategori/komedi">Komedi</a>
                                <a class="dropdown-item" href="/kategori/pertualangan">Pertualangan</a>
                                <a class="dropdown-item" href="/kategori/biografi">Biografi</a>
                                <a class="dropdown-item" href="/kategori/fiksi ilmiah">Fiksi ilmiah</a>
                            </div>
                            <div class="col">
                                <a class="dropdown-item" href="/kategori/romantis">Romantis</a>
                                <a class="dropdown-item" href="/kategori/misteri">Misteri</a>
                                <a class="dropdown-item" href="/kategori/horror">Horror</a>
                                <a class="dropdown-item" href="/kategori/sejarah">Sejarah</a>
                                <a class="dropdown-item" href="/kategori/cerpen">Cerpen</a>
                            </div>
                            <div class="col">
                                <a class="dropdown-item" href="/kategori/anak-anak">Anak-anak</a>
                                <a class="dropdown-item" href="/kategori/pembelajaran">Pembelajaran</a>
                                <a class="dropdown-item" href="/kategori/filosofi">Filosofi</a>
                                <a class="dropdown-item" href="/kategori/novel">Novel</a>
                                <a class="dropdown-item" href="/kategori/drama">Drama</a>
                            </div>
                        </div>
                    </div>
                </li>
            </ul>

            <div>
                <form class="d-flex" role="search" id="searchForm">
                    <img src="/img/svg/Search_light.svg" alt="search">
                    <input class="custom-input bg-color-grey me-2 ms-2" type="search" id="searchInput" placeholder="cari nama buku..." aria-label="Search">
                </form>
                <div class="dropdown-menu" id="searchResultsDropdown" aria-labelledby="searchInput">
                </div>
            </div>

            <script src="/js/search.js"></script>
        </div>
    </div>
</nav>
