@extends('admin.layouts.admin')

@section('content')
    <div class="content-page">
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card-box">
                            <h4 class="header-title mb-4">Video List</h4>
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Title</th>
                                            <th>Description</th>
                                            <th>Duration</th>
                                            <th>Thumbnail</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($videos as $video)
                                            <tr>
                                                <td>{{ $video->id }}</td>
                                                <td>{{ $video->title }}</td>
                                                <td>{{ $video->description }}</td>
                                                <td>{{ $video->duration }}</td>
                                                <td>
                                                    <img src="{{ $video->thumbnail_url }}" alt="{{ $video->title }}" width="100">
                                                </td>
                                                <td>
                                                    <!-- Add your actions here -->
                                                    <!-- Example: Edit and Delete buttons -->
                                                    <a href="{{ route('videos.edit', ['id' => $video->id]) }}" class="btn btn-sm btn-primary">Edit</a>
                                                    <a href="{{ route('videos.delete', ['id' => $video->id]) }}" class="btn btn-sm btn-danger">Delete</a>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="6">No videos found.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @include('admin.layouts.copyright')
    </div>
@endsection
