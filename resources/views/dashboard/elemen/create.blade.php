<div class="modal fade" id="modal-elemen" data-key-modal="modal-elemen" tabindex="-1" role="dialog" aria-labelledby="elemen-modal-title" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="elemen-modal-title"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                </button>
            </div>
            <div class="modal-body">
                <p><span class="text-danger">*</span> Wajib diisi</p>
                <p class="modal-text">
                    <div class="widget-content widget-content-area">
                        <form class="needs-validation" id="form-elemen" novalidate method="POST" action="">
                            @csrf
                            <div class="form-row">
                                <div class="col-md-6 mb-4">
                                    <label for="nama_elemen">Nama Elemen <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('nama_elemen') is-invalid @enderror" name="nama_elemen" id="nama_elemen" required>
                                    <div class="invalid-feedback">
                                        Kolom nama elemen tidak boleh kosong
                                    </div>
                                </div>
                                <div class="col-md-6 mb-4">
                                    <label for="unit_kompetensi_id">Unit Kompetensi <span class="text-danger">*</span></label>
                                    <select class="form-control select-unitKompetensi @error('unit_kompetensi_id') is-invalid @enderror" name="unit_kompetensi_id" id="unit_kompetensi_id" required>
                                    </select>
                                    <div class="invalid-feedback" style="margin-top: -20px">
                                        Kolom unit kompetensi tidak boleh kosong
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
