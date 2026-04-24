<div id="modal-gl-importgl" class="hidden fixed inset-0 bg-black/50 backdrop-blur-sm z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-2xl overflow-hidden transform transition-all">
        
        <div class="p-6 pb-4 flex items-start gap-4 border-b border-gray-100">
            <div class="p-3 bg-red-50 rounded-full">
                <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path>
                </svg>
            </div>
            <div>
                <h3 class="text-xl font-bold text-gray-900">Import GL Data</h3>
                <p class="text-sm text-gray-500">Drag and drop multiple Excel files to preview and upload.</p>
            </div>
        </div>

        <div class="p-6">
            <input type="file" id="glFileInput" class="hidden" multiple accept=".xls,.xlsx">

            <div id="glDropZone"
                class="border-2 border-dashed border-gray-300 rounded-xl p-8 flex flex-col items-center justify-center text-center hover:border-red-400 hover:bg-red-50/30 transition-all cursor-pointer"
                onclick="document.getElementById('glFileInput').click()">
                <svg class="w-10 h-10 text-gray-400 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path></svg>
                <p class="text-sm text-gray-600">
                    Drag & Drop Files Here or click to browse <br> 
                    excel file of <strong>GL Code List</strong>
                </p>
            </div>

            <div id="glFileListContainer" class="mt-6 hidden">
                <div class="flex justify-between items-center mb-3">
                    <h2 id="glFileCount" class="font-bold text-sm text-gray-700">Files: 0</h2>
                </div>
                <div id="glFileListRows" class="space-y-2 max-h-[250px] overflow-y-auto pr-2"></div>
            </div>
        </div>

        <div class="px-6 py-4 bg-gray-50 flex items-center justify-end border-t border-gray-100 gap-2">
            <button type="button" onclick="closeModal('gl-importgl')" class="px-4 py-2 text-xs font-bold uppercase tracking-wider text-gray-600 bg-white border border-gray-200 rounded-lg hover:bg-gray-100 transition-all">
                Cancel
            </button>
            <button type="button" onclick="uploadGLFiles()" class="px-6 py-2 text-xs font-bold uppercase tracking-wider text-white bg-[#D50000] rounded-lg hover:bg-red-700 shadow-md transition-all">
                Upload & Preview
            </button>
        </div>
    </div>
</div>

<script>
    let glFiles = [];

    // Initialize listeners
    document.getElementById('glFileInput').addEventListener('change', e => handleGLFiles(e.target.files));
    
    const dropZone = document.getElementById('glDropZone');
    dropZone.addEventListener('dragover', e => { e.preventDefault(); e.stopPropagation(); });
    dropZone.addEventListener('drop', e => {
        e.preventDefault();
        e.stopPropagation();
        handleGLFiles(e.dataTransfer.files);
    });

    function handleGLFiles(files) {
        for (let f of files) {
            glFiles.push(f);
        }
        renderGLFileList();
    }

    function renderGLFileList() {
        const container = document.getElementById('glFileListContainer');
        const rows = document.getElementById('glFileListRows');
        const count = document.getElementById('glFileCount');

        if (glFiles.length === 0) {
            container.classList.add('hidden');
            return;
        }

        container.classList.remove('hidden');
        rows.innerHTML = '';
        count.textContent = `Files: ${glFiles.length}`;

        glFiles.forEach((file, i) => {
            let row = document.createElement('div');
            row.className = "bg-white p-3 rounded border border-gray-200 flex justify-between items-center text-xs";
            row.innerHTML = `
                <div class="truncate mr-2">
                    <p class="font-medium text-gray-700">${file.name}</p>
                    <p class="text-[10px] text-gray-400">${(file.size / 1024).toFixed(2)} KB</p>
                </div>
                <button onclick="removeGLFile(${i})" class="text-red-500 hover:text-red-700 font-bold uppercase text-[10px]">Remove</button>
            `;
            rows.appendChild(row);
        });
    }

    function removeGLFile(i) {
        glFiles.splice(i, 1);
        renderGLFileList();
    }

    async function uploadGLFiles() {
        if (glFiles.length === 0) return alert("Please select files first.");
        
        // Add your upload logic here (similar to gle_import.php)
        console.log("Uploading files...", glFiles);
        // showFetchModal(glFiles.length); 
    }
</script>