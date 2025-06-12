    // Toggle details view
    document.querySelectorAll('.expand-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const icon = this.querySelector('i');
            icon.classList.toggle('rotate-icon');
            
            // Calculate and set max-height for smooth animation
            const targetId = this.getAttribute('data-bs-target');
            const detailElement = document.querySelector(targetId + ' .loan-details');
            
            if (detailElement.style.maxHeight) {
                detailElement.style.maxHeight = null;
            } else {
                detailElement.style.maxHeight = detailElement.scrollHeight + "px";
            }
        });
    });


// Kode original tetap dipertahankan dengan perbaikan tombol Baca
function searchBooks() {
    const query = document.getElementById('search-input').value.trim();
    console.log('Search input:', query); // Log input pencarian

    if (query) {
        console.log('Memulai pencarian buku...'); // Log sebelum pencarian dimulai
        fetchBooks(query);
    } else {
        alert('Masukkan judul, penulis, atau kategori untuk mencari!');
        console.log('Pencarian kosong.'); // Log jika input kosong
    }
}

// Fungsi untuk mengambil buku dari API dan menampilkannya
async function fetchBooks(query) {
    const bookList = document.getElementById('book-list');
    const loadingBar = document.getElementById('loading-bar');

    try {
        // Tampilkan loading bar dan bersihkan daftar buku sebelumnya
        loadingBar.style.display = 'block';
        bookList.innerHTML = '';
        console.log('Mengambil data buku untuk query:', query); // Log query

        // Ambil data buku dari API Google Books
        const response = await fetch(`https://www.googleapis.com/books/v1/volumes?q=${query}&maxResults=10&key=AIzaSyDvggerRAHEKMiua2KEEFKp556NmlFpbd8`);
        console.log('Status respons:', response.status); // Log status respons

        const data = await response.json();
        console.log('Data buku yang diperoleh:', data); // Log data buku

        const books = data.items;

        // Sembunyikan loading bar
        loadingBar.style.display = 'none';

        // Jika buku tidak ditemukan
        if (!books) {
            console.warn('Buku tidak ditemukan.'); // Log jika tidak ada buku
            bookList.innerHTML = '<p class="text-center">Buku tidak ditemukan.</p>';
            return;
        }

        // Loop untuk menampilkan buku
        books.forEach((book, index) => {
            const title = book.volumeInfo.title || 'Judul Tidak Tersedia';
            const authors = book.volumeInfo.authors ? book.volumeInfo.authors.join(', ') : 'Penulis Tidak Diketahui';
            const thumbnail = book.volumeInfo.imageLinks ? book.volumeInfo.imageLinks.thumbnail : 'https://via.placeholder.com/150';
            const previewLink = book.volumeInfo.previewLink || '#';
            const description = book.volumeInfo.description || 'Deskripsi tidak tersedia';
            const categories = book.volumeInfo.categories ? book.volumeInfo.categories.join(', ') : 'Tidak ada kategori';
            const publisher = book.volumeInfo.publisher || 'Tidak ada informasi penerbit';
            const publishedDate = book.volumeInfo.publishedDate || 'Tidak ada informasi tanggal terbit';
            const pageCount = book.volumeInfo.pageCount || 'Tidak tersedia';
            const language = book.volumeInfo.language || 'Tidak tersedia';
            const isbn = book.volumeInfo.industryIdentifiers ? 
                book.volumeInfo.industryIdentifiers[0].identifier : 'Tidak tersedia';

            // Menghasilkan rating acak antara 4.0 dan 5.0
            const rating = (Math.random() * 1 + 4).toFixed(1);

            // Status ketersediaan secara acak
            const isAvailable = Math.random() > 0.3;
            const availabilityText = isAvailable ? 'Tersedia' : 'Dipinjam';
            const availabilityBadge = isAvailable ? 'badge-available' : 'badge-borrowed';

            // Cek apakah buku sudah dipinjam oleh user (dari localStorage atau sistem tracking)
            const borrowedBooks = JSON.parse(localStorage.getItem('borrowedBooks') || '[]');
            const isBorrowedByUser = borrowedBooks.some(borrowedBook => borrowedBook.id === book.id);

            // Log detail buku
            console.log(`Buku ${index + 1}:`, {
                title,
                authors,
                rating,
                availability: availabilityText,
                isBorrowedByUser,
                previewLink
            });

            // Tentukan status tombol berdasarkan kondisi
            const borrowButtonText = isBorrowedByUser ? 'Sudah Dipinjam' : 'Pinjam';
            const borrowButtonDisabled = !isAvailable || isBorrowedByUser;
            const readButtonText = isBorrowedByUser ? 'Baca Lengkap' : 'Preview';
            const readButtonClass = isBorrowedByUser ? 'btn-success' : 'btn-outline-success';

            // Buat elemen buku
            const col = document.createElement('div');
            col.className = 'col-md-4 col-lg-3 mb-4';
            col.style.opacity = '0';

            col.innerHTML = `
                <div class="card h-100 shadow-sm fall-animation">
                    <div class="position-relative">
                        <img src="${thumbnail}" class="card-img-top" alt="${title}">
                        <span class="badge ${availabilityBadge} position-absolute top-0 start-0 m-2">${availabilityText}</span>
                        <button class="bookmark-btn position-absolute top-0 end-0 m-2">
                            <i class="far fa-bookmark"></i>
                        </button>
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">${title}</h5>
                        <p class="card-text">Penulis: ${authors}</p>
                        <p class="card-text">
                            <span class="text-warning"><i class="fas fa-star"></i></span> ${rating}
                        </p>
                        <div class="d-flex justify-content-between">
                            <button class="btn btn-primary w-100 me-1 borrow-btn" data-book-id="${book.id}" ${borrowButtonDisabled ? 'disabled' : ''}>
                                ${borrowButtonText}
                            </button>
                            <button class="btn ${readButtonClass} w-100 ms-1 preview-btn" data-book-id="${book.id}" title="${isBorrowedByUser ? 'Baca buku lengkap' : 'Preview buku'}">
                                ${readButtonText}
                            </button>
                        </div>
                        ${!isBorrowedByUser ? '<small class="text-muted d-block mt-2 text-center">Pinjam untuk akses lengkap</small>' : '<small class="text-success d-block mt-2 text-center">Akses penuh tersedia</small>'}
                    </div>
                </div>
            `;

            // Efek muncul satu per satu
            setTimeout(() => {
                col.style.opacity = '1';
                bookList.appendChild(col);
            }, index * 100);

            // Bookmark button action
            const bookmarkBtn = col.querySelector('.bookmark-btn');
            bookmarkBtn.addEventListener('click', () => {
                bookmarkBtn.classList.toggle('active');
                console.log('Bookmark diklik:', title); // Log ketika bookmark diklik
                if (bookmarkBtn.classList.contains('active')) {
                    bookmarkBtn.innerHTML = '<i class="fas fa-bookmark"></i>';
                } else {
                    bookmarkBtn.innerHTML = '<i class="far fa-bookmark"></i>';
                }
            });

            // Preview button action - Sekarang selalu dapat diklik
            const previewBtn = col.querySelector('.preview-btn');
            previewBtn.addEventListener('click', () => {
                console.log('Tombol baca diklik untuk buku:', title);
                
                if (isBorrowedByUser) {
                    // Jika sudah dipinjam, buka akses penuh
                    console.log('Membuka akses penuh untuk buku:', title);
                    showBookPreview(book, previewLink, thumbnail, title, authors, description, categories, publisher, publishedDate, pageCount, language, isbn, rating, isAvailable, true);
                } else {
                    // Jika belum dipinjam, buka preview terbatas
                    console.log('Membuka preview terbatas untuk buku:', title);
                    showBookPreview(book, previewLink, thumbnail, title, authors, description, categories, publisher, publishedDate, pageCount, language, isbn, rating, isAvailable, false);
                }
            });

            // Borrow button action - Menambahkan event listener untuk tombol Pinjam
            const borrowBtn = col.querySelector('.borrow-btn');
            borrowBtn.addEventListener('click', () => {
                if (!isBorrowedByUser && isAvailable) {
                    console.log('Pinjam diklik untuk buku:', title);
                    showBorrowForm(book, thumbnail, title, authors, isbn);
                } else if (isBorrowedByUser) {
                    console.log('Buku sudah dipinjam:', title);
                    alert('Buku ini sudah Anda pinjam!');
                } else {
                    console.log('Buku tidak tersedia:', title);
                    alert('Buku ini sedang tidak tersedia!');
                }
            });
        });

        console.log('Selesai menampilkan buku.'); // Log saat semua buku telah ditampilkan
    } catch (error) {
        console.error('Gagal memuat buku:', error); // Log jika ada kesalahan
        loadingBar.style.display = 'none';
        bookList.innerHTML = '<p class="text-center text-danger">Gagal memuat data buku. Silakan coba lagi.</p>';
    }
}

