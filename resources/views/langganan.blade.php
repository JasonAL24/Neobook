@extends('layouts.main')

@section('container')
    @php $subscribed = $member->premium_status @endphp
    <div class="white-container p-5">
{{--        Kalo belom subscribe (user tidak premium)--}}
        @if(!$subscribed)
        <div class="row justify-content-center">
            <h1 class="mt-5 fw-bold col-auto">Ayo bergabung dengan Neobook sekarang!</h1>
        </div>
        <div class="row text-center align-items-center justify-content-center mt-4">
            <div class="col-auto text-center">
                <img src="/img/OIG2_RemoveBG.png" alt="Logo Neobook" style="width: 7em">
            </div>
            <div class="col-auto text-center">
                <div class="fs-2 fw-bold">Neobook Premium</div>
            </div>
        </div>
        <div class="row align-items-center justify-content-center mt-5">
            <div class="col-auto me-3">
                <img src="/img/personal_books.png" alt="Akses Buku Personal" style="height: 10em">
                <div class="fs-4 fw-bold mt-4">
                    Akses buku yang tidak terbatas
                </div>
            </div>
            <div class="col-auto me-3">
                <img src="/img/community_access.png" alt="Akses Komunitas" style="height: 10em">
                <div class="fs-4 fw-bold mt-4">
                    Akses ke Komunitas
                </div>
            </div>
            <div class="col-auto me-3">
                <img src="/img/book_access.png" alt="Akses Buku" style="height: 10em">
                <div class="fs-4 fw-bold mt-4">
                    Rekomendasi buku personal
                </div>
            </div>
        </div>
        <div class="row mt-5 align-items-center justify-content-center mb-5">
            <h3 class="fw-bold col-auto">Rasakan keuntungan premium sekarang juga!</h3>
            <div class="w-100"></div>
            <div class="fs-4 mt-3 col-auto text-start">
                <span>Paket berlangganan premium untuk akses semua buku di Neobook</span>
                <ul>
                    <li>Tersedia banyak pilihan bacaan lokal & internasional.</li>
                    <li>Beragam genre buku karya tulis ternama.</li>
                    <li>Akses untuk komunitas.</li>
                    <li>Semua bacaan di buku premium</li>
                    <li>Semua bacaan di karya orisinil premium.</li>
                    <li>Koleksi bacaan terlengkap dari Neobook</li>
                    <li>Bacaan terbaru setiap minggu.</li>
                </ul>
            </div>
        </div>
{{--        <div class="row mt-5">--}}
{{--            <div class="col">--}}
{{--                <button class="btn p-3 text-light fs-4" style="background-color: #252734;" data-bs-toggle="modal" data-bs-target="#subscriptionModal">--}}
{{--                    Langganan Sekarang!--}}
{{--                </button>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--        List Harga2nya --}}
        <div class="row mt-3 justify-content-center">
            <div class="col-auto justify-content-center">
                <div class="card" style="width: 20rem; height: 37rem;">
                    <div class="card-body d-flex flex-column justify-content-center align-items-center text-center">
                        <h5 class="card-title mt-3">Paket</h5>
                        <h5 class="card-subtitle mb-2 mt-3 fw-bold">1 Bulan</h5>
                        <button class="btn btn-primary mt-auto fs-5" style="width: 70%" onclick="redirectToQRIS('59000')">Pilih Paket</button>
                        <div class="row justify-content-center mt-5 fs-5 w-100">
                            <div class="card-text bg-body-secondary rounded fw-bold" style="width: 50%">Diskon 50%</div>
                            <div class="card-text text-decoration-line-through opacity-50">Rp118.000</div>
                            <div class="card-text fw-bold">Rp59.000</div>
                        </div>
                        <div class="mt-auto">
                            <div class="card-text bg-warning rounded fw-bold">Rekomendasi bagi pemula</div>
                            <div class="fs-4">Rp <span class="fs-1 fw-bold">59.000</span>/bln</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-auto justify-content-center">
                <div class="bg-primary rounded-top border-bottom-0 text-center text-light fs-5" style="margin-top: -1.5em;">Paling Laris</div>
                <div class="card border-primary" style="width: 20rem; height: 37rem; border-radius: 0 0 5px 5px">
                    <div class="card-body d-flex flex-column justify-content-center align-items-center text-center">
                        <h5 class="card-title mt-3">Paket</h5>
                        <h5 class="card-subtitle mb-2 mt-3 fw-bold">3 Bulan</h5>
                        <button class="btn btn-primary mt-auto fs-5" style="width: 70%" onclick="redirectToQRIS('132750')">Pilih Paket</button>
                        <div class="row justify-content-center mt-5 fs-5 w-100">
                            <div class="card-text bg-body-secondary rounded fw-bold" style="width: 50%">Diskon 25%</div>
                            <div class="card-text text-decoration-line-through opacity-50">Rp177.000</div>
                            <div class="card-text fw-bold">Rp132.750</div>
                        </div>
                        <div class="mt-auto">
                            <div class="card-text bg-warning rounded fw-bold">25% Lebih Murah!</div>
                            <div class="fs-4">Rp <span class="fs-1 fw-bold">44.250</span>/bln</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-auto justify-content-center">
                <div class="card" style="width: 20rem; height: 37rem;">
                    <div class="card-body d-flex flex-column justify-content-center align-items-center text-center">
                        <h5 class="card-title mt-3">Paket</h5>
                        <h5 class="card-subtitle mb-2 mt-3 fw-bold">6 Bulan</h5>
                        <button class="btn btn-primary mt-auto fs-5" style="width: 70%" onclick="redirectToQRIS('212400')">Pilih Paket</button>
                        <div class="row justify-content-center mt-5 fs-5 w-100">
                            <div class="card-text bg-body-secondary rounded fw-bold" style="width: 50%">Diskon 40%</div>
                            <div class="card-text text-decoration-line-through opacity-50">Rp354.000</div>
                            <div class="card-text fw-bold">Rp212.400</div>
                        </div>
                        <div class="mt-auto">
                            <div class="card-text bg-warning rounded fw-bold">40% Lebih Murah!</div>
                            <div class="fs-4">Rp <span class="fs-1 fw-bold">35.400</span>/bln</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

{{--            Kalo User sudah premium --}}
        @else
            <div class="row text-center align-items-center justify-content-center mt-4">
                <div class="col-auto text-center">
                    <img src="/img/OIG2_RemoveBG.png" alt="Logo Neobook" style="width: 7em">
                </div>
                <div class="col-auto text-center">
                    <div class="fs-2 fw-bold">Neobook Premium</div>
                </div>
            </div>
            <div class="row text-center align-items-center justify-content-center mt-5">
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
            <div class="row text-center align-items-center justify-content-center mt-3">
                <div class="col">
                    <img src="/img/personal_books.png" alt="Akses Buku Personal" style="height: 10em">
                    <div class="fs-4 fw-bold mt-4">
                        Anda akan mendapatkan rekomendasi buku personal
                    </div>
                </div>
            </div>
            <div class="row text-center align-items-center justify-content-center mt-5">
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

        function redirectToQRIS(price) {
            // Ganti 'defaultqris.png' dengan QRIS yang sesuai
            window.location.href = '/qris?price=' + price;
        }
    </script>

@endsection
