<div class="modal fade" id="modal-kelompokAsesor" data-key-modal="modal-kelompokAsesor" tabindex="-1" role="dialog" aria-labelledby="kelompokAsesor-modal-title" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="kelompokAsesor-modal-title">Tambah Data Kelompok Asesor</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                </button>
            </div>
            <div class="modal-body">
                    <p><span class="text-danger">*</span> Wajib diisi</p>
                <p class="modal-text">
                    <div class="widget-content widget-content-area">
                        <form class="needs-validation" id="form-kelompokAsesor" novalidate method="POST" action="">
                            @csrf
                            <div class="form-row">
                                <div class="col-lg-6 mb-4">
                                    <label for="event_id">Event <span class="text-danger">*</span></label>
                                    <select class="form-control select-event @error('event_id') is-invalid @enderror" name="event_id" id="event_id" required>
                                    </select>
                                    <div class="invalid-feedback" style="margin-top: -20px">
                                        Kolom event tidak boleh kosong
                                    </div>
                                </div>
                                <div class="col-lg-6 mb-4">
                                    <label for="skema_id">Skema <span class="text-danger">*</span></label>
                                    <select class="form-control select-skema @error('skema_id') is-invalid @enderror" name="skema_id" id="skema_id" required>
                                    </select>
                                    <div class="invalid-feedback" style="margin-top: -20px">
                                        Kolom skema tidak boleh kosong
                                    </div>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-lg-6 mb-4">
                                    <label for="kelas_id">Kelas <span class="text-danger">*</span></label>
                                    <select class="form-control select-kelas @error('kelas_id') is-invalid @enderror" name="kelas_id" id="kelas_id" required>
                                    </select>
                                    <div class="invalid-feedback" style="margin-top: -20px">
                                        Kolom kelas tidak boleh kosong
                                    </div>
                                </div>
                                <div class="col-lg-6 mb-4">
                                    <label for="asesor_id">Asesor <span class="text-danger">*</span></label>
                                    <select class="form-control select-asesor @error('asesor_id') is-invalid @enderror" name="asesor_id" id="asesor_id" required>
                                    </select>
                                    <div class="invalid-feedback" style="margin-top: -20px">
                                        Kolom asesor tidak boleh kosong
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