// Fungsi untuk menampilkan preview buku (perlu ditambahkan jika belum ada)
function showBookPreview(book, previewLink, thumbnail, title, authors, description, categories, publisher, publishedDate, pageCount, language, isbn, rating, isAvailable, isFullAccess = false) {
    // Implementasi untuk menampilkan preview buku
    console.log('Menampilkan preview buku:', title, 'Akses penuh:', isFullAccess);
    
    // Contoh implementasi sederhana - bisa disesuaikan dengan kebutuhan
    if (isFullAccess) {
        // Buka akses penuh atau redirect ke halaman baca
        if (previewLink && previewLink !== '#') {
            window.open(previewLink, '_blank');
        } else {
            alert('Akses penuh tersedia! Implementasikan pembaca buku di sini.');
        }
    } else {
        // Tampilkan preview terbatas
        const limitedDescription = description.length > 200 ? description.substring(0, 200) + '...' : description;
        alert(`Preview: ${title}\n\nPenulis: ${authors}\n\nDeskripsi: ${limitedDescription}\n\nPinjam buku untuk akses lengkap!`);
    }
}

// Fungsi untuk menampilkan form peminjaman (perlu ditambahkan jika belum ada)
function showBorrowForm(book, thumbnail, title, authors, isbn) {
    console.log('Menampilkan form peminjaman untuk:', title);
    
    // Implementasi form peminjaman - bisa disesuaikan dengan kebutuhan
    const confirmBorrow = confirm(`Apakah Anda ingin meminjam buku "${title}" oleh ${authors}?`);
    
    if (confirmBorrow) {
        // Simulasi peminjaman - tambahkan ke localStorage
        const borrowedBooks = JSON.parse(localStorage.getItem('borrowedBooks') || '[]');
        const borrowedBook = {
            id: book.id,
            title: title,
            authors: authors,
            thumbnail: thumbnail,
            isbn: isbn,
            borrowDate: new Date().toISOString(),
            returnDate: new Date(Date.now() + 14 * 24 * 60 * 60 * 1000).toISOString() // 14 hari
        };
        
        borrowedBooks.push(borrowedBook);
        localStorage.setItem('borrowedBooks', JSON.stringify(borrowedBooks));
        
        alert(`Buku "${title}" berhasil dipinjam! Masa peminjaman: 14 hari.`);
        
        // Refresh tampilan untuk update status tombol
        const currentQuery = document.getElementById('search-input').value.trim();
        if (currentQuery) {
            fetchBooks(currentQuery);
        }
    }
}

// Fungsi helper untuk memperbarui status tombol setelah peminjaman berhasil
function updateBookButtonsAfterBorrow(bookId) {
    const borrowedBooks = JSON.parse(localStorage.getItem('borrowedBooks') || '[]');
    const isBorrowedByUser = borrowedBooks.some(borrowedBook => borrowedBook.id === bookId);
    
    if (isBorrowedByUser) {
        // Cari card buku yang sesuai dan update tombolnya
        const borrowBtn = document.querySelector(`[data-book-id="${bookId}"].borrow-btn`);
        const previewBtn = document.querySelector(`[data-book-id="${bookId}"].preview-btn`);
        
        if (borrowBtn) {
            borrowBtn.textContent = 'Sudah Dipinjam';
            borrowBtn.disabled = true;
        }
        
        if (previewBtn) {
            previewBtn.disabled = false;
            previewBtn.title = 'Klik untuk membaca buku';
        }
        
        // Hapus pesan "Pinjam buku untuk membaca"
        const card = borrowBtn?.closest('.card');
        const helpText = card?.querySelector('.text-muted');
        if (helpText) {
            helpText.remove();
        }
        
        console.log('Status tombol diperbarui untuk buku ID:', bookId);
    }
}

