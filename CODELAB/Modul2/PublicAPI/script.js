document.addEventListener('DOMContentLoaded', () => {
    const dataContainer = document.getElementById('api-data');
    const loadingElement = document.getElementById('loading');
    const errorElement = document.getElementById('error');
    const errorMessage = document.getElementById('error-message');
    const emptyState = document.getElementById('empty-state');

    // Menggunakan JSONPlaceholder sebagai API
    const API_URL = 'https://jsonplaceholder.typicode.com/users';
    async function fetchData() {
        try {
            loadingElement.classList.remove('hidden');
            errorElement.classList.add('hidden');
            dataContainer.innerHTML = '';
            emptyState.classList.add('hidden');

            const response = await fetch(API_URL);

            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }

            const data = await response.json();

            loadingElement.classList.add('hidden');

            if (data && data.length > 0) {
                renderData(data);
            } else {
                emptyState.classList.remove('hidden');
            }
        } catch (error) {
            loadingElement.classList.add('hidden');
            errorElement.classList.remove('hidden');
            errorMessage.textContent = `Gagal mengambil data: ${error.message}`;
            console.error('Fetch error:', error);
        }
    }

    function renderData(users) {
        users.forEach(user => {
            const card = document.createElement('div');
            card.className = 'bg-white rounded-lg shadow-md p-6 border border-slate-200 transition hover:shadow-lg';
            
            card.innerHTML = `
                <h2 class="text-xl font-bold text-blue-600 mb-2">${user.name}</h2>
                <p class="text-slate-600 mb-1"><strong>Username:</strong> ${user.username}</p>
                <p class="text-slate-600 mb-1"><strong>Email:</strong> ${user.email}</p>
                <p class="text-slate-600 mb-1"><strong>Telepon:</strong> ${user.phone}</p>
                <p class="text-slate-600"><strong>Website:</strong> <a href="http://${user.website}" target="_blank" class="text-blue-500 hover:underline">${user.website}</a></p>
                <div class="mt-4 pt-4 border-t border-slate-100">
                    <p class="text-sm text-slate-500 italic">${user.company.name}</p>
                </div>
            `;
            
            dataContainer.appendChild(card);
        });
    }

    fetchData();
});
