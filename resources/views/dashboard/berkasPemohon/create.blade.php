<div class="modal fade" id="modal-berkasPemohon" data-key-modal="modal-berkasPemohon" tabindex="-1" role="dialog" aria-labelledby="berkasPemohon-modal-title" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="berkasPemohon-modal-title"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                </button>
            </div>
            <div class="modal-body">
                    <p><span class="text-danger">*</span> Wajib diisi</p>
                <p class="modal-text">
                    <div class="widget-content widget-content-area">
                        <form class="needs-validation" id="form-berkasPemohon" novalidate method="POST" action="">
                            @csrf
                            <div class="form-row">
                                <div class="col-md-6 mb-4">
                                    <label for="nama_berkas">Nama Berkas <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('nama_berkas') is-invalid @enderror" name="nama_berkas" id="nama_berkas" required>
                                    <div class="invalid-feedback">
                                        Kolom nama berkas tidak boleh kosong
                                    </div>
                                </div>
                                <div class="col-md-6 mb-4">
                                    <label for="skema_id">Skema <span class="text-danger">*</span></label>
                                    <select class="form-control select-skema @error('skema_id') is-invalid @enderror" name="skema_id" id="skema_id" required>
                                    </select>
                                    <div class="invalid-feedback" style="margin-top: -20px">
                                        Kolom skema tidak boleh kosong
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