// Fungsi untuk menampilkan halaman preview buku
function showBookPreview(book, previewLink, thumbnail, title, authors, description, categories, publisher, publishedDate, pageCount, language, isbn, rating, isAvailable) {
    // Buat overlay untuk halaman preview
    const overlay = document.createElement('div');
    overlay.className = 'preview-overlay';
    overlay.style.position = 'fixed';
    overlay.style.top = '0';
    overlay.style.left = '0';
    overlay.style.width = '100%';
    overlay.style.height = '100%';
    overlay.style.backgroundColor = 'rgba(0, 0, 0, 0.9)';
    overlay.style.zIndex = '1000';
    overlay.style.overflowY = 'auto';
    overlay.style.display = 'flex';
    overlay.style.justifyContent = 'center';
    overlay.style.alignItems = 'flex-start';
    overlay.style.padding = '20px';
    overlay.style.transition = 'all 0.3s ease-in-out';
    overlay.style.opacity = '0';

    // Ambil sampel teks dari buku (jika ada)
    let sampleText = '';
    if (book.searchInfo && book.searchInfo.textSnippet) {
        sampleText = book.searchInfo.textSnippet;
    }

    // Format deskripsi untuk membatasi panjangnya
    const shortDescription = description.length > 300 ? 
        description.substring(0, 300) + '...' : description;

    // Membuat konten preview
    const previewContent = document.createElement('div');
    previewContent.className = 'preview-content';
    previewContent.style.backgroundColor = 'white';
    previewContent.style.borderRadius = '8px';
    previewContent.style.maxWidth = '900px';
    previewContent.style.width = '100%';
    previewContent.style.boxShadow = '0 5px 15px rgba(0, 0, 0, 0.3)';
    previewContent.style.margin = '30px auto';
    previewContent.style.transform = 'translateY(-20px)';
    previewContent.style.transition = 'transform 0.3s ease-in-out';

    // Status peminjaman
    const availabilityText = isAvailable ? 'Tersedia' : 'Dipinjam';
    const availabilityClass = isAvailable ? 'text-success' : 'text-danger';

    previewContent.innerHTML = `
        <div class="preview-header" style="background-color: #f8f9fa; padding: 20px; border-radius: 8px 8px 0 0; position: relative;">
            <button id="close-preview" style="position: absolute; top: 10px; right: 10px; background: none; border: none; font-size: 24px; cursor: pointer;">&times;</button>
            <h2 style="margin-top: 0; color: #333; font-weight: bold;">${title}</h2>
            <p style="margin-bottom: 5px; font-style: italic;">oleh ${authors}</p>
        </div>
        
        <div class="preview-body" style="display: flex; padding: 20px;">
            <div class="preview-left" style="flex: 0 0 30%; padding-right: 20px;">
                <img src="${thumbnail}" alt="${title}" style="width: 100%; border-radius: 4px; box-shadow: 0 2px 5px rgba(0,0,0,0.2);">
                <div class="mt-3" style="margin-top: 15px;">
                    <p style="margin-bottom: 5px;"><span class="text-warning"><i class="fas fa-star"></i></span> ${rating} / 5.0</p>
                    <p style="margin-bottom: 5px;"><strong>Status:</strong> <span class="${availabilityClass}">${availabilityText}</span></p>
                    <button id="preview-borrow-btn" class="btn btn-primary w-100 mt-3" style="margin-top: 15px; padding: 8px; border-radius: 4px; background-color: #007bff; color: white; border: none; cursor: pointer; ${!isAvailable ? 'opacity: 0.65; cursor: not-allowed;' : ''}" ${!isAvailable ? 'disabled' : ''}>
                        Pinjam Buku
                    </button>
                </div>
            </div>
            
            <div class="preview-right" style="flex: 0 0 70%;">
                <div class="preview-tabs" style="border-bottom: 1px solid #dee2e6; margin-bottom: 15px;">
                    <ul style="display: flex; list-style: none; padding: 0; margin: 0;">
                        <li class="preview-tab active" data-tab="info" style="padding: 10px 15px; cursor: pointer; border-bottom: 2px solid #007bff; font-weight: bold; color: #007bff;">Informasi</li>
                        <li class="preview-tab" data-tab="synopsis" style="padding: 10px 15px; cursor: pointer;">Sinopsis</li>
                        <li class="preview-tab" data-tab="sample" style="padding: 10px 15px; cursor: pointer;">Sampel Konten</li>
                    </ul>
                </div>
                
                <div id="tab-info" class="tab-content active" style="display: block;">
                    <table style="width: 100%; border-collapse: collapse;">
                        <tr>
                            <td style="padding: 8px 0; border-bottom: 1px solid #eee; width: 40%;"><strong>Penerbit</strong></td>
                            <td style="padding: 8px 0; border-bottom: 1px solid #eee;">${publisher}</td>
                        </tr>
                        <tr>
                            <td style="padding: 8px 0; border-bottom: 1px solid #eee;"><strong>Tanggal Terbit</strong></td>
                            <td style="padding: 8px 0; border-bottom: 1px solid #eee;">${publishedDate}</td>
                        </tr>
                        <tr>
                            <td style="padding: 8px 0; border-bottom: 1px solid #eee;"><strong>Kategori</strong></td>
                            <td style="padding: 8px 0; border-bottom: 1px solid #eee;">${categories}</td>
                        </tr>
                        <tr>
                            <td style="padding: 8px 0; border-bottom: 1px solid #eee;"><strong>Jumlah Halaman</strong></td>
                            <td style="padding: 8px 0; border-bottom: 1px solid #eee;">${pageCount}</td>
                        </tr>
                        <tr>
                            <td style="padding: 8px 0; border-bottom: 1px solid #eee;"><strong>Bahasa</strong></td>
                            <td style="padding: 8px 0; border-bottom: 1px solid #eee;">${language.toUpperCase()}</td>
                        </tr>
                        <tr>
                            <td style="padding: 8px 0; border-bottom: 1px solid #eee;"><strong>ISBN</strong></td>
                            <td style="padding: 8px 0; border-bottom: 1px solid #eee;">${isbn}</td>
                        </tr>
                    </table>
                </div>
                
                <div id="tab-synopsis" class="tab-content" style="display: none;">
                    <div style="line-height: 1.6;">
                        ${description}
                    </div>
                </div>
                
                <div id="tab-sample" class="tab-content" style="display: none;">
                    <div style="line-height: 1.6; background-color: #f9f9f9; padding: 15px; border-radius: 4px; border-left: 4px solid #007bff;">
                        ${sampleText || 'Sampel konten tidak tersedia untuk buku ini. Silakan kunjungi Google Books untuk pratinjau lebih lanjut.'}
                    </div>
                </div>
            </div>
        </div>
    `;

    document.body.appendChild(overlay);

    // Event untuk tabs
    const tabs = previewContent.querySelectorAll('.preview-tab');
    tabs.forEach(tab => {
        tab.addEventListener('click', () => {
            const tabId = tab.getAttribute('data-tab');
            
            // Hide all tab contents
            const tabContents = previewContent.querySelectorAll('.tab-content');
            tabContents.forEach(content => content.style.display = 'none');
            
            // Remove active class from all tabs
            tabs.forEach(t => {
                t.style.borderBottom = 'none';
                t.style.fontWeight = 'normal';
                t.style.color = '#333';
            });
            
            // Show the selected tab content
            const selectedContent = previewContent.querySelector(`#tab-${tabId}`);
            selectedContent.style.display = 'block';
            
            // Add active class to selected tab
            tab.style.borderBottom = '2px solid #007bff';
            tab.style.fontWeight = 'bold';
            tab.style.color = '#007bff';
        });
    });

    // Animasi untuk menampilkan overlay
    setTimeout(() => {
        overlay.style.opacity = '1';
        previewContent.style.transform = 'translateY(0)';
    }, 50);

    overlay.appendChild(previewContent);

    // Tambahkan event listener untuk tombol close
    const closeButton = document.getElementById('close-preview');
    closeButton.addEventListener('click', () => {
        // Animasi untuk menutup overlay
        overlay.style.opacity = '0';
        previewContent.style.transform = 'translateY(-20px)';
        
        setTimeout(() => {
            document.body.removeChild(overlay);
        }, 300);
    });

    // Event listener untuk tombol pinjam
    const borrowButton = document.getElementById('preview-borrow-btn');
    borrowButton.addEventListener('click', () => {
        if (isAvailable) {
            // Tutup halaman preview
            overlay.style.opacity = '0';
            previewContent.style.transform = 'translateY(-20px)';
            
            setTimeout(() => {
                document.body.removeChild(overlay);
                // Buka form peminjaman
                showBorrowForm(book, thumbnail, title, authors, isbn);
            }, 300);
        }
    });

    // Menutup preview dengan klik di luar content
    overlay.addEventListener('click', (e) => {
        if (e.target === overlay) {
            overlay.style.opacity = '0';
            previewContent.style.transform = 'translateY(-20px)';
            
            setTimeout(() => {
                document.body.removeChild(overlay);
            }, 300);
        }
    });

    // Tambahkan CSS untuk responsivitas
    const style = document.createElement('style');
    style.textContent = `
        @media (max-width: 768px) {
            .preview-body {
                flex-direction: column;
            }
            .preview-left, .preview-right {
                flex: 0 0 100%;
                padding-right: 0;
            }
            .preview-left {
                margin-bottom: 20px;
                max-width: 250px;
                margin-left: auto;
                margin-right: auto;
            }
        }
    `;
    document.head.appendChild(style);
}

