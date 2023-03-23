@extends('platform::dashboard')

@section('title', 'Create Newsletter')

@section('content')
    <div class="card">
        <div class="card-header">Create Newsletter</div>
        <div class="card-body">
            <form method="POST" action="{{ url('platform.newsletters.store') }}">
                @csrf
                <div class="form-group">
                    <label for="title">Title:</label>
                    <input type="text" class="form-control" id="title" name="title" required>
                </div>
                <div class="form-group">
                    <label for="content">Content:</label>
                    <textarea class="form-control" id="content" name="content" required></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Send Newsletter</button>
            </form>
        </div>
    </div>
@endsection
