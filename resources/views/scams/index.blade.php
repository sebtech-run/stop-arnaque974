<x-layout title="Tous les signalements - Stop Arnaque 974">
    <div class="max-w-6xl mx-auto px-4 py-10">

        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-6">

            <div>
                <h1 class="text-3xl font-bold text-slate-900 mb-2">
                    🚨 Tous les signalements
                </h1>
                <p class="text-slate-600 text-sm md:text-base">
                    Consultez la liste des arnaques ou alertez la communauté.
                </p>
            </div>

            <div class="w-full md:w-auto flex flex-col sm:flex-row gap-3">
                <a href="{{ route('scam.create') }}" class="flex justify-center items-center gap-2 bg-red-600 text-white px-5 py-2.5 rounded-lg font-bold hover:bg-red-700 transition shadow-sm whitespace-nowrap">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                    </svg>
                    Signaler
                </a>

                <form action="{{ route('scams.index') }}" method="GET" class="flex gap-2 w-full sm:w-auto">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Chercher un numéro..." class="w-full sm:w-auto rounded-lg border-gray-300 shadow-sm focus:border-red-500 focus:ring-red-500">
                    <button type="submit" class="bg-slate-900 text-white px-4 py-2 rounded-lg hover:bg-slate-700 transition">🔍</button>
                </form>
            </div>

        </div>

        @if(request('search'))
            <div class="mb-6 p-4 bg-yellow-50 text-yellow-800 rounded-lg flex justify-between items-center shadow-sm border border-yellow-100">
                <span>Résultats pour : <strong>"{{ request('search') }}"</strong></span>
                <a href="{{ route('scams.index') }}" class="text-sm font-bold underline hover:text-red-600 transition">Effacer la recherche</a>
            </div>
        @endif

        <div class="grid md:grid-cols-3 gap-6">
            @foreach($scams as $scam)
                <article class="bg-white rounded-xl shadow-sm hover:shadow-md transition border border-gray-100 flex flex-col h-full overflow-hidden">

                     <div class="aspect-video w-full bg-slate-100 border-b border-gray-100 overflow-hidden relative">
                        @php
                            $preuves = is_string($scam->evidence_paths) ? json_decode($scam->evidence_paths, true) : $scam->evidence_paths;
                        @endphp

                        @if(!empty($preuves) && is_array($preuves) && count($preuves) > 0)
                            <img src="{{ Storage::url($preuves[0]) }}"
                                alt="{{ $scam->title }}"
                                class="w-full h-full object-cover hover:scale-105 transition-transform duration-300">
                        @else
                            <img src="{{ asset('images/stop-arnaque974-img-default.png') }}"
                                alt="Stop Arnaque 974"
                                class="w-full h-full object-cover opacity-60 hover:scale-105 transition-transform duration-300">
                            <span class="absolute bottom-2 right-2 bg-white/80 backdrop-blur-sm text-slate-600 text-[10px] px-2 py-1 rounded font-medium shadow-sm">
                                Image d'illustration
                            </span>
                        @endif
                    </div>

                    <div class="p-6 flex flex-col grow">
                        <div class="flex justify-between items-start mb-3">
                            <span class="px-3 py-1 text-[10px] font-bold uppercase tracking-wider rounded-full
                                {{ $scam->type == 'ransomware' ? 'bg-red-50 text-red-700 border border-red-100' : 'bg-blue-50 text-blue-700 border border-blue-100' }}">
                                {{ $scam->type }}
                            </span>
                            <span class="text-xs text-gray-400 font-medium">{{ $scam->created_at->format('d/m/Y') }}</span>
                        </div>

                        <h4 class="text-lg font-bold mb-2 line-clamp-2 text-slate-900">{{ $scam->title }}</h4>
                        <p class="text-gray-600 text-sm line-clamp-3 mb-4 grow">
                            {{ $scam->description }}
                        </p>

                        @if($scam->scammer_phone)
                            <div class="bg-gray-50 p-2 rounded text-xs font-mono font-bold text-red-700 mb-4 border border-gray-100 inline-block w-fit">
                                📞 {{ $scam->scammer_phone }}
                            </div>
                        @endif

                        <a href="{{ route('scam.show', $scam) }}" class="text-red-600 font-bold text-sm hover:text-red-800 transition mt-auto flex items-center gap-1">
                            Voir le détail
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4">
                                <path fill-rule="evenodd" d="M3 10a.75.75 0 01.75-.75h10.638L10.23 5.29a.75.75 0 111.04-1.08l5.5 5.25a.75.75 0 010 1.08l-5.5 5.25a.75.75 0 11-1.04-1.08l4.158-3.96H3.75A.75.75 0 013 10z" clip-rule="evenodd" />
                            </svg>
                        </a>
                    </div>
                </article>
            @endforeach
        </div>

        <div class="mt-10">
            {{ $scams->withQueryString()->links() }}
        </div>

        @if($scams->isEmpty())
            <div class="text-center py-16 px-4 bg-white rounded-xl shadow-sm border border-gray-100 mt-6">
                <div class="text-4xl mb-4">🕵️‍♂️</div>
                <h3 class="text-xl font-bold text-slate-900 mb-2">Aucun signalement trouvé</h3>
                <p class="text-gray-500 mb-6 max-w-md mx-auto">
                    Nous n'avons trouvé aucune arnaque correspondant à votre recherche. Si vous avez été victime ou témoin d'une tentative de fraude, aidez les autres Réunionnais en la signalant.
                </p>
                <a href="{{ route('scam.create') }}" class="inline-flex justify-center items-center gap-2 bg-red-600 text-white px-6 py-3 rounded-lg font-bold hover:bg-red-700 transition shadow-md">
                    Signaler cette arnaque maintenant
                </a>
            </div>
        @endif
    </div>
</x-layout>