// Fungsi helper untuk mendapatkan tanggal hari ini dalam format yyyy-mm-dd
function getCurrentDate() {
    return new Date().toISOString().split('T')[0];
}

// Fungsi helper untuk mendapatkan tanggal 7 hari dari sekarang (default tanggal pengembalian)
function getDefaultReturnDate() {
    const date = new Date();
    date.setDate(date.getDate() + 7);
    return date.toISOString().split('T')[0];
}

// Panggil setupLoanButtons() setelah buku-buku ditampilkan
document.addEventListener('DOMContentLoaded', function() {
    // Tambahkan observer untuk mendeteksi ketika buku ditambahkan ke DOM
    const observer = new MutationObserver(function(mutations) {
        mutations.forEach(function(mutation) {
            if (mutation.addedNodes.length) {
                setupLoanButtons();
            }
        });
    });
    
    // Amati perubahan pada container buku
    const bookListContainer = document.getElementById('book-list');
    if (bookListContainer) {
        observer.observe(bookListContainer, { childList: true, subtree: true });
    }
    
    // Tambahkan SweetAlert jika belum tersedia
    if (typeof Swal === 'undefined') {
        const sweetAlertScript = document.createElement('script');
        sweetAlertScript.src = 'https://cdn.jsdelivr.net/npm/sweetalert2@11';
        document.head.appendChild(sweetAlertScript);
    }
    
    // Setup loan buttons untuk elemen yang sudah ada
    setupLoanButtons();
    
    // Tambahkan tombol "Riwayat Peminjaman" ke navbar untuk melihat demo peminjaman
    const navbarNav = document.querySelector('#navbarNav ul.navbar-nav');
    if (navbarNav) {
        const historyItem = document.createElement('li');
        historyItem.className = 'nav-item';
        historyItem.innerHTML = `<a class="nav-link" href="#" id="showLoanHistory">Riwayat Peminjaman</a>`;
        navbarNav.appendChild(historyItem);
        
        // Event listener untuk tombol riwayat peminjaman
        document.getElementById('showLoanHistory').addEventListener('click', function(e) {
            e.preventDefault();
            showLoanHistory();
        });
    }
});

// Fungsi untuk menampilkan riwayat peminjaman dari localStorage
function showLoanHistory() {
    // Ambil data peminjaman dari localStorage
    const loanHistory = JSON.parse(localStorage.getItem('loanHistory')) || [];
    
    // Buat HTML untuk tabel riwayat peminjaman
    let tableRows = '';
    
    if (loanHistory.length === 0) {
        tableRows = `<tr><td colspan="5" class="text-center">Belum ada riwayat peminjaman</td></tr>`;
    } else {
        loanHistory.forEach((loan, index) => {
            const borrowDate = new Date(loan.borrowDate).toLocaleDateString('id-ID');
            const returnDate = new Date(loan.returnDate).toLocaleDateString('id-ID');
            
            tableRows += `
            <tr>
                <td>${index + 1}</td>
                <td>${loan.bookTitle}</td>
                <td>${borrowDate}</td>
                <td>${returnDate}</td>
                <td>
                    <span class="badge bg-primary">${loan.status}</span>
                </td>
            </tr>`;
        });
    }
    
    // Buat modal untuk menampilkan riwayat peminjaman
    const historyModalHTML = `
    <div class="modal fade" id="historyModal" tabindex="-1" aria-labelledby="historyModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="historyModalLabel">Riwayat Peminjaman Buku</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Judul Buku</th>
                                    <th>Tanggal Pinjam</th>
                                    <th>Tanggal Kembali</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                ${tableRows}
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>`;
    
    // Tambahkan modal ke body
    document.body.insertAdjacentHTML('beforeend', historyModalHTML);
    
    // Inisialisasi dan tampilkan modal
    const historyModal = new bootstrap.Modal(document.getElementById('historyModal'));
    historyModal.show();
    
    // Event untuk membersihkan modal setelah ditutup
    document.getElementById('historyModal').addEventListener('hidden.bs.modal', function () {
        this.remove();
    });
}

// Tambahkan CSS untuk styling
document.head.insertAdjacentHTML('beforeend', `
<style>
    .bookmark-btn {
        background: rgba(255, 255, 255, 0.8);
        border: none;
        border-radius: 50%;
        width: 32px;
        height: 32px;
        line-height: 32px;
        text-align: center;
        padding: 0;
        cursor: pointer;
        transition: all 0.2s ease;
    }
    
    .bookmark-btn:hover {
        background: rgba(255, 255, 255, 1);
        transform: scale(1.1);
    }
    
    .bookmark-btn.active {
        color: #ffc107;
    }
    
    .badge-available {
        background-color: #28a745;
    }
    
    .badge-borrowed {
        background-color: #dc3545;
    }
    
    /* Ubah background modal agar transparan */
    .modal-backdrop {
        background-color: rgba(0, 0, 0, 0.5) !important;
    }

    /* Tambahkan efek blur pada latar belakang saat modal aktif */
    .modal-backdrop.show {
        backdrop-filter: blur(4px);
    }

    /* Sesuaikan tampilan modal */
    .modal-content {
        background-color: rgba(255, 255, 255, 0.95);
        border-radius: 10px;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
    }

    .modal-header, .modal-footer {
        background-color: rgba(13, 110, 253, 0.9);
        color: white;
        border: none;
    }
      /* Ubah background modal agar transparan */
    .modal-backdrop {
        background-color: transparent !important;
    }

    /* Tambahkan efek blur pada latar belakang saat modal aktif */
    .modal-backdrop.show {
        backdrop-filter: blur(4px);
    }

    /* Sesuaikan tampilan modal */
    .modal-content {
        background-color: rgba(255, 255, 255, 0.9);
        backdrop-filter: blur(10px);
    }

    .modal-header, .modal-footer {
        background-color: rgba(0, 123, 255, 0.8);
        color: white;
    }
    .modal-header {
        border-top-left-radius: 10px;
        border-top-right-radius: 10px;
    }
    
    .modal-footer {
        border-bottom-left-radius: 10px;
        border-bottom-right-radius: 10px;
    }
    
    .btn-close-white {
        filter: brightness(0) invert(1);
        
    }
</style>
`);

