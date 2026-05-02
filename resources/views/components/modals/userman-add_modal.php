<div id="modal-add-user" class="hidden fixed inset-0 bg-black/50 backdrop-blur-sm z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-lg transform transition-all">
        
        <!-- Header: Reduced padding -->
        <div class="p-4 pb-0 flex items-start gap-4">
            <div class="p-2 bg-red-50 rounded-full">
                <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                </svg>
            </div>
            <div>
                <h3 class="text-lg font-bold text-gray-900">Create Account</h3>
                <p class="text-xs text-gray-500">Create a new user account and set initial access level.</p>
            </div>
        </div>

        <!-- Form: Tightened space-y and padding -->
        <form id="createUserForm" class="p-4 space-y-2">
            <div>
                <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">ID Number</label>
                <input type="text" name="id_number" id="input_id_number" required
                    class="w-full px-4 py-2 text-sm border border-gray-200 rounded-lg focus:ring-1 focus:ring-red-500 outline-none transition-all">
            </div>

            <div>
                <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">Username</label>
                <input type="text" name="username" id="display_username" readonly
                    placeholder="will be generated"
                    class="w-full px-4 py-2 text-sm bg-gray-50 border border-gray-200 rounded-lg text-gray-500 italic outline-none">
            </div>

            <div class="grid grid-cols-3 gap-3">
                <div>
                    <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">Firstname</label>
                    <input type="text" name="firstname" required
                        class="w-full px-3 py-2 text-sm border border-gray-200 rounded-lg focus:ring-1 focus:ring-red-500 outline-none transition-all">
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">Middlename</label>
                    <input type="text" name="middlename"
                        class="w-full px-3 py-2 text-sm border border-gray-200 rounded-lg focus:ring-1 focus:ring-red-500 outline-none transition-all">
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">Lastname</label>
                    <input type="text" name="lastname" id="input_lastname" required
                        class="w-full px-3 py-2 text-sm border border-gray-200 rounded-lg focus:ring-1 focus:ring-red-500 outline-none transition-all">
                </div>
            </div>

            <!-- Report Filter Labels Added Here -->
            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">Main Zone</label>
                    <select name="role_id" class="w-full px-3 py-2 text-sm border border-gray-200 rounded-lg focus:ring-1 focus:ring-red-500 outline-none transition-all cursor-pointer">
                        <?php if (!empty($roles)): ?>
                            <?php foreach ($roles as $role): ?>
                                <option value="<?= $role['id'] ?>"><?= htmlspecialchars($role['name']) ?></option>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </select>
                </div>
                
                <div class="relative" id="dept-dropdown-wrapper">
                    <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">Zone</label>
                    <input type="hidden" id="selected_dept_id" name="department_id">    
                    <input type="text" id="dept_search" placeholder="Select or Add..." 
                        class="w-full px-3 py-2 text-sm border border-gray-200 rounded-lg focus:ring-1 focus:ring-red-500 outline-none transition-all cursor-pointer"
                        onclick="toggleDeptDropdown(true)">

                    <div id="dept_dropdown" class="absolute z-[100] w-full mt-1 bg-white border border-gray-200 rounded-lg shadow-xl hidden max-h-64 overflow-y-auto">
                        <div id="add_dept_trigger" onclick="enableAddDeptMode()" class="px-3 py-2 hover:bg-gray-50 cursor-pointer border-b border-gray-100 text-red-600 font-bold flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10" stroke-width="2"/><path d="M12 8v8m-4-4h8" stroke-width="2" stroke-linecap="round"/></svg>
                            Add Department
                        </div>
                        <div id="add_dept_input_container" class="hidden px-2 py-2">
                            <input type="text" id="new_dept_input" placeholder="Type name & enter..." class="w-full px-2 py-1 text-sm border border-red-300 rounded focus:outline-none" onkeydown="handleDeptEnter(event)">
                        </div>
                        <div id="dept_options">
                            <?php if (!empty($departments)): ?>
                                <?php foreach ($departments as $dept): ?>
                                    <div class="px-3 py-2 hover:bg-gray-100 cursor-pointer text-sm" onclick="selectDept('<?= $dept['id'] ?>', '<?= htmlspecialchars($dept['name']) ?>')">
                                        <?= htmlspecialchars($dept['name']) ?>
                                    </div>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>

            <!-- More Report Filter Labels Added Here -->
            <div class="grid grid-cols-2 gap-3">
                <div class="relative" id="lvl4-wrapper">
                    <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-1"> Level 4 Category</label>
                    <input type="text" id="lvl4_input"
                        placeholder="Search Category..."
                        onclick="toggleLvl4Dropdown(true)"
                        class="w-full px-3 py-2 text-sm border border-gray-200 rounded-lg">

                    <div id="lvl4_dropdown" onclick="event.stopPropagation()" class="hidden absolute z-[100] w-full mt-1 bg-white border rounded-lg shadow max-h-64 overflow-y-auto">
                        <div class="px-3 py-2 border-b">
                            <label class="flex items-center gap-2 font-bold">
                                <input type="checkbox" onchange="toggleAllLvl4(this)"> Select All
                            </label>
                        </div>
                        <div id="lvl4_options"></div>
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">Assign GL Codes</label>
                    <div class="relative" id="gl-dropdown-wrapper">
                        <input type="text" id="gl_global_search"
                            onclick="handleGlClick()"
                            autocomplete="off"        
                            placeholder="Search any GL code..."
                            class="w-full px-3 py-2 text-sm border border-gray-200 rounded-lg focus:ring-1 focus:ring-red-500 outline-none"
                            onclick="toggleGlDropdown(true)">
                        
                        <div id="gl_dropdown" onclick="event.stopPropagation()" class="absolute z-[100] w-full mt-1 bg-white border border-gray-200 rounded-lg shadow-xl hidden max-h-48 overflow-y-auto">
                            <div class="px-3 py-2 border-b border-gray-100 bg-gray-50">
                                <label class="flex items-center gap-2 cursor-pointer font-bold text-sm text-gray-700">
                                    <input type="checkbox" id="gl_select_all" onchange="toggleSelectAll()"> Select All
                                </label>
                            </div>
                            <div id="gl_options_list"></div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div id="gl_tags_container" style="scrollbar-width: thin;"
                class="flex flex-wrap gap-2 mt-1 max-h-20 overflow-y-auto border border-gray-200 rounded-lg p-2">
            </div>
            <div id="hidden_gl_inputs"></div>

            <div class="flex justify-end gap-3 mt-4 pt-3 border-t border-gray-100">
                <button type="button" onclick="closeAddUserModal()"
                    class="px-6 py-2 text-xs font-bold uppercase tracking-wider text-gray-600 bg-gray-100 rounded-lg hover:bg-gray-200 transition-all">
                    Cancel
                </button>
                <button type="submit" 
                    class="px-6 py-2 text-xs font-bold uppercase tracking-wider text-white bg-[#D50000] rounded-lg hover:bg-red-700 shadow-md hover:shadow-lg transition-all">
                    Create Account
                </button>
            </div>
        </form>
    </div>
