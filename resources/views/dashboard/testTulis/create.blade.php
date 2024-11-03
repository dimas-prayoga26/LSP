<div class="modal fade" id="modal-testTulis" data-key-modal="modal-testTulis" tabindex="-1" role="dialog" aria-labelledby="testTulis-modal-title" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="testTulis-modal-title">Tambah Data Test Tulis</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                </button>
            </div>
            <div class="modal-body">
                    <p><span class="text-danger">*</span> Wajib diisi</p>
                <p class="modal-text">
                    <div class="widget-content widget-content-area">
                        <form class="needs-validation" id="form-testTulis" novalidate method="POST" action="">
                            @csrf
                            <div class="form-row">
                                <div class="col-12 mb-2">
                                    <label for="skema_id">Skema</label>
                                    <select class="form-control select-skema @error('skema_id') is-invalid @enderror" name="skema_id" id="skema_id"></select>
                                </div>
                                <div class="col-12 mb-2">
                                    <label for="unit_kompetensi_id">Unit Kompetensi <span class="text-danger">*</span></label>
                                    <select class="form-control select-unitKompetensi @error('unit_kompetensi_id') is-invalid @enderror" name="unit_kompetensi_id" id="unit_kompetensi_id" required></select>
                                    <div class="invalid-feedback" style="margin-top: -20px">
                                        Kolom unit kompetensi tidak boleh kosong
                                    </div>
                                </div>
                                <div class="col-12 mb-2">
                                    <label for="kriteria_unjuk_kerja_id">Kriteria Unjuk Kerja <span class="text-danger">*</span></label>
                                    <select class="form-control select-unjukKerja @error('kriteria_unjuk_kerja_id') is-invalid @enderror" name="kriteria_unjuk_kerja_id" id="kriteria_unjuk_kerja_id" required></select>
                                    <div class="invalid-feedback" style="margin-top: -20px">
                                        Kolom kriteria unjuk kerja tidak boleh kosong
                                    </div>
                                </div>
                                <div class="col-12 mb-2">
                                    <label for="pertanyaan">Pertanyaan Soal <span class="text-danger">*</span></label>
                                    <div class="widget-content widget-content-area">
                                        <textarea class="form-control @error('pertanyaan') is-invalid @enderror" id="pertanyaan" name="pertanyaan"></textarea>
                                    </div>
                                    <div class="invalid-feedback">
                                        Kolom pertanyaan tidak boleh kosong
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="kunci_jawaban">Kunci Jawaban</label>
                                    <select class="form-control select-standar @error('kunci_jawaban') is-invalid @enderror" name="kunci_jawaban" id="kunci_jawaban">
                                        <option hidden selected disabled>Please select</option>
                                    </select>
                                </div>
                            </div>
                            <div id="jawabanContainer">
                                <div class="jawabanRow">
                                    <div class="form-row">
                                        <div class="col-sm-10">
                                            <div class="input-group mb-4">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" id="jawaban">A</span>
                                                </div>
                                                <input type="text" class="form-control" placeholder="Pilihan jawaban A" name="jawaban[]" required>
                                            </div>
                                        </div>
                                        <div class="col-sm-2">
                                            <button type="button" class="btn btn-outline-danger removeJawabanButton">Hapus</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-sm-10">
                                    <button type="button" class="btn btn-outline-info" id="addJawabanButton">Tambah Pilihan Jawaban</button>
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
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const jawabanContainer = document.getElementById('jawabanContainer');
        const kunciJawabanSelect = document.getElementById('kunci_jawaban');

        function attachRemoveEvent(button) {
            button.addEventListener('click', function() {
                button.closest('.jawabanRow').remove();
                updateJawabanLabels();
                updateRemoveButtonVisibility();
            });
        }

        document.querySelectorAll('.removeJawabanButton').forEach(button => {
            attachRemoveEvent(button);
        });

        document.getElementById('addJawabanButton').addEventListener('click', function() {
            const lastJawabanRow = jawabanContainer.querySelector('.jawabanRow:last-child');
            const newJawabanRow = lastJawabanRow.cloneNode(true);

            newJawabanRow.querySelectorAll('input').forEach(input => {
                input.value = '';
            });

            jawabanContainer.appendChild(newJawabanRow);
            updateJawabanLabels();
            attachRemoveEvent(newJawabanRow.querySelector('.removeJawabanButton'));
            updateRemoveButtonVisibility();
        });

        function updateJawabanLabels() {
            const jawabanRows = jawabanContainer.querySelectorAll('.jawabanRow');
            kunciJawabanSelect.innerHTML = '<option hidden selected disabled>Please select</option>';
            jawabanRows.forEach((row, index) => {
                const label = String.fromCharCode(65 + index);
                row.querySelector('.input-group-text').textContent = label;
                row.querySelector('input').placeholder = `Pilihan jawaban ${label}`;
                const option = document.createElement('option');
                option.value = label;
                option.textContent = `Pilihan jawaban ${label}`;
                kunciJawabanSelect.appendChild(option);
            });
        }

        function updateRemoveButtonVisibility() {
            const jawabanRows = jawabanContainer.querySelectorAll('.jawabanRow');
            if (jawabanRows.length > 1) {
                document.querySelectorAll('.removeJawabanButton').forEach(button => {
                    button.style.display = 'inline-block';
                });
            } else {
                document.querySelector('.removeJawabanButton').style.display = 'none';
            }
        }

        updateJawabanLabels();
        updateRemoveButtonVisibility();
    });
</script>
@push('ckEditor')
    <script>
        ClassicEditor
            .create(document.querySelector('#pertanyaan'), {
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
                placeholder: 'Ketikkan pertanyaan soal...',
            })
            .then(editor => {
                window.pertanyaanEditor = editor;
            })
            .catch(error => {
                console.error(error);
            });
    </script>
@endpush