// Tambahkan kode JavaScript ini di file JS Anda
document.addEventListener('DOMContentLoaded', function() {
    window.addEventListener('scroll', function() {
      const navbar = document.querySelector('.navbar');
      if (window.scrollY > 50) {
        navbar.classList.add('scrolled');
      } else {
        navbar.classList.remove('scrolled');
      }
    });
    
    // Animasi untuk logo pada saat halaman dimuat
    const navbarBrand = document.querySelector('.navbar-brand');
    navbarBrand.style.opacity = '0';
    navbarBrand.style.transform = 'translateY(-20px)';
    
    setTimeout(function() {
      navbarBrand.style.transition = 'all 0.8s ease';
      navbarBrand.style.opacity = '1';
      navbarBrand.style.transform = 'translateY(0)';
    }, 300);
    
    // Animasi untuk menu item saat halaman dimuat
    const navItems = document.querySelectorAll('.nav-item');
    navItems.forEach(function(item, index) {
      item.style.opacity = '0';
      item.style.transform = 'translateY(-20px)';
      
      setTimeout(function() {
        item.style.transition = 'all 0.5s ease';
        item.style.opacity = '1';
        item.style.transform = 'translateY(0)';
      }, 400 + (index * 100));
    });
    
    // Animasi untuk tombol saat halaman dimuat
    const buttons = document.querySelectorAll('.btn');
    buttons.forEach(function(btn, index) {
      btn.style.opacity = '0';
      btn.style.transform = 'translateY(-20px)';
      
      setTimeout(function() {
        btn.style.transition = 'all 0.5s ease';
        btn.style.opacity = '1';
        btn.style.transform = 'translateY(0)';
      }, 800 + (index * 100));
    });
  });

  document.addEventListener('DOMContentLoaded', function() {
    // Add focus animation to search input
    const searchInput = document.getElementById('search-input');
    if (searchInput) {
        searchInput.addEventListener('focus', function() {
            this.parentElement.classList.add('animate__animated', 'animate__pulse');
        });
        
        searchInput.addEventListener('blur', function() {
            this.parentElement.classList.remove('animate__animated', 'animate__pulse');
        });
    }
    
    // Add typing animation for placeholder
    if (searchInput) {
        const placeholders = [
            "Cari judul buku favorit Anda...",
            "Temukan penulis terkenal...",
            "Jelajahi kategori bacaan baru...",
            "Cari buku motivasi dan inspirasi...",
            "Temukan novel romantis terbaik..."
        ];
        
        let currentPlaceholder = 0;
        
        setInterval(() => {
            searchInput.setAttribute('placeholder', '');
            let i = 0;
            const typing = setInterval(() => {
                searchInput.setAttribute('placeholder', searchInput.getAttribute('placeholder') + placeholders[currentPlaceholder].charAt(i));
                i++;
                if (i >= placeholders[currentPlaceholder].length) {
                    clearInterval(typing);
                    currentPlaceholder = (currentPlaceholder + 1) % placeholders.length;
                }
            }, 100);
        }, 5000);
    }
});
fetchBooks();
// DOM Elements
document.addEventListener('DOMContentLoaded', function() {
    // Inisialisasi komponen
    initializeComponents();
    
    // Event Listeners
    setupEventListeners();
    
    // Load Data
    loadBooks();
    
    // Animasi Intro
    animateIntro();
    
    // Rotating Text di Hero Section
    initRotatingText();
});

/**
 * Inisialisasi semua komponen Bootstrap dan custom
 */
function initializeComponents() {
    // Inisialisasi tooltips
    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    tooltipTriggerList.map(function(tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
    
    // Inisialisasi popovers
    const popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'));
    popoverTriggerList.map(function(popoverTriggerEl) {
        return new bootstrap.Popover(popoverTriggerEl);
    });
    
    // Inisialisasi dark mode toggle
    initDarkMode();
    
    // Inisialisasi Carousel
    initCarousel();
}

/**
 * Set up event listeners untuk interaksi pengguna
 */
function setupEventListeners() {
    // Search functionality
    const searchInput = document.querySelector('.search-input');
    if (searchInput) {
        searchInput.addEventListener('keyup', function(e) {
            if (e.key === 'Enter') {
                searchBooks(this.value);
            }
        });
        
        const searchButton = document.querySelector('.search-button');
        if (searchButton) {
            searchButton.addEventListener('click', function() {
                searchBooks(searchInput.value);
            });
        }
    }
    
    // Category filter
    const categoryCards = document.querySelectorAll('.category-card');
    categoryCards.forEach(card => {
        card.addEventListener('click', function() {
            // Tambahkan kelas active ke kartu yang dipilih
            categoryCards.forEach(c => c.classList.remove('active-category'));
            this.classList.add('active-category');
            
            // Ambil kategori dari teks heading
            const category = this.querySelector('h5').textContent;
            filterByCategory(category);
            
            // Scroll ke bagian katalog
            document.getElementById('katalog').scrollIntoView({ behavior: 'smooth' });
        });
    });
    
    // Borrow book button
    const borrowButtons = document.querySelectorAll('.btn-borrow');
    borrowButtons.forEach(button => {
        if (!button.disabled) {
            button.addEventListener('click', function() {
                const bookTitle = this.closest('.card').querySelector('.card-title').textContent;
                showBorrowModal(bookTitle);
            });
        }
    });
    
    // Navbar smooth scroll
    const navLinks = document.querySelectorAll('.navbar-nav .nav-link');
    navLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            if (this.getAttribute('href').startsWith('#')) {
                e.preventDefault();
                const targetId = this.getAttribute('href');
                const targetElement = document.querySelector(targetId);
                if (targetElement) {
                    const navbarHeight = document.querySelector('.navbar').offsetHeight;
                    const targetPosition = targetElement.offsetTop - navbarHeight;
                    window.scrollTo({
                        top: targetPosition,
                        behavior: 'smooth'
                    });
                    
                    // Update active link
                    navLinks.forEach(l => l.classList.remove('active'));
                    this.classList.add('active');
                }
            }
        });
    });
    
    // Login form validation
    const loginForm = document.getElementById('loginForm');
    if (loginForm) {
        loginForm.addEventListener('submit', function(e) {
            e.preventDefault();
            validateLoginForm();
        });
    }
    
    // Register form validation
    const registerForm = document.getElementById('registerForm');
    if (registerForm) {
        registerForm.addEventListener('submit', function(e) {
            e.preventDefault();
            validateRegisterForm();
        });
    }
    
    // Scroll to top button
    window.addEventListener('scroll', function() {
        toggleScrollToTopButton();
    });
    
    const scrollToTopBtn = document.getElementById('scrollToTop');
    if (scrollToTopBtn) {
        scrollToTopBtn.addEventListener('click', function() {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });
    }
}

