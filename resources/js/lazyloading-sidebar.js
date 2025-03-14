document.addEventListener('DOMContentLoaded', function() {
    function showLoading() {
        Swal.fire({
            icon: 'info', // Ikon info untuk menunjukkan status memuat
            html: `
                <div class="flex flex-col items-center justify-center">
                    <h2 class="text-black text-2xl mt-2">Mohon Tunggu...</h2>
                    <p class="text-black text-lg">Sedang memuat halaman...</p>
                </div>
            `,
            allowOutsideClick: false, // Tidak bisa menutup dengan klik di luar modal
            showConfirmButton: false, // Menghilangkan tombol konfirmasi
            didOpen: () => {
                Swal.showLoading(); // Menampilkan spinner loading
            },
        });
    }
    
    

    function hideLoading() {
        Swal.close();
    }

    // Handle klik pada sidebar
    document.querySelectorAll('.lazy-loading').forEach(function(link) {
        link.addEventListener('click', function() {
            showLoading();
        });
    });

    // Saat halaman selesai dimuat
    window.addEventListener('load', function() {
        hideLoading();
    });
});