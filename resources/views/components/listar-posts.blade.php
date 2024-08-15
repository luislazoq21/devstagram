<div>
    @if ($posts->count())
        <div class="grid md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @foreach ($posts as $post)
                <div>
                    <a href="{{ route('posts.show', [$post->user, $post]) }}">
                        <img src="{{ asset('uploads') . '/' . $post->imagen }}" alt="Image del post {{ $post->titulo }}">
                    </a>
                </div>
            @endforeach
        </div>
        @if ($posts->hasPages())
            <div class="mt-10">
                {{ $posts->links() }}
            </div>
        @endif
    @else
        <p class="text-center">No hay posts. Sigue a alguien para poder mostrar sus posts.</p>
    @endif
</div>
