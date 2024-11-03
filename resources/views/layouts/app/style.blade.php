@php
    $pengaturan = App\Models\Pengaturan::value('application_icon');
    $image = asset('admin/assets/img/nopict.png');
    if($pengaturan != null) {
        $image = asset('storage/'.$pengaturan);
    }
@endphp
<link rel="icon" type="image/x-icon" href="{{ $image }}"/>
<link href="{{ asset('admin/assets/css/loader.css') }}" rel="stylesheet" type="text/css" />
<script src="{{ asset('admin/assets/js/loader.js') }}"></script>
<link href="https://fonts.googleapis.com/css?family=Quicksand:400,500,600,700&display=swap" rel="stylesheet">
<link href="{{ asset('admin/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('admin/assets/css/plugins.css') }}" rel="stylesheet" type="text/css" />
{{-- DataTable --}}
<link rel="stylesheet" type="text/css" href="{{ asset('admin/plugins/table/datatable/datatables.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('admin/plugins/table/datatable/dt-global_style.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('admin/plugins/table/datatable/custom_dt_custom.css') }}">

<link href="{{ asset('admin/plugins/apex/apexcharts.css') }}" rel="stylesheet" type="text/css">
<link href="{{ asset('admin/assets/css/dashboard/dash_1.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('admin/assets/css/elements/breadcrumb.css') }}" rel="stylesheet" type="text/css" />
{{-- Sweetalert --}}
<link href="{{ asset('admin/plugins/sweetalerts/sweetalert2.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('admin/plugins/sweetalerts/sweetalert.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('admin/assets/css/components/custom-sweetalert.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('admin/assets/css/components/custom-modal.css') }}" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="{{ asset('admin/assets/css/elements/alert.css') }}">
{{-- Select2 --}}
<link rel="stylesheet" type="text/css" href="{{ asset('admin/plugins/select2/select2.min.css') }}">
{{-- Date Time Picker --}}
<link href="{{ asset('admin/plugins/flatpickr/flatpickr.css') }}" rel="stylesheet" type="text/css">
<link href="{{ asset('admin/plugins/flatpickr/custom-flatpickr.css') }}" rel="stylesheet" type="text/css">
{{-- Snackbar --}}
<link href="{{ asset('admin/plugins/notification/snackbar/snackbar.min.css') }}" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="{{ asset('admin/assets/css/widgets/modules-widgets.css') }}">
{{-- Form Step Bar --}}
<link href="{{ asset('admin/assets/css/scrollspyNav.css') }}" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="{{ asset('admin/plugins/jquery-step/jquery.steps.css') }}">
{{-- Upload File --}}
<link href="{{ asset('admin/plugins/file-upload/file-upload-with-preview.min.css') }}" rel="stylesheet" type="text/css" />
{{-- Checkbox Style --}}
<link rel="stylesheet" type="text/css" href="{{ asset('admin/assets/css/forms/theme-checkbox-radio.css') }}">
<style>
    #formValidate .wizard > .content {min-height: 25em;}
    #example-vertical.wizard > .content {min-height: 24.5em;}
</style>
@if(request()->routeIs('login') || request()->routeIs('password.request') || request()->routeIs('password.reset'))
    <link href="{{ asset('admin/assets/css/authentication/form-1.css') }}" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" type="text/css" href="{{ asset('admin/assets/css/forms/theme-checkbox-radio.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('admin/assets/css/forms/switches.css') }}">
@endif
@if(request()->routeIs('profile.*'))
    <link href="{{ asset('admin/assets/css/users/user-profile.css') }}" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" type="text/css" href="{{ asset('admin/plugins/dropify/dropify.min.css') }}">
    <link href="{{ asset('admin/assets/css/users/account-setting.css') }}" rel="stylesheet" type="text/css" />
@endif
<style>
    .ck-editor__editable[role="textbox"] {
        min-height: 200px;
    }
</style>
