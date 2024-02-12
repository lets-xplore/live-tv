@extends("admin.layouts.admin")

@section("content")

<style>
    .content-page {
        font-size: 18px;
        /* Increase the font size for the entire page */
    }

    .card-box {
        padding: 20px;
    }

    .alert {
        font-size: 16px;
        /* Increase the font size for alerts */
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
</style>

<div class="content-page">
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-6 offset-lg-3">
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

                        <form action="{{ route('admin.import.video') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="vimeo_token">Enter Vimeo Token:</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" id="vimeo_token" value="{{$token}}" name="vimeo_token" required readonly>
                                    <div class="input-group-append">
                                        <button type="button" class="btn btn-secondary" id="changeTokenBtn">Change Token</button>
                                    </div>
                                </div>
                            </div>
                            <div class="text-center">
                                <button type="submit" class="btn btn-primary">Import</button>
                            </div>
                        </form>
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
        $('#changeTokenBtn').click(function() {
            $('#vimeo_token').removeAttr('readonly');
            $('#vimeo_token').val('');
        });
    });
</script>
@endpush
