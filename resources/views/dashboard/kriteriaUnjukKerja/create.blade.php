<div class="modal fade" id="modal-kriteriaUnjukKerja" data-key-modal="modal-kriteriaUnjukKerja" tabindex="-1" role="dialog" aria-labelledby="kriteriaUnjukKerja-modal-title" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="kriteriaUnjukKerja-modal-title"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                </button>
            </div>
            <div class="modal-body">
                    <p><span class="text-danger">*</span> Wajib diisi</p>
                <p class="modal-text">
                    <div class="widget-content widget-content-area">
                        <form class="needs-validation" id="form-kriteriaUnjukKerja" novalidate method="POST" action="">
                            @csrf
                            <div class="form-row">
                                <div class="col-md-6 mb-4">
                                    <label for="nama_kriteria_kerja">Nama Kriteria <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('nama_kriteria_kerja') is-invalid @enderror" name="nama_kriteria_kerja" id="nama_kriteria_kerja" required>
                                    <div class="invalid-feedback">
                                        Kolom nama kriteria tidak boleh kosong
                                    </div>
                                </div>
                                <div class="col-md-6 mb-4">
                                    <label for="elemen_id">Elemen <span class="text-danger">*</span></label>
                                    <select class="form-control select-elemen @error('elemen_id') is-invalid @enderror" name="elemen_id" id="elemen_id" required>
                                    </select>
                                    <div class="invalid-feedback" style="margin-top: -20px">
                                        Kolom elemen tidak boleh kosong
                                    </div>
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
