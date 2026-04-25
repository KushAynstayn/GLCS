<div id="modal-add-user" class="hidden fixed inset-0 bg-black/50 backdrop-blur-sm z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-lg transform transition-all">
        
        <div class="p-6 pb-0 flex items-start gap-4">
            <div class="p-3 bg-red-50 rounded-full">
                <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                </svg>
            </div>
            <div>
                <h3 class="text-xl font-bold text-gray-900">Create Account</h3>
                <p class="text-sm text-gray-500">Create a new user account and set initial access level.</p>
            </div>
        </div>

        <form id="createUserForm" action="process_user.php" method="POST" class="p-6 space-y-4">
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

            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">Role</label>
                    <select name="role_id" class="w-full px-3 py-2 text-sm border border-gray-200 rounded-lg focus:ring-1 focus:ring-red-500 outline-none transition-all cursor-pointer">
                        <?php if (!empty($roles)): ?>
                            <?php foreach ($roles as $role): ?>
                                <option value="<?= $role['id'] ?>"><?= htmlspecialchars($role['name']) ?></option>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </select>
                </div>
                
                <div class="relative" id="dept-dropdown-wrapper">
                    <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">Department</label>
                    <input type="hidden" name="department_id" id="selected_dept_id">
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

            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">Level 4 Category</label>
                    <select id="level4_category" onchange="updateGlOptions()" class="w-full px-3 py-2 text-sm border border-gray-200 rounded-lg focus:ring-1 focus:ring-red-500 outline-none transition-all cursor-pointer">
                        <option value="">Select Category</option>
                        <option value="Cash on Hand">Cash on Hand</option>
                        <option value="Cash on Bank">Cash on Bank</option>
                        <option value="Revolving Fund Support">Revolving Fund Support</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">Assign GL Codes</label>
                    <div class="relative" id="gl-dropdown-wrapper">
                        <input type="text" id="gl_search_input" readonly placeholder="Select GL Codes..." 
                            class="w-full px-4 py-2 text-sm border border-gray-200 rounded-lg focus:ring-1 focus:ring-red-500 outline-none transition-all cursor-pointer"
                            onclick="toggleGlDropdown(true)">
                        
                        <div id="gl_dropdown" class="absolute z-[100] w-full mt-1 bg-white border border-gray-200 rounded-lg shadow-xl hidden max-h-64 overflow-y-auto">
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
            
            <div id="gl_tags_container" class="flex flex-wrap gap-2 mt-3"></div>
            <div id="hidden_gl_inputs"></div>

            <div class="flex justify-end gap-3 mt-8 pt-4 border-t border-gray-100">
                <button type="button" onclick="closeModal('add-user')" 
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
    // --- Mock Data ---
    const glCategoryMap = {
        "Cash on Hand": ["111157", "111158", "111159"],
        "Cash on Bank": ["111201", "111202"],
        "Revolving Fund Support": ["111301", "111302", "111303", "111304", "111305"]
    };

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
        const container = document.getElementById('gl_tags_container');
        const hiddenInputs = document.getElementById('hidden_gl_inputs');
        const checkboxes = document.querySelectorAll('.gl-checkbox');
        
        container.innerHTML = '';
        hiddenInputs.innerHTML = '';
        
        checkboxes.forEach(cb => {
            if (cb.checked) {
                // Add tag UI
                const tag = document.createElement('span');
                tag.className = "bg-red-100 text-red-700 px-2 py-1 rounded text-xs font-bold flex items-center gap-1";
                tag.textContent = cb.value;
                container.appendChild(tag);

                // Add hidden input
                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = 'gl_codes[]';
                input.value = cb.value;
                hiddenInputs.appendChild(input);
            }
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
                const newDiv = document.createElement('div');
                newDiv.className = "px-3 py-2 hover:bg-gray-100 cursor-pointer text-sm";
                newDiv.textContent = val;
                newDiv.onclick = () => selectDept('new_' + Date.now(), val);
                deptOptions.prepend(newDiv);
                newDeptInput.value = '';
                addTrigger.classList.remove('hidden');
                addInputContainer.classList.add('hidden');
                selectDept('new_' + Date.now(), val);
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
        document.getElementById('modal-' + id).classList.remove('hidden');
    }

    function closeModal(id) {
        document.getElementById('modal-' + id).classList.add('hidden');
    }
</script>