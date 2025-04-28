<script src="{{ url('assets/libs/jquery/dist/jquery.min.js') }}"></script>
<script src="{{ url('assets/libs/popper.js/dist/umd/popper.min.js') }}"></script>
<script src="{{ url('assets/libs/bootstrap/dist/js/bootstrap.min.js') }}"></script>
<script src="{{ url('dist/js/form.js') }}"></script>
<script src="{{ url('assets/libs/SnackBar-master/dist/snackbar.min.js') }}"></script>
<script src="{{ url('dist/js/waves.js') }}"></script>
<script src="{{ url('dist/js/sidebarmenu.js') }}"></script>
<script src="{{ url('assets/extra-libs/DataTables/datatables.min.js') }}"></script>
<script src="{{ url('assets/libs/dropify-master/dist/js/dropify.min.js') }}"></script>
<script src="{{ url('assets/libs/select2/dist/js/select2.full.min.js') }}"></script>
<script src="{{ url('assets/libs/select2/dist/js/select2.min.js') }}"></script>
<script src="{{ url('assets/libs/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ url('dist/js/custom.js') }}"></script>
<script src="{{ url('plugin/toastr/toastr.min.js') }}"></script>
<script>
    @if(Session::has('success'))

        toastr.success("{{ session('success') }}");
    @endif
    @if(Session::has('error'))

        toastr.error("{{ session('error') }}");
    @endif
    @if(Session::has('info'))

        toastr.info("{{ session('info') }}");
    @endif
    @if(Session::has('warning'))

        toastr.warning("{{ session('warning') }}");
    @endif
</script>
@yield('page-script')
</body>
</html>
