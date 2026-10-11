document.addEventListener('DOMContentLoaded', () => {
    const navbarToggle = document.getElementById('navbar-toggle');
    const navbarMenu = document.getElementById('navbar-menu');

    if (navbarToggle && navbarMenu) {
        navbarToggle.addEventListener('click', () => {
            navbarMenu.classList.toggle('hidden');
        });
    }

    // Validasi Formulir Kontak
    const contactForm = document.querySelector('#kontak form');
    if (contactForm) {
        contactForm.addEventListener('submit', (event) => {
            const nameInput = document.getElementById('nama');
            const emailInput = document.getElementById('email');
            const messageInput = document.getElementById('pesan');

            if (!nameInput.value.trim()) {
                alert('Nama tidak boleh kosong.');
                event.preventDefault();
                return;
            }

            if (!emailInput.value.trim()) {
                alert('Email tidak boleh kosong.');
                event.preventDefault();
                return;
            }

            // Validasi format email dasar
            const emailPattern = /^[\w.\-]+@[\w.\-]+\.[a-zA-Z]{2,4}$/;
            if (!emailPattern.test(emailInput.value.trim())) {
                alert('Format email tidak valid.');
                event.preventDefault();
                return;
            }

            if (!messageInput.value.trim()) {
                alert('Pesan tidak boleh kosong.');
                event.preventDefault();
                return;
            }

            alert('Formulir berhasil dikirim (simulasi)!');
        });
    }
});
