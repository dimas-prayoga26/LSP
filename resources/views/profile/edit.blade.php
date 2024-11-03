@extends('layouts.app.main')
@section('title','Profile Edit')
@section('content')
    <div class="layout-px-spacing">
        <div class="account-settings-container layout-top-spacing">
            <div class="account-content">
                <div class="scrollspy-example" data-spy="scroll" data-target="#account-settings-scroll" data-offset="-100">
                    <div class="row">
                        <div class="col-xl-12 col-lg-12 col-md-12 layout-spacing">
                            <form id="general-info" class="section general-info" method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                                @csrf
                                @method('patch')
                                <div class="info">
                                    <h6 class="">General Information</h6>
                                    <div class="row">
                                        <div class="col-md-12 text-right mb-5">
                                            <button type="submit" id="add-work-platforms" class="btn btn-primary">Update</button>
                                        </div>
                                        <div class="col-lg-11 mx-auto">
                                            <div class="row">
                                                @php
                                                    $imageProfile = asset('admin/assets/img/nopict.png');
                                                    if(!empty($user->photo) && Storage::disk('public')->exists($user->photo)) {
                                                        $imageProfile = asset('storage/' . $user->photo);
                                                    }
                                                    // dd($imageProfile);
                                                @endphp

                                                <div class="col-xl-2 col-lg-12 col-md-4">
                                                    <div class="upload mt-4 pr-md-4">
                                                        <input type="file" id="input-file-max-fs" name="photo" class="dropify" data-default-file="{{ $imageProfile }}" data-max-file-size="2M" />
                                                        <p class="mt-2"><i class="flaticon-cloud-upload mr-1"></i> Upload Picture</p>
                                                    </div>
                                                    <small>Available accepted JPG,JPEG,PNG. Max: 2MB</small>
                                                </div>
                                                <div class="col-xl-10 col-lg-12 col-md-8 mt-md-0 mt-4">
                                                    <div class="form">
                                                        <div class="row">
                                                            <div class="col-sm-6">
                                                                <div class="form-group">
                                                                    <label for="name">Nama Lengkap (Tanpa Gelar)</label>
                                                                    <input type="text" class="form-control mb-4" id="name" placeholder="Full Name" name="name" value="{{ $user->name }}">
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6">
                                                                <div class="form-group">
                                                                    <label for="email">Email</label>
                                                                    <input type="email" class="form-control mb-4" id="email" placeholder="Email" name="email" value="{{ $user->email }}">
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6">
                                                                <div class="form-group">
                                                                    <label for="phone">No. Telp</label>
                                                                    <input type="number" class="form-control mb-4" id="phone" placeholder="08*****" name="phone" value="{{ $user->phone }}">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label for="jenis_kelamin">Jenis Kelamin</label>
                                                                <select class="form-control mb-4" id="s-from1" name="jenis_kelamin">
                                                                    <option value="" @selected($user->jenis_kelamin !== 'Laki-laki' && $user->jenis_kelamin !== 'Perempuan')>Pilih jenis kelamin</option>
                                                                    <option @selected($user->jenis_kelamin === 'Laki-laki') value="Laki-laki">Laki-laki</option>
                                                                    <option @selected($user->jenis_kelamin === 'Perempuan') value="Perempuan">Perempuan</option>
                                                                </select>
                                                            </div>
                                                            <div class="col-md-12">
                                                                <textarea class="form-control" placeholder="Alamat" name="address" rows="10">{{ $user->address }}</textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="col-xl-12 col-lg-12 col-md-12 layout-spacing">
                            <form id="contact" class="section contact" method="POST" action="{{ route('password.update') }}">
                                @csrf
                                @method('put')
                                <div class="info">
                                    <h5 class="">Password Edit</h5>
                                    <div class="row">
                                        <div class="col-md-12 text-right mb-5">
                                            <button type="submit" id="add-work-platforms" class="btn btn-primary">Update</button>
                                        </div>
                                        <div class="col-md-11 mx-auto">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="update_password_current_password">Password Lama</label>
                                                        <input type="password" name="current_password" class="form-control mb-4" id="update_password_current_password">
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="update_password_password">Password Baru</label>
                                                        <input type="password" name="password" class="form-control mb-4" id="update_password_password">
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="update_password_password_confirmation">Konfirmasi Password Baru</label>
                                                        <input type="password" name="password_confirmation" class="form-control mb-4" id="update_password_password_confirmation">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
       $(document).ready(function(){
            $('.dropify').dropify();
        });

    
    </script>
@endsection
