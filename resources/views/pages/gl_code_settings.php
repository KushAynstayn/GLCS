<?php
// gl_code_settings.php
?>

<div class="w-full mx-auto mb-4">
    <h1 class="text-3xl font-extrabold text-[#a61e22] tracking-tight">GL Settings</h1>
    <p class="text-gray-500 mb-2 text-sm">Configure and manage General Ledger accounts, hierarchies, and structures.</p>

    <div class="flex items-center justify-between mb-4">
        <!-- Search Group (Moved to the Left) -->
        <div class="flex items-center gap-2">
            <label class="text-[10px] font-bold text-gray-400 uppercase tracking-widest whitespace-nowrap">Search</label>
            <input type="text" placeholder="Search by GL code or description..." class="px-4 py-1.5 text-xs border border-gray-200 rounded-lg text-gray-600 focus:outline-none focus:ring-1 focus:ring-[#D50000] w-64 transition-all">
        </div>

        <!-- Action Buttons (Moved to the Right and made thinner) -->
        <div class="flex gap-3">
            <button onclick="openModal('gl-addgl')" class="px-4 py-1.5 text-xs font-bold uppercase tracking-wider text-red-700 bg-red-50 border border-red-100 rounded-lg hover:bg-red-600 hover:text-white transition-all duration-300 hover:shadow-lg transform hover:-translate-y-1 flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                <span>Add</span>
            </button>

            <button onclick="openModal('gl-importgl')" class="px-4 py-1.5 text-xs font-bold uppercase tracking-wider text-red-700 bg-red-50 border border-red-100 rounded-lg hover:bg-red-600 hover:text-white transition-all duration-300 hover:shadow-lg transform hover:-translate-y-1 flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                <span>Import</span>
            </button>
        </div>
    </div>

    <?php include __DIR__ . '/../components/modals/gl-useraccess_modal.php'; ?>
    <?php include __DIR__ . '/../components/modals/gl-addgl_modal.php'; ?>
    <?php include __DIR__ . '/../components/modals/gl-importgl_modal.php'; ?>
    <?php include __DIR__ . '/../components/modals/success_modal.php'; ?>
    <?php include __DIR__ . '/../components/modals/fetch_modal.php'; ?>
    <?php include __DIR__ . '/../components/modals/preview_modal.php'; ?>
    <?php include __DIR__ . '/../components/modals/insert_modal.php'; ?>

    <div class="border border-gray-100 rounded-xl bg-white shadow-sm overflow-hidden flex flex-col">
        <div class="overflow-auto scrollbar-hide max-h-[440px]">
            <table class="w-full min-w-max text-center text-[11px] text-gray-700 border-collapse whitespace-nowrap">
                <thead class="bg-[#D50000] text-white sticky top-0 z-30 shadow-sm">
                    <tr class="uppercase tracking-wider">
                        <th class="px-6 py-1.5 font-bold border-b border-[#8e191d]">GL Account</th>
                        <th class="px-6 py-1.5 font-bold border-b border-[#8e191d]">Account Title</th>
                        <th class="px-6 py-1.5 font-bold border-b border-[#8e191d]">Level 4</th>
                        <th class="px-6 py-1.5 font-bold border-b border-[#8e191d]">Level 3</th>
                        <th class="px-6 py-1.5 font-bold border-b border-[#8e191d]">Level 2</th>
                        <th class="px-6 py-1.5 font-bold border-b border-[#8e191d]">Level 1</th>
                        <th class="px-6 py-1.5 font-bold border-b border-[#8e191d]">FS Account Type</th>
                        <th class="px-6 py-1.5 font-bold border-b border-[#8e191d]">Normal Balance</th>
                        <th class="px-6 py-1.5 font-bold border-b border-[#8e191d]">Status</th>
                    </tr>
                </thead>

                <tbody id="glTableBody" class="divide-y divide-gray-100 bg-white uppercase">
                    <tr>
                        <td colspan="9" class="p-12 text-center text-gray-400 italic font-medium">
                            No data yet.
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="flex h-[40px] items-center justify-center gap-4 py-2 border-t border-gray-100 bg-gray-50/50">
            <button id="btn-prev-gl" onclick="prevPage()"
                class="px-4 py-1 text-[11px] font-bold border border-gray-300 text-gray-600 rounded uppercase tracking-wider hover:bg-gray-200 disabled:opacity-50 disabled:cursor-not-allowed transition-colors">
                Prev
            </button>

            <span id="pageInfo" class="text-[11px] font-bold text-gray-500 uppercase tracking-widest">
                1 / 1
            </span>

            <button id="btn-next-gl" onclick="nextPage()"
                class="px-4 py-1 text-[11px] font-bold border border-gray-300 text-gray-600 rounded uppercase tracking-wider hover:bg-gray-200 disabled:opacity-50 disabled:cursor-not-allowed transition-colors">
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
            table.className = "w-full text-xs border mb-4 uppercase";

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

                // Root row styling with Fluid Transition
                row.className = `
                    group relative row-fluid-transition border-b border-gray-50 bg-white uppercase
                    ${isEnabled ? 'hover:bg-red-100/60' : 'opacity-40 grayscale'}
                `;

                row.innerHTML = `
                    <!-- The Piano Key Accent -->
                    <td class="px-6 py-1.5 font-bold relative group-hover:translate-x-1 transition-transform duration-300">
                        <!-- The Piano Key (Now properly contained) -->
                        <div class="absolute left-0 top-0 bottom-0 w-[4px] bg-[#D50000] scale-y-0 group-hover:scale-y-100 transition-transform duration-300 origin-center"></div>
                        ${gl.gl_account}
                    </td>
                    <td class="px-6 py-1.5">${gl.account_title}</td>
                    <td class="px-6 py-1.5">${gl.level_4}</td>
                    <td class="px-6 py-1.5">${gl.level_3}</td>
                    <td class="px-6 py-1.5">${gl.level_2}</td>
                    <td class="px-6 py-1.5">${gl.level_1}</td>
                    <td class="px-6 py-1.5">${gl.fs_account_type}</td>
                    <td class="px-6 py-1.5">${gl.normal_balance}</td>

                    <!-- STATUS TOGGLE -->
                    <td class="px-6 py-3 text-center">
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

                            <span class="text-[9px] font-bold uppercase status-label transition-colors duration-300
                                ${isEnabled ? 'text-[#D50000]' : 'text-gray-500'} group-hover:text-[#D50000]">
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

/* This hides the scrollbar across all browsers while keeping scroll functionality */
.scrollbar-hide::-webkit-scrollbar {
    display: none;
}
.scrollbar-hide {
    -ms-overflow-style: none;  /* IE and Edge */
    scrollbar-width: none;  /* Firefox */
}


/* Custom fluid transition */
.row-fluid-transition {
    transition: all 0.4s cubic-bezier(0.25, 0.8, 0.25, 1);
}

</style>