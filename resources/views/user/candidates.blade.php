@extends('layouts.user')

@section('content')
    <div class="container mt-5">
        <h2>Candidates in {{ $category->name }}</h2>
        <ul>
            @foreach ($candidates as $candidate)
                <li>
                    {{ $candidate->first_name }} {{ $candidate->last_name }} - {{ $candidate->position }}
                    <form method="POST" action="{{ route('user.vote', [$category->id, $candidate->id]) }}">
                        @csrf
                        <button type="submit">Vote</button>
                    </form>
                </li>
            @endforeach
        </ul>
    </div>
@endsection
