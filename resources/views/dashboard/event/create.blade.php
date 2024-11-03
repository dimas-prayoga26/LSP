<div class="modal fade" id="modal-event" data-key-modal="modal-event" tabindex="-1" role="dialog" aria-labelledby="event-modal-title" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="event-modal-title"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                </button>
            </div>
            <div class="modal-body">
                    <p><span class="text-danger">*</span> Wajib diisi</p>
                <p class="modal-text">
                    <div class="widget-content widget-content-area">
                        <form class="needs-validation" id="form-event" novalidate method="POST" action="">
                            @csrf
                            <div class="form-row">
                                <div class="col-md-6 mb-4">
                                    <label for="event_mulai">Tanggal Dimulai <span class="text-danger">*</span></label>
                                    <input id="event_mulai" name="event_mulai" class="form-control flatpickr flatpickr-input active @error('event_mulai') is-invalid @enderror" type="text" placeholder="Select Date.." required>
                                    <div class="invalid-feedback">
                                        Kolom tanggal mulai tidak boleh kosong
                                    </div>
                                </div>
                                <div class="col-md-6 mb-4">
                                    <label for="event_selesai">Tanggal Selesai <span class="text-danger">*</span></label>
                                    <input id="event_selesai" name="event_selesai" class="form-control flatpickr flatpickr-input active @error('event_selesai') is-invalid @enderror" type="text" placeholder="Select Date.." required>
                                    <div class="invalid-feedback">
                                        Kolom tanggal selesai tidak boleh kosong
                                    </div>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-md-6 mb-4">
                                    <label for="nama_event">Nama Event <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('nama_event') is-invalid @enderror" name="nama_event" id="nama_event" placeholder="Sertifikasi Kompetensi RPL-A" required>
                                    <div class="invalid-feedback">
                                        Kolom nama event tidak boleh kosong
                                    </div>
                                </div>
                                <div class="col-md-6 mb-4">
                                    <label for="tuk">TUK <span class="text-danger">*</span></label>
                                    <select class="form-control select-tuk @error('tuk') is-invalid @enderror" id="tuk" name="tuk" required>
                                        <option value="" selected disabled>Please select</option>
                                        <option value="Sewaktu">Sewaktu</option>
                                        <option value="Tempat Kerja">Tempat Kerja</option>
                                        <option value="Mandiri">Mandiri</option>
                                    </select>
                                    <div class="invalid-feedback" style="margin-top: -20px">
                                        Kolom tuk tidak boleh kosong
                                    </div>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-12 mb-4">
                                    <label for="keterangan">Deskripsi <span class="text-danger">*</span></label>
                                    <textarea class="form-control @error('keterangan') is-invalid @enderror" id="keterangan" name="keterangan" required cols="30" rows="5"></textarea>
                                    <div class="invalid-feedback">
                                        Kolom deskripsi tidak boleh kosong
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
