@extends('layouts.admin')

@section('content')
    <div class="container mt-5">
        <h2>Candidates in {{ $category->name }}</h2>
        <a href="{{ route('candidates.create', $category->id) }}" class="btn btn-success">Add Candidate</a>
        <table class="table table-bordered mt-3">
            <thead>
                <tr>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Position</th>
                    <th>Last Position</th>
                    <th>JCI Career</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($candidates as $candidate)
                    <tr>
                        <td>{{ $candidate->first_name }}</td>
                        <td>{{ $candidate->last_name }}</td>
                        <td>{{ $candidate->position }}</td>
                        <td>{{ $candidate->last_position }}</td>
                        <td>{{ $candidate->jci_career }}</td>
                        <td>
                            <a href="{{ route('candidates.edit', [$category->id, $candidate->id]) }}" class="btn btn-warning">Edit</a>
                            <form action="{{ route('candidates.destroy', [$category->id, $candidate->id]) }}" method="POST" style="display:inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
