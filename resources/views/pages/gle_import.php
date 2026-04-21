<?php
// gle_import.php
// This is a component page, designed to be included within views/layouts/main.php.
// It contains only the specific content and tailwind-styled elements for the 'gle_import' page.
?>

<div class="max-w-7xl mx-auto mb-16">
    <h1 class="text-3xl font-extrabold text-[#a61e22] tracking-tight">General Ledger Extraction Import</h1>
    <p class="text-gray-500 mb-6">Streamline your financial workflow by uploading your extraction files below.</p>

    <input type="file" id="fileInput" class="hidden" multiple accept=".xls, .xlsx">

    <div id="dropZone" class="group border-2 border-dashed border-[#DDEAF2] rounded-xl bg-[#F8FAFC]/50 py-12 md:py-14 flex flex-col items-center justify-center text-center px-6 cursor-pointer transition-all duration-300 hover:border-[#EF4444] hover:bg-white hover:shadow-inner" 
         onclick="document.getElementById('fileInput').click()">
        
        <svg xmlns="http://www.w3.org/2000/svg" 
             class="w-12 h-5 text-gray-400 group-hover:text-[#EF4444] transition-colors duration-300 mb-4" 
             fill="none" 
             viewBox="0 0 24 24" 
             stroke="currentColor" 
             stroke-width="1.5">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
        </svg>

        <p class="text-xl font-bold text-[#0D2149] mb-1">
            Drag & Drop Files Here
        </p>

        <p class="text-base text-gray-500 mb-1">
            or <span class="text-[#0D2149] font-semibold underline">click to browse</span>
        </p>

        <p class="text-sm text-gray-400 font-medium">
            Supports multiple Excel files (.xls, .xlsx)
        </p>
    </div>

    <div id="fileListContainer" class="mt-6 hidden">
        <div class="flex items-center justify-between mb-4">
            <h2 id="fileCount" class="font-bold text-lg text-[#0D2149]">Files: 0</h2>
            <div class="flex gap-2">
                <button onclick="showFetchModal(allFiles.length)" class="bg-[#a61e22] text-white px-4 py-2 rounded-lg text-sm font-semibold hover:bg-[#8e191d] transition-colors flex items-center gap-2">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M5 20h14v-2H5v2zM19 9h-4V3H9v6H5l7 7 7-7z"/></svg>
                    Fetch
                </button>
                <button onclick="removeAllFiles()" class="bg-white border border-[#a61e22] text-[#a61e22] px-4 py-2 rounded-lg text-sm font-semibold hover:bg-red-50 transition-colors flex items-center gap-2">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M6 19c0 1.1.9 2 2 2h8c1.1 0 2-.9 2-2V7H6v12zM19 4h-3.5l-1-1h-5l-1 1H5v2h14V4z"/></svg>
                    Remove All
                </button>
            </div>
        </div>
        <div id="fileListRows" class="space-y-2">
        </div>
    </div>
</div>

<?php include __DIR__ . '/../components/modals/fetch_modal.php'; ?>

<script>
    const fileInput = document.getElementById('fileInput');
    const dropZone = document.getElementById('dropZone');
    const fileListContainer = document.getElementById('fileListContainer');
    const fileListRows = document.getElementById('fileListRows');
    const fileCount = document.getElementById('fileCount');
    let allFiles = [];

    // Handle File Selection
    fileInput.addEventListener('change', (e) => handleFiles(e.target.files));

    // Drag and Drop Events
    dropZone.addEventListener('dragover', (e) => { e.preventDefault(); dropZone.classList.add('border-[#EF4444]'); });
    dropZone.addEventListener('dragleave', () => dropZone.classList.remove('border-[#EF4444]'));
    dropZone.addEventListener('drop', (e) => {
        e.preventDefault();
        dropZone.classList.remove('border-[#EF4444]');
        handleFiles(e.dataTransfer.files);
    });

    function handleFiles(files) {
        for (let file of files) {
            allFiles.push(file);
        }
        renderFileList();
    }

    function removeFile(index) {
        allFiles.splice(index, 1);
        renderFileList();
    }

    function removeAllFiles() {
        allFiles = [];
        renderFileList();
    }

    function formatBytes(bytes) {
        if (bytes === 0) return '0 Bytes';
        const k = 1024;
        const sizes = ['Bytes', 'KB', 'MB', 'GB'];
        const i = Math.floor(Math.log(bytes) / Math.log(k));
        return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
    }

    function renderFileList() {
        if (allFiles.length === 0) {
            fileListContainer.classList.add('hidden');
            return;
        }

        fileListContainer.classList.remove('hidden');
        fileListRows.innerHTML = '';
        fileCount.textContent = `Files: ${allFiles.length}`;

        allFiles.forEach((file, index) => {
            const row = document.createElement('div');
            // Reduced padding from p-4 to p-3 for a thinner, more professional look
            row.className = "bg-white p-2 rounded-lg shadow-sm border border-gray-100 flex items-center justify-between";
            row.innerHTML = `
                <div class="flex items-center gap-3">
                    <svg class="w-5 h-5 text-gray-400" fill="currentColor" viewBox="0 0 24 24"><path d="M14 2H6c-1.1 0-1.99.9-1.99 2L4 20c0 1.1.89 2 1.99 2H18c1.1 0 2-.9 2-2V8l-6-6z"/></svg>
                    <div>
                        <p class="font-medium text-gray-800 text-sm">${file.name}</p>
                        <p class="text-xs text-gray-400">${formatBytes(file.size)}</p>
                    </div>
                </div>
                <button onclick="removeFile(${index})" class="text-gray-400 hover:text-[#EF4444] transition-colors">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M6 19c0 1.1.9 2 2 2h8c1.1 0 2-.9 2-2V7H6v12zM19 4h-3.5l-1-1h-5l-1 1H5v2h14V4z"/></svg>
                </button>
            `;
            fileListRows.appendChild(row);
        });
    }
</script>