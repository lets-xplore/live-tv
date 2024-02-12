@extends("admin.layouts.admin")


@section("styles")
<style>
    .drag-handle {
        cursor: grab;
        font-size: 20px;
        /* Increase the font size for drag handle */
    }

    .align {
        text-align: end;
    }

    .color {
        background-color: #e5d8da;
    }

    .dnone {
        display: none;
    }

    td {
        vertical-align: middle !important;
        font-size: 18px;
        /* Increase the font size for table cells */
    }

    .modal-title {
        font-size: 24px;
        /* Increase the font size for modal titles */
    }

    .modal-body {
        font-size: 18px;
        /* Increase the font size for modal body text */
    }

    .form-group label {
        font-size: 18px;
        /* Increase the font size for form labels */
    }

    .form-control {
        font-size: 18px;
        /* Increase the font size for form inputs */
        padding: 10px;
        /* Increase the padding for form inputs */
    }

    .btn {
        font-size: 18px;
        /* Increase the font size for buttons */
    }

    a#reorderButton {
        color: #fff !important;
    }
</style>
@endsection

@section("content")

<div class="content-page">
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card-box">

                        @if (session('error'))
                        <div class="alert alert-danger alert-dismissible fade show">
                            {{ session('error') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        @endif

                        @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show">
                            {{ session('success') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        @endif

                        <div class="text-right mb-3">
                            <button id="addCategoryBtn" class="btn btn-primary">Add Clinic</button>
                            @if(count($categories) > 1)

                            @if(!request('change-order'))
                            <a href="{{ route('admin.category') }}?change-order=1" class="btn btn-secondary" id="reorderButton">Change Order</a>
                            @else
                            <button href="#" class="btn btn-secondary done" id="reorderButton">Save Order</button>
                            @endif"



                            @endif
                        </div>

                        <!-- Categories table -->
                        @if(count($categories) > 0)
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped" id="sortable-table">
                                <thead>
                                    <tr>
                                        <th class=" order  @if(!request('change-order')) dnone @endif">Order</th>
                                        <th>Name</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($categories as $category)
                                    <tr data-item-id="{{ $category->id }}" draggable="true">
                                        <td style="width: 10px;" class="order @if(!request('change-order')) dnone @endif"><span class="drag-handle"><i class="fa fa-ellipsis-v" aria-hidden="true"></i>&nbsp;<i class="fa fa-ellipsis-v" aria-hidden="true"></i></span></td>
                                        <td style="display:none;">{{ $category->id }}</td>
                                        <td>{{ $category->name }}</td>
                                        <td>
                                            @if ($category->status == 1)
                                            <span class="badge badge-success">Active</span>
                                            @else
                                            <span class="badge badge-danger">Inactive</span>
                                            @endif
                                        </td>
                                        <td>
                                            <!-- Edit button -->
                                            <a href="{{ route('admin.category.edit', ['id' => $category->id]) }}" class="btn btn-sm btn-primary">
                                                <i class="fa fa-pencil"></i>
                                            </a>
                                            <!-- Delete button (You can add a confirmation dialog here) -->
                                            <a href="#" class="btn btn-sm btn-danger delete-category" data-id="{{ $category->id }}">
                                                <i class="fa fa-trash"></i>
                                            </a>

                                            <!-- Video icon to open modal -->
                                            <a href="#" class="btn btn-sm btn-info video-icon" data-toggle="modal" data-target="#videoModal" data-videos="{{ json_encode($category->videos) }}">
                                                <i class="fa fa-video-camera"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @else
                        <p>No records found.</p>
                        @endif

                        @if(!request('change-order'))
                        <nav class="paging_simple_numbers">
                            @include('admin.pagination', ['paginator' => $categories])
                        </nav>
                        @endif




                    </div>
                </div>
            </div>
        </div>
    </div>
    @include("admin.layouts.copyright")
</div>

<div class="modal fade" id="addCategoryModal" tabindex="-1" role="dialog" aria-labelledby="addCategoryModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addCategoryModalLabel">Add Clinic</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="addCategoryForm" action="{{ route('admin.category.add') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="categoryName">Clinic Name</label>
                        <input type="text" class="form-control" id="categoryName" name="category_name" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Add</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Video Modal -->
<div class="modal fade" id="videoModal" tabindex="-1" role="dialog" aria-labelledby="videoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="videoModalLabel">Video Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Video data table -->
                <table class="table table-bordered table-striped" id="videoDataTable">
                    <thead>
                        <tr>
                            <th>Thumbnail</th>
                            <th>Video Name</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Video data will be populated here dynamically -->
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        $('#addCategoryBtn').click(function() {
            $('#addCategoryModal').modal('show');
        });
        $('.video-icon').click(function() {
            var videos = $(this).data('videos');
            var modalBody = $('#videoModal .modal-body');
            var tableBody = modalBody.find('tbody');


            tableBody.empty();

            if (videos.length === 0) {
                var noDataMessage = '<tr><td colspan="2">No videos available</td></tr>';
                tableBody.append(noDataMessage);
            } else {
                $.each(videos, function(index, video) {
                    var thumbnail = '<img src="' + video.thumb_image + '" alt="Thumbnail" class="img-thumbnail">';
                    var videoName = video.title;

                    var row = '<tr><td>' + thumbnail + '</td><td>' + videoName + '</td></tr>';
                    tableBody.append(row);
                });
            }
            $('#videoModal').modal('show');
        });
    });
</script>
@endpush
