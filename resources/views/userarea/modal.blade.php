<div class="card p-4">
    @if ($contents->poster_path)
    <div class="poster" style="background-image: url(https://image.tmdb.org/t/p/w500/{{ $contents->poster_path }});"></div>
    @else
        <p class="text-center"><i>No poster image available.</i></p>
    @endif

    <div class="card-body">
        <h5 class="card-title">{{ $contents->original_title }}</h5>
        <p class="card-text">
            {{ $contents->overview }}
            <hr/>
            <b>Popularity:</b> {{ $contents->popularity }}<br>
            <b>Vote average:</b> {{ $contents->vote_average }}<br>
            <b>Vote count:</b> {{ $contents->vote_count }}<br>
            <b>Status:</b> {{ $contents->status }}<br>
            <b>Language:</b> {{ $contents->original_language }}<br>
            <b>Genre(s):</b><br>
                @foreach ($contents->genres as $genre)
                    {{ $genre->name }}<br>
                @endforeach
        </p>
        <span onclick="jQuery('#myModal').modal('hide');" class="btn btn-primary">Close</span>
    </div>
</div>
