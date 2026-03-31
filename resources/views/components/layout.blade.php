<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ $title ?? 'Stop Arnaque 974 - Prévention et Accompagnement Numérique à la Réunion' }}</title>
    <meta name="description" content="{{ $description ?? 'Plateforme citoyenne de recensement des arnaques à la Réunion. Découvrez également nos ateliers d\'accompagnement au numérique pour seniors et enfants.' }}">
    <link rel="canonical" href="{{ url()->current() }}">

    <meta property="og:title" content="{{ $title ?? 'Stop Arnaque 974 - Prévention & Numérique' }}" />
    <meta property="og:description" content="{{ $description ?? 'Ensemble contre les arnaques à la Réunion. Informez-vous et découvrez nos ateliers numériques.' }}" />
    <meta property="og:type" content="website" />
    <meta property="og:url" content="{{ url()->current() }}" />

    <meta property="og:image" content="{{ $ogImage ?? asset('images/stop-arnaque974-img-default.png') }}" />
    <meta property="og:locale" content="fr_FR" />

    <link rel="icon" type="image/png" href="{{ asset('favicon-96x96.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('favicon-96x96.png') }}">
    <meta name="theme-color" content="#ffffff">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 text-slate-800 flex flex-col min-h-screen font-sans">

    <div class="bg-slate-900 text-slate-300 text-xs py-2">
        <div class="max-w-6xl mx-auto px-4 flex justify-between items-center">
            <div class="flex items-center gap-4">
                <span class="font-bold text-white flex items-center gap-1">
                    🛡️ Initiative Citoyenne
                </span>
                <span class="hidden sm:inline text-slate-500">|</span>
                <span class="hidden sm:inline">Prévention & Ateliers Numériques à la Réunion</span>
            </div>
            <div>
                <a href="{{ route('pages.contact') }}" class="hover:text-white transition flex items-center gap-1">
                    Nous contacter / Nos services &rarr;
                </a>
            </div>
        </div>
    </div>

   <nav class="bg-white shadow-sm top-0 z-50 border-b border-gray-100 relative">
    <div class="max-w-6xl mx-auto px-4">
        <div class="flex justify-between items-center h-20">

            <div class="flex items-center">
                <a href="{{ route('home') }}" class="group">
                    <div class="text-2xl font-extrabold tracking-tight leading-none">
                        <span class="text-red-600">Stop</span>Arnaque<span class="text-slate-900">974</span>
                    </div>
                    <div class="text-[10px] uppercase font-bold text-gray-500 tracking-widest group-hover:text-red-600 transition">
                        Vigilance Océan Indien
                    </div>
                </a>
            </div>

            <div class="hidden md:flex items-center gap-2 lg:gap-6 text-sm font-medium">
                <a href="{{ route('home') }}" class="px-3 py-2 rounded-lg transition whitespace-nowrap {{ request()->routeIs('home') ? 'bg-indigo-50 text-indigo-700 font-bold' : 'text-gray-600 hover:text-slate-900 hover:bg-gray-50' }}">
                    🏠 Accueil
                </a>
                <a href="{{ route('scams.index') }}" class="px-3 py-2 rounded-lg transition whitespace-nowrap {{ request()->routeIs('scams.*') ? 'bg-indigo-50 text-indigo-700 font-bold' : 'text-gray-600 hover:text-slate-900 hover:bg-gray-50' }}">
                    🚨 Signalements
                </a>
                <a href="{{ route('posts.index') }}" class="px-3 py-2 rounded-lg transition whitespace-nowrap {{ request()->routeIs('posts.*') ? 'bg-indigo-50 text-indigo-700 font-bold' : 'text-gray-600 hover:text-slate-900 hover:bg-gray-50' }}">
                    🛡️ Conseils
                </a>
                <a href="{{ route('pages.contact') }}" class="px-3 py-2 rounded-lg transition whitespace-nowrap {{ request()->routeIs('pages.contact') ? 'bg-indigo-50 text-indigo-700 font-bold' : 'text-gray-600 hover:text-slate-900 hover:bg-gray-50' }}">
                    🤝 Contact & Ateliers
                </a>
                <a href="{{ route('scam.create') }}" class="ml-2 inline-flex items-center gap-2 bg-red-600 text-white px-5 py-2.5 rounded-lg font-bold hover:bg-red-700 transition shadow-md hover:shadow-lg transform hover:-translate-y-0.5 duration-200">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                    </svg>
                    Signaler
                </a>
            </div>

            <div class="md:hidden flex items-center">
                <button id="mobile-menu-btn" class="text-slate-600 hover:text-indigo-600 focus:outline-none p-2 rounded-lg hover:bg-slate-50 transition">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-8 h-8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <div id="mobile-menu" class="hidden md:hidden absolute top-20 left-0 w-full bg-white border-b border-gray-100 shadow-xl z-40">
        <div class="flex flex-col px-4 pt-2 pb-6 space-y-2">
            <a href="{{ route('home') }}" class="block px-4 py-3 rounded-lg transition {{ request()->routeIs('home') ? 'bg-indigo-50 text-indigo-700 font-bold' : 'text-gray-600 hover:text-slate-900 hover:bg-gray-50' }}">
                🏠 Accueil
            </a>
            <a href="{{ route('scams.index') }}" class="block px-4 py-3 rounded-lg transition {{ request()->routeIs('scams.*') ? 'bg-indigo-50 text-indigo-700 font-bold' : 'text-gray-600 hover:text-slate-900 hover:bg-gray-50' }}">
                🚨 Signalements
            </a>
            <a href="{{ route('posts.index') }}" class="block px-4 py-3 rounded-lg transition {{ request()->routeIs('posts.*') ? 'bg-indigo-50 text-indigo-700 font-bold' : 'text-gray-600 hover:text-slate-900 hover:bg-gray-50' }}">
                🛡️ Conseils & Prévention
            </a>
            <a href="{{ route('pages.contact') }}" class="block px-4 py-3 rounded-lg transition {{ request()->routeIs('pages.contact') ? 'bg-indigo-50 text-indigo-700 font-bold' : 'text-gray-600 hover:text-slate-900 hover:bg-gray-50' }}">
                🤝 Contact & Ateliers
            </a>
            <a href="{{ route('scam.create') }}" class="mt-4 flex justify-center items-center gap-2 w-full bg-red-600 text-white px-4 py-3 rounded-lg font-bold shadow-sm hover:bg-red-700">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                </svg>
                Signaler une arnaque
            </a>
        </div>
    </div>
