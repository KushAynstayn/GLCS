function openModal(id) {
        document.getElementById('modal-' + id).classList.remove('hidden');
    }

    function closeModal(id) {
        document.getElementById('modal-' + id).classList.add('hidden');
    }


    async function openEditUser(userId) {

        const res = await fetch(`index.php?api=user-getOne&id=${userId}`);
        const result = await res.json();

        if (!result.ok) return alert('Failed to load user');

        const u = result.data;

        document.getElementById('edit_id_number').value = u.id_number;
        document.getElementById('edit_username').value = u.username;
        document.getElementById('edit_firstname').value = u.first_name;
        document.getElementById('edit_middlename').value = u.middle_name ?? '';
        document.getElementById('edit_lastname').value = u.last_name;
        document.getElementById('edit_role').value = u.role_id;

        document.getElementById('edit_status').value = u.status;

        // 🔥 LOAD GL TAGS
        const container = document.getElementById('edit_gl_tags_container');

        if (container) {

            container.innerHTML = '';

            // ✅ SAFE: initialize selected GLs properly
            window.selectedGLs = (u.gl_codes || []).map(gl => parseInt(gl.id));

            renderGLTags(u.gl_codes);
        }

        window.editUserId = u.id;

        setTimeout(() => {
            ['edit_id_number', 'edit_username', 'edit_firstname', 'edit_middlename', 'edit_lastname']
            .forEach(id => {
                const el = document.getElementById(id);
                if (!el) return;

                el.value = el.value.toUpperCase(); // 🔥 FORCE immediately

                el.oninput = () => {
                    el.value = el.value.toUpperCase();
                };
            });
        }, 100);

        openModal('userman');
    }



    async function saveEditUser() {

        const data = {
            id: window.editUserId,
            id_number: document.getElementById('edit_id_number').value,
            firstname: document.getElementById('edit_firstname').value,
            middlename: document.getElementById('edit_middlename').value,
            lastname: document.getElementById('edit_lastname').value,
            username: document.getElementById('edit_username').value,
            role_id: document.getElementById('edit_role').value,
            status: document.getElementById('edit_status').value,
            gl_codes: Array.from(new Set((window.selectedGLs || []).map(id => parseInt(id)))) // reuse selectedGLs if you want advanced editing
        };

        const res = await fetch('index.php?api=user-update', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(data)
        });

        const result = await res.json();

        if (!result.ok) return alert(result.message);

        alert('Updated successfully');

        resetEditModal();
        closeModal('userman');

        location.reload();
    }



    async function resetUserPassword() {

        if (!confirm('Reset password to default?')) return;

        await fetch('index.php?api=user-resetPassword', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ user_id: window.editUserId })
        });

        alert('Password reset to default');
    }



    function addGL(gl) {
        const id = parseInt(gl.id);

        window.selectedGLs = window.selectedGLs || [];
        if (window.selectedGLs.includes(id)) return;

        window.selectedGLs.push(id);

        const container = document.getElementById('edit_gl_tags_container');

        const tag = document.createElement('span');
        tag.className = "bg-green-100 px-2 py-1 text-xs rounded flex items-center gap-1";
        tag.textContent = `${gl.gl_account} - ${gl.account_title}`;

        const btn = document.createElement('button');
        btn.textContent = '×';
        btn.className = "text-red-500 font-bold ml-1 hover:text-red-700 focus:outline-none";

        // ✅ NEW LOGIC: Remove from array AND remove the element directly
        btn.onclick = function (e) {
            e.preventDefault();
            e.stopPropagation();
            
            // 1. Remove the ID from the state array
            window.selectedGLs = window.selectedGLs.filter(g => g !== id);
            
            // 2. Remove the tag element directly from the UI
            tag.remove();
        };

        tag.appendChild(btn);
        container.appendChild(tag);
    }



    document.addEventListener('DOMContentLoaded', () => {

        function forceUppercase(id) {
            const el = document.getElementById(id);
            if (!el) return;

            el.addEventListener('input', () => {
                el.value = el.value.toUpperCase();
            });
        }

        ['edit_id_number', 'edit_username', 'edit_firstname', 'edit_middlename', 'edit_lastname']
            .forEach(forceUppercase);

    });



    document.getElementById('edit_gl_search')?.addEventListener('input', async function () {

        const keyword = this.value;

        if (keyword.length < 2) return;

        const res = await fetch(`index.php?api=gl-search&keyword=${keyword}`);
        const result = await res.json();

        if (!result.ok) return;

        console.log(result); // debug once

        const results = document.getElementById('edit_gl_results');
        results.innerHTML = '';

        if (!result.data || result.data.length === 0) {
            results.innerHTML = '<div class="p-1 text-gray-400">No results</div>';
            return;
        }

        result.data.forEach(gl => {

            const div = document.createElement('div');
            div.className = "p-1 hover:bg-gray-100 cursor-pointer";

            div.innerText = `${gl.gl_account} - ${gl.account_title}`;

            div.onclick = () => {
                addGL(gl);
                results.innerHTML = '';
            };

            results.appendChild(div);
        });
    });



    function resetEditModal() {

        // clear search
        const search = document.getElementById('edit_gl_search');
        if (search) search.value = '';

        // clear results dropdown
        const results = document.getElementById('edit_gl_results');
        if (results) results.innerHTML = '';

        // clear GL tags
        const container = document.getElementById('edit_gl_tags_container');
        if (container) container.innerHTML = '';

        // reset array
        window.selectedGLs = [];
    }



    function renderGLTags(glList = []) {
        const container = document.getElementById('edit_gl_tags_container');
        if (!container) return;

        container.innerHTML = '';

        glList.forEach(gl => {
            const id = parseInt(gl.id);

            const tag = document.createElement('span');
            tag.className = "bg-green-100 px-2 py-1 text-xs rounded flex items-center gap-1";
            tag.textContent = `${gl.gl_account} - ${gl.account_title}`;

            const btn = document.createElement('button');
            btn.textContent = '×';
            btn.className = "text-red-500 font-bold ml-1 hover:text-red-700 focus:outline-none";

            // ✅ NEW LOGIC: Remove from array AND remove the element directly
            btn.onclick = function (e) {
                e.preventDefault();
                e.stopPropagation();
                
                // 1. Remove the ID from the state array
                window.selectedGLs = window.selectedGLs.filter(g => g !== id);
                
                // 2. Remove the tag element directly from the UI
                tag.remove();
            };

            tag.appendChild(btn);
            container.appendChild(tag);
        });
    }


    
    document.addEventListener('click', function (e) {

        const row = e.target.closest('.user-row');

        if (!row) return;

        openEditUser(row.dataset.id);
    });