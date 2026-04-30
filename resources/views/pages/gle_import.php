
<?php include __DIR__ . '/../components/modals/fetch_modal.php'; ?>
<?php include __DIR__ . '/../components/modals/preview_modal.php'; ?>
<?php include __DIR__ . '/../components/modals/insert_modal.php'; ?>


<div class="w-full mx-auto mb-16">
    <h1 class="text-3xl font-extrabold text-[#a61e22] tracking-tight">
        General Ledger Extraction Import
    </h1>
    <p class="text-gray-500 mb-6">
        Upload, preview, and import multiple Excel files efficiently.
    </p>

    <!-- FILE INPUT -->
    <input type="file" id="fileInput" class="hidden" multiple accept=".xls,.xlsx">

    <!-- DROPZONE -->
    <div id="dropZone"
        class="border-2 border-dashed border-[#DDEAF2] rounded-xl bg-[#F8FAFC]/50 py-12 flex flex-col items-center justify-center text-center px-6 cursor-pointer hover:border-[#EF4444] hover:bg-white transition"
        onclick="document.getElementById('fileInput').click()">

        <p class="text-xl font-bold text-[#0D2149]">Drag & Drop Files Here</p>
        <p class="text-sm text-gray-400">or click to browse multiple Excel files</p>
    </div>

    <!-- FILE LIST -->
    <div id="fileListContainer" class="mt-6 hidden">
        <div class="flex justify-between mb-3">
            <h2 id="fileCount" class="font-bold text-lg text-[#0D2149]">Files: 0</h2>

            <button onclick="uploadFiles()"
                class="bg-[#D50000] text-white px-4 py-2 rounded-lg text-sm">
                Upload & Preview
            </button>
        </div>

        <div id="fileListRows" class="space-y-2"></div>
    </div>

    <!-- PREVIEW AREA -->
    <div id="previewContainer" class="mt-8"></div>
</div>



<script>
let allFiles = [];
let uploadedFileKeys = [];
let uploadedFilesData = [];

const fileInput = document.getElementById('fileInput');
const fileListContainer = document.getElementById('fileListContainer');
const fileListRows = document.getElementById('fileListRows');
const fileCount = document.getElementById('fileCount');

// =========================
// FILE HANDLING
// =========================
fileInput.addEventListener('change', e => handleFiles(e.target.files));

document.getElementById('dropZone').addEventListener('dragover', e => e.preventDefault());
document.getElementById('dropZone').addEventListener('drop', e => {
    e.preventDefault();
    handleFiles(e.dataTransfer.files);
});

function handleFiles(files) {
    for (let f of files) {
        allFiles.push(f);
    }
    renderFileList();
}

function renderFileList() {
    if (allFiles.length === 0) {
        fileListContainer.classList.add('hidden');
        return;
    }

    fileListContainer.classList.remove('hidden');
    fileListRows.innerHTML = '';
    fileCount.textContent = `Files: ${allFiles.length}`;

    allFiles.forEach((file, i) => {
        let row = document.createElement('div');
        row.className = "bg-white p-3 rounded border flex justify-between";

        row.innerHTML = `
            <div>
                <p class="font-medium">${file.name}</p>
                <p class="text-xs text-gray-400">${(file.size / 1024).toFixed(2)} KB</p>
            </div>
            <button onclick="removeFile(${i})" class="text-red-500">Remove</button>
        `;

        fileListRows.appendChild(row);
    });
}

function removeFile(i) {
    allFiles.splice(i, 1);
    renderFileList();
}

// =========================
// UPLOAD + PROGRESS
// =========================
async function uploadFiles() {

    if (allFiles.length === 0) return;

    showFetchModal(allFiles.length);

    try {

        let formData = new FormData();

        // ✅ send ALL files in ONE request
        allFiles.forEach(file => {
            formData.append("files[]", file);
        });

        let res = await fetch("/GLCS/public/index.php?api=1&action=upload", {
            method: "POST",
            body: formData
        });

        if (!res.ok) {
            throw new Error("Upload failed");
        }

        let data = await res.json();

        if (!data.ok) {
            throw new Error(data.message || "Upload error");
        }

        uploadedFileKeys = data.file_keys || [];

        // ✅ update progress UI
        document.getElementById("fileProgressText").textContent =
            `File count: ${allFiles.length}/${allFiles.length}`;

        document.getElementById("progressPercent").textContent = "100%";
        document.getElementById("progressBar").style.width = "100%";

        closeFetchModal();

        // 👉 go to preview
        await fetchPreview();

    } catch (err) {
        console.error(err);
        closeFetchModal();
        alert("Upload failed: " + err.message);
    }
}


// =========================
// PREVIEW ALL FILES
// =========================
function renderPreview() {

    let container = document.getElementById("previewContainer");
    container.innerHTML = "";

    uploadedFileKeys.forEach((key, index) => {

        let card = document.createElement("div");
        card.className = "border rounded p-4 mb-4 bg-white";

        card.innerHTML = `
            <h3 class="font-bold text-[#a61e22] mb-2">
                File ${index + 1}: ${key}
            </h3>

            <p class="text-sm text-gray-500">
                Preview loaded from backend (first rows stored in JSON)
            </p>
        `;

        container.appendChild(card);
    });
}

// =========================
// RESET
// =========================
function resetAll() {
    allFiles = [];
    uploadedFileKeys = [];
    uploadedFilesData = [];

    fileListContainer.classList.add('hidden');
    document.getElementById("previewContainer").innerHTML = "";
}


async function fetchPreview() {

    let res = await fetch("/GLCS/public/index.php?api=1&action=preview", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ file_keys: uploadedFileKeys })
    });

    let data = await res.json();

    console.log("PREVIEW:", data);

    uploadedFilesData = data.data || [];

    renderPreviewModal();
}


function renderPreviewModal() {

    let container = document.getElementById("previewTables");
    container.innerHTML = "";

    uploadedFilesData.forEach((file, index) => {

        let tableHTML = `
            <div class="border rounded p-4">
                <h3 class="font-bold text-[#a61e22] mb-2">
                    File ${index + 1}: ${file.file_key}
                </h3>

                <div class="overflow-auto">
                    <table class="min-w-full text-sm border">
                        <thead class="bg-gray-100">
                            <tr>
                                ${Object.keys(file.preview[0] || {}).map(h => `<th class="p-2 border">${h}</th>`).join('')}
                            </tr>
                        </thead>
                        <tbody>
                            ${file.preview.map(row => `
                                <tr>
                                    ${Object.values(row).map(v => `<td class="p-2 border">${v ?? ''}</td>`).join('')}
                                </tr>
                            `).join('')}
                        </tbody>
                    </table>
                </div>
            </div>
        `;

        container.innerHTML += tableHTML;
    });

    showPreviewModal();
}


function showPreviewModal() {
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

        let res = await fetch("/GLCS/public/index.php?api=1&action=insert", {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify({ file_keys: uploadedFileKeys })
        });

        let data = await res.json();

        console.log("INSERT:", data);

        if (!data.ok) {
            throw new Error(data.message || "Insert failed");
        }

        progressBar.style.width = "100%";
        progressText.textContent = "Completed";

        resetAll();

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

