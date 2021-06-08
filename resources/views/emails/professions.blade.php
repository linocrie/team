<h3>Professions</h3>

@empty($beforeProfessions)
    <p>professions created are:</p>
@else
    <p>Your professions was updated from:</p>
    <span>
        <ul>
            @foreach($beforeProfessions as $profession)
                <li>
                    {{ $profession }}
                </li>
            @endforeach
        </ul>
    </span>
    <p>to:</p>
@endempty

<span>
    <ul>
        @foreach($updatedProfessions as $profession)
            <li>
                {{ $profession }}
            </li>
        @endforeach
    </ul>
</span>
