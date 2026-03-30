<x-layout title="Tous les signalements - Stop Arnaque 974">
    <div class="max-w-6xl mx-auto px-4 py-10">

        <div class="flex flex-col md:flex-row justify-between items-center mb-8 gap-4">
            <h1 class="text-3xl font-bold text-slate-900">
                🚨 Tous les signalements
            </h1>

            <form action="{{ route('scams.index') }}" method="GET" class="w-full md:w-auto flex gap-2">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Chercher un numéro..." class="rounded-lg border-gray-300 shadow-sm focus:border-red-500 focus:ring-red-500">
                <button type="submit" class="bg-slate-900 text-white px-4 py-2 rounded-lg hover:bg-slate-700">🔍</button>
            </form>
        </div>

        @if(request('search'))
            <div class="mb-6 p-4 bg-yellow-50 text-yellow-800 rounded-lg flex justify-between items-center">
                <span>Résultats pour : <strong>"{{ request('search') }}"</strong></span>
                <a href="{{ route('scams.index') }}" class="text-sm underline hover:text-red-600">Effacer</a>
            </div>
        @endif

        <div class="grid md:grid-cols-3 gap-6">
            @foreach($scams as $scam)
                <article class="bg-white p-6 rounded-xl shadow-sm hover:shadow-md transition border border-gray-100 flex flex-col h-full">
                    <div class="flex justify-between items-start mb-3">
                        <span class="px-3 py-1 text-xs font-bold uppercase tracking-wider rounded-full
                            {{ $scam->type == 'ransomware' ? 'bg-red-100 text-red-700' : 'bg-blue-100 text-blue-700' }}">
                            {{ $scam->type }}
                        </span>
                        <span class="text-xs text-gray-400">{{ $scam->created_at->format('d/m/Y') }}</span>
                    </div>

                    <h4 class="text-lg font-bold mb-2 line-clamp-2">{{ $scam->title }}</h4>
                    <p class="text-gray-600 text-sm line-clamp-3 mb-4 grow">
                        {{ $scam->description }}
                    </p>

                    @if($scam->scammer_phone)
                        <div class="bg-gray-50 p-2 rounded text-xs font-mono text-red-700 mb-4">
                            📞 {{ $scam->scammer_phone }}
                        </div>
                    @endif

                    <a href="{{ route('scam.show', $scam) }}" class="text-red-600 font-medium text-sm hover:underline mt-auto">
                        Voir le détail &rarr;
                    </a>
                </article>
            @endforeach
        </div>

        <div class="mt-10">
            {{ $scams->withQueryString()->links() }}
        </div>

        @if($scams->isEmpty())
            <div class="text-center py-20 text-gray-500">
                Aucun signalement trouvé pour cette recherche.
            </div>
        @endif
    </div>
</x-layout>
