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
        </div>

        <div class="flex items-center gap-2">
            <label class="text-[10px] font-bold text-gray-400 uppercase tracking-widest whitespace-nowrap">Search</label>
            <input type="text" placeholder="Search by GL code or description..." class="px-4 py-2 text-xs border border-gray-200 rounded-lg text-gray-600 focus:outline-none focus:ring-1 focus:ring-[#D50000] w-64 transition-all">
        </div>
    </div>

    <?php include __DIR__ . '/../components/modals/gl-useraccess_modal.php'; ?>
    <?php include __DIR__ . '/../components/modals/gl-addgl_modal.php'; ?>
    <?php include __DIR__ . '/../components/modals/gl-importgl_modal.php'; ?>
    <?php include __DIR__ . '/../components/modals/success_modal.php'; ?>
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
                    <th class="px-2 py-3 font-semibold text-center">Status</th>
                </tr>
            </thead>
            <tbody id="glTableBody" class="divide-y divide-gray-50">
            </tbody>
        </table>

        <div class="flex items-center justify-center gap-4 py-3 border-t border-gray-100 bg-gray-50/50">
            <button onclick="prevPage()" class="px-3 py-1 text-[10px] font-semibold text-gray-600 bg-white border border-gray-200 rounded">
                Prev
            </button>

            <span id="pageInfo" class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">
                1 / 1
            </span>

            <button onclick="nextPage()" class="px-3 py-1 text-[10px] font-semibold text-gray-600 bg-white border border-gray-200 rounded">
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

    // Function to toggle the label text
    function toggleLabel(checkbox) {
        const label = checkbox.parentElement.querySelector('.status-label');
        if (checkbox.checked) {
            label.textContent = 'Enabled';
            label.classList.replace('text-gray-500', 'text-[#D50000]');
        } else {
            label.textContent = 'Disabled';
            label.classList.replace('text-[#D50000]', 'text-gray-500');
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

            // ✅ reset UI after short delay
            setTimeout(() => {
                closeInsertModal();
                resetGLImportUI();
            }, 700);

        } catch (err) {

            console.error(err);

            progressText.textContent = "Error occurred";
            alert("Insert failed: " + err.message);
        }
    }


    function closeInsertModal() {
        document.getElementById('insertModal').classList.add('hidden');
    }


    function resetGLImportUI() {

        // clear files
        window.glFiles = [];

        // clear file list UI (adjust ID if different)
        const list = document.getElementById("glFileList");
        if (list) list.innerHTML = "";

        // hide container if you have one
        const container = document.getElementById("glFileListContainer");
        if (container) container.classList.add("hidden");

        // clear stored keys
        window.glFileKeys = [];
    }


    let currentPage = 1;
    let totalPages = 1;

    // =========================================
    // LOAD GL CODES (PAGINATED)
    // =========================================
    async function loadGLCodes(page = 1) {

        try {
            const res = await fetch(`index.php?api=gl-codes&page=${page}`);

            const data = await res.json();

            const tbody = document.getElementById('glTableBody');
            tbody.innerHTML = '';

            // =========================
            // NO DATA FOUND
            // =========================
            if (!data.ok || !data.data || data.data.length === 0) {

                tbody.innerHTML = `
                    <tr>
                        <td colspan="9" class="text-center py-6 text-gray-400 text-xs uppercase tracking-wider">
                            No Data Found
                        </td>
                    </tr>
                `;

                document.getElementById('pageInfo').innerText = `0 / 0`;
                return;
            }

            // =========================
            // UPDATE PAGINATION STATE
            // =========================
            currentPage = Number(data.page);
            totalPages = Number(data.total_pages);

            // =========================
            // RENDER ROWS
            // =========================
            data.data.forEach(gl => {

                const isEnabled = gl.status == 1;

                const row = document.createElement('tr');

                // disabled styling
                row.className = `
                    cursor-pointer transition-all
                    ${isEnabled ? 'hover:bg-red-50/50' : 'opacity-40 grayscale'}
                `;

                row.innerHTML = `
                    <td class="px-2 py-3">${gl.gl_account}</td>
                    <td class="px-2 py-3">${gl.account_title}</td>
                    <td class="px-2 py-3">${gl.level_4}</td>
                    <td class="px-2 py-3">${gl.level_3}</td>
                    <td class="px-2 py-3">${gl.level_2}</td>
                    <td class="px-2 py-3">${gl.level_1}</td>
                    <td class="px-2 py-3">${gl.fs_account_type}</td>
                    <td class="px-2 py-3">${gl.normal_balance}</td>

                    <!-- STATUS TOGGLE -->
                    <td class="px-2 py-3 text-center">
                        <label class="relative inline-flex items-center justify-center cursor-pointer gap-2"
                            onclick="event.stopPropagation()">

                            <input type="checkbox"
                                ${isEnabled ? 'checked' : ''}
                                class="sr-only peer"
                                onchange="toggleStatus(this, '${gl.gl_account}')">

                            <div class="w-9 h-5 bg-gray-200 rounded-full peer-focus:outline-none
                                peer peer-checked:after:translate-x-full
                                after:content-[''] after:absolute after:top-[2px] after:left-[2px]
                                after:bg-white after:border after:rounded-full after:h-4 after:w-4
                                after:transition-all peer-checked:bg-[#D50000]">
                            </div>

                            <span class="text-[9px] font-bold uppercase status-label
                                ${isEnabled ? 'text-[#D50000]' : 'text-gray-500'}">
                                ${isEnabled ? 'Enabled' : 'Disabled'}
                            </span>

                        </label>
                    </td>
                `;

                tbody.appendChild(row);
            });

            // =========================
            // UPDATE PAGINATION UI
            // =========================
            document.getElementById('pageInfo').innerText =
                `${currentPage} / ${totalPages}`;

        } catch (err) {
            console.error("LOAD GL ERROR:", err);
        }
    }


    // =========================================
    // PAGINATION CONTROLS
    // =========================================
    function nextPage() {
        if (currentPage < totalPages) {
            loadGLCodes(currentPage + 1);
        }
    }

    function prevPage() {
        if (currentPage > 1) {
            loadGLCodes(currentPage - 1);
        }
    }


    // =========================================
    // INIT LOAD
    // =========================================
    document.addEventListener('DOMContentLoaded', () => {
        loadGLCodes(1);
    });


    // =========================================
    // TOGGLE STATUS
    // =========================================
    async function toggleStatus(checkbox, glAccount) {

        const enabled = checkbox.checked ? 1 : 0;

        try {
            const res = await fetch('index.php?api=gl-toggle-status', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({
                    gl_account: glAccount,
                    status: enabled
                })
            });

            const data = await res.json();

            if (!data.ok) throw new Error(data.message);

            toggleLabel(checkbox);

            // reload to apply style
            loadGLCodes();

        } catch (err) {
            alert("Failed: " + err.message);
            checkbox.checked = !checkbox.checked;
        }
    }


    // AUTO LOAD
    document.addEventListener('DOMContentLoaded', loadGLCodes);

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