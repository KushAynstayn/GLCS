<?php
// gl_code_settings.php
?>

<div class="max-w-7xl mx-auto mb-16">
    <h1 class="text-3xl font-extrabold text-[#a61e22] tracking-tight">GL Settings</h1>
    <p class="text-gray-500 mb-6 text-sm">Configure and manage General Ledger accounts, hierarchies, and structures.</p>

    <div class="flex items-center justify-between mb-8">
        <div class="flex gap-3">
            <button onclick="openModal('gl-addgl')" class="px-6 py-3 text-xs font-bold uppercase tracking-wider text-red-700 bg-red-50 border border-red-100 rounded-lg hover:bg-red-600 hover:text-white transition-all duration-300 hover:shadow-lg transform hover:-translate-y-1 flex items-center gap-3">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                <div class="flex flex-col items-start">
                    <span>Add</span>
                    <span class="text-[9px] opacity-75">New Entry</span>
                </div>
            </button>

            <button onclick="openModal('gl-importgl')" class="px-6 py-3 text-xs font-bold uppercase tracking-wider text-red-700 bg-red-50 border border-red-100 rounded-lg hover:bg-red-600 hover:text-white transition-all duration-300 hover:shadow-lg transform hover:-translate-y-1 flex items-center gap-3">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                <div class="flex flex-col items-start">
                    <span>Import</span>
                    <span class="text-[9px] opacity-75">CSV/Excel</span>
                </div>
            </button>

            <button class="px-6 py-3 text-xs font-bold uppercase tracking-wider text-red-700 bg-red-50 border border-red-100 rounded-lg hover:bg-red-600 hover:text-white transition-all duration-300 hover:shadow-lg transform hover:-translate-y-1 flex items-center gap-3">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                <div class="flex flex-col items-start">
                    <span>Download</span>
                    <span class="text-[9px] opacity-75">Export Data</span>
                </div>
            </button>

            <button class="px-6 py-3 text-xs font-bold uppercase tracking-wider text-red-700 bg-red-50 border border-red-100 rounded-lg hover:bg-red-600 hover:text-white transition-all duration-300 hover:shadow-lg transform hover:-translate-y-1 flex items-center gap-3">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                <div class="flex flex-col items-start">
                    <span>Reset All</span>
                    <span class="text-[9px] opacity-75">Clear Filters</span>
                </div>
            </button>
        </div>

        <div class="flex items-center gap-2">
            <label class="text-[10px] font-bold text-gray-400 uppercase tracking-widest whitespace-nowrap">Search</label>
            <input type="text" placeholder="Search by GL code or description..." class="px-4 py-2 text-xs border border-gray-200 rounded-lg text-gray-600 focus:outline-none focus:ring-1 focus:ring-[#D50000] w-64 transition-all">
        </div>
    </div>

    <?php include __DIR__ . '/../components/modals/user-access_modal.php'; ?>
    <?php include __DIR__ . '/../components/modals/success_modal.php'; ?>
    <?php include __DIR__ . '/../components/modals/gl-addgl_modal.php'; ?>
    <?php include __DIR__ . '/../components/modals/gl-importgl_modal.php'; ?>
    <?php include __DIR__ . '/../components/modals/fetch_modal.php'; ?>
    <?php include __DIR__ . '/../components/modals/preview_modal.php'; ?>
    <?php include __DIR__ . '/../components/modals/insert_modal.php'; ?>

    <div class="border border-gray-100 rounded-xl bg-white shadow-sm overflow-hidden">
        <table class="w-full text-left text-[10px] text-gray-600 border-collapse">
            <thead class="bg-[#D50000] border-b border-[#8e191d]">
                <tr class="text-white uppercase tracking-wider">
                    <th class="px-2 py-3 font-semibold">GL Account</th>
                    <th class="px-2 py-3 font-semibold">Account Title</th>
                    <th class="px-2 py-3 font-semibold">Level 4</th>
                    <th class="px-2 py-3 font-semibold">Level 3</th>
                    <th class="px-2 py-3 font-semibold">Level 2</th>
                    <th class="px-2 py-3 font-semibold">Level 1</th>
                    <th class="px-2 py-3 font-semibold">FS Account Type</th>
                    <th class="px-2 py-3 font-semibold">Normal Balance</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                <tr onclick="openModal('user-access')" class="cursor-pointer hover:bg-red-50/50 transition-colors">
                    <td class="px-2 py-3">1001</td>
                    <td class="px-2 py-3">Cash in Bank</td>
                    <td class="px-2 py-3">Cash</td>
                    <td class="px-2 py-3">Assets</td>
                    <td class="px-2 py-3">Current Assets</td>
                    <td class="px-2 py-3">Balance Sheet</td>
                    <td class="px-2 py-3">Asset</td>
                    <td class="px-2 py-3">Debit</td>
                </tr>
            </tbody>
        </table>

        <div class="flex items-center justify-center gap-4 py-3 border-t border-gray-100 bg-gray-50/50">
            <button class="px-3 py-1 text-[10px] font-semibold text-gray-600 bg-white border border-gray-200 rounded hover:border-red-200 hover:text-red-600 transition-colors shadow-sm uppercase tracking-wider">
                Prev
            </button>
            <span class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">
                1 / 1
            </span>
            <button class="px-3 py-1 text-[10px] font-semibold text-gray-600 bg-white border border-gray-200 rounded hover:border-red-200 hover:text-red-600 transition-colors shadow-sm uppercase tracking-wider">
                Next
            </button>
        </div>
    </div>
