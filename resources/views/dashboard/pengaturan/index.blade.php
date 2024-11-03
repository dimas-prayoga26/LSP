@extends('layouts.app.main')
@section('title','Pengaturan')
@section('content')
<div class="row layout-top-spacing" id="cancel-row">
    <div id="breadcrumbDefault" class="col-xl-12 col-lg-12 layout-spacing">
        <nav class="breadcrumb-one" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-home"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg></a></li>
                <li class="breadcrumb-item dropdown">
                    <a class="dropdown-toggle" href="#" role="button" id="pendingTask" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                        Pengaturan UMUM
                    </a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">Pengaturan</li>
            </ol>
        </nav>
    </div>
    <div class="col-lg-12">
        <div class="statbox widget box box-shadow">
            <p><span class="text-danger">*</span> Wajib diisi</p>
            <div class="widget-content widget-content-area">
                <form class="needs-validation" id="form-pengaturan" novalidate method="POST" action="{{ route('pengaturan.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="form-row">
                        <div class="col-md-6 mb-4">
                            <div class="d-flex">
                                <div id="file-available-logo"></div>
                                <span class="ml-2 text-danger" style="cursor: pointer" title="Delete Logo" id="delete-icon-logo" onclick="deleteImage('logo')">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg>
                                </span>
                            </div>
                            <label for="application_logo">Logo</label>
                            <input type="file" class="form-control @error('application_logo') is-invalid @enderror" name="application_logo" id="application_logo" accept=".jpg,.jpeg,.png">
                            <small>Accepted .png,.jpg,.jpeg Max. total size 2 MB</small>
                        </div>
                        <div class="col-md-6 mb-4">
                            <div class="d-flex">
                                <div id="file-available-favicon"></div>
                                <span class="ml-2 text-danger" style="cursor: pointer" title="Delete Favicon" id="delete-icon-favicon" onclick="deleteImage('favicon')">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg>
                                </span>
                            </div>
                            <label for="application_icon">Favicon</label>
                            <input type="file" class="form-control @error('application_icon') is-invalid @enderror" name="application_icon" id="application_icon" >
                            <small>Accepted .ico Max. total size 1 MB</small>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-6 mb-4">
                            <label for="application_name">Nama Website <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('application_name') is-invalid @enderror" name="application_name" id="application_name" value="{{ old('application_name', $pengaturan['application_name'] ?? '') }}" required>
                            <div class="invalid-feedback">
                                Kolom nama website tidak boleh kosong
                            </div>
                        </div>
                        <div class="col-md-6 mb-4">
                            <label for="application_short_name">Alias Web/ Short Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('application_short_name') is-invalid @enderror" name="application_short_name" id="application_short_name" required value="{{ old('application_short_name', $pengaturan['application_short_name']  ?? '') }}">
                            <div class="invalid-feedback">
                                Kolom nama alias website tidak boleh kosong
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-6 mb-4">
                            <label for="application_email">Email<span class="text-danger">*</span></label>
                            <input type="email" class="form-control @error('application_email') is-invalid @enderror" name="application_email" id="application_email" required value="{{ old('application_email', $pengaturan['application_email'] ?? '') }}">
                            <div class="invalid-feedback">
                                Kolom email website tidak boleh kosong
                            </div>
                        </div>
                        <div class="col-md-6 mb-4">
                            <label for="application_contact">Kontak <span class="text-danger">*</span></label>
                            <input type="tel" class="form-control @error('application_contact') is-invalid @enderror" name="application_contact" id="application_contact" required value="{{ old('application_contact', $pengaturan['application_contact'] ?? '') }}">
                            <div class="invalid-feedback">
                                Kolom kontak website tidak boleh kosong
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-4 mb-4">
                            <label for="instagram_account">Instagram</label>
                            <div class="input-group mb-4">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon7">
                                        <img src="{{ asset('admin/assets/img/icon/instagram.svg') }}" width="30" height="30" alt="instagram">
                                    </span>
                                </div>
                                <input type="text" class="form-control" id="instagram_account" name="instagram_account" aria-describedby="basic-addon3" placeholder="Masukkan username" value="{{ old('instagram_account', $pengaturan['instagram_account'] ?? '') }}">
                            </div>
                        </div>
                        <div class="col-md-4 mb-4">
                            <label for="facebook_account">Facebook</label>
                            <div class="input-group mb-4">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon7">
                                        <img src="{{ asset('admin/assets/img/icon/facebook.svg') }}" width="30" height="30" alt="facebook">
                                    </span>
                                </div>
                                <input type="text" class="form-control" id="facebook_account" name="facebook_account" aria-describedby="basic-addon3" placeholder="Masukkan nama" value="{{ old('facebook_account', $pengaturan['facebook_account'] ?? '') }}">
                            </div>
                        </div>
                        <div class="col-md-4 mb-4">
                            <label for="whatsapp_account">WhatsApp</label>
                            <div class="input-group mb-4">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon7">
                                        <img src="{{ asset('admin/assets/img/icon/whatsapp.svg') }}" width="30" height="30" alt="whatsapp">
                                    </span>
                                </div>
                                <input type="text" class="form-control" id="whatsapp_account" name="whatsapp_account" aria-describedby="basic-addon3" placeholder="Masukkan nomor" value="{{ old('whatsapp_account', $pengaturan['whatsapp_account'] ?? '') }}">
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-4 mb-4">
                            <label for="twitter_account">Twitter X</label>
                            <div class="input-group mb-4">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon7">
                                        <img src="{{ asset('admin/assets/img/icon/twitterX.svg') }}" width="30" height="30" alt="twitter">
                                    </span>
                                </div>
                                <input type="text" class="form-control" id="twitter_account" name="twitter_account" aria-describedby="basic-addon3" placeholder="Masukkan username" value="{{ old('twitter_account', $pengaturan['twitter_account'] ?? '') }}">
                            </div>
                        </div>
                        <div class="col-md-4 mb-4">
                            <label for="youtube_account">YouTube</label>
                            <div class="input-group mb-4">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon7">
                                        <img src="{{ asset('admin/assets/img/icon/youtube.svg') }}" width="30" height="30" alt="youtube">
                                    </span>
                                </div>
                                <input type="text" class="form-control" id="youtube_account" name="youtube_account" aria-describedby="basic-addon3" placeholder="Masukkan nama" value="{{ old('youtube_account', $pengaturan['youtube_account'] ?? '') }}">
                            </div>
                        </div>
                        <div class="col-md-4 mb-4">
                            <label for="linkedin_account">Linked In</label>
                            <div class="input-group mb-4">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon7">
                                        <img src="{{ asset('admin/assets/img/icon/linkedin.svg') }}" width="30" height="30" alt="linkedin">
                                    </span>
                                </div>
                                <input type="text" class="form-control" id="linkedin_account" name="linkedin_account" aria-describedby="basic-addon3" placeholder="Masukkan nama" value="{{ old('linkedin', $pengaturan['linkedin'] ?? '') }}">
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-6 mb-4">
                            <label for="application_footer">Footer<span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('application_footer') is-invalid @enderror" name="application_footer" id="application_footer" required value="{{ old('application_footer', $pengaturan['application_footer'] ?? '') }}">
                            <div class="invalid-feedback">
                                Kolom footer website tidak boleh kosong
                            </div>
                        </div>
                        <div class="col-md-6 mb-4">
                            <label for="application_prefix_title">Prefix Title<span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('application_prefix_title') is-invalid @enderror" name="application_prefix_title" id="application_prefix_title" required value="{{ old('application_prefix_title', $pengaturan['application_prefix_title'] ?? '') }}">
                            <div class="invalid-feedback">
                                Kolom prefix title website tidak boleh kosong
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-12 mb-4">
                            <label for="application_description">Deskripsi Website<span class="text-danger">*</span></label>
                            <textarea class="form-control @error('application_description') is-invalid @enderror" id="application_description" name="application_description" cols="30" rows="3" required>{!! old('application_description', $pengaturan['application_description'] ?? '') !!}</textarea>
                            <div class="invalid-feedback">
                                Kolom deskripsi website tidak boleh kosong
                            </div>
                        </div>
                    </div>
                    <button class="btn btn-primary mt-3 text-center" id="btn-form" type="submit">Simpan</button>
                </form>
            </div>
        </div>
    </div>
