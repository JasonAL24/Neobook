@extends('layouts.main')

@section('container')
<div class="white-container p-5">
    @if(!$member->premium_status)
    <div class="d-flex flex-column justify-content-center text-center align-items-center">
        <span class="fw-bold">Ayo selesaikan pembayaran Anda sekarang</span>
        <span>Scan QR Code dibawah ini dengan aplikasi pembayaranmu</span>
        <div class="d-flex flex-row align-items-center justify-content-center">
            <div>Selesaikan pembayaranmu dalam waktu</div>
            <div class="p-1 rounded text-light bg-danger ms-2">
                <img
                    src="/img/svg/time.svg" alt="time"><span id="countdown" >24:00:00</span>
            </div>
        </div>
        <img src="/img/QRIS.png" alt="QRIS" class="img-fluid mt-4" style="width: 15%;">
        <div class="mt-5 d-flex flex-column">
            <span>Total Bayar</span>
            <span class="fw-bold">{{$price}}</span>
        </div>
    </div>
    <div>
        <span class="fw-bold">Cara pembayaran</span>
        <ol>
            <li>Buka aplikasi bank yang mendukung pembayaran QRIS di HP-mu.</li>
            <li>Scan QR Code di atas.</li>
            <li>Pastikan total tagihan sudah benar, lalu klik "Bayar".</li>
            <li>Setelah berhasil, klik tombol "Sudah Membayar" dibawah ini.</li>
        </ol>
    </div>
    <div class="text-center mt-5">
        <form action="{{route('subscribe')}}" method="POST">
            @csrf
            <button class="btn btn-primary" type="submit">
                Sudah Membayar
            </button>
        </form>
    </div>
    @else
        <div class="d-flex flex-column justify-content-center text-center align-items-center">
            <span class="fw-bold">Langganan Anda sudah aktif! Semoga Anda puas dengan layanan kami!</span>
            <span id="countdownMessage">Lanjut ke Beranda dalam waktu 3 detik...</span>
        </div>
    @endif
</div>
<script>
    var now = new Date().getTime();
    deadline = now + 24 * 60 * 60 * 1000;

    // Update countdown setiap 1 detik
    var x = setInterval(function() {
        // Tanggal sekarang
        var now = new Date().getTime();

        // Jarak antara tanggal akhir dan sekarang
        var distance = deadline - now;

        // Hitung waktu tersisa dalam jam, menit, dan detik
        var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
        var seconds = Math.floor((distance % (1000 * 60)) / 1000);

        // Tampilkan countdown dalam elemen dengan id "countdown"
        document.getElementById("countdown").innerHTML = hours + ":" + minutes + ":" + seconds;

        // Jika waktu habis, tampilkan pesan
        if (distance < 0) {
            clearInterval(x);
            document.getElementById("countdown").innerHTML = "Waktu habis!";
        }
    }, 1000);

    // Hitung mundur waktu dari 3 detik
    var countdown = 3;

    // Fungsi untuk memperbarui pesan countdown
    function updateCountdownMessage() {
        document.getElementById("countdownMessage").innerHTML = "Lanjut ke Beranda dalam waktu " + countdown + " detik...";
    }

    // Panggil fungsi updateCountdownMessage() untuk pertama kali
    updateCountdownMessage();

    // Set interval untuk mengupdate pesan setiap detik
    var countdownInterval = setInterval(function() {
        // Kurangi countdown setiap detik
        countdown--;

        // Perbarui pesan countdown
        updateCountdownMessage();

        // Jika countdown mencapai 0, arahkan pengguna ke halaman home
        if (countdown <= 0) {
            clearInterval(countdownInterval); // Hentikan interval
            window.location.href = "/home"; // Arahkan ke halaman home
        }
    }, 1000); // Interval setiap 1 detik

</script>
@endsection