</div>

<script>
    function openModal(id) {
        var modal = document.getElementById('modal-' + id);
        if (modal) {
            modal.classList.remove('hidden');
        }
    }

    function closeModal(id) {
        var modal = document.getElementById('modal-' + id);
        if (modal) {
            modal.classList.add('hidden');
        }
    }

    async function uploadGLFiles() {
        if (glFiles.length === 0) {
            return alert("Please select files first.");
        }

        let formData = new FormData();

        glFiles.forEach(file => {
            formData.append('files[]', file);
        });

        showFetchModal(glFiles.length);

        const res = await fetch('index.php?api=gl-upload', {
            method: 'POST',
            body: formData
        });

        const data = await res.json();

        if (!data.ok) {
            alert(data.message);
            return;
        }

        // PREVIEW
        const previewRes = await fetch('index.php?api=gl-preview', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ file_keys: data.file_keys })
        });

        const previewData = await previewRes.json();

        closeFetchModal();
        openPreviewModal(previewData);

        // STORE KEYS
        window.glFileKeys = data.file_keys;
    }


    async function insertGLData() {
        console.log("INSERT CLICKED"); // 👈 ADD THIS
        const res = await fetch('index.php?api=gl-insert', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ file_keys: window.glFileKeys })
        });

        const data = await res.json();

        alert(`Inserted ${data.inserted} records`);
    }


    function openPreviewModal(data) {
        const container = document.getElementById('previewTables');
        container.innerHTML = '';

        data.data.forEach(file => {

            let table = document.createElement('table');
            table.className = "w-full text-xs border mb-4";

            let headers = Object.keys(file.preview[0] || {});

            let thead = `<tr class="bg-gray-100">`;
            headers.forEach(h => {
                thead += `<th class="px-2 py-1 border">${h}</th>`;
            });
            thead += `</tr>`;

            let rows = '';
            file.preview.forEach(row => {
                rows += `<tr>`;
                headers.forEach(h => {
                    rows += `<td class="px-2 py-1 border">${row[h] ?? ''}</td>`;
                });
                rows += `</tr>`;
            });

            table.innerHTML = `<thead>${thead}</thead><tbody>${rows}</tbody>`;
            container.appendChild(table);
        });

        document.getElementById('previewModal').classList.remove('hidden');
    }

    function closePreviewModal() {
        document.getElementById('previewModal').classList.add('hidden');
    }

    function openInsertModal() {
        closePreviewModal();
        document.getElementById('insertModal').classList.remove('hidden');

        // 🔥 ADD THIS
        startInsert();
    }


    async function startInsert() {

        let progressBar = document.getElementById("insertProgressBar");
        let progressText = document.getElementById("insertProgressText");

        progressBar.style.width = "20%";
        progressText.textContent = "Starting insert...";

        try {

            if (!window.glFileKeys || window.glFileKeys.length === 0) {
                throw new Error("No uploaded files found");
            }

            let res = await fetch('index.php?api=gl-insert', {
                method: "POST",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify({ file_keys: window.glFileKeys })
            });

            if (!res.ok) {
                throw new Error("Insert request failed");
            }

            let data = await res.json();

            if (!data.ok) {
                throw new Error(data.message || "Insert failed");
            }

            progressBar.style.width = "100%";
            progressText.textContent = "Completed";

        } catch (err) {

            console.error(err);

            progressText.textContent = "Error occurred";
            alert("Insert failed: " + err.message);
        }
    }


    function closeInsertModal() {
        document.getElementById('insertModal').classList.add('hidden');
    }

</script>

<style>
/* Modal Animation */
#modal-user-access:not(.hidden) > div,
#modal-gl-addgl:not(.hidden) > div,
#modal-gl-importgl:not(.hidden) > div {
    animation: pop 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275) forwards;
}

@keyframes pop {
    0% { opacity: 0; transform: scale(0.95); }
    100% { opacity: 1; transform: scale(1); }
}
</style>