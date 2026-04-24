// /resources/assets/js/add-user.js

document.addEventListener('DOMContentLoaded', function() {
    const idInput = document.getElementById('input_id_number');
    const lastInput = document.getElementById('input_lastname');
    const userDisplay = document.getElementById('display_username');
    const glInput = document.getElementById('gl_search_input');
    const glOptions = document.getElementById('gl_options');
    const glContainer = document.getElementById('gl_tags_container');
    const hiddenInputs = document.getElementById('hidden_gl_inputs');

    // Username Generation: Lastname + ID Number
    function generateUsername() {
        const lastname = lastInput.value.trim().toLowerCase();
        const idNumber = idInput.value.trim();
        userDisplay.value = lastname + idNumber;
    }

    if(idInput && lastInput) {
        idInput.addEventListener('input', generateUsername);
        lastInput.addEventListener('input', generateUsername);
    }

    // GL Code Tagging System
    let selectedGLs = new Set();

    if (glInput) {
        glInput.addEventListener('input', function() {
            const val = this.value;
            
            // Check if the input matches one of the options in the datalist
            const options = Array.from(glOptions.options).map(opt => opt.value);
            
            if (options.includes(val)) {
                if (!selectedGLs.has(val)) {
                    selectedGLs.add(val);
                    renderGLTags();
                }
                // Clear the input after selection so user can search again
                this.value = ''; 
            }
        });
    }

    function renderGLTags() {
        glContainer.innerHTML = '';
        hiddenInputs.innerHTML = '';

        selectedGLs.forEach(code => {
            // Visual Tag
            const tag = document.createElement('div');
            tag.className = 'flex items-center gap-2 px-3 py-1 bg-red-50 text-red-700 rounded-full text-[11px] font-bold border border-red-100 animate-pop';
            tag.innerHTML = `
                ${code}
                <button type="button" onclick="removeGL('${code}')" class="hover:text-red-900 font-extrabold text-sm ml-1">&times;</button>
            `;
            glContainer.appendChild(tag);

            // Hidden input for POST data
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'gl_codes[]';
            input.value = code;
            hiddenInputs.appendChild(input);
        });
    }

    window.removeGL = function(code) {
        selectedGLs.delete(code);
        renderGLTags();
    };
});