</div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            getData()
        });
        function getData() {
            $.ajax({
                url: "{{ route('pengaturan.datatable') }}",
                type: 'GET',
                success: function(response) {
                    const data = response.data;
                    const urlLogo = `{{ asset('storage/${data.application_logo}') }}`;
                    const urlIcon = `{{ asset('storage/${data.application_icon}') }}`;
                    const urlNoPict = `{{ asset('admin/assets/img/nopict.png') }}`;

                    $('#application_name').val(data.application_name);
                    $('#application_short_name').val(data.application_short_name);
                    $('#application_email').val(data.application_email);
                    $('#application_contact').val(data.application_contact);
                    $('#instagram_account').val(data.instagram_account);
                    $('#facebook_account').val(data.facebook_account);
                    $('#whatsapp_account').val(data.whatsapp_account);
                    $('#twitter_account').val(data.twitter_account);
                    $('#youtube_account').val(data.youtube_account);
                    $('#linkedin_account').val(data.linkedin_account);
                    $('#application_footer').val(data.application_footer);
                    $('#application_prefix_title').val(data.application_prefix_title);
                    $('#application_description').val(data.application_description);
                    if(data.application_logo) {
                        $('#delete-icon-logo').removeClass('d-none');
                        $('#file-available-logo').html(`<img src="${urlLogo}" class="rounded-circle" style="width:70px; height:70px"/>`);
                    } else {
                        $('#delete-icon-logo').addClass('d-none');
                        $('#file-available-logo').html(`<img src="${urlNoPict}" class="rounded-circle" style="width:70px; height:70px"/>`);
                    }
                    if(data.application_icon) {
                        $('#delete-icon-favicon').removeClass('d-none');
                        $('#file-available-favicon').html(`<img src="${urlIcon}" class="rounded-circle" style="width:70px; height:70px"/>`);
                    } else {
                        $('#delete-icon-favicon').addClass('d-none');
                        $('#file-available-favicon').html(`<img src="${urlNoPict}" class="rounded-circle" style="width:70px; height:70px"/>`);
                    }
                },
                error: function(xhr, status, error) {
                    snackBarAlert('Data gagal dimuat', '#e7515a');
                }
            });
        }

        function deleteImage(type) {
            const deleteRoute = '{{ route("pengaturan.image-delete", [":type"]) }}';
            const deleteRouteRendered = deleteRoute.replace(':type', type);

            $.ajax({
                url: deleteRouteRendered,
                type: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                success: function(response) {
                    swal(
                        'Terhapus!',
                        'Image berhasil dihapus',
                        'success'
                        )
                    getData();
                },
                error: function(xhr, status, error) {
                    swal(
                    'Gagal Terhapus!',
                    'Data terpilih gagal terhapus',
                    'error'
                    )
                }
            });
        }
    </script>
    @push('ckEditor')
        <script>
            ClassicEditor
                .create(document.querySelector('#application_description'), {
                    toolbar: {
                        items: [
                            'exportPDF','exportWord', '|',
                            'findAndReplace', 'selectAll', '|',
                            'heading', '|',
                            'bold', 'italic', 'strikethrough', 'underline', 'code', 'subscript', 'superscript', 'removeFormat', '|',
                            'bulletedList', 'numberedList', 'todoList', '|',
                            'outdent', 'indent', '|',
                            'undo', 'redo',
                            '-',
                            'fontSize', 'fontFamily', 'fontColor', 'fontBackgroundColor', 'highlight', '|',
                            'alignment', '|',
                            'link', 'blockQuote', 'insertTable', 'codeBlock', 'htmlEmbed', '|',
                            'specialCharacters', 'horizontalLine', 'pageBreak', '|',
                            'textPartLanguage', '|',
                            'sourceEditing'
                        ],
                        shouldNotGroupWhenFull: true
                    },
                    placeholder: 'Ketikkan deskripsi website...',
                })
                .catch(error => {
                    console.error(error);
                });
        </script>
    @endpush
@endsection