</div>

<script>

    let selectedGLs = {}; 

    
    function toggleGlDropdown(show) {
        document.getElementById('gl_dropdown').classList.toggle('hidden', !show);
    }

    function updateGlOptions() {
        const category = document.getElementById('level4_category').value;
        const optionsList = document.getElementById('gl_options_list');
        const selectAllCheckbox = document.getElementById('gl_select_all');
        
        // Clear
        optionsList.innerHTML = '';
        selectAllCheckbox.checked = false;
        document.getElementById('gl_tags_container').innerHTML = '';
        document.getElementById('hidden_gl_inputs').innerHTML = '';

        if (category && glCategoryMap[category]) {
            glCategoryMap[category].forEach(code => {
                const div = document.createElement('div');
                div.className = "px-3 py-2 hover:bg-gray-50 cursor-pointer flex items-center gap-2 text-sm";
                
                const checkbox = document.createElement('input');
                checkbox.type = 'checkbox';
                checkbox.value = code;
                checkbox.className = 'gl-checkbox';
                checkbox.onchange = updateGlTags;

                const label = document.createElement('span');
                label.textContent = `${code} - ${category}`;

                div.appendChild(checkbox);
                div.appendChild(label);
                optionsList.appendChild(div);
            });
        }
    }

    function toggleSelectAll() {
        const selectAll = document.getElementById('gl_select_all');
        const checkboxes = document.querySelectorAll('.gl-checkbox');
        checkboxes.forEach(cb => cb.checked = selectAll.checked);
        updateGlTags();
    }

    function updateGlTags() {

        const checkboxes = document.querySelectorAll('.gl-checkbox');

        // ✅ Update state from currently visible checkboxes
        checkboxes.forEach(cb => {

            const id = cb.value;

            if (cb.checked) {
                selectedGLs[id] = {
                    id: id,
                    code: cb.getAttribute('data-code'),
                    title: cb.getAttribute('data-title')
                };
            } else {
                delete selectedGLs[id];
            }
        });

        // ✅ Rebuild UI from STATE (not DOM)
        const container = document.getElementById('gl_tags_container');
        const hiddenInputs = document.getElementById('hidden_gl_inputs');

        container.innerHTML = '';
        hiddenInputs.innerHTML = '';

        Object.values(selectedGLs).forEach(gl => {

            // UI tag
            const tag = document.createElement('span');
            tag.className = "bg-red-100 text-red-700 px-2 py-1 rounded text-xs font-bold flex items-center gap-1";

            tag.innerHTML = `
                ${gl.code} - ${gl.title}
                <button type="button" onclick="removeGl('${gl.id}')" class="ml-1 text-red-500">✕</button>
            `;

            container.appendChild(tag);

            // hidden input (for backend)
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'gl_codes[]';
            input.value = gl.id;

            hiddenInputs.appendChild(input);
        });
    }

    // --- Department Search & Add Logic ---
    const deptSearch = document.getElementById('dept_search');
    const deptDropdown = document.getElementById('dept_dropdown');
    const deptOptions = document.getElementById('dept_options');
    const addTrigger = document.getElementById('add_dept_trigger');
    const addInputContainer = document.getElementById('add_dept_input_container');
    const newDeptInput = document.getElementById('new_dept_input');

    function toggleDeptDropdown(show) {
        deptDropdown.classList.toggle('hidden', !show);
    }

    deptSearch.addEventListener('input', function() {
        const filter = this.value.toUpperCase();
        const items = deptOptions.getElementsByTagName('div');
        for (let i = 0; i < items.length; i++) {
            items[i].style.display = items[i].textContent.toUpperCase().indexOf(filter) > -1 ? "" : "none";
        }
    });

    function selectDept(id, name) {
        deptSearch.value = name;
        document.getElementById('selected_dept_id').value = id;
        toggleDeptDropdown(false);
    }

    function enableAddDeptMode() {
        addTrigger.classList.add('hidden');
        addInputContainer.classList.remove('hidden');
        newDeptInput.focus();
    }

    function handleDeptEnter(e) {
        if (e.key === 'Enter') {
            e.preventDefault();

            const val = newDeptInput.value.trim();

            if (val) {

                document.getElementById('department_name').value = val;

                const newId = 'new_' + Date.now();

                const newDiv = document.createElement('div');
                newDiv.className = "px-3 py-2 hover:bg-gray-100 cursor-pointer text-sm";
                newDiv.textContent = val;
                newDiv.onclick = () => selectDept(newId, val);

                deptOptions.prepend(newDiv);

                newDeptInput.value = '';

                addTrigger.classList.remove('hidden');
                addInputContainer.classList.add('hidden');

                selectDept(newId, val);
            }
        }
    }

    document.addEventListener('click', function(e) {
        if (!document.getElementById('dept-dropdown-wrapper').contains(e.target)) {
            toggleDeptDropdown(false);
        }
        if (!document.getElementById('gl-dropdown-wrapper').contains(e.target)) {
            toggleGlDropdown(false);
        }
    });

    function openModal(id) {

        if (id === 'add-user') {
            closeAddUserModal(); // 🔥 force fresh state before opening
        }

        document.getElementById('modal-' + id).classList.remove('hidden');
    }

    function closeModal(id) {
        document.getElementById('modal-' + id).classList.add('hidden');
    }



    let selectedCategories = [];

    async function loadLevel4() {
        const res = await fetch('index.php?api=gl-level4');
        const data = await res.json();

        const container = document.getElementById('lvl4_options');
        container.innerHTML = '';

        data.data.forEach(cat => {
            const div = document.createElement('div');

            div.className = "px-3 py-2 flex gap-2";

            div.innerHTML = `
                <input type="checkbox" value="${cat}" onchange="handleLvl4Change()">
                <span>${cat}</span>
            `;

            container.appendChild(div);
        });
    }

    function handleLvl4Change() {
        const checked = document.querySelectorAll('#lvl4_options input:checked');

        selectedCategories = Array.from(checked).map(cb => cb.value);

        document.getElementById('lvl4_input').value =
            selectedCategories.join(', ') || '';

        loadGLCodesByCategory();

        document.getElementById('lvl4_dropdown').classList.add('hidden');
    }

    function toggleAllLvl4(cb) {
        document.querySelectorAll('#lvl4_options input')
            .forEach(x => x.checked = cb.checked);

        handleLvl4Change();
    }

    async function loadGLCodesByCategory() {

        const res = await fetch('index.php?api=gl-by-category', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ categories: selectedCategories })
        });

        const data = await res.json();

        const container = document.getElementById('gl_options_list');
        container.innerHTML = '';

        data.data.forEach(gl => {

            const alreadySelected = document.querySelector(
                `#hidden_gl_inputs input[value="${gl.id}"]`
            );

            const div = document.createElement('div');
            div.className = "px-3 py-2 flex gap-2";

            div.innerHTML = `
                <input 
                    type="checkbox" 
                    class="gl-checkbox" 
                    value="${gl.id}" 
                    data-id="${gl.id}"
                    data-code="${gl.gl_account}"
                    data-title="${gl.account_title}"
                    ${alreadySelected ? 'checked' : ''}
                    onchange="updateGlTags()"
                >
                <span>${gl.gl_account} - ${gl.account_title}</span>
            `;

            container.appendChild(div);
        });
    }

    function toggleLvl4Dropdown(show) {
        document.getElementById('lvl4_dropdown')
            .classList.toggle('hidden', !show);
    }

    document.addEventListener('DOMContentLoaded', () => {
        loadLevel4();
    });



    document.getElementById('createUserForm')
    .addEventListener('submit', async function(e) {

        e.preventDefault();

        const formData = new FormData(this);
        const data = Object.fromEntries(formData.entries());

        data.gl_codes = formData.getAll('gl_codes[]');

        const res = await fetch('index.php?api=create-user', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(data)
        });

        const result = await res.json();

        if (!result.ok) {
            alert(result.message);
            return;
        }

        alert('User created successfully');
        location.reload();
    });


    document.addEventListener('click', function(e) {

        const lvl4Wrapper = document.getElementById('lvl4-wrapper');

        if (!lvl4Wrapper.contains(e.target)) {
            document.getElementById('lvl4_dropdown')
                .classList.add('hidden');
        }

    });


    function resetGlState() {

        selectedCategories = [];

        const search = document.getElementById('gl_search_input');
        if (search) search.value = '';

        document.getElementById('gl_tags_container').innerHTML = '';
        document.getElementById('hidden_gl_inputs').innerHTML = '';
        document.getElementById('gl_options_list').innerHTML = '';

        const selectAll = document.getElementById('gl_select_all');
        if (selectAll) selectAll.checked = false;
    }



    function closeAddUserModal() {

        // CLOSE MODAL
        document.getElementById('modal-add-user').classList.add('hidden');

        // =========================
        // RESET FORM
        // =========================
        document.getElementById('createUserForm').reset();

        // =========================
        // RESET DEPARTMENT
        // =========================
        document.getElementById('dept_search').value = '';
        const deptId = document.getElementById('selected_dept_id');
        if (deptId) deptId.value = '';

        const deptName = document.getElementById('department_name');
        if (deptName) deptName.value = '';

        // =========================
        // RESET LEVEL 4
        // =========================
        selectedCategories = [];

        document.getElementById('lvl4_input').value = '';

        document.querySelectorAll('#lvl4_options input')
            .forEach(cb => cb.checked = false);

        // 🔥 VERY IMPORTANT
        document.getElementById('lvl4_dropdown').classList.add('hidden');

        // =========================
        // RESET GL CODES (FULL CLEAN)
        // =========================

        resetGlState();

        document.getElementById('gl_dropdown').classList.add('hidden');
        // 7. Close dropdown
        document.getElementById('gl_dropdown').classList.add('hidden');
    }


    function removeGl(id) {

        delete selectedGLs[id];

        // uncheck if visible
        document.querySelectorAll('.gl-checkbox').forEach(cb => {
            if (cb.value == id) cb.checked = false;
        });

        updateGlTags();
    }


    document.getElementById('lvl4_input').addEventListener('input', function () {

        const filter = this.value.toLowerCase();

        const items = document.querySelectorAll('#lvl4_options div');

        items.forEach(item => {
            const text = item.textContent.toLowerCase();

            item.style.display = text.includes(filter) ? '' : 'none';
        });

    });


    let isSearching = false;
    let glSearchTimeout;

    document.getElementById('gl_global_search').addEventListener('input', function () {

        clearTimeout(glSearchTimeout);

        const query = this.value.trim();
        const container = document.getElementById('gl_options_list');

        // ✅ If cleared → go back to category
        if (query.length < 2) {
            loadGLCodesByCategory();
            return;
        }

        glSearchTimeout = setTimeout(async () => {

            const res = await fetch('index.php?api=gl-search', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ query })
            });

            const data = await res.json();

            // 🔥 Replace ONLY dropdown view (not selected items)
            container.innerHTML = '';

            data.data.forEach(gl => {

                const alreadySelected = document.querySelector(
                    `#hidden_gl_inputs input[value="${gl.id}"]`
                );

                const div = document.createElement('div');
                div.className = "px-3 py-2 flex gap-2";

                div.innerHTML = `
                    <input type="checkbox"
                        class="gl-checkbox"
                        value="${gl.id}"
                        data-id="${gl.id}"
                        data-code="${gl.gl_account}"
                        data-title="${gl.account_title}"
                        ${alreadySelected ? 'checked' : ''}
                        onchange="updateGlTags()">
                    <span>${gl.gl_account} - ${gl.account_title}</span>
                `;

                container.appendChild(div);
            });

        }, 300);
    });


    document.getElementById('gl_global_search').addEventListener('focus', function () {
        document.getElementById('gl_options_list').innerHTML = '';
    });



    function handleGlClick() {

        const query = document.getElementById('gl_global_search').value.trim();

        // ✅ If not searching → show category GL codes
        if (query.length < 2) {
            loadGLCodesByCategory();
        }

        toggleGlDropdown(true);
    }

</script>