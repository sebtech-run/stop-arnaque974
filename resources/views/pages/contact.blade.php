<x-layout title="Contact & Ateliers Numériques - Stop Arnaque 974">
    <div class="max-w-4xl mx-auto px-4 py-10">

        <div class="text-center mb-10">
            <span class="bg-indigo-100 text-indigo-800 text-xs font-bold px-4 py-1.5 rounded-full uppercase tracking-wide">
                Ateliers & Accompagnement
            </span>
            <h1 class="text-3xl md:text-4xl font-extrabold mt-6 mb-4 text-slate-900">
                Contact & Ateliers Numériques
            </h1>
            <p class="text-lg text-gray-600 max-w-2xl mx-auto leading-relaxed">
                Vous êtes un <strong>particulier</strong>, une <strong>mairie</strong> ou une structure pour <strong>seniors</strong> ?<br>
                Nous intervenons sur toute la Réunion pour vous accompagner dans la maîtrise du numérique et la prévention des risques liés à internet.
            </p>
        </div>

        @if(session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-6 mb-8 rounded-r-lg shadow-sm">
                <div class="flex items-center gap-3">
                    <span class="text-2xl">✅</span>
                    <div>
                        <p class="font-bold text-lg">Message envoyé avec succès !</p>
                        <p>{{ session('success') }}</p>
                    </div>
                </div>
            </div>
        @endif

        <div class="grid md:grid-cols-3 gap-8">
            <div class="md:col-span-1 space-y-6">

                <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                    <h3 class="font-bold text-slate-900 mb-4 text-lg border-b pb-2">Nos Prestations</h3>
                    <ul class="space-y-4 text-sm text-gray-700">
                        <li class="flex items-start gap-3">
                            <span class="text-indigo-500 text-lg">👵</span>
                            <span><strong>Accompagnement Seniors</strong><br><span class="text-xs text-gray-500">Mails, démarches en ligne, smartphone...</span></span>
                        </li>
                        <li class="flex items-start gap-3">
                            <span class="text-indigo-500 text-lg">🧒</span>
                            <span><strong>Ateliers Enfants/Ados</strong><br><span class="text-xs text-gray-500">Réseaux sociaux, cyberharcèlement...</span></span>
                        </li>
                        <li class="flex items-start gap-3">
                            <span class="text-indigo-500 text-lg">🎤</span>
                            <span><strong>Conférences Prévention</strong><br><span class="text-xs text-gray-500">Pour Mairies, CCAS, Associations...</span></span>
                        </li>
                    </ul>
                </div>

                <div class="bg-red-50 p-6 rounded-xl border border-red-100">
                    <h3 class="font-bold text-red-900 mb-2">Vous êtes victime d'une arnaque ?</h3>
                    <p class="text-sm text-red-800 mb-4">
                        Si vos coordonnées bancaires ont été compromises, contactez immédiatement votre banque pour faire opposition.
                    </p>
                    <a href="{{ route('scam.create') }}" class="block text-center bg-white text-red-600 font-bold py-2.5 rounded-lg text-sm border border-red-200 hover:bg-red-50 hover:border-red-300 transition shadow-sm">
                        Faire un signalement
                    </a>
                </div>
            </div>

            <div class="md:col-span-2 bg-white p-8 rounded-xl shadow-md border border-gray-100">
                <form action="{{ route('contact.send') }}" method="POST" class="space-y-6">
                    @csrf

                    <div class="grid md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-1">Vous êtes ? <span class="text-indigo-500">*</span></label>
                            <select name="profile" required class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 bg-gray-50">
                                <option value="" disabled selected>Choisir un profil...</option>
                                <option value="particulier">Particulier (Senior, Parent...)</option>
                                <option value="mairie">Mairie / Collectivité (CCAS)</option>
                                <option value="association">Association / Club</option>
                                <option value="entreprise">Entreprise / CE</option>
                                <option value="autre">Autre</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-1">Nom ou Structure <span class="text-indigo-500">*</span></label>
                            <input type="text" name="name" placeholder="Ex: M. Hoarau / Mairie de..." required class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        </div>
                    </div>

                    <div class="grid md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-1">Adresse Email <span class="text-indigo-500">*</span></label>
                            <input type="email" name="email" placeholder="votre@email.re" required class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-1">Téléphone <span class="text-gray-400 font-normal text-xs">(Recommandé)</span></label>
                            <input type="text" name="phone" placeholder="0692..." class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1">Objet de votre demande <span class="text-indigo-500">*</span></label>
                        <select name="subject_type" required class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="cours_particulier">Demande de cours d'informatique / Accompagnement</option>
                            <option value="atelier_groupe">Devis pour un atelier de groupe (Mairie, Club...)</option>
                            <option value="conference">Demande d'intervention / Conférence Prévention</option>
                            <option value="autre">Autre question ou partenariat</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-1">Votre message <span class="text-indigo-500">*</span></label>
                        <textarea name="message" rows="5" placeholder="Expliquez-nous votre besoin (niveau en informatique, dates souhaitées, ville d'intervention...)" required class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"></textarea>
                    </div>

                    <div class="pt-2">
                        <button type="submit" class="w-full bg-indigo-600 text-white font-bold py-4 rounded-lg hover:bg-indigo-700 transition shadow-lg flex justify-center items-center gap-2">
                            <span>Envoyer ma demande</span>
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 12L3.269 3.126A59.768 59.768 0 0121.485 12 59.77 59.77 0 013.27 20.876L5.999 12zm0 0h7.5" />
                            </svg>
                        </button>
                        <p class="text-xs text-gray-400 text-center mt-3">Vos données sont strictement confidentielles et ne seront jamais revendues.</p>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-layout>
