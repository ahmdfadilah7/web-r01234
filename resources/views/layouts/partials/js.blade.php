@section('js')

<!-- Required vendors -->
<script src="{{ asset('assets/vendor/global/global.min.js') }}"></script>
<script src="{{ asset('assets/js/quixnav-init.js') }}"></script>
<script src="{{ asset('assets/js/custom.min.js') }}"></script>

<!-- Vectormap -->
<script src="{{ asset('assets/vendor/raphael/raphael.min.js') }}"></script>
<script src="{{ asset('assets/vendor/morris/morris.min.js') }}"></script>

<script src="{{ asset('assets/vendor/circle-progress/circle-progress.min.js') }}"></script>
<script src="{{ asset('assets/vendor/chart.js/Chart.bundle.min.js') }}"></script>

<script src="{{ asset('assets/vendor/gaugeJS/dist/gauge.min.js') }}"></script>

<!--  flot-chart js -->
<script src="{{ asset('assets/vendor/flot/jquery.flot.js') }}"></script>
<script src="{{ asset('assets/vendor/flot/jquery.flot.resize.js') }}"></script>

<!-- Owl Carousel -->
<script src="{{ asset('assets/vendor/owl-carousel/js/owl.carousel.min.js') }}"></script>

<!-- Counter Up -->
<script src="{{ asset('assets/vendor/jqvmap/js/jquery.vmap.min.js') }}"></script>
<script src="{{ asset('assets/vendor/jqvmap/js/jquery.vmap.usa.js') }}"></script>
<script src="{{ asset('assets/vendor/jquery.counterup/jquery.counterup.min.js') }}"></script>

<!-- Summernote -->
<script src="{{ asset('assets/vendor/summernote/js/summernote.min.js') }}"></script>
<!-- Summernote init -->
<script src="{{ asset('assets/js/plugins-init/summernote-init.js') }}"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
<script src="{{ asset('assets/js/dashboard/dashboard-1.js') }}"></script>

<script>
    @if(Session::has('success'))
    toastr.options =
    {
        "closeButton" : true,
        "progressBar" : true
    }
            toastr.success("{{ session('success') }}");
    @endif
    
    @if(Session::has('errors'))
    toastr.options =
        {
            "closeButton" : true,
            "progressBar" : true
        }
        @foreach ($errors->all() as $errors)
            toastr.error("{{ $errors }}");
        @endforeach
    @endif
    
    @if(Session::has('warning'))
        toastr.options =
            {
                "closeButton" : true,
                "progressBar" : true
            }
        toastr.warning("{{ session('warning') }}");
    @endif
</script>

@endsection