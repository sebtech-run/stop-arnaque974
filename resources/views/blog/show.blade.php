<x-layout>
    <article class="max-w-3xl mx-auto px-4 py-10">
        @if($post->image_path)
            <img src="{{ asset('storage/' . $post->image_path) }}" class="w-full h-64 md:h-96 object-cover rounded-xl shadow-lg mb-8">
        @endif

        <h1 class="text-4xl font-extrabold mb-4">{{ $post->title }}</h1>
        <p class="text-gray-500 mb-8">Publié le {{ $post->created_at->format('d/m/Y') }}</p>

        <div class="prose prose-lg prose-red max-w-none text-gray-700">
            {!! $post->content !!}
        </div>

        <div class="mt-10 pt-10 border-t">
            <a href="{{ route('posts.index') }}" class="text-gray-600 hover:text-red-600 font-medium">&larr; Retour aux conseils</a>
        </div>
    </article>
</x-layout>
