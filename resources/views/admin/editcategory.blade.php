@extends("admin.layouts.admin")

@section("content")

<div class="content-page">
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card-box">
                        <!-- Add your form here -->
                        @if (session('error'))
                        <div class="alert alert-danger alert-dismissible fade show large-text">
                            {{ session('error') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        @endif

                        @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show large-text">
                            {{ session('success') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        @endif

                        <!-- Edit Category Form -->
                        <form action="{{ route('admin.category.update', ['id' => $category->id]) }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="categoryName" class="large-text">Clinic Name</label>
                                <input type="text" class="form-control large-input" id="categoryName" name="category_name" value="{{ $category->name }}" required>
                            </div>
                            <div class="form-group">
                                <label>Status</label><br>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="status" id="activeStatus" value="1" {{ $category->status == 1 ? 'checked' : '' }}>
                                    <label class="form-check-label large-text" for="activeStatus">Active</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="status" id="inactiveStatus" value="0" {{ $category->status == 0 ? 'checked' : '' }}>
                                    <label class="form-check-label large-text" for="inactiveStatus">Inactive</label>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="videoSelect" class="large-text">Select Videos</label>
                                <select class="form-control select2 large-input" id="videoSelect" name="video_ids[]" multiple data-placeholder="Select Videos">
                                    @foreach($videos as $video)
                                    <option value="{{ $video->id }}" {{ is_array($category->video_id_array) && in_array($video->id, $category->video_id_array) ? 'selected' : '' }} data-thumbnail="{{ $video->thumb_image }}">{{ $video->name }}</option>
                                    @endforeach
                                </select>

                            </div>
                            <div class="text-center">
                                <button type="submit" class="btn btn-primary large-button">Update</button>
                                <a href="{{ route('admin.category') }}" class="btn btn-info large-button">Back</a>
                                <a href="#" class="btn btn-danger delete-category large-button" data-id="{{ $category->id }} ">Delete</a>
                            </div>
                        </form>
                        <!-- End Edit Category Form -->
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include("admin.layouts.copyright")
</div>

@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        $('#videoSelect').select2({
            templateResult: formatVideo,
            templateSelection: formatText,
            escapeMarkup: function(markup) {
                return markup;
            }
        });

        function formatVideo(video) {
            if (!video.id) {
                return video.text;
            }

            if (video.selected) {
                return null;
            }

            var $video = $(
                '<span><img src="' + $(video.element).data('thumbnail') + '" class="img-thumbnail" style="width: 90px; height: 90px;"> ' + video.text + '</span>'
            );
            return $video;
        }

        function formatText(video) {
            return video.text;
        }
    });
</script>
@endpush
