<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login Pegawai | E-Archive PN Bale Bandung</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600,700,800&display=swap" rel="stylesheet" />
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { font-family: 'Figtree', sans-serif; }
        /* Background ala Netflix (bisa diganti foto gedung pengadilan pakai url) */
        .bg-login-cover {
            background-color: #022c22; /* Warna hijau sangat gelap */
            background-image: radial-gradient(circle at center, #064e3b 0%, #022c22 100%);
            /* Kalau mau pakai foto background, hapus komen di bawah dan atur url-nya: */
            /* background-image: linear-gradient(rgba(2, 44, 34, 0.8), rgba(2, 44, 34, 0.9)), url('/images/gedung-pnbb.jpg'); */
            /* background-size: cover; background-position: center; */
        }
    </style>
</head>
<body class="antialiased bg-login-cover min-h-screen flex items-center justify-center p-4">

    <div class="bg-white w-full max-w-md rounded-[2rem] shadow-2xl overflow-hidden relative border border-emerald-50">
        
        <div class="h-2 w-full bg-gradient-to-r from-emerald-400 to-emerald-700"></div>

        <div class="p-10">
            <div class="text-center mb-8">
                <img src="{{ asset('images/logo-pnbb.jpg') }}" alt="Logo PN Bale Bandung" class="h-20 w-auto mx-auto mb-4 drop-shadow-md">
                <h1 class="text-2xl font-black text-emerald-900 tracking-tight">LOGIN PEGAWAI</h1>
                <p class="text-xs font-bold text-amber-600 tracking-widest uppercase mt-1">E-Archive PN Bale Bandung</p>
            </div>

            <form method="POST" action="{{ route('login') }}" class="space-y-6">
                @csrf

                <div>
                    <label for="email" class="block text-[10px] font-black text-emerald-800 uppercase tracking-widest mb-2">Alamat Email</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                        placeholder="nama@pn-balebandung.go.id"
                        class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 bg-gray-50 focus:bg-white focus:border-emerald-500 focus:ring-0 transition-colors text-sm font-medium outline-none">
                    @error('email')
                        <span class="text-red-500 text-xs font-bold mt-1 block">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label for="password" class="block text-[10px] font-black text-emerald-800 uppercase tracking-widest mb-2">Kata Sandi</label>
                    <div class="relative">
                        <input id="password" type="password" name="password" required
                            placeholder="••••••••"
                            class="w-full pl-4 pr-12 py-3 rounded-xl border-2 border-gray-200 bg-gray-50 focus:bg-white focus:border-emerald-500 focus:ring-0 transition-colors text-sm font-medium outline-none">
                        
                        <button type="button" onclick="togglePassword()" class="absolute inset-y-0 right-0 px-4 flex items-center text-gray-400 hover:text-emerald-600 transition-colors focus:outline-none">
                            <svg id="eye-closed" class="w-5 h-5 block" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18" />
                            </svg>
                            <svg id="eye-open" class="w-5 h-5 hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                        </button>
                    </div>
                </div>

                <div class="flex items-center justify-between mt-4">
                    <label class="flex items-center gap-2 cursor-pointer group">
                        <input type="checkbox" name="remember" class="w-4 h-4 rounded border-gray-300 text-emerald-600 focus:ring-emerald-500 cursor-pointer">
                        <span class="text-[11px] font-bold text-gray-500 uppercase tracking-wide group-hover:text-emerald-700 transition">Ingat Saya</span>
                    </label>

                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="text-[11px] font-bold text-emerald-600 hover:text-emerald-800 uppercase tracking-wide transition">
                            Lupa Sandi?
                        </a>
                    @endif
                </div>

                <button type="submit" class="w-full mt-6 py-3.5 px-4 border border-transparent rounded-xl shadow-lg shadow-emerald-200 text-sm font-black text-white bg-emerald-700 hover:bg-emerald-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 transition-all uppercase tracking-widest transform active:scale-95">
                    Masuk Ke Sistem
                </button>
            </form>

            <div class="mt-8 text-center">
                <a href="{{ url('/') }}" class="inline-flex items-center gap-1.5 text-[10px] font-bold text-gray-400 hover:text-gray-600 uppercase tracking-widest transition group">
                    <svg class="w-3 h-3 transform group-hover:-translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Kembali Ke Beranda Publik
                </a>
            </div>
        </div>
        
        <div class="bg-gray-50 py-4 text-center border-t border-gray-100">
            <p class="text-[9px] font-black text-gray-400 uppercase tracking-widest">&copy; SUPPORT BY DIGITECH UNIVERSITY
            </p>
        </div>
    </div>

    <script>
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const eyeClosed = document.getElementById('eye-closed');
            const eyeOpen = document.getElementById('eye-open');

            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                eyeClosed.classList.add('hidden');
                eyeClosed.classList.remove('block');
                eyeOpen.classList.remove('hidden');
                eyeOpen.classList.add('block');
            } else {
                passwordInput.type = 'password';
                eyeClosed.classList.remove('hidden');
                eyeClosed.classList.add('block');
                eyeOpen.classList.add('hidden');
                eyeOpen.classList.remove('block');
            }
        }
    </script>
</body>
</html>