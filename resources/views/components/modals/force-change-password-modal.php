<div id="changePasswordModal"
     class="fixed inset-0 z-[9999] hidden items-center justify-center bg-black/50 backdrop-blur-sm opacity-0 transition-opacity duration-300">

    <div id="modalContent"
         class="bg-white w-full max-w-md rounded-2xl shadow-2xl p-8 transform scale-95 opacity-0 transition-all duration-300">

        <div class="text-center mb-6">
            <h3 class="text-2xl font-bold text-gray-800">Create a New Password</h3>
            <p class="text-sm text-gray-500 mt-1">
                Default password detected. Please update to continue.
            </p>
        </div>

        <form id="forcePasswordForm" class="space-y-5">

            <!-- NEW PASSWORD -->
            <div class="relative">
                <input type="password" id="newPassword" required
                       class="peer w-full border-b-2 border-gray-300 focus:border-red-600 outline-none py-2 pr-10 transition">
                <label class="absolute left-0 top-2 text-gray-500 text-sm transition-all
                              peer-focus:-top-4 peer-focus:text-xs peer-focus:text-red-600
                              peer-valid:-top-4 peer-valid:text-xs">
                    New Password
                </label>

                <!-- Toggle -->
                <span class="absolute right-2 top-2 cursor-pointer text-gray-400"
                      onclick="togglePassword('newPassword', this)">👁️</span>
            </div>

            <!-- REQUIREMENTS -->
            <div class="text-xs bg-gray-50 border rounded-xl p-3 space-y-1">
                <p class="font-semibold text-gray-700">Password must contain:</p>
                <p id="reqLength" class="text-red-500">• At least 8 characters</p>
                <p id="reqUpper" class="text-red-500">• Uppercase letter</p>
                <p id="reqLower" class="text-red-500">• Lowercase letter</p>
                <p id="reqNumber" class="text-red-500">• Number</p>
                <p id="reqSpecial" class="text-red-500">• Special character</p>
            </div>

            <!-- CONFIRM -->
            <div class="relative">
                <input type="password" id="confirmPassword" required
                       class="peer w-full border-b-2 border-gray-300 focus:border-red-600 outline-none py-2 pr-10 transition">
                <label class="absolute left-0 top-2 text-gray-500 text-sm transition-all
                              peer-focus:-top-4 peer-focus:text-xs peer-focus:text-red-600
                              peer-valid:-top-4 peer-valid:text-xs">
                    Confirm Password
                </label>

                <span class="absolute right-2 top-2 cursor-pointer text-gray-400"
                      onclick="togglePassword('confirmPassword', this)">👁️</span>

                <p id="passwordMatchMessage" class="text-xs mt-2"></p>
            </div>

            <!-- BUTTON -->
            <button type="submit" id="submitBtn"
                    class="w-full bg-red-600 text-white py-2 rounded-xl font-semibold shadow hover:bg-red-700 transition flex items-center justify-center gap-2">

                <span id="btnText">Change Password</span>
                <span id="btnLoader" class="hidden animate-spin border-2 border-white border-t-transparent rounded-full w-4 h-4"></span>

            </button>

        </form>
    </div>
</div>


<script>
function showForcePasswordModal() {
    const modal = document.getElementById('changePasswordModal');
    const content = document.getElementById('modalContent');

    modal.classList.remove('hidden');

    setTimeout(() => {
        modal.classList.remove('opacity-0');
        content.classList.remove('opacity-0', 'scale-95');
        content.classList.add('scale-100');
    }, 10);

    document.body.style.overflow = 'hidden'; // lock scroll
}

function togglePassword(id, el) {
    const input = document.getElementById(id);
    input.type = input.type === "password" ? "text" : "password";
}

/* VALIDATION */
document.addEventListener("DOMContentLoaded", function () {

    const password = document.getElementById("newPassword");
    const confirmPassword = document.getElementById("confirmPassword");

    const reqLength = document.getElementById("reqLength");
    const reqUpper = document.getElementById("reqUpper");
    const reqLower = document.getElementById("reqLower");
    const reqNumber = document.getElementById("reqNumber");
    const reqSpecial = document.getElementById("reqSpecial");

    const message = document.getElementById("passwordMatchMessage");

    function setRequirement(el, valid) {
        el.classList.toggle("text-green-500", valid);
        el.classList.toggle("text-red-500", !valid);
    }

    function validateStrength() {
        const value = password.value;

        const hasLength = value.length >= 8;
        const hasUpper = /[A-Z]/.test(value);
        const hasLower = /[a-z]/.test(value);
        const hasNumber = /[0-9]/.test(value);
        const hasSpecial = /[^A-Za-z0-9]/.test(value);

        setRequirement(reqLength, hasLength);
        setRequirement(reqUpper, hasUpper);
        setRequirement(reqLower, hasLower);
        setRequirement(reqNumber, hasNumber);
        setRequirement(reqSpecial, hasSpecial);

        return hasLength && hasUpper && hasLower && hasNumber && hasSpecial;
    }

    function checkMatch() {
        if (!confirmPassword.value) {
            message.textContent = "";
            return false;
        }

        if (password.value === confirmPassword.value) {
            message.textContent = "✔ Passwords match";
            message.className = "text-green-500 text-xs mt-2";
            return true;
        } else {
            message.textContent = "✖ Passwords do not match";
            message.className = "text-red-500 text-xs mt-2";
            return false;
        }
    }

    password.addEventListener("keyup", () => {
        validateStrength();
        checkMatch();
    });

    confirmPassword.addEventListener("keyup", checkMatch);

    /* SUBMIT */
    document.getElementById("forcePasswordForm").addEventListener("submit", function(e) {
        e.preventDefault();

        if (!validateStrength() || !checkMatch()) {
            alert("Please fix password requirements.");
            return;
        }

        // loading state
        document.getElementById("btnText").textContent = "Updating...";
        document.getElementById("btnLoader").classList.remove("hidden");

        // 👉 NEXT STEP: AJAX HERE
    });

});
</script>