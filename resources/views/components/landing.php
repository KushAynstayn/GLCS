<style>
    /* Slow, professional float for icons */
    @keyframes smooth-bounce {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-15px); }
    }
    .animate-smooth-bounce { animation: smooth-bounce 4s ease-in-out infinite; }

    /* Slide effect for the button */
    .btn-slide { position: relative; overflow: hidden; transition: color 0.3s ease; display: inline-block; cursor: pointer; }
    .btn-slide::before { content: ''; position: absolute; top: 0; left: -100%; width: 100%; height: 100%; background-color: #dc3545; transition: left 0.4s ease-in-out; z-index: 0; }
    .btn-slide:hover::before { left: 0; }
    .btn-slide:hover { color: white; }
    .btn-slide span { position: relative; z-index: 1; }
</style>

<div class="relative w-full flex-1 bg-cover bg-center bg-no-repeat flex items-center justify-between" 
     style="background-image: url('assets/images/landing_bg.png');">
    
    <div id="content-container" class="z-10 pl-20 transition-all duration-700 ease-in-out">
        
        <div id="header-group" class="transition-all duration-700 ease-in-out -mt-35">
            <h1 id="gl-title" class="text-8xl font-bold font-league-spartan text-white drop-shadow-[0_4px_4px_rgba(0,0,0,0.5)] leading-none transition-all duration-500">
                GENERAL<br>LEDGER
            </h1>
            <h2 id="gl-subtitle" class="text-2xl font-poppins text-white tracking-widest mt-0 transition-all duration-500">
                CONSOLIDATED SYSTEM
            </h2>
            
            <button id="btn-login-trigger" onclick="showLogin()" class="btn-slide mt-10 inline-block bg-white text-red-800 font-bold py-3 px-12 rounded-lg shadow-lg border border-red-800">
                <span>LOGIN</span>
            </button>
        </div>

        <div id="login-form" class="hidden opacity-0 transition-opacity duration-700 mt-8 w-[350px] flex-shrink-0">
            <form action="../actions/login_action.php" method="post" class="space-y-4">
                <input type="text" name="email" placeholder="USERNAME" class="w-full px-6 py-4 border border-white/50 bg-white/10 rounded-full text-white text-center placeholder:text-white/70 focus:outline-none focus:bg-white/20 transition-all uppercase" required>
                
                <div class="relative w-full">
                    <input type="password" id="password-input" name="password" placeholder="PASSWORD" class="w-full px-6 py-4 border border-white/50 bg-white/10 rounded-full text-white text-center placeholder:text-white/70 focus:outline-none focus:bg-white/20 transition-all" required>
                    <button type="button" onclick="togglePassword()" class="absolute right-5 top-1/2 transform -translate-y-1/2 text-white/70 hover:text-white focus:outline-none">
                        <i id="eye-icon" class="fas fa-eye"></i>
                    </button>
                </div>
                
                <button type="submit" name="submit" class="w-full bg-white text-red-800 font-bold py-3 rounded-full hover:bg-gray-100 transition-all shadow-md active:scale-95 tracking-widest">
                    LOGIN
                </button>

                <div class="text-center pt-2">
                    <button type="button" onclick="hideLogin()" class="text-xs font-semibold text-white/70 hover:text-white underline underline-offset-4 transition-colors">
                        Back to home
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div class="absolute top-[4%] right-[3%] p-4 bg-white/20 backdrop-blur-md shadow-2xl rounded-2xl text-red-800 border border-white/30 z-20 animate-smooth-bounce"><i class="fas fa-book-open text-3xl"></i></div>
    <div class="absolute top-[8%] left-[60%] p-4 bg-white/20 backdrop-blur-md shadow-2xl rounded-2xl text-red-800 border border-white/30 z-20 animate-smooth-bounce"><i class="fas fa-peso-sign text-3xl"></i></div>
    <div class="absolute top-[50%] left-[55%] p-4 bg-white/20 backdrop-blur-md shadow-2xl rounded-2xl text-red-800 border border-white/30 z-20 animate-smooth-bounce"><i class="fas fa-dollar-sign text-3xl"></i></div>
    <div class="absolute top-[5%] left-[75%] p-4 bg-white/20 backdrop-blur-md shadow-2xl rounded-2xl text-red-800 border border-white/30 z-20 animate-smooth-bounce"><i class="fas fa-save text-3xl"></i></div>
    <div class="absolute top-[30%] right-[30%] p-4 bg-white/20 backdrop-blur-md shadow-2xl rounded-2xl text-red-800 border border-white/30 z-20 animate-smooth-bounce"><i class="fas fa-money-bill-wave text-3xl"></i></div>

    <div class="relative h-full flex items-end justify-end self-end z-0">
        <img src="assets/images/landing_illu.png" alt="M Lhuillier Team Illustration" class="h-auto w-auto max-h-full" id="illustration">
    </div>
</div>

<script>
    function showLogin() {
        const title = document.getElementById('gl-title');
        const subtitle = document.getElementById('gl-subtitle');
        const triggerBtn = document.getElementById('btn-login-trigger');
        const loginForm = document.getElementById('login-form');
        const headerGroup = document.getElementById('header-group');

        title.classList.replace('text-8xl', 'text-4xl');
        subtitle.classList.replace('text-2xl', 'text-base');
        
        headerGroup.classList.replace('-mt-35', 'mt-0');
        triggerBtn.style.display = 'none'; 
        
        loginForm.classList.remove('hidden');
        setTimeout(() => { loginForm.classList.remove('opacity-0'); }, 50);
    }

    function hideLogin() {
        const title = document.getElementById('gl-title');
        const subtitle = document.getElementById('gl-subtitle');
        const triggerBtn = document.getElementById('btn-login-trigger');
        const loginForm = document.getElementById('login-form');
        const headerGroup = document.getElementById('header-group');

        loginForm.classList.add('opacity-0');
        setTimeout(() => {
            loginForm.classList.add('hidden');
            
            title.classList.replace('text-4xl', 'text-8xl');
            subtitle.classList.replace('text-base', 'text-2xl');
            
            headerGroup.classList.replace('mt-0', '-mt-35');
            triggerBtn.style.display = 'inline-block'; 
        }, 500);
    }

    function togglePassword() {
        const passwordInput = document.getElementById('password-input');
        const eyeIcon = document.getElementById('eye-icon');
        
        if (passwordInput.type === "password") {
            passwordInput.type = "text";
            eyeIcon.classList.remove('fa-eye');
            eyeIcon.classList.add('fa-eye-slash');
        } else {
            passwordInput.type = "password";
            eyeIcon.classList.remove('fa-eye-slash');
            eyeIcon.classList.add('fa-eye');
        }
    }
</script>