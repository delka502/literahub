// Fungsi untuk menampilkan form peminjaman buku
function showBorrowForm(book, thumbnail, title, authors, isbn) {
    // Periksa apakah form sudah ada di halaman (mencegah duplikasi)
    const existingOverlay = document.getElementById('borrow-form-overlay');
    if (existingOverlay) {
        console.log('Form sudah terbuka. Menghapus form lama...');
        document.body.removeChild(existingOverlay);
    }
    // Mendapatkan token CSRF dari meta tag
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    
    // Mendapatkan tanggal hari ini
    const today = new Date();
    const formattedToday = today.toISOString().split('T')[0];
    
    // Mendapatkan tanggal pengembalian default (14 hari dari sekarang)
    const returnDate = new Date();
    returnDate.setDate(today.getDate() + 14);
    const formattedReturnDate = returnDate.toISOString().split('T')[0];

    // Buat overlay untuk form peminjaman dengan z-index tinggi
    const overlay = document.createElement('div');
    overlay.id = 'borrow-form-overlay'; // Tambahkan ID untuk memudahkan debugging
    overlay.className = 'borrow-overlay';
    overlay.style.position = 'fixed';
    overlay.style.top = '0';
    overlay.style.left = '0';
    overlay.style.width = '100%';
    overlay.style.height = '100%';
    overlay.style.backgroundColor = 'rgba(0, 0, 0, 0.9)';
    overlay.style.zIndex = '9999'; // Pastikan z-index sangat tinggi
    overlay.style.overflowY = 'auto';
    overlay.style.display = 'flex';
    overlay.style.justifyContent = 'center';
    overlay.style.alignItems = 'flex-start';
    overlay.style.padding = '20px';
    overlay.style.transition = 'opacity 0.3s ease-in-out';
    overlay.style.opacity = '0';

    // Membuat konten form
    const formContent = document.createElement('div');
    formContent.className = 'borrow-form-content';
    formContent.style.backgroundColor = 'white';
    formContent.style.borderRadius = '8px';
    formContent.style.maxWidth = '600px';
    formContent.style.width = '100%';
    formContent.style.boxShadow = '0 5px 15px rgba(0, 0, 0, 0.3)';
    formContent.style.margin = '30px auto';
    formContent.style.transform = 'translateY(-20px)';
    formContent.style.transition = 'transform 0.3s ease-in-out';

    formContent.innerHTML = `
        <div class="form-header" style="background-color: #f8f9fa; padding: 20px; border-radius: 8px 8px 0 0; position: relative; text-align: center;">
            <button id="close-form" style="position: absolute; top: 10px; right: 10px; background: none; border: none; font-size: 24px; cursor: pointer; width: 30px; height: 30px; display: flex; align-items: center; justify-content: center;">&times;</button>
            <h2 style="margin-top: 0; color: #333; font-weight: bold;">Form Peminjaman Buku</h2>
        </div>
        
        <div class="book-info" style="display: flex; align-items: center; padding: 15px; border-bottom: 1px solid #eee; background-color: #f9f9f9;">
            <img src="${thumbnail}" alt="${title}" style="width: 100px; border-radius: 4px; box-shadow: 0 2px 5px rgba(0,0,0,0.2); margin-right: 15px;">
            <div>
                <h3 style="margin: 0 0 5px 0; font-size: 18px;">${title}</h3>
                <p style="margin: 0; font-style: italic; color: #666;">oleh ${authors}</p>
                <p style="margin: 5px 0 0 0; font-size: 12px; color: #888;">ISBN: ${isbn}</p>
            </div>
        </div>
        
        <form id="borrow-form" style="padding: 20px;">
            <input type="hidden" name="_token" value="${csrfToken}">
            <input type="hidden" name="book_id" value="${book.id}">
            <input type="hidden" name="book_title" value="${title}">
            <input type="hidden" name="book_authors" value="${authors}">
            <input type="hidden" name="book_isbn" value="${isbn}">
            
            <div class="form-group" style="margin-bottom: 15px;">
                <label for="fullname" style="display: block; margin-bottom: 5px; font-weight: bold;">Nama Lengkap</label>
                <input type="text" id="fullname" name="fullname" required style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px;">
            </div>
            
            <div class="form-group" style="margin-bottom: 15px;">
                <label for="student-id" style="display: block; margin-bottom: 5px; font-weight: bold;">Nomor Induk Mahasiswa</label>
                <input type="text" id="student-id" name="student_id" required style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px;">
            </div>
            
            <div class="form-row" style="display: flex; gap: 15px; margin-bottom: 15px;">
                <div class="form-group" style="flex: 1;">
                    <label for="borrow-date" style="display: block; margin-bottom: 5px; font-weight: bold;">Tanggal Pinjam</label>
                    <input type="date" id="borrow-date" name="borrow_date" value="${formattedToday}" required style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px;">
                </div>
                
                <div class="form-group" style="flex: 1;">
                    <label for="return-date" style="display: block; margin-bottom: 5px; font-weight: bold;">Tanggal Kembali</label>
                    <input type="date" id="return-date" name="return_date" value="${formattedReturnDate}" required style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px;">
                </div>
            </div>
            
            <div class="form-group" style="margin-bottom: 15px;">
                <label for="purpose" style="display: block; margin-bottom: 5px; font-weight: bold;">Tujuan Peminjaman</label>
                <select id="purpose" name="purpose" required style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px;">
                    <option value="" disabled selected>Pilih tujuan peminjaman</option>
                    <option value="Keperluan Akademik">Keperluan Akademik</option>
                    <option value="Penelitian">Penelitian</option>
                    <option value="Bacaan Pribadi">Bacaan Pribadi</option>
                    <option value="other">Lainnya</option>
                </select>
            </div>
            
            <div id="other-purpose" class="form-group" style="margin-bottom: 15px; display: none;">
                <label for="other-purpose-text" style="display: block; margin-bottom: 5px; font-weight: bold;">Tujuan Lainnya</label>
                <textarea id="other-purpose-text" name="other_purpose" style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px; height: 80px;"></textarea>
            </div>
            
            <div class="form-group" style="margin-bottom: 20px;">
                <div style="display: flex; align-items: flex-start;">
                    <input type="checkbox" id="agreement" name="agreement" required style="margin-top: 3px; margin-right: 8px;">
                    <label for="agreement" style="font-size: 14px; line-height: 1.4;">Saya setuju untuk mengembalikan buku dalam kondisi baik sesuai tanggal yang ditentukan</label>
                </div>
            </div>
            
            <button type="submit" class="btn btn-primary" style="width: 100%; padding: 10px; background-color: #007bff; color: white; border: none; border-radius: 4px; cursor: pointer; font-weight: bold;">Ajukan Peminjaman</button>
        </form>
    `;

    // Tambahkan formContent ke dalam overlay
    overlay.appendChild(formContent);
    
    // Tambahkan overlay ke dalam body
    document.body.appendChild(overlay);

    // Animasi untuk menampilkan overlay
    setTimeout(() => {
        overlay.style.opacity = '1';
        formContent.style.transform = 'translateY(0)';
    }, 50);

    // Validasi tanggal kembali (harus setelah tanggal pinjam)
    const borrowDateInput = formContent.querySelector('#borrow-date');
    const returnDateInput = formContent.querySelector('#return-date');
    
    borrowDateInput.addEventListener('change', () => {
        const borrowDate = new Date(borrowDateInput.value);
        const returnDate = new Date(returnDateInput.value);
        
        if (returnDate <= borrowDate) {
            const newReturnDate = new Date(borrowDate);
            newReturnDate.setDate(borrowDate.getDate() + 14);
            returnDateInput.value = newReturnDate.toISOString().split('T')[0];
        }
    });

    // Tambahkan event listener untuk dropdown purpose
    const purposeSelect = formContent.querySelector('#purpose');
    const otherPurposeDiv = formContent.querySelector('#other-purpose');
    
    purposeSelect.addEventListener('change', () => {
        if (purposeSelect.value === 'other') {
            otherPurposeDiv.style.display = 'block';
            formContent.querySelector('#other-purpose-text').setAttribute('required', '');
        } else {
            otherPurposeDiv.style.display = 'none';
            formContent.querySelector('#other-purpose-text').removeAttribute('required');
        }
    });

    // Fungsi untuk menutup form
    function closeForm() {
        // Cek apakah overlay masih ada di DOM
        if (!document.body.contains(overlay)) {
            console.log('Overlay sudah tidak ada di DOM');
            return;
        }
        
        // Animasi untuk menutup overlay
        overlay.style.opacity = '0';
        formContent.style.transform = 'translateY(-20px)';
        
        // Nonaktifkan pointer events untuk mencegah interaksi selama animasi tutup
        overlay.style.pointerEvents = 'none';
        
        // Hapus semua event listener untuk mencegah multiple calls
        const closeBtn = formContent.querySelector('#close-form');
        if (closeBtn) {
            closeBtn.removeEventListener('click', handleCloseClick);
            // Disable tombol untuk mencegah multiple clicks
            closeBtn.disabled = true;
        }
        
        console.log('Proses menutup modal dimulai');
        
        setTimeout(() => {
            // Double check untuk memastikan overlay masih ada sebelum dihapus
            if (document.body.contains(overlay)) {
                document.body.removeChild(overlay);
                console.log('Modal berhasil ditutup');
            } else {
                console.log('Overlay sudah dihapus sebelumnya');
            }
        }, 300);
    }

    // Handler function untuk tombol close agar bisa di-remove nantinya
    function handleCloseClick(e) {
        e.preventDefault(); // Mencegah event bubbling
        e.stopPropagation(); // Hentikan propagasi event
        console.log('Tombol close diklik');
        closeForm();
    }

    // Tambahkan event listener untuk tombol close
    const closeButton = formContent.querySelector('#close-form');
    closeButton.addEventListener('click', handleCloseClick);

    // Menutup form dengan klik di luar content
    function handleOutsideClick(e) {
        if (e.target === overlay) {
            console.log('Klik di luar modal');
            closeForm();
        }
    }
    
    overlay.addEventListener('click', handleOutsideClick);

    // Fungsi untuk menampilkan animasi sukses
    function showSuccessAnimation(title) {
        // Buat overlay untuk animasi sukses
        const successOverlay = document.createElement('div');
        successOverlay.className = 'success-overlay';
        successOverlay.style.position = 'fixed';
        successOverlay.style.top = '0';
        successOverlay.style.left = '0';
        successOverlay.style.width = '100%';
        successOverlay.style.height = '100%';
        successOverlay.style.backgroundColor = 'rgba(0, 0, 0, 0.8)';
        successOverlay.style.zIndex = '1001';
        successOverlay.style.display = 'flex';
        successOverlay.style.justifyContent = 'center';
        successOverlay.style.alignItems = 'center';
        successOverlay.style.opacity = '0';
        successOverlay.style.transition = 'opacity 0.5s ease';

        // Buat container untuk animasi
        const successContainer = document.createElement('div');
        successContainer.className = 'success-container';
        successContainer.style.textAlign = 'center';
        successContainer.style.color = 'white';
        successContainer.style.maxWidth = '500px';
        successContainer.style.padding = '20px';
        successContainer.style.transform = 'scale(0.8)';
        successContainer.style.transition = 'transform 0.6s cubic-bezier(0.175, 0.885, 0.32, 1.275)';

        // Buat check icon untuk animasi
        const checkIcon = document.createElement('div');
        checkIcon.className = 'success-icon';
        checkIcon.innerHTML = `
            <svg xmlns="http://www.w3.org/2000/svg" width="100" height="100" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                <polyline points="22 4 12 14.01 9 11.01"></polyline>
            </svg>
        `;
        checkIcon.style.color = '#4CAF50';
        checkIcon.style.marginBottom = '20px';
        checkIcon.style.transform = 'scale(0)';
        checkIcon.style.transition = 'transform 0.5s cubic-bezier(0.175, 0.885, 0.32, 1.275) 0.2s';

        // Buat judul sukses
        const successTitle = document.createElement('h2');
        successTitle.textContent = 'Peminjaman Berhasil!';
        successTitle.style.fontSize = '28px';
        successTitle.style.marginBottom = '15px';
        successTitle.style.opacity = '0';
        successTitle.style.transform = 'translateY(20px)';
        successTitle.style.transition = 'opacity 0.5s ease 0.4s, transform 0.5s ease 0.4s';

        // Buat pesan sukses
        const successMessage = document.createElement('p');
        successMessage.innerHTML = `Buku <strong>"${title}"</strong> berhasil diajukan untuk dipinjam.<br>Silakan cek status peminjaman Anda di halaman "Buku Saya".`;
        successMessage.style.fontSize = '16px';
        successMessage.style.lineHeight = '1.5';
        successMessage.style.opacity = '0';
        successMessage.style.transform = 'translateY(20px)';
        successMessage.style.transition = 'opacity 0.5s ease 0.6s, transform 0.5s ease 0.6s';

        // Buat tombol OK
        const okButton = document.createElement('button');
        okButton.textContent = 'OK';
        okButton.style.marginTop = '25px';
        okButton.style.padding = '10px 30px';
        okButton.style.backgroundColor = '#4CAF50';
        okButton.style.color = 'white';
        okButton.style.border = 'none';
        okButton.style.borderRadius = '5px';
        okButton.style.fontSize = '16px';
        okButton.style.cursor = 'pointer';
        okButton.style.boxShadow = '0 4px 8px rgba(0,0,0,0.2)';
        okButton.style.opacity = '0';
        okButton.style.transform = 'translateY(20px)';
        okButton.style.transition = 'opacity 0.5s ease 0.8s, transform 0.5s ease 0.8s, background-color 0.3s';

        // Hover effect untuk tombol OK
        okButton.onmouseover = function() {
            okButton.style.backgroundColor = '#43A047';
        };
        okButton.onmouseout = function() {
            okButton.style.backgroundColor = '#4CAF50';
        };

        // Tambahkan event listener untuk tombol OK
        okButton.addEventListener('click', () => {
            // Animasi untuk menutup success overlay
            successOverlay.style.opacity = '0';
            
            setTimeout(() => {
                document.body.removeChild(successOverlay);
            }, 500);
        });

        // Buat animasi konfeti (elemen dekoratif)
        const confettiContainer = document.createElement('div');
        confettiContainer.style.position = 'absolute';
        confettiContainer.style.top = '0';
        confettiContainer.style.left = '0';
        confettiContainer.style.width = '100%';
        confettiContainer.style.height = '100%';
        confettiContainer.style.overflow = 'hidden';
        confettiContainer.style.pointerEvents = 'none';

        // Tambahkan semua elemen ke container
        successContainer.appendChild(checkIcon);
        successContainer.appendChild(successTitle);
        successContainer.appendChild(successMessage);
        successContainer.appendChild(okButton);
        successOverlay.appendChild(confettiContainer);
        successOverlay.appendChild(successContainer);
        document.body.appendChild(successOverlay);

        // Tambahkan confetti
        for (let i = 0; i < 100; i++) {
            createConfetti(confettiContainer);
        }

        // Animasi untuk menampilkan overlay dan elemen-elemennya
        setTimeout(() => {
            successOverlay.style.opacity = '1';
            successContainer.style.transform = 'scale(1)';
            checkIcon.style.transform = 'scale(1)';
            successTitle.style.opacity = '1';
            successTitle.style.transform = 'translateY(0)';
            successMessage.style.opacity = '1';
            successMessage.style.transform = 'translateY(0)';
            okButton.style.opacity = '1';
            okButton.style.transform = 'translateY(0)';
        }, 100);
    }

    // Fungsi untuk membuat confetti
    function createConfetti(container) {
        const confetti = document.createElement('div');
        const size = Math.random() * 10 + 5;
        const colors = ['#f44336', '#e91e63', '#9c27b0', '#673ab7', '#3f51b5', '#2196f3', '#03a9f4', '#00bcd4', '#009688', '#4CAF50', '#8BC34A', '#CDDC39', '#FFEB3B', '#FFC107', '#FF9800', '#FF5722'];
        const color = colors[Math.floor(Math.random() * colors.length)];
        
        confetti.style.position = 'absolute';
        confetti.style.width = `${size}px`;
        confetti.style.height = `${size}px`;
        confetti.style.backgroundColor = color;
        confetti.style.borderRadius = Math.random() > 0.5 ? '50%' : '0';
        confetti.style.opacity = Math.random();
        confetti.style.top = '-20px';
        confetti.style.left = `${Math.random() * 100}%`;
        confetti.style.transform = `rotate(${Math.random() * 360}deg)`;
        confetti.style.zIndex = '-1';
        
        container.appendChild(confetti);
        
        // Animasi untuk confetti
        const duration = Math.random() * 3 + 2;
        const delay = Math.random() * 2;
        
        confetti.animate(
            [
                { 
                    transform: `translate3d(${(Math.random() - 0.5) * 500}px, 0, 0) rotate(0deg)`,
                    opacity: Math.random() 
                },
                { 
                    transform: `translate3d(${(Math.random() - 0.5) * 500}px, ${window.innerHeight}px, 0) rotate(${Math.random() * 720}deg)`,
                    opacity: 0 
                }
            ],
            {
                duration: duration * 1000,
                delay: delay * 1000,
                fill: 'both',
                easing: 'cubic-bezier(0.21, 0.61, 0.35, 1)'
            }
        );
        
        // Hapus konfeti setelah animasi selesai
        setTimeout(() => {
            container.removeChild(confetti);
        }, (duration + delay) * 1000);
    }

    // Tambahkan validasi untuk form dan submit AJAX
    const borrowForm = formContent.querySelector('#borrow-form');
    borrowForm.addEventListener('submit', (e) => {
        e.preventDefault();
        
        // Validasi form sebelum submit
        const fullname = formContent.querySelector('#fullname').value;
        const studentId = formContent.querySelector('#student-id').value;
        const borrowDate = formContent.querySelector('#borrow-date').value;
        const returnDate = formContent.querySelector('#return-date').value;
        const purpose = formContent.querySelector('#purpose').value;
        const otherPurpose = formContent.querySelector('#other-purpose-text').value;
        const agreement = formContent.querySelector('#agreement').checked;
        
        if (!fullname || !studentId || !borrowDate || !returnDate || !purpose || (purpose === 'other' && !otherPurpose) || !agreement) {
            alert('Mohon lengkapi semua kolom yang diperlukan.');
            return;
        }
        
        // Buat FormData untuk dikirim ke server
        const formData = new FormData(borrowForm);
        
        // Jika tujuan lainnya dipilih, gunakan nilai dari other-purpose-text
        if (purpose === 'other') {
            formData.set('purpose', otherPurpose);
        }
        
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
                // Hapus event listener untuk mencegah multiple calls
                if (closeButton) {
                    closeButton.removeEventListener('click', handleCloseClick);
                }
                overlay.removeEventListener('click', handleOutsideClick);
                
                // Tutup form peminjaman
                closeForm();
                
                setTimeout(() => {
                    // Tampilkan animasi sukses setelah form ditutup
                    showSuccessAnimation(title);
                }, 400); // Ditambah waktu delay untuk memastikan form sudah tertutup
            } else {
                alert(`Error: ${data.message}`);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Terjadi kesalahan saat memproses peminjaman. Silakan coba lagi.');
        });
    });

    // Tambahkan validasi format NIM
    const studentIdInput = formContent.querySelector('#student-id');
    studentIdInput.addEventListener('input', () => {
        const value = studentIdInput.value;
        // Hanya mengizinkan angka dan huruf untuk NIM
        studentIdInput.value = value.replace(/[^a-zA-Z0-9]/g, '');
    });

    // Tambahkan validasi untuk nama lengkap
    const fullnameInput = formContent.querySelector('#fullname');
    fullnameInput.addEventListener('input', () => {
        const value = fullnameInput.value;
        // Hanya mengizinkan huruf, spasi, dan beberapa karakter khusus untuk nama
        fullnameInput.value = value.replace(/[^a-zA-Z\s'.,-]/g, '');
    });

    // Tambahkan CSS untuk responsivitas
    const style = document.createElement('style');
    style.textContent = `
        @media (max-width: 768px) {
            .form-row {
                flex-direction: column;
                gap: 10px;
            }
            .book-info {
                flex-direction: column;
                text-align: center;
            }
            .book-info img {
                margin-right: 0;
                margin-bottom: 10px;
            }
        }
    `;
    document.head.appendChild(style);
}

// Menambahkan event listener untuk tombol Pinjam
function setupLoanButtons() {
    // Dapatkan semua tombol Pinjam yang ada di halaman
    const loanButtons = document.querySelectorAll('.btn-primary:not([disabled])');
    
    loanButtons.forEach(button => {
        button.addEventListener('click', function(event) {
            // Dapatkan informasi buku dari kartu parent
            const bookCard = this.closest('.card');
            const bookId = bookCard.dataset.bookId; // Asumsi ID disimpan di data-book-id attribute
            const bookTitle = bookCard.querySelector('.card-title').textContent;
            const bookAuthor = bookCard.querySelector('.card-text').textContent.replace('Penulis: ', '');
            const bookImage = bookCard.querySelector('img').src;
            const bookISBN = bookCard.dataset.isbn || ""; // Asumsi ISBN disimpan di data-isbn
            
            // Data buku untuk form
            const book = {
                id: bookId
            };
            
            // Tampilkan form peminjaman
            showBorrowForm(book, bookImage, bookTitle, bookAuthor, bookISBN);
        });
    });
}

// Initialize the page
document.addEventListener('DOMContentLoaded', function() {
    setupLoanButtons();
});