@extends('admin.layouts.admin')

@section('content')
<div class="content-page">
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card-box">

                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>SR #</th>
                                        <th>Thumbnail</th>
                                        <th>Title</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($videos as $index => $video)
                                    <tr>
                                        <td>{{ $index + 1 }}</td> <!-- Calculate SR number -->
                                        <td>
                                            <img src="{{ $video->thumb_image }}" alt="{{ $video->name }}">
                                        </td>
                                        <td>{{ $video->name }}</td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="6">No videos found.</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>


                        <nav class="paging_simple_numbers">
                            @include('admin.pagination', ['paginator' => $videos])
                        </nav>

                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('admin.layouts.copyright')
</div>
@endsection
