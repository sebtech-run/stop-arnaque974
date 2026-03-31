<x-layout>

    @if(session('success'))
        <div class="bg-green-50 border-b border-green-200 text-green-800 px-4 py-3 text-center text-sm font-medium">
            ✅ {{ session('success') }}
        </div>
    @endif

    <div class="bg-slate-50 py-16 px-4 text-center border-b border-gray-100">
        <h2 class="text-4xl md:text-5xl font-extrabold text-slate-900 mb-4 tracking-tight">Ne vous faites plus avoir.</h2>
        <p class="text-lg text-slate-600 mb-8 max-w-2xl mx-auto">Plateforme citoyenne de recensement des arnaques et fraudes à la Réunion.</p>

        <form action="{{ route('scams.index') }}" method="GET" class="max-w-2xl mx-auto flex flex-col sm:flex-row gap-3">
            <input type="text"
                   name="search"
                   value="{{ request('search') }}"
                   placeholder="Rechercher un numéro, un site, un nom..."
                   class="w-full px-5 py-4 rounded-xl border border-gray-200 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-100 text-slate-900 shadow-sm transition text-lg">

            <button type="submit" class="bg-red-600 text-white px-8 py-4 rounded-xl font-bold hover:bg-red-700 transition shadow-md whitespace-nowrap flex items-center justify-center gap-2 text-lg">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                </svg>
                Vérifier
            </button>
        </form>

        @if(request('search'))
            <div class="mt-6 text-slate-700">
                <h2 class="text-lg">Résultats pour : <strong>"{{ request('search') }}"</strong></h2>
                <a href="{{ route('home') }}" class="text-indigo-600 font-medium text-sm hover:underline mt-2 inline-block">Effacer la recherche</a>
            </div>
        @endif
    </div>

    <section class="bg-white py-12 border-b border-gray-100">
        <div class="max-w-5xl mx-auto px-4">
            <div class="text-center mb-10">
                <h2 class="text-2xl font-bold text-slate-900">Une communauté vigilante à la Réunion</h2>
                <p class="text-gray-500 mt-2">La plateforme StopArnaque974 repose sur l'entraide citoyenne :</p>
            </div>

            <div class="grid md:grid-cols-3 gap-8 text-center">
                <div class="p-4">
                    <div class="w-16 h-16 bg-indigo-50 text-indigo-600 rounded-full flex items-center justify-center mx-auto mb-4 text-2xl shadow-sm border border-indigo-100">📢</div>
                    <h3 class="font-bold text-lg mb-2 text-slate-900">1. Vous signalez</h3>
                    <p class="text-sm text-gray-600">Vous recevez un SMS suspect ou voyez une pub bizarre ? Postez-le anonymement via notre formulaire.</p>
                </div>

                <div class="p-4">
                    <div class="w-16 h-16 bg-indigo-50 text-indigo-600 rounded-full flex items-center justify-center mx-auto mb-4 text-2xl shadow-sm border border-indigo-100">🛡️</div>
                    <h3 class="font-bold text-lg mb-2 text-slate-900">2. Nous vérifions</h3>
                    <p class="text-sm text-gray-600">Chaque signalement est analysé par un modérateur pour éviter les faux positifs et la diffamation.</p>
                </div>

                <div class="p-4">
                    <div class="w-16 h-16 bg-indigo-50 text-indigo-600 rounded-full flex items-center justify-center mx-auto mb-4 text-2xl shadow-sm border border-indigo-100">✅</div>
                    <h3 class="font-bold text-lg mb-2 text-slate-900">3. L'île est protégée</h3>
                    <p class="text-sm text-gray-600">Une fois validée, l'arnaque est visible par tous. Le numéro ou site est référencé pour protéger les autres.</p>
                </div>
            </div>
        </div>
    </section>

    <main class="max-w-5xl mx-auto px-4 py-12 grow w-full">
        <h3 class="text-xl font-bold mb-8 flex items-center gap-2 text-slate-900">
            <span class="w-2 h-8 bg-red-600 rounded-full"></span>
            Derniers signalements à la Réunion
        </h3>

        @if($scams->isEmpty())
            <div class="text-center py-12 text-gray-500 bg-white rounded-xl shadow-sm border border-gray-100">
                Aucune arnaque signalée pour le moment. Restez vigilants !
            </div>
        @else
            <div class="grid md:grid-cols-2 gap-6 mb-8">
                @foreach($scams as $scam)

                    <article class="bg-white rounded-xl shadow-sm hover:shadow-md transition border border-gray-100 flex flex-col h-full group overflow-hidden">

                        <div class="aspect-video w-full bg-slate-100 border-b border-gray-100 overflow-hidden relative">

                            @php
                                // ON UTILISE LE BON NOM : evidence_paths
                                $preuves = is_string($scam->evidence_paths) ? json_decode($scam->evidence_paths, true) : $scam->evidence_paths;
                            @endphp

                            @if(!empty($preuves) && is_array($preuves) && count($preuves) > 0)
                                <img src="{{ Storage::url($preuves[0]) }}"
                                    alt="{{ $scam->title }}"
                                    class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">

                            @else
                                <img src="{{ asset('images/stop-arnaque974-img-default.png') }}"
                                    alt="Stop Arnaque 974"
                                    class="w-full h-full object-cover opacity-60 group-hover:scale-105 transition-transform duration-300">

                                <span class="absolute bottom-2 right-2 bg-white/80 backdrop-blur-sm text-slate-600 text-[10px] px-2 py-1 rounded font-medium shadow-sm">
                                    Image d'illustration
                                </span>
                            @endif

                        </div>

                        <div class="p-6 flex flex-col grow">
                            <div class="flex justify-between items-start mb-4">
                                <span class="px-3 py-1 text-xs font-bold uppercase tracking-wider rounded-full
                                    {{ $scam->type == 'ransomware' ? 'bg-red-50 text-red-700 border border-red-100' : 'bg-indigo-50 text-indigo-700 border border-indigo-100' }}">
                                    {{ $scam->type }}
                                </span>
                                <span class="text-xs text-gray-400 font-medium">{{ $scam->created_at->format('d/m/Y') }}</span>
                            </div>

                            <h4 class="text-lg font-bold mb-2 text-slate-900 group-hover:text-red-600 transition">{{ $scam->title }}</h4>
                            <p class="text-gray-600 text-sm line-clamp-2 mb-4 grow">
                                {{ Str::limit($scam->description, 100) }}
                            </p>

                            @if($scam->scammer_phone || $scam->scammer_url)
                                <div class="bg-slate-50 p-3 rounded-lg text-sm mb-4 border border-slate-100">
                                    @if($scam->scammer_phone)
                                        <div class="flex items-center gap-2 text-red-700 font-mono mb-1 truncate">
                                            📞 {{ $scam->scammer_phone }}
                                        </div>
                                    @endif
                                    @if($scam->scammer_url)
                                        <div class="flex items-center gap-2 text-indigo-700 font-mono truncate">
                                            🔗 {{ Str::limit($scam->scammer_url, 30) }}
                                        </div>
                                    @endif
                                </div>
                            @endif

                            <div class="mt-auto pt-4 border-t border-gray-50">
                                <a href="{{ route('scam.show', $scam->slug) }}" class="text-red-600 font-bold text-sm hover:text-red-800 flex items-center gap-1 transition">
                                    Voir le détail <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4"><path fill-rule="evenodd" d="M3 10a.75.75 0 01.75-.75h10.638L10.23 5.29a.75.75 0 111.04-1.08l5.5 5.25a.75.75 0 010 1.08l-5.5 5.25a.75.75 0 11-1.04-1.08l4.158-3.96H3.75A.75.75 0 013 10z" clip-rule="evenodd" /></svg>
                                </a>
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>

            <div class="text-center mt-12 mb-8">
                <a href="{{ route('scams.index') }}" class="inline-flex items-center gap-2 bg-white text-slate-900 border border-slate-200 font-bold px-8 py-3 rounded-full hover:border-slate-300 hover:bg-slate-50 transition shadow-sm">
                    Voir tous les signalements
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17.25 8.25L21 12m0 0l-3.75 3.75M21 12H3" />
                    </svg>
                </a>
                <a href="{{ route('scam.create') }}" class="inline-flex items-center gap-2 bg-red-600 text-white font-bold px-8 py-3 rounded-full hover:bg-red-700 transition shadow-sm ml-4">
                    Signaler une arnaque
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                </a>
            </div>
        @endif
    </main>

     <section class="bg-indigo-50/50 py-12 border-b border-indigo-100/50">
        <div class="max-w-5xl mx-auto px-4 flex flex-col md:flex-row items-center gap-8">
            <div class="md:w-2/3">
                <span class="text-indigo-600 font-bold tracking-wider uppercase text-sm mb-2 block">💡 Un service citoyen par Kartié-Connect</span>
                <h2 class="text-3xl font-extrabold text-slate-900 mb-4">Besoin d'aide pour maîtriser le numérique ?</h2>
                <p class="text-gray-600 mb-6 text-lg leading-relaxed">
                    <strong>StopArnaque974</strong> est une initiative 100% gratuite, créée et soutenue par notre entreprise locale <strong>Kartié-Connect</strong>.<br><br>
                    Parce que la prévention passe avant tout par la maîtrise des outils, Kartié-Connect propose des <strong>ateliers d'accompagnement numérique</strong>. Que ce soit pour les seniors souhaitant gagner en autonomie ou pour sensibiliser les plus jeunes, nous vous accompagnons pas à pas partout à la Réunion.
                </p>
                <a href="{{ route('pages.contact') }}" class="inline-flex items-center gap-2 bg-indigo-600 text-white px-6 py-3 rounded-lg font-bold hover:bg-indigo-700 transition shadow-md">
                    Découvrir les ateliers Kartié-Connect &rarr;
                </a>

            </div>
            <div class="md:w-1/3 flex justify-center">
                <div class="text-8xl drop-shadow-sm">🧑‍💻</div>
            </div>
        </div>
    </section>
</x-layout>
