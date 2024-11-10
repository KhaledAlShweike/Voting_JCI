@extends('layouts.user')

@section('content')
    <div class="container mt-5">
        <h2>Categories</h2>
        <ul>
            @foreach ($categories as $category)
                <li><a href="{{ route('user.candidates', $category->id) }}">{{ $category->name }}</a></li>
            @endforeach
        </ul>
    </div>
@endsection
