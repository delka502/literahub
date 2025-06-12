// Kirim data ke server menggunakan fetch API
fetch('/peminjaman/store', {
    method: 'POST',
    headers: {
        'X-CSRF-TOKEN': csrfToken,
        'Accept': 'application/json'
    },
    body: formData
})
.then(response => response.json())
.then(data => {
    if (data.success) {
        alert(`Buku "${title}" berhasil diajukan untuk dipinjam. Silakan cek status peminjaman Anda di halaman "Buku Saya".`);
        
        // Tutup form
        overlay.style.opacity = '0';
        formContent.style.transform = 'translateY(-20px)';
        
        setTimeout(() => {
            document.body.removeChild(overlay);
        }, 300);
    } else {
        alert(`Error: ${data.message}`);
    }
})
.catch(error => {
    console.error('Error:', error);
    alert('Terjadi kesalahan saat memproses peminjaman. Silakan coba lagi.');
});