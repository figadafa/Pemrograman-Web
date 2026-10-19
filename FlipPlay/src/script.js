window.changeCategory = (cat) => {
    const buttons = document.querySelectorAll('.category-btn');
    buttons.forEach(b => b.classList.replace('bg-indigo-600', 'bg-slate-800'));
    const activeBtn = document.getElementById(`btn-${cat}`);
    if (activeBtn) {
        activeBtn.classList.replace('bg-slate-800', 'bg-indigo-600');
    }

    const animeContent = document.getElementById('content-anime');
    const otherContent = document.getElementById('content-other');
    const catName = document.getElementById('category-name');

    if (cat === 'anime') {
        if (animeContent) animeContent.classList.remove('hidden');
        if (otherContent) otherContent.classList.add('hidden');
    } else {
        if (animeContent) animeContent.classList.add('hidden');
        if (otherContent) otherContent.classList.remove('hidden');
        if (catName) catName.textContent = cat.charAt(0).toUpperCase() + cat.slice(1);
    }
};

document.addEventListener('DOMContentLoaded', () => {
    // 1. Navbar Mobile Toggle
    const menuBtn = document.getElementById('menu-btn');
    const mobileMenu = document.getElementById('mobile-menu');
    if (menuBtn && mobileMenu) {
        menuBtn.addEventListener('click', () => {
            mobileMenu.classList.toggle('hidden');
        });
    }

    // 2. Contact Form Validation
    const contactForm = document.getElementById('contact-form');
    if (contactForm) {
        contactForm.addEventListener('submit', (e) => {
            e.preventDefault();
            const name = document.getElementById('nama').value.trim();
            const email = document.getElementById('email').value.trim();
            const pesan = document.getElementById('pesan').value.trim();

            if (!name || !email || !pesan) {
                alert('Semua field pada form kontak harus diisi!');
                return;
            }

            const emailRegex = /^[\w.\-]+@[\w.\-]+\.[a-zA-Z]{2,4}$/;
            if (!emailRegex.test(email)) {
                alert('Format email tidak valid.');
                return;
            }

            alert('Terima kasih! Pesan Anda berhasil dikirim (simulasi).');
            contactForm.reset();
        });
    }

    // 3. The Vibe Grid - Fetch API, Search, & Aura Discovery
    const API_URL = 'https://api.tenrai.org/v1/anime';
    const gridContainer = document.getElementById('anime-grid');
    const loadingState = document.getElementById('loading-state');
    const errorState = document.getElementById('error-state');
    const errorMessage = document.getElementById('error-message');
    const emptyState = document.getElementById('empty-state');
    const searchInput = document.getElementById('search-input');
    const retryBtn = document.getElementById('retry-btn');
    const auraButtons = document.querySelectorAll('.aura-btn');

    let allAnimeData = [];
    let currentAura = 'all';
    let currentSearchQuery = '';

    async function fetchAnimeData() {
        try {
            if (loadingState) loadingState.classList.remove('hidden');
            if (errorState) errorState.classList.add('hidden');
            if (emptyState) emptyState.classList.add('hidden');
            if (gridContainer) gridContainer.innerHTML = '';

            const response = await fetch(API_URL);
            if (!response.ok) {
                throw new Error(`HTTP error! Status: ${response.status}`);
            }

            const jsonResponse = await response.json();
            // Penanganan struktur respons fleksibel (Tenrai / Jikan / Array langsung)
            allAnimeData = Array.isArray(jsonResponse) ? jsonResponse : (jsonResponse.data || jsonResponse.result || []);

            if (loadingState) loadingState.classList.add('hidden');
            filterAndRender();
        } catch (error) {
            if (loadingState) loadingState.classList.add('hidden');
            if (errorState) errorState.classList.remove('hidden');
            if (errorMessage) {
                errorMessage.textContent = `Gagal memuat data Vibe Grid: ${error.message}. Periksa koneksi internet Anda.`;
            }
            console.error('Fetch error:', error);
        }
    }

    function filterAndRender() {
        if (!gridContainer) return;

        // Array Method: filter
        const filtered = allAnimeData.filter(anime => {
            // Pencarian Judul
            const title = (anime.title || anime.name || '').toLowerCase();
            const matchesSearch = title.includes(currentSearchQuery.toLowerCase());

            // Logika Filter Aura
            let matchesAura = true;
            const genres = anime.genres ? anime.genres.map(g => (typeof g === 'string' ? g : g.name).toLowerCase()) : [];
            const episodes = anime.episodes || anime.totalEpisodes || 0;

            if (currentAura === 'high-energy') {
                matchesAura = genres.includes('action') || genres.includes('adventure');
            } else if (currentAura === 'melancholy') {
                matchesAura = genres.includes('drama');
            } else if (currentAura === 'binge-mode') {
                matchesAura = episodes > 12;
            }

            return matchesSearch && matchesAura;
        });

        renderAnimeCards(filtered);
    }

    function renderAnimeCards(animeList) {
        if (!gridContainer) return;
        gridContainer.innerHTML = '';

        if (animeList.length === 0) {
            if (emptyState) emptyState.classList.remove('hidden');
            return;
        }

        if (emptyState) emptyState.classList.add('hidden');

        // Array Method: forEach & Template Literals
        animeList.forEach(anime => {
            const title = anime.title || anime.name || 'Tanpa Judul';
            const score = anime.score !== undefined && anime.score !== null ? anime.score : 'N/A';
            const imageUrl = anime.image || anime.cover || (anime.images && anime.images.jpg && anime.images.jpg.image_url) || 'https://via.placeholder.com/300x450?text=No+Image';
            const episodes = (anime.episodes || anime.totalEpisodes) ? `${anime.episodes || anime.totalEpisodes} Eps` : 'Ongoing/Unknown';
            const genresStr = anime.genres ? anime.genres.map(g => (typeof g === 'string' ? g : g.name)).slice(0, 2).join(', ') : 'General';

            const card = document.createElement('div');
            card.className = 'bg-slate-900 rounded-xl overflow-hidden border border-slate-800 hover:border-indigo-500/50 transition flex flex-col shadow-lg';

            card.innerHTML = `
                <div class="relative h-64 overflow-hidden bg-slate-800">
                    <img src="${imageUrl}" alt="${escapeHtml(title)}" class="w-full h-full object-cover hover:scale-105 transition duration-300" loading="lazy">
                    <div class="absolute top-3 right-3 bg-slate-950/80 backdrop-blur-md px-2.5 py-1 rounded-md text-xs font-bold text-amber-400 flex items-center gap-1 border border-slate-700/50">
                        <span>★</span> ${score}
                    </div>
                </div>
                <div class="p-5 flex flex-col flex-grow justify-between">
                    <div>
                        <div class="flex items-center justify-between text-xs text-indigo-400 font-semibold mb-2">
                            <span>${genresStr}</span>
                            <span>${episodes}</span>
                        </div>
                        <h3 class="font-bold text-slate-100 text-base line-clamp-1 mb-2" title="${escapeHtml(title)}">${escapeHtml(title)}</h3>
                    </div>
                    <button class="w-full mt-4 bg-indigo-600/20 hover:bg-indigo-600 text-indigo-300 hover:text-white py-2 rounded-lg text-xs font-bold transition border border-indigo-500/30">
                        Watch Vibe
                    </button>
                </div>
            `;

            gridContainer.appendChild(card);
        });
    }

    function escapeHtml(str) {
        return String(str)
            .replace(/&/g, "&amp;")
            .replace(/</g, "&lt;")
            .replace(/>/g, "&gt;")
            .replace(/"/g, "&quot;")
            .replace(/'/g, "&#039;");
    }

    // Event Handling 1: Search input (real-time filtering)
    if (searchInput) {
        searchInput.addEventListener('input', (e) => {
            currentSearchQuery = e.target.value.trim();
            filterAndRender();
        });
    }

    // Event Handling 2: Tombol Aura
    auraButtons.forEach(btn => {
        btn.addEventListener('click', (e) => {
            auraButtons.forEach(b => {
                b.classList.remove('bg-indigo-600', 'text-white', 'shadow');
                b.classList.add('bg-slate-800', 'text-slate-300', 'hover:bg-slate-700');
            });
            const target = e.currentTarget;
            target.classList.remove('bg-slate-800', 'text-slate-300', 'hover:bg-slate-700');
            target.classList.add('bg-indigo-600', 'text-white', 'shadow');

            currentAura = target.getAttribute('data-aura');
            filterAndRender();
        });
    });

    // Event Retry
    if (retryBtn) {
        retryBtn.addEventListener('click', () => {
            fetchAnimeData();
        });
    }

    // Fetch awal data
    fetchAnimeData();
});
