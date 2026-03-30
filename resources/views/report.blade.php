<x-layout title="Signaler une arnaque - Stop Arnaque 974">
    <div class="max-w-3xl mx-auto px-4 py-10">

        <div class="bg-white p-8 rounded-xl shadow-sm border border-gray-100">
            <h1 class="text-2xl font-bold mb-2 text-slate-900">Signaler une nouvelle arnaque</h1>
            <p class="text-gray-500 mb-8">
                Votre vigilance protège les autres Réunionnais. Remplissez ce formulaire pour lancer l'alerte.
            </p>

            <div class="bg-indigo-50 border border-indigo-100 rounded-xl p-6 mb-8">
                <h2 class="text-indigo-900 font-bold text-base mb-4 flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z" />
                    </svg>
                    Comment traitons-nous votre signalement ?
                </h2>

                <div class="grid md:grid-cols-3 gap-6 relative">
                    <div class="hidden md:block absolute top-4 left-0 w-full h-0.5 bg-indigo-200 -z-10 transform scale-x-75"></div>

                    <div class="relative bg-indigo-50 text-center">
                        <div class="w-8 h-8 mx-auto bg-indigo-600 text-white font-bold rounded-full flex items-center justify-center mb-3 text-sm shadow-md">1</div>
                        <h3 class="font-bold text-sm text-indigo-900 mb-1">Dépôt</h3>
                        <p class="text-xs text-indigo-800 leading-relaxed">
                            Vous décrivez l'arnaque et joignez vos preuves (captures d'écran).
                        </p>
                    </div>

                    <div class="relative bg-indigo-50 text-center">
                        <div class="w-8 h-8 mx-auto bg-white text-indigo-600 border-2 border-indigo-600 font-bold rounded-full flex items-center justify-center mb-3 text-sm shadow-md">2</div>
                        <h3 class="font-bold text-sm text-indigo-900 mb-1">Vérification</h3>
                        <p class="text-xs text-indigo-800 leading-relaxed">
                            Notre équipe vérifie les faits et <strong>anonymise</strong> vos données personnelles.
                        </p>
                    </div>

                    <div class="relative bg-indigo-50 text-center">
                        <div class="w-8 h-8 mx-auto bg-white text-green-600 border-2 border-green-600 font-bold rounded-full flex items-center justify-center mb-3 text-sm shadow-md">3</div>
                        <h3 class="font-bold text-sm text-indigo-900 mb-1">Publication</h3>
                        <p class="text-xs text-indigo-800 leading-relaxed">
                            L'alerte est validée. Elle devient visible pour protéger la communauté.
                        </p>
                    </div>
                </div>
            </div>

            @if ($errors->any())
                <div class="bg-red-50 text-red-700 p-4 rounded-lg mb-6 text-sm border border-red-100">
                    <p class="font-bold mb-1">Oups, il manque des informations :</p>
                    <ul class="list-disc pl-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('scam.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf

                <div class="grid md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1">Titre court <span class="text-red-500">*</span></label>
                        <input type="text" name="title" required placeholder="Ex: SMS Colis La Poste" value="{{ old('title') }}" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-red-500 focus:ring-red-500">
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1">Type d'arnaque <span class="text-red-500">*</span></label>
                        <select name="type" required class="w-full rounded-lg border-gray-300 shadow-sm focus:border-red-500 focus:ring-red-500">
                            <option value="sms_fraud">Arnaque SMS / Colis</option>
                            <option value="phishing">Phishing / Email (Caf, Ameli...)</option>
                            <option value="leboncoin">Petites Annonces (Leboncoin, FB)</option>
                            <option value="fake_support">Faux Support Technique</option>
                            <option value="ransomware">Ransomware / Virus</option>
                            <option value="other">Autre</option>
                        </select>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1">Description détaillée <span class="text-red-500">*</span></label>
                    <p class="text-xs text-gray-400 mb-2">Ne mettez pas votre propre nom ou adresse ici. Racontez simplement les faits.</p>
                    <textarea name="description" rows="5" required placeholder="Racontez ce qui s'est passé..." class="w-full rounded-lg border-gray-300 shadow-sm focus:border-red-500 focus:ring-red-500">{{ old('description') }}</textarea>
                </div>

                <div class="bg-slate-50 p-5 rounded-lg border border-slate-200">
                    <h3 class="text-sm font-bold text-slate-900 mb-1">Informations sur l'arnaqueur</h3>
                    <p class="text-xs text-slate-500 mb-4">Ces données permettront aux futures victimes de trouver votre signalement via la recherche.</p>

                    <div class="grid md:grid-cols-3 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-gray-500 mb-1">Téléphone utilisé</label>
                            <input type="text" name="scammer_phone" placeholder="0692..." value="{{ old('scammer_phone') }}" class="w-full text-sm rounded-md border-gray-300 focus:border-red-500 focus:ring-red-500">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-500 mb-1">Email utilisé</label>
                            <input type="email" name="scammer_email" placeholder="exemple@mail.com" value="{{ old('scammer_email') }}" class="w-full text-sm rounded-md border-gray-300 focus:border-red-500 focus:ring-red-500">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-500 mb-1">Site Web / Lien</label>
                            <input type="url" name="scammer_url" placeholder="http://..." value="{{ old('scammer_url') }}" class="w-full text-sm rounded-md border-gray-300 focus:border-red-500 focus:ring-red-500">
                        </div>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1">Preuves (Captures d'écran)</label>
                    <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-lg hover:bg-gray-50 transition relative">
                        <div class="space-y-1 text-center w-full">
                            <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                                <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                            <div class="flex text-sm text-gray-600 justify-center">
                                <label for="evidence-upload" class="relative cursor-pointer bg-white rounded-md font-medium text-indigo-600 hover:text-indigo-500 focus-within:outline-none">
                                    <span>Parcourir les fichiers</span>
                                    <input id="evidence-upload" name="evidence[]" type="file" multiple accept="image/*" class="sr-only" onchange="updateFileList(this)">
                                </label>
                            </div>
                            <p class="text-xs text-gray-500 mb-2">PNG, JPG jusqu'à 2Mo</p>

                            <div id="file-list" class="mt-3 text-sm font-medium text-green-600 bg-green-50 rounded p-2 hidden"></div>
                        </div>
                    </div>
                </div>

                <div class="pt-4 border-t">
                    <button type="submit" class="w-full bg-red-600 text-white font-bold py-4 rounded-lg hover:bg-red-700 transition shadow-lg text-lg">
                        Envoyer le signalement
                    </button>
                    <p class="text-center text-xs text-gray-400 mt-4">
                        Ce site est protégé par reCAPTCHA et les règles de confidentialité s'appliquent.
                    </p>
                </div>
            </form>
        </div>
    </div>

    <script>
        function updateFileList(input) {
            const fileList = document.getElementById('file-list');

            if (input.files.length > 0) {
                // On affiche la zone
                fileList.classList.remove('hidden');

                // On compte le nombre de fichiers
                let text = input.files.length === 1 ? '1 image sélectionnée : ' : input.files.length + ' images sélectionnées : ';

                // On récupère le nom des fichiers
                let fileNames = Array.from(input.files).map(file => file.name).join(', ');

                // On écrit le texte dans la zone
                fileList.innerHTML = '✅ ' + text + '<span class="text-gray-700 font-normal">' + fileNames + '</span>';
            } else {
                // S'il annule, on recache la zone
                fileList.classList.add('hidden');
                fileList.innerHTML = '';
            }
        }
    </script>
</x-layout>
