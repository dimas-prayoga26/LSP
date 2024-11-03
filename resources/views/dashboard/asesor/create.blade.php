<div class="modal fade" id="modal-asesor" data-key-modal="modal-asesor" tabindex="-1" role="dialog" aria-labelledby="asesor-modal-title" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="asesor-modal-title"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                </button>
            </div>
            <div class="modal-body">
                    <p><span class="text-danger">*</span> Wajib diisi</p>
                <p class="modal-text">
                    <div class="widget-content widget-content-area">
                        <form class="needs-validation" id="form-asesor" novalidate method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="form-row">
                                <div class="col-md-6 mb-4">
                                    <label for="nip">NIP <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('nip') is-invalid @enderror" name="nip" id="nip" required>
                                    <div class="invalid-feedback">
                                        Kolom nip tidak boleh kosong
                                    </div>
                                </div>
                                <div class="col-md-6 mb-4">
                                    <label for="name">Nama Lengkap <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" id="name" required>
                                    <div class="invalid-feedback">
                                        Kolom nama tidak boleh kosong
                                    </div>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-md-6 mb-4">
                                    <label for="email">Email <span class="text-danger">*</span></label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" id="email" required>
                                    <div class="invalid-feedback">
                                        Kolom email tidak boleh kosong
                                    </div>
                                </div>
                                <div class="col-md-6 mb-4">
                                    <label for="phone">No. Telp</label>
                                    <input type="tel" class="form-control @error('phone') is-invalid @enderror" name="phone" id="phone" placeholder="08*****">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-md-6 mb-4">
                                    <label for="photo">Photo</label>
                                    <input type="file" class="form-control @error('photo') is-invalid @enderror" name="photo" id="photo" accept=".jpg,.jpeg,.png">
                                    <small>Accepted .png,.jpg,.jpeg Max. total size 2 MB</small>
                                    <div id="container-file-photo-show">
                                        <p>Available File: <small id="file-available-photo"></small></p>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-4">
                                    <label for="surat_tugas">Surat Tugas</label>
                                    <input type="file" class="form-control @error('surat_tugas') is-invalid @enderror" name="surat_tugas" id="surat_tugas" accept=".pdf">
                                    <small>Accepted .pdf Max. total size 5 MB</small>
                                    <div id="container-file-suratTugas-show">
                                        <p>Available File: <small id="file-available-suratTugas"></small></p>
                                    </div>
                                </div>
                            </div>
                            <div class="form-row" id="editForm-container">
                                <div class="col-md-6 mb-4">
                                    <label for="password">Password</label>
                                    <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" id="password">
                                </div>
                                <div class="col-md-6 mb-4">
                                    <label for="username">Username</label>
                                    <input type="text" class="form-control @error('username') is-invalid @enderror" name="username" id="username">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-md-6 mb-4">
                                    <label for="jenis_kelamin">Jenis Kelamin</label>
                                    <select class="form-control select-standar @error('jenis_kelamin') is-invalid @enderror" name="jenis_kelamin" id="jenis_kelamin">
                                        <option hidden selected disabled >Please select</option>
                                        <option value="Laki-laki">Laki-laki</option>
                                        <option value="Perempuan">Perempuan</option>
                                    </select>
                                </div>
                                <div class="col-md-6 mb-4" id="editForm-status">
                                    <label for="status">Status</label>
                                    <select class="form-control select-standar @error('status') is-invalid @enderror" name="status" id="status">
                                        <option hidden selected disabled >Please select</option>
                                        <option value="active">active</option>
                                        <option value="nonactive">nonactive</option>
                                    </select>
                                </div>
                                <div class="col-md-6 mb-4">
                                    <label for="address">Alamat</label>
                                    <textarea class="form-control @error('address') is-invalid @enderror" id="address" name="address" cols="30" rows="3"></textarea>
                                </div>
                            </div>
                            <button class="btn btn-primary mt-3 text-center" id="btn-form" type="submit">Simpan</button>
                        </form>
                    </div>
                </p>
            </div>
        </div>
    </div>
</div>
