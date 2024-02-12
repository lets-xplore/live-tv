<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content=" Admin">
    <meta name="author" content="ReDiscover Tech, LLC">
    <link rel="shortcut icon" href="{{ URL::asset('upload/source/') }}">
    <title> Admin</title>




    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.0/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset('admin_assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset('admin_assets/css/icons.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset('admin_assets/plugins/multiselect/css/multi-select.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset('admin_assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset('admin_assets/plugins/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('admin_assets/css/style.css') }}" rel="stylesheet" type="text/css" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.6.3/css/font-awesome.min.css" rel="stylesheet" type="text/css" />

    <script src="{{ URL::asset('admin_assets/js/modernizr.min.js') }}"></script>

    <!-- Add these links to your HTML file's head section -->





    @yield('styles')
    <!-- App css -->




</head>

<body class="fixed-left">
    <div id="wrapper">

        @include("admin.layouts.topbar")

        @include("admin.layouts.sidebar")

        @yield("content")

    </div>

    <!-- jQuery  -->

    <script src="{{ URL::asset('admin_assets/js/jquery.min.js') }}"></script>
    <script src="{{ URL::asset('admin_assets/js/popper.min.js') }}"></script>
    <script src="{{ URL::asset('admin_assets/js/bootstrap.min.js') }}"></script>

    <script src="{{ URL::asset('admin_assets/js/detect.js') }}"></script>
    <script src="{{ URL::asset('admin_assets/js/fastclick.js') }}"></script>
    <script src="{{ URL::asset('admin_assets/js/jquery.blockUI.js') }}"></script>
    <script src="{{ URL::asset('admin_assets/js/waves.js') }}"></script>
    <script src="{{ URL::asset('admin_assets/js/jquery.nicescroll.js') }}"></script>
    <script src="{{ URL::asset('admin_assets/js/jquery.slimscroll.js') }}"></script>
    <script src="{{ URL::asset('admin_assets/js/jquery.scrollTo.min.js') }}"></script>
    <script src="{{ URL::asset('admin_assets/plugins/tinymce/tinymce.min.js') }}"></script>


    <script src="{{ URL::asset('admin_assets/plugins/jquery-knob/jquery.knob.js') }}"></script>
    <script src="{{ URL::asset('admin_assets/plugins/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>

    <script type="text/javascript" src="{{ URL::asset('admin_assets/plugins/multiselect/js/jquery.multi-select.js') }}"></script>
    <script src="{{ URL::asset('admin_assets/plugins/select2/js/select2.min.js') }}" type="text/javascript"></script>



    <!-- App js -->
    <script src="{{ URL::asset('admin_assets/js/jquery.core.js') }}"></script>
    <script src="{{ URL::asset('admin_assets/js/jquery.app.js') }}"></script>
    <!-- jQuery UI -->
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

    <script>
        jQuery(document).ready(function($) {
            $("#sortable-table tbody").sortable({
                items: "tr",
                cursor: "move",
                handle: ".drag-handle",
                opacity: 0.6,
            });
        });


        function displayReOrder() {
            $(".order").toggleClass("dnone");

        }

        function displayDone() {
            $(".order").toggleClass("dnone");
            $("#reorderButton").removeClass("done");


            var sortedItemIds = [];
            $("tbody tr").each(function(index) {
                var itemId = $(this).data("item-id");
                sortedItemIds[itemId] = index + 1;
            });
            $.ajax({
                method: "GET",
                url: "{{ route('admin.update-order') }}",
                data: {
                    sortedItemIds: sortedItemIds
                },
                success: function(response) {
                    //s console.log("Order saved successfully");
                    window.location.href = "{{ route('admin.category') }}";

                },
                error: function(xhr, status, error) {
                    console.error(error);
                }
            });

        }


        $("#reorderButton").on("click", function() {
            if ($(this).hasClass("done")) {
                displayDone();
            } else {
                displayReOrder();
            }
            $(this).toggleClass("done");
            $(this).text("Save Order");
            $(this).attr("data-original-title", "Save Order");

        });
    </script>

    <script>
        // Wait for the DOM to be ready
        document.addEventListener('DOMContentLoaded', function() {
            // Find the Reset Data button by its ID
            const resetDataBtn = document.getElementById('resetDataBtn');

            // Add a click event listener to the Reset Data button
            resetDataBtn.addEventListener('click', function(e) {
                e.preventDefault();

                // Show a SweetAlert confirmation dialog
                Swal.fire({
                    title: 'Are you sure?',
                    text: 'This action will reset all data. Do you want to continue?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, reset it!',
                    cancelButtonText: 'No, cancel',
                    reverseButtons: true,
                    customClass: {
                        confirmButton: 'swal2-confirm custom-button' // Add the custom class here
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        // If confirmed, redirect to the reset data URL
                        window.location.href = "{{ route('admin.reset.data') }}";
                    }
                });
            });
        });


        // Handle click on delete button with SweetAlert confirmation
        $('.delete-category').click(function(e) {
            e.preventDefault();
            var categoryId = $(this).data('id');

            Swal.fire({
                title: 'Are you sure?',
                text: 'You won\'t be able to revert this!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!',
            }).then((result) => {
                if (result.isConfirmed) {
                    // Perform the delete action, e.g., redirect to a delete route
                    window.location.href = "{{ route('admin.category.delete') }}/" + categoryId;
                }
            });
        });
    </script>




    @stack('scripts')

</body>

</html>
