@extends('layouts.main')

@section('container')
    @php $subscribed = $member->premium_status @endphp
    <div class="white-container p-5 text-center">
        @if(!$subscribed)
        <div class="row">
            <h1 class="mt-5 fw-bold">Ayo bergabung dengan Neobook sekarang!</h1>
        </div>
        <div class="row text-center align-items-center justify-content-center mt-4">
            <div class="col-auto text-center">
                <img src="/img/OIG2_RemoveBG.png" alt="Logo Neobook" style="width: 7em">
            </div>
            <div class="col-auto text-center">
                <div class="fs-2 fw-bold">Neobook Premium</div>
            </div>
        </div>
        <div class="row align-items-center mt-5">
            <div class="col">
                <img src="/img/community_access.png" alt="Akses Komunitas" style="height: 10em">
                <div class="fs-4 fw-bold mt-4">
                    Akses ke Komunitas
                </div>
            </div>
            <div class="col">
                <img src="/img/book_access.png" alt="Akses Buku" style="height: 10em">
                <div class="fs-4 fw-bold mt-4">
                    Akses buku yang tidak terbatas
                </div>
            </div>
            <div class="col">
                <img src="/img/personal_books.png" alt="Akses Buku Personal" style="height: 10em">
                <div class="fs-4 fw-bold mt-4">
                    Dapatkan rekomendasi buku personal
                </div>
            </div>
        </div>
        <div class="row mt-5">
            <h2 class="fw-bold">Rasakan keuntungan premium sekarang juga!</h2>
        </div>
        <div class="row mt-5">
            <div class="col">
                <button class="btn p-3 text-light fs-4" style="background-color: #252734;" data-bs-toggle="modal" data-bs-target="#subscriptionModal">
                    Langganan Sekarang!
                </button>
            </div>
        </div>
        <div class="modal fade" id="subscriptionModal" tabindex="-1" aria-labelledby="subscriptionModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header border-0">
                        <h5 class="modal-title" id="subscriptionModalLabel">Konfirmasi Langganan</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div id="modal-text">Apakah kamu yakin untuk mulai berlangganan?</div>
                        <div class="spinner-border text-primary mt-3 d-none" role="status" id="loadingSpinner">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                    </div>
                    <div class="modal-footer border-0">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="button" class="btn btn-primary" id="confirmButton">Ya, Mulai Berlangganan</button>
                    </div>
                </div>
            </div>
        </div>
        @else
            <div class="row text-center align-items-center justify-content-center mt-4">
                <div class="col-auto text-center">
                    <img src="/img/OIG2_RemoveBG.png" alt="Logo Neobook" style="width: 7em">
                </div>
                <div class="col-auto text-center">
                    <div class="fs-2 fw-bold">Neobook Premium</div>
                </div>
            </div>
            <div class="row align-items-center mt-5">
                <div class="col">
                    <img src="/img/community_access.png" alt="Akses Komunitas" style="height: 10em">
                    <div class="fs-4 fw-bold mt-4">
                        Anda telah mendapatkan akses ke Komunitas
                    </div>
                </div>
                <div class="col">
                    <img src="/img/book_access.png" alt="Akses Buku" style="height: 10em">
                    <div class="fs-4 fw-bold mt-4">
                        Anda telah mendapatkan akses buku yang tidak terbatas
                    </div>
                </div>

            </div>
            <div class="row mt-3">
                <div class="col">
                    <img src="/img/personal_books.png" alt="Akses Buku Personal" style="height: 10em">
                    <div class="fs-4 fw-bold mt-4">
                        Anda akan mendapatkan rekomendasi buku personal
                    </div>
                </div>
            </div>
            <div class="row mt-5">
                <h2 class="fw-bold">Terima kasih telah berlangganan kepada Neobook!</h2>
            </div>
        @endif
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const confirmButton = document.getElementById('confirmButton');
            const loadingSpinner = document.getElementById('loadingSpinner');
            const modalText = document.getElementById('modal-text');

            confirmButton.addEventListener('click', function () {
                // Show loading spinner
                loadingSpinner.classList.remove('d-none');
                modalText.classList.add('d-none');

                // Send AJAX request
                fetch('/subscribe', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({})
                })
                    .then(response => response.json())
                    .then(data => {
                        // Handle success response
                        if (data.success) {
                            window.location.reload();
                        }
                    })
                    .catch(error => {
                        // Handle error response
                        console.error('Error:', error);
                        alert('An error occurred. Please try again.');
                    })
                    .finally(() => {
                        // Hide loading spinner
                        loadingSpinner.classList.add('d-none');
                        // Close modal
                        const modalElement = document.getElementById('subscriptionModal');
                        const modal = bootstrap.Modal.getInstance(modalElement);
                        modal.hide();
                    });
            });
        });
    </script>

@endsection