/**
 * Animasi Intro untuk halaman
 */
function animateIntro() {
    // Animate hero section
    const heroContent = document.querySelector('.hero-content');
    if (heroContent) {
        heroContent.classList.add('animate__animated', 'animate__fadeIn');
    }
    
    // Animate book cards dengan stagger delay
    const bookCards = document.querySelectorAll('.card');
    bookCards.forEach((card, index) => {
        setTimeout(() => {
            card.classList.add('animate__animated', 'animate__fadeInUp');
        }, 100 * index);
    });
    
    // Animate category cards dengan stagger delay
    const categoryCards = document.querySelectorAll('.category-card');
    categoryCards.forEach((card, index) => {
        setTimeout(() => {
            card.classList.add('animate__animated', 'animate__fadeInUp');
        }, 100 * index);
    });
}

/**
 * Initializes a rotating text effect in the hero section
 */
function initRotatingText() {
    const rotatingTextElement = document.getElementById('rotating-text');
    if (rotatingTextElement) {
        const words = ['Petualangan', 'Inspirasi', 'Pengetahuan', 'Kebijaksanaan', 'Kreativitas'];
        let currentIndex = 0;
        
        setInterval(() => {
            rotatingTextElement.classList.add('animate__animated', 'animate__fadeOut');
            
            setTimeout(() => {
                currentIndex = (currentIndex + 1) % words.length;
                rotatingTextElement.textContent = words[currentIndex];
                rotatingTextElement.classList.remove('animate__fadeOut');
                rotatingTextElement.classList.add('animate__fadeIn');
            }, 500);
            
            setTimeout(() => {
                rotatingTextElement.classList.remove('animate__fadeIn');
            }, 1000);
        }, 3000);
    }
}

/**
 * Load books from API/Data
 */

/**
 * Menampilkan buku-buku dalam katalog
 */
function displayBooks(books) {
    const booksContainer = document.querySelector('#katalog .row');
    if (!booksContainer) return;
    
    // Kosongkan container
    booksContainer.innerHTML = '';
    
    // Tampilkan buku-buku
    books.forEach(book => {
        const bookElement = createBookElement(book);
        booksContainer.appendChild(bookElement);
    });
    
    // Re-inisialisasi animasi
    const bookCards = document.querySelectorAll('.card');
    bookCards.forEach((card, index) => {
        setTimeout(() => {
            card.classList.add('animate__animated', 'animate__fadeInUp');
        }, 100 * index);
    });
}

/**
 * Membuat elemen buku untuk ditampilkan di katalog
 */
function createBookElement(book) {
    const col = document.createElement('div');
    col.className = 'col-md-6 col-lg-4 col-xl-3';
    
    // Tentukan badge status
    const statusBadge = book.status === 'available' ? 
        '<span class="book-badge badge-available">Tersedia</span>' : 
        '<span class="book-badge badge-borrowed">Dipinjam</span>';
    
    // Tentukan apakah tombol bisa diklik
    const buttonState = book.status === 'available' ? 
        `<button class="btn btn-borrow w-100" data-id="${book.id}">Pinjam Buku</button>` : 
        `<button class="btn btn-borrow w-100" disabled>Pinjam Buku</button>`;
    
    col.innerHTML = `
        <div class="card" data-id="${book.id}">
            <div class="position-relative">
                <img src="${book.cover}" class="card-img-top" alt="${book.title} Cover">
                ${statusBadge}
            </div>
            <div class="card-body">
                <h5 class="card-title">${book.title}</h5>
                <p class="card-text text-muted">${book.author}</p>
                <div class="mb-3">
                    <span class="book-info"><i class="fas fa-bookmark me-1"></i> ${book.category}</span>
                    <span class="book-info"><i class="fas fa-star me-1"></i> ${book.rating}</span>
                </div>
                ${buttonState}
            </div>
        </div>
    `;
    
    // Tambahkan event listener untuk menampilkan detail buku
    const cardElement = col.querySelector('.card');
    cardElement.addEventListener('click', function(e) {
        // Pastikan klik bukan pada tombol pinjam
        if (!e.target.classList.contains('btn-borrow')) {
            showBookDetailModal(book);
        }
    });
    
    // Tambahkan event listener untuk tombol pinjam
    const borrowButton = col.querySelector('.btn-borrow');
    if (!borrowButton.disabled) {
        borrowButton.addEventListener('click', function() {
            showBorrowModal(book.title);
        });
    }
    
    return col;
}

/**
 * Menampilkan modal detail buku
 */
