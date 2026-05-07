<?php include __DIR__ . '/../components/modals/fetch_modal.php'; ?>
<?php include __DIR__ . '/../components/modals/preview_modal.php'; ?>
<?php include __DIR__ . '/../components/modals/insert_modal.php'; ?>


<div class="w-full mx-auto mb-4">
    <h1 class="text-3xl font-extrabold text-[#a61e22] tracking-tight">
        General Ledger Extraction Import
    </h1>
    <p class="text-gray-500 mb-2 text-sm">
        Upload, preview, and import multiple Excel files efficiently.
    </p>

    <!-- FILE INPUT -->
    <input type="file" id="fileInput" class="hidden" multiple accept=".xls,.xlsx">

    <!-- DROPZONE -->
    <div id="dropZone"
        class="border-2 border-dashed border-[#DDEAF2] rounded-xl bg-[#F8FAFC]/50 py-6 flex flex-col items-center justify-center text-center px-6 cursor-pointer hover:border-[#EF4444] hover:bg-white transition"
        onclick="document.getElementById('fileInput').click()">

        <p class="text-xl font-bold text-[#0D2149]">Drag & Drop Files Here</p>
        <p class="text-sm text-gray-400">or click to browse multiple Excel files</p>
    </div>

    <!-- FILE LIST -->
    <div id="fileListContainer" class="mt-4 hidden">
        <div class="flex justify-between items-center mb-2">
            <h2 id="fileCount" class="font-bold text-md text-[#0D2149]">Files: 0</h2>

            <button onclick="uploadFiles()"
                class="bg-[#D50000] text-white px-4 py-1.5 rounded-lg text-sm font-semibold">
                Upload & Preview
            </button>
        </div>

        <div id="fileListRows" class="space-y-1"></div>
    </div>

    <!-- PREVIEW AREA -->
    <div id="previewContainer" class="mt-4"></div>
</div>


<script src="../resources/assets/js/gle_import.js"></script>





