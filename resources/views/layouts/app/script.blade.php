<!-- BEGIN GLOBAL MANDATORY SCRIPTS -->
<script src="{{ asset('admin/assets/js/libs/jquery-3.1.1.min.js') }}"></script>
<script src="{{ asset('admin/plugins/jquery-ui/jquery-ui.min.js') }}"></script>
<script src="{{ asset('admin/bootstrap/js/popper.min.js') }}"></script>
<script src="{{ asset('admin/bootstrap/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('admin/plugins/perfect-scrollbar/perfect-scrollbar.min.js') }}"></script>
<script src="{{ asset('admin/assets/js/app.js') }}"></script>
<script>
    $(document).ready(function() {
        App.init();
    });
</script>
<script src="{{ asset('admin/plugins/highlight/highlight.pack.js') }}"></script>
<script src="{{ asset('admin/assets/js/custom.js') }}"></script>
{{-- Datatable --}}
<script src="{{ asset('admin/plugins/table/datatable/datatables.js') }}"></script>
{{-- Chart --}}
<script src="{{ asset('admin/plugins/apex/apexcharts.min.js') }}"></script>
{{-- Dashboard --}}
<script src="{{ asset('admin/assets/js/dashboard/dash_1.js') }}"></script>
{{-- Sweet Alert --}}
<script src="{{ asset('admin/plugins/sweetalerts/sweetalert2.min.js') }}"></script>
<script src="{{ asset('admin/plugins/sweetalerts/custom-sweetalert.js') }}"></script>
{{-- Validation Form --}}
<script src="{{ asset('admin/assets/js/forms/bootstrap_validation/bs_validation_script.js') }}"></script>
{{-- Select2 --}}
<script src="{{ asset('admin/plugins/select2/select2.min.js') }}"></script>
<script src="{{ asset('admin/plugins/select2/custom-select2.js') }}"></script>
{{-- Date Time Picker --}}
<script src="{{ asset('admin/plugins/flatpickr/flatpickr.js') }}"></script>
<script src="{{ asset('admin/plugins/flatpickr/custom-flatpickr.js') }}"></script>
<!-- toastr -->
<script src="{{ asset('admin/plugins/notification/snackbar/snackbar.min.js') }}"></script>
<script src="{{ asset('admin/assets/js/components/notification/custom-snackbar.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
{{-- CkEditor 5 --}}
<script src="{{ asset('admin/assets/js/ckeditor5-build-classic/ckeditor.js') }}"></script>
{{-- Form Step Bar --}}
<script src="{{ asset('admin/assets/js/scrollspyNav.js') }}"></script>
<script src="{{ asset('admin/plugins/jquery-step/jquery.steps.min.js') }}"></script>
<script src="{{ asset('admin/plugins/jquery-step/custom-jquery.steps.js') }}"></script>
{{-- Upload File --}}
<script src="{{ asset('admin/plugins/file-upload/file-upload-with-preview.min.js') }}"></script>
<script src="{{ asset('admin/plugins/dropify/dropify.min.js') }}"></script>
<script src="{{ asset('admin/plugins/blockui/jquery.blockUI.min.js') }}"></script>
<script src="{{ asset('admin/assets/js/users/account-settings.js') }}"></script>
<script>
    var secondUpload = new FileUploadWithPreview('mySecondImage')
</script>
@if(request()->routeIs('login') || request()->routeIs('password.request'))
    <script src="{{ asset('admin/assets/js/authentication/form-1.js') }}"></script>
@endif
@stack('ckEditor')