</nav>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const btn = document.getElementById('mobile-menu-btn');
        const menu = document.getElementById('mobile-menu');

        btn.addEventListener('click', function () {
            menu.classList.toggle('hidden');
        });
    });
</script>

    <main class="grow">
        {{ $slot }}
    </main>

    <footer class="bg-white border-t mt-auto">
        <div class="max-w-6xl mx-auto px-4 py-10">
            <div class="grid md:grid-cols-4 gap-8">
                <div class="col-span-1 md:col-span-2">
                    <div class="text-xl font-bold text-slate-900 mb-4">StopArnaque<span class="text-red-600">974</span></div>
                    <p class="text-gray-500 text-sm leading-relaxed mb-4">
                        Une plateforme citoyenne gratuite pour lutter contre la cybercriminalité à la Réunion.<br><br>
                        Ce service solidaire est propulsé par <strong>Kartié-Connect</strong>, votre partenaire local pour l'accompagnement et les ateliers numériques.
                    </p>
                    <div class="flex gap-4">
                        <a href="#" class="text-gray-400 hover:text-blue-600 transition">Facebook</a>
                        <a href="#" class="text-gray-400 hover:text-blue-400 transition">Twitter / X</a>
                    </div>
                </div>

                <div>
                    <h4 class="font-bold text-slate-900 mb-4">La Plateforme</h4>
                    <ul class="space-y-2 text-sm text-gray-600">
                        <li><a href="{{ route('home') }}" class="hover:text-red-600">Derniers signalements</a></li>
                        <li><a href="{{ route('posts.index') }}" class="hover:text-red-600">Blog Prévention</a></li>
                        <li><a href="https://www.cybermalveillance.gouv.fr/" target="_blank" rel="nofollow" class="hover:text-red-600">Cybermalveillance.gouv.fr</a></li>
                    </ul>
                </div>

                <div>
                    <h4 class="font-bold text-slate-900 mb-4">Nos Services</h4>
                    <ul class="space-y-2 text-sm text-gray-600">
                        <li><a href="{{ route('pages.contact') }}" class="hover:text-blue-600 font-medium">💻 Découvrir nos Ateliers</a></li>
                        <li><a href="{{ route('pages.contact') }}" class="hover:text-red-600">Nous contacter</a></li>
                        <li><a href="{{ route('pages.legal') }}" class="hover:text-red-600">Mentions Légales</a></li>
                    </ul>
                </div>
            </div>

            <div class="border-t border-gray-100 mt-10 pt-6 text-center text-xs text-gray-400">
                &copy; {{ date('Y') }} Stop-Arnaque974, un service gratuit proposé par <strong>Kartié-Connect</strong>. Tous droits réservés. <br>
                Développé avec ❤️ à la Réunion.
            </div>
        </div>
    </footer>

</body>
</html>
