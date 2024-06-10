@extends('layouts.main')

@section('container')
    @if(!$member->premium_status && $book->category === 'novel')
        <div style="height:60vh" class="text-center">
            <p class="mt-4"><b>Maaf, buku ini tidak tersedia untuk non-premium</b></p>
            <p>Silahkan untuk langganan menjadi premium</p>
        </div>
    @else
        <div class="main-bg">
            <div class="container justify-content-center">
                <div class="row">
                    <div class="col-lg-2">
                        <a href="/books/{{$book->id}}">
                            <button type="button" class="btn btn-secondary" style="background-color: #282A36">
                                <img src="/img/svg/arrow_left_white.svg" alt="<-">
                                <b>Detail Buku</b>
                            </button>
                        </a>
                    </div>
                    <div class="col text-center">
                        <h2>{{$book->name}}</h2>
                    </div>
                    <div class="col-lg-2">
                        <div class="dropdown">
                            <button class="btn" type="button" id="contentsDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                <img src="/img/svg/menu.svg" alt="menu">
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="contentsDropdown" id="contentsMenu" style="max-height: 400px; overflow-y: auto;">
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="row mt-3 align-items-center justify-content-center">
                    <div class="col-lg-1 text-center">
                        <button id="prevPage" class="btn btn-light rounded-circle prev-button" style="width: 72px; height: 72px">
                            <img src="/img/svg/arrow.svg" alt="arrow_left">
                        </button>
                        <span class="prev-text">Halaman sebelumnya</span>
                    </div>
                    <div class="col-lg-10 text-center">
                        <canvas id="pdfViewer" class="mx-auto book-content"></canvas>
                        <div id="notAvailableText" style="display: none; height:60vh">
                            <img src="/img/error/404_not_found.png" alt="404 not found">
                            <p class="mt-4"><b>Maaf, buku ini masih belom tersedia</b></p>
                            <p>Mohon periksa ulang di lain waktu</p>
                        </div>
                    </div>
                    <div class="col-lg-1 text-center">
                        <button id="nextPage" class="btn btn-light rounded-circle next-button" style="width: 72px; height: 72px">
                            <img src="/img/svg/arrow.svg" alt="arrow_right" style="transform: scaleX(-1);">
                        </button>
                        <span class="next-text">Halaman berikutnya</span>
                    </div>
                </div>
                <div class="row bottom-controls align-items-center" id="bottomControls">
                    <div class="col-lg-2"></div>
                    <div class="col-lg-7 text-center d-flex flex-column">
                        <div id="currentPage" class="btn" data-bs-toggle="modal" data-bs-target="#pageModal"></div>
                        <i id="currentPageId"></i>
                    </div>
                    <div class="col-lg-1 d-flex flex-row">
                        <button id="zoomIn" class="btn">
                            <img src="/img/svg/zoom_in.svg" alt="zoom in" class="icon">
                        </button>
                        <button id="zoomOut" class="btn ms-2">
                            <img src="/img/svg/zoom_out.svg" alt="zoom out" class="icon">
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="pageModal" tabindex="-1" aria-labelledby="pageModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="pageModalLabel">Pindah ke Halaman</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="pageForm">
                            <div class="mb-3">
                                <label for="pageNumberInput" class="form-label">Nomor Halaman</label>
                                <input type="number" class="form-control" id="pageNumberInput" min="1">
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        <button type="button" class="btn btn-primary" id="goToPageButton">Pindah</button>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <script>
        var pdfUrl = '/books/{{$book->filename}}.pdf';
        var pdfDoc = null;
        var pageNum = 1;
        var pageRendering = false;
        var canvas = document.getElementById('pdfViewer');
        var ctx = canvas.getContext('2d');

        function updatePageNumber(currentPage) {
            var maxPage = pdfDoc.numPages;
            var pageNumberElement = document.getElementById("currentPage");
            pageNumberElement.textContent = currentPage + "/" + maxPage;
            var pageNumberIdElement = document.getElementById("currentPageId");
            pageNumberIdElement.textContent = "Halaman " + currentPage + " dari " + maxPage;
        }

        var scale = 1.5;

        document.getElementById('zoomIn').addEventListener('click', function(){
            if (scale <= 2){
                scale += 0.1;
                renderPage(pageNum);
            }
        });
        document.getElementById('zoomOut').addEventListener('click', function(){
            if (scale >= 1) {
                scale -= 0.1;
                renderPage(pageNum);
            }
        });

        document.addEventListener('keydown', function(event) {
            // Check if the pressed key is the right arrow key
            if (event.key === 'ArrowRight') {
                nextPage();
            }
            // Check if the pressed key is the left arrow key
            else if (event.key === 'ArrowLeft') {
                prevPage();
            }
        });

        document.getElementById('nextPage').addEventListener('click', nextPage);
        document.getElementById('prevPage').addEventListener('click', prevPage);

        function nextPage() {
            if (pageNum > pdfDoc.numPages || pageRendering) return;
            else if (pageNum === pdfDoc.numPages){
                var giveRatingUrl = "/books/{{$book->id}}/giverating";
                window.location.href = giveRatingUrl;
            }
            pageNum++;
            if (pageNum <= pdfDoc.numPages){
                updateLastPage(pageNum);
                renderPage(pageNum);
            }
        }

        function prevPage() {
            if (pageNum <= 1 || pageRendering) return;
            pageNum--;
            updateLastPage(pageNum);
            renderPage(pageNum);
        }

        function updateLastPage(pageNum) {
            var bookId = {{$book->id}};
            var lastPage = pageNum;

            var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            // Send an AJAX request to update the last_page value in the pivot table
            $.ajax({
                url: '/update-last-page',
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                data: {
                    book_id: bookId,
                    last_page: lastPage
                },
                success: function(response) {
                    console.log('Last page updated successfully.');
                },
                error: function(xhr, status, error) {
                    console.error('Error updating last page:', error);
                }
            });
        }

        pdfjsLib.getDocument(pdfUrl).promise.then(function(pdfDoc_) {
            pdfDoc = pdfDoc_;
            renderPage(pageNum);

            pdfDoc.getOutline().then(function(outline) {
                if (outline) {
                    var contentsMenu = document.getElementById('contentsMenu');
                    for (let i = 0; i < outline.length; i++) {
                        const dest = outline[i].dest;
                        pdfDoc.getDestination(dest).then(function(dest) {
                            const ref = dest[0];
                            pdfDoc.getPageIndex(ref).then(function(id) {
                                const pageNumber = parseInt(id) + 1;
                                const title = outline[i].title;
                                const listItem = document.createElement('li');
                                listItem.innerHTML = '<a class="dropdown-item" href="#" onclick="goToPage(' + pageNumber + ')">' + title + '</a>';
                                contentsMenu.appendChild(listItem);
                            });
                        });
                    }
                }
            });

        }).catch(function(error) {
            document.getElementById('prevPage').style.display = 'none';
            document.getElementById('nextPage').style.display = 'none';
            document.getElementById('contentsDropdown').style.display = 'none';
            document.getElementById('contentsMenu').style.display = 'none';
            document.getElementById('notAvailableText').style.display = 'block';
        });

        function renderPage(num) {
            pageRendering = true;
            console.log(num);

            pdfDoc.getPage(num).then(function(page) {
                var viewport = page.getViewport({ scale: scale });
                canvas.height = viewport.height;
                canvas.width = viewport.width;

                var renderContext = {
                    canvasContext: ctx,
                    viewport: viewport
                };
                var renderTask = page.render(renderContext);

                renderTask.promise.then(function() {
                    pageRendering = false;
                });
            }).catch(function (error){
                console.error('Error rendering page:', error);
            });
            updatePageNumber(num);
        }

        function goToPage(page) {
            pageNum = parseInt(page);
            updateLastPage(pageNum);
            renderPage(pageNum);
        }

        var bottomControls = document.getElementById("bottomControls");

        function updateBottomControlsPosition() {
            var rect = bottomControls.getBoundingClientRect();
            var bottomOffset = rect.bottom - window.innerHeight;

            if (bottomOffset > 0) {
                bottomControls.style.transform = "translateY(-" + bottomOffset + "px)";
            } else {
                bottomControls.style.transform = "translateY(0)";
            }
        }

        window.addEventListener("load", updateBottomControlsPosition);
        window.addEventListener("scroll", updateBottomControlsPosition);

        function renderSpecifiedPage() {
            pageNum = {{$startPageNum}};
            if (isNaN(pageNum) || pageNum < 1) {
                pageNum = 1;
                return;
            }

            renderPage(pageNum);
        }

        document.getElementById('goToPageButton').addEventListener('click', function() {
            var pageInput = document.getElementById('pageNumberInput').value;
            var pageNumber = parseInt(pageInput);
            if (pageNumber >= 1 && pageNumber <= pdfDoc.numPages) {
                goToPage(pageNumber);
                var pageModal = bootstrap.Modal.getInstance(document.getElementById('pageModal'));
                pageModal.hide();
            } else {
                alert('Please enter a valid page number.');
            }
        });

        document.getElementById('pageNumberInput').addEventListener('keydown', function(event) {
            if (event.key === 'Enter'){
                event.preventDefault();
                var pageInput = document.getElementById('pageNumberInput').value;
                var pageNumber = parseInt(pageInput);
                if (pageNumber >= 1 && pageNumber <= pdfDoc.numPages) {
                    goToPage(pageNumber);
                    var pageModal = bootstrap.Modal.getInstance(document.getElementById('pageModal'));
                    pageModal.hide();
                } else {
                    alert('Please enter a valid page number.');
                }
            }
        });

        renderSpecifiedPage();


    </script>
@endsection
