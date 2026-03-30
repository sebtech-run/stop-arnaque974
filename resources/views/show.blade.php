<x-layout>

    <main class="max-w-4xl mx-auto px-4 py-10">

        <article class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="p-8 border-b border-gray-100 bg-slate-50">
                <div class="flex flex-wrap gap-2 mb-4">
                    <span class="px-3 py-1 text-xs font-bold uppercase tracking-wider rounded-full bg-red-100 text-red-700">
                        {{ $scam->type }}
                    </span>
                    <span class="text-gray-500 text-sm flex items-center">
                        Publié le {{ $scam->created_at->format('d/m/Y à H:i') }}
                    </span>
                </div>
                <h1 class="text-3xl font-extrabold text-slate-900 mb-2">{{ $scam->title }}</h1>
            </div>

            <div class="p-8 grid md:grid-cols-3 gap-8">
                <div class="md:col-span-2 space-y-6">
                    <div>
                        <h3 class="font-bold text-lg mb-2">Que s'est-il passé ?</h3>
                        <div class="prose text-gray-700 whitespace-pre-wrap leading-relaxed">
                            {{ $scam->description }}
                        </div>
                    </div>

                    @if($scam->evidence_paths && count($scam->evidence_paths) > 0)
                        <div>
                            <h3 class="font-bold text-lg mb-4">Preuves / Captures d'écran</h3>
                            <div class="grid grid-cols-2 gap-4">
                                @foreach($scam->evidence_paths as $path)
                                    <a href="{{ asset('storage/' . $path) }}" target="_blank" class="block group relative overflow-hidden rounded-lg border">
                                        <img src="{{ asset('storage/' . $path) }}" class="w-full h-48 object-cover group-hover:scale-105 transition duration-300">
                                        <div class="absolute inset-0 bg-black/50 flex items-center justify-center opacity-0 group-hover:opacity-100 transition">
                                            <span class="text-white text-sm font-bold">Voir en grand 🔍</span>
                                        </div>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>

                <div class="space-y-6">
                    <div class="bg-red-50 p-6 rounded-xl border border-red-100">
                        <h3 class="font-bold text-red-800 mb-4 border-b border-red-200 pb-2">Identifiants signalés</h3>

                        @if(!$scam->scammer_phone && !$scam->scammer_email && !$scam->scammer_url)
                            <p class="text-sm text-gray-500 italic">Aucune donnée technique fournie.</p>
                        @endif

                        <ul class="space-y-4">
                            @if($scam->scammer_phone)
                            <li>
                                <span class="text-xs font-bold text-gray-500 uppercase block">Téléphone</span>
                                <span class="text-lg font-mono font-bold text-slate-900">{{ $scam->scammer_phone }}</span>
                            </li>
                            @endif

                            @if($scam->scammer_email)
                            <li>
                                <span class="text-xs font-bold text-gray-500 uppercase block">Email</span>
                                <span class="text-sm font-mono text-slate-900 break-all">{{ $scam->scammer_email }}</span>
                            </li>
                            @endif

                            @if($scam->scammer_url)
                            <li>
                                <span class="text-xs font-bold text-gray-500 uppercase block">Site Web</span>
                                <a href="{{ $scam->scammer_url }}" rel="nofollow" target="_blank" class="text-sm font-mono text-blue-600 hover:underline break-all">
                                    {{ Str::limit($scam->scammer_url, 40) }}
                                </a>
                                <div class="text-[10px] text-red-500 mt-1">⚠️ Ne cliquez pas si vous avez un doute.</div>
                            </li>
                            @endif
                        </ul>
                    </div>

                    <div class="bg-blue-50 p-6 rounded-xl border border-blue-100 text-sm text-blue-800">
                        <strong>Conseil de sécurité :</strong><br>
                        Ne communiquez jamais vos codes bancaires ou mots de passe par SMS ou email.
                    </div>
                </div>
            </div>
        </article>

        @if($otherScams->count() > 0)
        <div class="mt-16 pt-10 border-t border-gray-200">
            <h2 class="text-2xl font-bold text-slate-900 mb-6 flex items-center gap-2">
                <span class="text-red-600">⚠️</span>
                Derniers signalements vérifiés
            </h2>

            <div class="grid md:grid-cols-3 gap-6">
                @foreach($otherScams as $other)
                    <a href="{{ route('scam.show', $other) }}" class="group block bg-white rounded-lg shadow-sm border border-gray-100 hover:shadow-md transition overflow-hidden">

                        <div class="p-4">
                            <div class="flex justify-between items-start mb-2">
                                <span class="px-2 py-1 text-[10px] font-bold uppercase tracking-wider rounded-full bg-slate-100 text-slate-600">
                                    {{ $other->type }}
                                </span>
                                <span class="text-xs text-gray-400">
                                    {{ $other->created_at->diffForHumans() }}
                                </span>
                            </div>

                            <h3 class="font-bold text-slate-900 leading-tight group-hover:text-red-600 transition mb-2">
                                {{ Str::limit($other->title, 50) }}
                            </h3>

                            <p class="text-xs text-gray-500 line-clamp-2">
                                {{ $other->description }}
                            </p>
                        </div>

                        <div class="bg-gray-50 px-4 py-2 border-t border-gray-100 flex justify-between items-center">
                            <span class="text-xs font-medium text-red-600">Voir le détail &rarr;</span>

                            @if($other->evidence_paths)
                                <span class="text-xs text-gray-400 flex items-center gap-1">
                                    📷 Preuve
                                </span>
                            @endif
                        </div>
                    </a>
                @endforeach
            </div>
            <div class="mt-8 text-center">
                <a href="{{ route('scams.index') }}" class="inline-block border border-gray-300 text-gray-700 font-medium px-6 py-2 rounded-lg hover:bg-gray-50 transition">
                    Voir tous les signalements
                </a>
            </div>

        </div>
    @endif

    </main>
</x-layout>

