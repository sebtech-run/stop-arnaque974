<x-layout>
    <div class="max-w-5xl mx-auto px-4 py-10">
        <h1 class="text-3xl font-bold mb-8">Conseils & Prévention</h1>

        <div class="grid md:grid-cols-3 gap-6">
            @foreach($posts as $post)
                <a href="{{ route('posts.show', $post->slug) }}" class="group block bg-white rounded-xl shadow-sm overflow-hidden hover:shadow-md transition">
                    @if($post->image_path)
                        <img src="{{ asset('storage/' . $post->image_path) }}" class="h-48 w-full object-cover group-hover:scale-105 transition duration-500">
                    @else
                        <div class="h-48 w-full bg-gray-200 flex items-center justify-center text-gray-400">Pas d'image</div>
                    @endif

                    <div class="p-5">
                        <h2 class="font-bold text-xl mb-2 group-hover:text-red-600 transition">{{ $post->title }}</h2>
                        <div class="text-gray-500 text-sm line-clamp-3">
                            {!! strip_tags($post->content) !!} </div>
                        <span class="text-red-600 text-sm font-medium mt-4 block">Lire l'article &rarr;</span>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
</x-layout>
