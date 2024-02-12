@extends("admin.layouts.admin")

@section("content")


<style>
    .card-box {
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        margin-bottom: 20px;
    }

    .card-icon {
        font-size: 48px;
        margin-bottom: 20px;
    }

    .card-count {
        font-size: 36px;
    }

    .video-card {
        background-color: #387f97;
        color: #fff;
    }

    .clinic-card-active {
        background-color: #006A4E;
        color: #fff;
    }

    .clinic-card-inactive {
        background-color: #D32F2F;
        /* Change to the color you prefer for inactive clinics */
        color: #fff;
    }

    .card-label {
        font-size: 18px;
        font-weight: bold;
        text-transform: uppercase;
    }

    .count-wrapper {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .count-increment {
        cursor: pointer;
        transition: transform 0.2s;
    }

    .count-increment:hover {
        transform: scale(1.1);
    }
</style>

<div class="content-page">
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-4">
                    <div class="card-box video-card">
                        <div class="text-center">
                            <div class="card-icon">
                                <i class="fa fa-video-camera" aria-hidden="true"></i>
                            </div>
                            <div class="count-wrapper">
                                <div class="card-label">Total Videos</div>
                                <div class="card-count">
                                    <span class="count-increment">{{ $totalVideos }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="card-box clinic-card clinic-card-active">
                        <div class="text-center">
                            <div class="card-icon">
                                <i class="fa fa-hospital-o" aria-hidden="true"></i>
                            </div>
                            <div class="count-wrapper">
                                <div class="card-label">Total Active Clinic</div>
                                <div class="card-count">
                                    <span class="count-increment">{{ $activeCategories }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="card-box clinic-card clinic-card-inactive">
                        <div class="text-center">
                            <div class="card-icon">
                                <i class="fa fa-hospital-o" aria-hidden="true"></i>
                            </div>
                            <div class="count-wrapper">
                                <div class="card-label">Total Inactive Clinic</div>
                                <div class="card-count">
                                    <span class="count-increment">{{ $inactiveCategories }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-12">
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
                </div>
            </div>
        </div>
    </div>
    @include("admin.layouts.copyright")
</div>

@endsection

@push('scripts')

@endpush