function showBookDetailModal(book) {
    const modalElement = document.getElementById('bookDetailModal');
    if (!modalElement) return;
    
    // Perbarui konten modal
    const modalTitle = modalElement.querySelector('.modal-title');
    modalTitle.textContent = book.title;
    
    const modalBody = modalElement.querySelector('.modal-body');
    modalBody.innerHTML = `
        <div class="row">
            <div class="col-md-4 mb-4 mb-md-0">
                <img src="${book.cover}" class="book-cover-lg img-fluid" alt="${book.title} Cover">
            </div>
            <div class="col-md-8">
                <h4 class="mb-3">${book.title}</h4>
                <p class="text-muted mb-4">${book.author}</p>
                
                <div class="mb-4">
                    <p class="mb-3">${book.description}</p>
                </div>
                
                <div class="row mb-4">
                    <div class="col-6">
                        <p class="book-detail-info"><span class="book-detail-title">Kategori:</span> ${book.category}</p>
                        <p class="book-detail-info"><span class="book-detail-title">Tahun Terbit:</span> ${book.publishedYear}</p>
                        <p class="book-detail-info"><span class="book-detail-title">Halaman:</span> ${book.pages}</p>
                    </div>
                    <div class="col-6">
                        <p class="book-detail-info"><span class="book-detail-title">Bahasa:</span> ${book.language}</p>
                        <p class="book-detail-info"><span class="book-detail-title">Rating:</span> ${book.rating} <i class="fas fa-star text-warning"></i></p>
                        <p class="book-detail-info"><span class="book-detail-title">ISBN:</span> ${book.isbn}</p>
                    </div>
                </div>
                
                <div class="d-flex justify-content-between">
                    <button class="btn btn-outline-secondary" 
                        data-bs-toggle="tooltip" 
                        data-bs-placement="top" 
                        title="Tambahkan ke Wishlist">
                        <i class="far fa-heart me-1"></i> Wishlist
                    </button>
                    
                    ${book.status === 'available' ? 
                        `<button class="btn btn-borrow" data-id="${book.id}">
                            <i class="fas fa-book-reader me-1"></i> Pinjam Buku
                        </button>` : 
                        `<button class="btn btn-borrow" disabled>
                            <i class="fas fa-book-reader me-1"></i> Buku Dipinjam
                        </button>`
                    }
                </div>
            </div>
        </div>
    `;
    
    // Tambahkan event listener untuk tombol pinjam
    const borrowButton = modalBody.querySelector('.btn-borrow');
    if (!borrowButton.disabled) {
        borrowButton.addEventListener('click', function() {
            // Tutup modal detail buku
            const bookDetailModal = bootstrap.Modal.getInstance(modalElement);
            bookDetailModal.hide();
            
            // Tampilkan modal peminjaman
            setTimeout(() => {
                showBorrowModal(book.title);
            }, 500);
        });
    }
    
    // Inisialisasi tooltip
    const tooltipTriggerList = [].slice.call(modalBody.querySelectorAll('[data-bs-toggle="tooltip"]'));
    tooltipTriggerList.map(function(tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
    
    // Tampilkan modal
    const bookDetailModal = new bootstrap.Modal(modalElement);
    bookDetailModal.show();
}

/**
 * Menampilkan modal peminjaman buku
 */
function showBorrowModal(bookTitle) {
    const modalElement = document.getElementById('borrowModal');
    if (!modalElement) return;
    
    // Perbarui konten modal
    const modalTitle = modalElement.querySelector('.modal-title');
    modalTitle.textContent = `Pinjam Buku: ${bookTitle}`;
    
    const modalBody = modalElement.querySelector('.modal-body');
    modalBody.innerHTML = `
        <div class="alert alert-info">
            <i class="fas fa-info-circle me-2"></i> Silakan masukkan informasi peminjaman Anda.
        </div>
        
        <form id="borrowForm">
            <div class="mb-3">
                <label for="borrowDate" class="form-label">Tanggal Peminjaman</label>
                <input type="date" class="form-control" id="borrowDate" required>
            </div>
            
            <div class="mb-3">
                <label for="returnDate" class="form-label">Tanggal Pengembalian</label>
                <input type="date" class="form-control" id="returnDate" required>
            </div>
            
            <div class="mb-3">
                <label for="borrowNotes" class="form-label">Catatan (opsional)</label>
                <textarea class="form-control" id="borrowNotes" rows="3"></textarea>
            </div>
            
            <div class="form-check mb-3">
                <input class="form-check-input" type="checkbox" id="borrowConfirm" required>
                <label class="form-check-label" for="borrowConfirm">
                    Saya setuju dengan <a href="#" data-bs-toggle="modal" data-bs-target="#termsModal">ketentuan peminjaman</a>
                </label>
            </div>
        </form>
    `;
    
    // Setup default dates
    const today = new Date();
    const borrowDateInput = modalBody.querySelector('#borrowDate');
    const returnDateInput = modalBody.querySelector('#returnDate');
    
    // Set default borrow date to today
    borrowDateInput.valueAsDate = today;
    borrowDateInput.min = today.toISOString().split('T')[0];
    
    // Set default return date to 7 days from today
    const returnDate = new Date();
    returnDate.setDate(today.getDate() + 7);
    returnDateInput.valueAsDate = returnDate;
    returnDateInput.min = today.toISOString().split('T')[0];
    
    // Validasi bahwa tanggal pengembalian harus setelah tanggal peminjaman
    borrowDateInput.addEventListener('change', function() {
        const newBorrowDate = new Date(this.value);
        const returnDate = new Date(returnDateInput.value);
        
        if (newBorrowDate > returnDate) {
            returnDateInput.valueAsDate = new Date(newBorrowDate);
            returnDateInput.valueAsDate.setDate(newBorrowDate.getDate() + 7);
        }
        
        // Update min date for return
        returnDateInput.min = this.value;
    });
    
    // Tambahkan event listener untuk tombol submit
    const confirmButton = modalElement.querySelector('.modal-footer .btn-primary');
    confirmButton.addEventListener('click', function() {
        const borrowForm = document.getElementById('borrowForm');
        if (borrowForm.checkValidity()) {
            processBorrowRequest(bookTitle);
        } else {
            // Trigger browser's built-in form validation
            borrowForm.reportValidity();
        }
    });
    
    // Tampilkan modal
    const borrowModal = new bootstrap.Modal(modalElement);
    borrowModal.show();
}

/**
 * Memproses permintaan peminjaman buku
 */
function processBorrowRequest(bookTitle) {
    // Tutup modal peminjaman
    const modalElement = document.getElementById('borrowModal');
    const borrowModal = bootstrap.Modal.getInstance(modalElement);
    borrowModal.hide();
    
    // Tampilkan Toast notifikasi
    const toast = document.getElementById('borrowSuccessToast');
    const toastBody = toast.querySelector('.toast-body');
    toastBody.textContent = `Peminjaman buku "${bookTitle}" berhasil diproses! Silakan ambil buku di perpustakaan.`;
    
    const bsToast = new bootstrap.Toast(toast);
    bsToast.show();
    
    // Animasi tombol borrow menjadi borrowed
    const books = JSON.parse(localStorage.getItem('books'));
    const bookIndex = books.findIndex(book => book.title === bookTitle);
    
    if (bookIndex !== -1) {
        books[bookIndex].status = 'borrowed';
        localStorage.setItem('books', JSON.stringify(books));
        
        // Refresh tampilan buku
        displayBooks(books);
        
        // Perbarui statistik
        updateBookStats(books);
    }
}

/**
 * Memperbarui statistik buku
 */
function updateBookStats(books) {
    const availableBooks = books.filter(book => book.status === 'available').length;
    const borrowedBooks = books.filter(book => book.status === 'borrowed').length;
    
    const availableBooksElement = document.getElementById('availableBooks');
    const borrowedBooksElement = document.getElementById('borrowedBooks');
    
    if (availableBooksElement) {
        availableBooksElement.textContent = availableBooks;
    }
    
    if (borrowedBooksElement) {
        borrowedBooksElement.textContent = borrowedBooks;
    }
}

/**
 * Mencari buku berdasarkan kata kunci
 */
function searchBooks(keyword) {
    if (!keyword) {
        // Jika kata kunci kosong, tampilkan semua buku
        const books = JSON.parse(localStorage.getItem('books'));
        displayBooks(books);
        return;
    }
    
    keyword = keyword.toLowerCase();
    const books = JSON.parse(localStorage.getItem('books'));
    
    // Filter buku-buku yang cocok dengan kata kunci
    const filteredBooks = books.filter(book => 
        book.title.toLowerCase().includes(keyword) ||
        book.author.toLowerCase().includes(keyword) ||
        book.category.toLowerCase().includes(keyword)
    );
    
    // Tampilkan hasil pencarian
    displayBooks(filteredBooks);
    
    // Perbarui judul bagian katalog
    const katalogTitle = document.querySelector('#katalog h2');
    if (katalogTitle) {
        katalogTitle.textContent = `Hasil Pencarian: "${keyword}"`;
    }
    
    // Scroll ke bagian katalog
    document.getElementById('katalog').scrollIntoView({ behavior: 'smooth' });
}

/**
 * Filter buku berdasarkan kategori
 */
function filterByCategory(category) {
    const books = JSON.parse(localStorage.getItem('books'));
    
    if (category === 'Semua') {
        displayBooks(books);
    } else {
        const filteredBooks = books.filter(book => book.category === category);
        displayBooks(filteredBooks);
    }
    
    // Perbarui judul bagian katalog
    const katalogTitle = document.querySelector('#katalog h2');
    if (katalogTitle) {
        katalogTitle.textContent = `Kategori: ${category}`;
    }
}

/**
 * Validasi form login
 */
function validateLoginForm() {
    const email = document.getElementById('loginEmail').value;
    const password = document.getElementById('loginPassword').value;
    
    // Validasi sederhana (dalam aplikasi nyata, ini akan dikirim ke server)
    if (email && password) {
        // Tampilkan Toast notifikasi
        const toast = document.getElementById('loginSuccessToast');
        const toastBody = toast.querySelector('.toast-body');
        toastBody.textContent = 'Login berhasil! Selamat datang kembali.';
        
        const bsToast = new bootstrap.Toast(toast);
        bsToast.show();
        
        // Tutup modal
        const loginModal = bootstrap.Modal.getInstance(document.getElementById('loginModal'));
        loginModal.hide();
        
        // Redirect ke halaman dashboard (dalam aplikasi nyata)
        // window.location.href = 'dashboard.html';
    } else {
        alert('Email dan Password harus diisi!');
    }
}

/**
 * Validasi form registrasi
 */
function validateRegisterForm() {
    const name = document.getElementById('registerName').value;
    const email = document.getElementById('registerEmail').value;
    const password = document.getElementById('registerPassword').value;
    const confirmPassword = document.getElementById('registerConfirmPassword').value;
    
    // Validasi sederhana (dalam aplikasi nyata, ini akan dikirim ke server)
    if (name && email && password && confirmPassword) {
        if (password !== confirmPassword) {
            alert('Password dan Konfirmasi Password tidak cocok!');
            return;
        }
        
        // Tampilkan Toast notifikasi
        const toast = document.getElementById('registerSuccessToast');
        const toastBody = toast.querySelector('.toast-body');
        toastBody.textContent = 'Registrasi berhasil! Silakan login dengan akun Anda.';
        
        const bsToast = new bootstrap.Toast(toast);
        bsToast.show();
        
        // Tutup modal
        const registerModal = bootstrap.Modal.getInstance(document.getElementById('registerModal'));
        registerModal.hide();
        
        // Buka modal login
        setTimeout(() => {
            const loginModal = new bootstrap.Modal(document.getElementById('loginModal'));
            loginModal.show();
        }, 1000);
    } else {
        alert('Semua field harus diisi!');
    }
}

/**
 * Inisialisasi fungsi dark mode
 */
function initDarkMode() {
    const darkModeToggle = document.getElementById('darkModeToggle');
    if (!darkModeToggle) return;
    
    // Cek preferensi user sebelumnya
    const savedDarkMode = localStorage.getItem('darkMode') === 'true';
    
    // Terapkan mode sesuai preferensi
    if (savedDarkMode) {
        document.body.classList.add('dark-mode');
        darkModeToggle.checked = true;
    }
    
    // Tambahkan event listener untuk toggle
    darkModeToggle.addEventListener('change', function() {
        if (this.checked) {
            document.body.classList.add('dark-mode');
            localStorage.setItem('darkMode', 'true');
        } else {
            document.body.classList.remove('dark-mode');
            localStorage.setItem('darkMode', 'false');
        }
    });
}

/**
 * Inisialisasi carousel
 */
function initCarousel() {
    const carousel = document.getElementById('featuredBooks');
    if (!carousel) return;
    
    // Inisialisasi carousel Bootstrap
    const bsCarousel = new bootstrap.Carousel(carousel, {
        interval: 5000,
        touch: true
    });
    
    // Tambahkan event listener untuk touch swipe
    let touchStartX = 0;
    let touchEndX = 0;
    
    carousel.addEventListener('touchstart', function(e) {
        touchStartX = e.touches[0].clientX;
    }, false);
    
    carousel.addEventListener('touchend', function(e) {
        touchEndX = e.changedTouches[0].clientX;
        handleSwipe();
    }, false);
    
    function handleSwipe() {
        if (touchEndX < touchStartX) {
            // Swipe left
            bsCarousel.next();
        }
        if (touchEndX > touchStartX) {
            // Swipe right
            bsCarousel.prev();
        }
    }
}

/**
 * Toggle tombol scroll to top
 */
function toggleScrollToTopButton() {
    const scrollToTopBtn = document.getElementById('scrollToTop');
    if (!scrollToTopBtn) return;}

    document.addEventListener('DOMContentLoaded', function() {
        // Counter Animation for Statistics
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const counters = document.querySelectorAll('.stats-number');
                    counters.forEach(counter => {
                        const targetValue = parseInt(counter.getAttribute('data-count'));
                        const duration = 2000; // Animation duration in milliseconds
                        let startValue = 0;
                        const increment = targetValue / (duration / 20);
                        
                        // Animate the counter
                        const updateCounter = () => {
                            startValue += increment;
                            counter.textContent = Math.floor(startValue);
                            
                            if (startValue < targetValue) {
                                setTimeout(updateCounter, 20);
                            } else {
                                counter.textContent = targetValue.toLocaleString();
                            }
                        };
                        
                        // Start animation
                        updateCounter();
                    });
                    observer.unobserve(entry.target);
                }
            });
        }, { threshold: 0.5 });
    
        // Observe the statistics section
        const statsSection = document.querySelector('#statistik');
        if (statsSection) {
            observer.observe(statsSection);
        }
        
        // Add animation class when scrolling into view
        const serviceCards = document.querySelectorAll('.service-card');
        const serviceObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('animate__animated', 'animate__fadeInUp');
                    serviceObserver.unobserve(entry.target);
                }
            });
        }, { threshold: 0.2 });
        
        serviceCards.forEach(card => {
            serviceObserver.observe(card);
        });
    });