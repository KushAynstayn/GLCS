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

    /* Underline effect for Get Started */
    .btn-underline {
        position: relative;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        color: white;
        font-weight: bold;
        text-decoration: none;
        transition: color 0.3s ease;
    }

    .btn-underline::after {
        content: '';
        position: absolute;
        width: 0;
        height: 2px;
        bottom: -4px;
        left: 0;
        background-color: white;
        transition: width 0.3s ease-in-out;
    }

    .btn-underline:hover::after {
        width: 100%;
    }

    /* Arrow nudge animation on hover */
    .btn-underline:hover i {
        transform: translateX(5px);
        transition: transform 0.3s ease;
    }
</style>

<div class="relative w-full flex-1 bg-cover bg-center bg-no-repeat flex items-center justify-between" 
     style="background-image: url('assets/images/landing_bg.png'); min-height: calc(100vh - 64px);">
    
    <div id="content-container" class="z-10 pl-20 transition-all duration-700 ease-in-out">
        
        <div id="header-group" class="transition-all duration-700 ease-in-out -mt-35">
            <h1 id="gl-title" class="text-8xl font-bold font-league-spartan text-white drop-shadow-[0_4px_4px_rgba(0,0,0,0.5)] leading-none transition-all duration-500">
                GENERAL<br>LEDGER
            </h1>
            <h2 id="gl-subtitle" class="text-2xl font-poppins text-white tracking-widest mt-0 transition-all duration-500">
                CONSOLIDATED SYSTEM
            </h2>
            
            <button id="btn-login-trigger" onclick="showLogin()" class="btn-underline mt-10 text-l tracking-widest uppercase focus:outline-none">
                <span>GET STARTED</span>
                <i class="fas fa-arrow-right text-lg transition-transform duration-300"></i>
            </button>
        </div>

        <div id="login-form" class="hidden opacity-0 transition-opacity duration-700 mt-8 w-[350px] flex-shrink-0">
            <form id="loginForm" class="space-y-4">
                <input type="text" name="username" placeholder="USERNAME"
                class="w-full px-6 py-4 border border-white/50 bg-white/10 rounded-full text-white text-center placeholder:text-white/70 focus:outline-none focus:bg-white/20 transition-all uppercase" required>
                
                <div class="relative w-full">
                    <input type="password" id="password-input" name="password" placeholder="PASSWORD" class="w-full px-6 py-4 border border-white/50 bg-white/10 rounded-full text-white text-center placeholder:text-white/70 focus:outline-none focus:bg-white/20 transition-all" required>
                    <button type="button" onclick="toggleLoginPassword()" class="absolute right-5 top-1/2 transform -translate-y-1/2 text-white/70 hover:text-white focus:outline-none">
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

    <div class="absolute top-[4%] right-[3%] p-4 bg-[#a61e22] backdrop-blur-md shadow-2xl rounded-2xl text-white border border-white/30 z-20 animate-smooth-bounce">
        <i class="fas fa-book-open text-3xl"></i>
    </div>

    <div class="absolute top-[8%] left-[60%] p-4 bg-[#a61e22] backdrop-blur-md shadow-2xl rounded-2xl text-white border border-white/30 z-20 animate-smooth-bounce">
        <i class="fas fa-peso-sign text-3xl"></i>
    </div>

    <div class="absolute top-[50%] left-[53%] p-4 bg-[#a61e22] backdrop-blur-md shadow-2xl rounded-2xl text-white border border-white/30 z-20 animate-smooth-bounce">
        <i class="fas fa-dollar-sign text-3xl"></i>
    </div>

    <div class="absolute top-[75%] left-[59%] p-4 bg-[#a61e22] backdrop-blur-md shadow-2xl rounded-2xl text-white border border-white/30 z-20 animate-smooth-bounce">
        <i class="fas fa-wallet text-3xl"></i>
    </div>

    <div class="absolute top-[13%] left-[78%] p-4 bg-[#a61e22] backdrop-blur-md shadow-2xl rounded-2xl text-white border border-white/30 z-20 animate-smooth-bounce">
        <i class="fas fa-save text-3xl"></i>
    </div>

    <div class="absolute top-[30%] right-[31%] p-4 bg-[#a61e22] backdrop-blur-md shadow-2xl rounded-2xl text-white border border-white/30 z-20 animate-smooth-bounce">
        <i class="fas fa-money-bill-wave text-3xl"></i>
    </div>

    <div class="relative h-full w-[38%] flex items-end justify-end self-end z-0">
        <img src="assets/images/landing_illu.png" 
            alt="M Lhuillier Team Illustration" 
            class="h-auto w-full max-w-[110%] object-contain origin-bottom-right scale-110" 
            id="illustration">
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
        }, 50);
    }

    window.toggleLoginPassword = function () {
        const input = document.getElementById('password-input');
        const icon = document.getElementById('eye-icon');

        if (!input || !icon) return;

        const isHidden = input.type === "password";

        input.type = isHidden ? "text" : "password";

        icon.classList.toggle('fa-eye', !isHidden);
        icon.classList.toggle('fa-eye-slash', isHidden);
    };


    document.getElementById("loginForm").addEventListener("submit", async function(e) {
        e.preventDefault();

        const formData = new FormData(this);

        const res = await fetch("index.php?api=1&action=login", {
            method: "POST",
            body: formData
        });

        const data = await res.json();

        console.log(data);

        if (data.ok) {

            if (data.force_password_change) {
                if (typeof showForcePasswordModal === "function") {
                    showForcePasswordModal();
                } else {
                    console.error("Modal not loaded yet");
                }
            } else {
                window.location.href = data.redirect;
            }

        } else {
            alert(data.message);
        }
    });

</script>