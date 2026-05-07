const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 2500,
        timerProgressBar: true
    });


    function openModal(id) {
        var modal = document.getElementById('modal-' + id);
        if (modal) {
            modal.classList.remove('hidden');
        }

        if (id === 'gl-addgl') {
            loadDropdowns();
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
            return Swal.fire({
                icon: 'warning',
                title: 'No Files Selected',
                text: 'Please select files first.',
                confirmButtonColor: '#D50000'
            });
        }

        let formData = new FormData();

        glFiles.forEach(file => {
            formData.append('files[]', file);
        });

        showFetchModal(glFiles.length);

        Swal.fire({
            title: 'Uploading Files...',
            text: 'Please wait while the system processes your files.',
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });

        const res = await fetch('index.php?api=gl-upload', {
            method: 'POST',
            body: formData
        });

        const data = await res.json();

        Swal.close();

        if (!data.ok) {
            Swal.fire({
                icon: 'error',
                title: 'Upload Failed',
                text: data.message,
                confirmButtonColor: '#D50000'
            });

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

        Swal.fire({
            icon: 'success',
            title: 'Insert Successful',
            text: `${data.inserted} records inserted successfully.`,
            confirmButtonColor: '#D50000'
        });
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
            Swal.fire({
                icon: 'error',
                title: 'Insert Failed',
                text: err.message,
                confirmButtonColor: '#D50000'
            });
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

            Toast.fire({
                icon: 'success',
                title: enabled ? 'GL Enabled' : 'GL Disabled'
            });

            // reload to apply style
            loadGLCodes();

        } catch (err) {
            Swal.fire({
                icon: 'error',
                title: 'Status Update Failed',
                text: err.message,
                confirmButtonColor: '#D50000'
            });
            checkbox.checked = !checkbox.checked;
        }
    }


    // AUTO LOAD
    document.addEventListener('DOMContentLoaded', loadGLCodes);



    async function loadDropdowns() {
        const res = await fetch('index.php?api=gl-dropdowns');
        const data = await res.json();

        if (!data.ok) return;

        const fields = data.data;

        Object.keys(fields).forEach(field => {
            const select = document.querySelector(`[name="${field}"]`);
            if (!select) return;

            fields[field].forEach(val => {
                const opt = document.createElement('option');
                opt.value = val;
                opt.textContent = val;
                select.appendChild(opt);
            });
        });
    }



    document.getElementById('addGlForm').addEventListener('submit', async function(e) {
        e.preventDefault();

        const formData = new FormData(this);

        const payload = Object.fromEntries(formData.entries());

        Swal.fire({
            title: 'Saving GL Code...',
            text: 'Please wait.',
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });

        const res = await fetch('index.php?api=gl-store', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(payload)
        });

        const data = await res.json();

        Swal.close();

        if (!data.ok) {

            Swal.fire({
                icon: 'error',
                title: 'Failed',
                text: data.message || 'Something went wrong.',
                confirmButtonColor: '#D50000'
            });

            return;
        }

        Swal.fire({
            icon: 'success',
            title: 'Success',
            text: 'GL Code Added Successfully',
            confirmButtonColor: '#D50000',
            timer: 1800,
            showConfirmButton: false
        });

        closeModal('gl-addgl');
        this.reset();

        loadGLCodes(); // 🔥 refresh table
    });