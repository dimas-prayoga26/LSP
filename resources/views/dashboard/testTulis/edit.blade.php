<script>
    function handleEdit(elemen) {
        $('#testTulis-modal-title').text('Edit Data Test Tulis');
        $('#btn-form').text('Update');
        const editRoute = elemen.getAttribute('data-route');
        const uuid = elemen.getAttribute('data-uuid');
        const updateRoute = '{{ route("ujianTulis.update", [":uuid"]) }}';
        const form = $('.needs-validation');
        form.attr('action', updateRoute.replace(':uuid', uuid));
        form.attr('data-method', 'PUT');

        if ($('#_method').length === 0) {
            form.append('<input type="hidden" name="_method" id="_method" value="PUT">');
        }
        $('#modal-testTulis').modal('show');

        $.ajax({
            url: editRoute,
            type: 'GET',
            success: function (response) {
                const data = response.data;
                const unitKompetensiSelect = $('#unit_kompetensi_id');
                const kriteriaKerjaSelect = $('#kriteria_unjuk_kerja_id');

                if (window.pertanyaanEditor) {
                    window.pertanyaanEditor.setData(data.pertanyaan);
                }

                if (unitKompetensiSelect.find("option[value='" + data.unit_kompetensi.judul_unit + "']").length) {
                    unitKompetensiSelect.val(data.unit_kompetensi.judul_unit).trigger('change');
                } else {
                    const newOption = new Option(data.unit_kompetensi.judul_unit, data.unit_kompetensi.uuid, true, true);
                    unitKompetensiSelect.append(newOption).trigger('change');
                }

                if (kriteriaKerjaSelect.find("option[value='" + data.kriteria_unjuk_kerja.nama_kriteria_kerja + "']").length) {
                    kriteriaKerjaSelect.val(data.kriteria_unjuk_kerja.nama_kriteria_kerja).trigger('change');
                } else {
                    const newOption = new Option(data.kriteria_unjuk_kerja.nama_kriteria_kerja, data.kriteria_unjuk_kerja.uuid, true, true);
                    kriteriaKerjaSelect.append(newOption).trigger('change');
                }

                const jawabanContainer = $('#jawabanContainer');
                const kunciJawabanSelect = document.getElementById('kunci_jawaban');

                jawabanContainer.empty();
                JSON.parse(data.jawaban).forEach((jawaban, index) => {
                    const label = String.fromCharCode(65 + index);
                    const jawabanRow = `
                        <div class="jawabanRow">
                            <div class="form-row">
                                <div class="col-sm-10">
                                    <div class="input-group mb-4">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="jawaban">${label}</span>
                                        </div>
                                        <input type="text" class="form-control" placeholder="Pilihan jawaban ${label}" name="jawaban[]" value="${jawaban}" required>
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <button type="button" class="btn btn-outline-danger removeJawabanButton">Hapus</button>
                                </div>
                            </div>
                        </div>
                    `;
                    jawabanContainer.append(jawabanRow);
                });

                const kunciJawaban = data.kunci_jawaban;

                kunciJawabanSelect.innerHTML = '<option hidden selected disabled>Please select</option>';
                JSON.parse(data.jawaban).forEach((jawaban, index) => {
                    const label = String.fromCharCode(65 + index);
                    const option = document.createElement('option');
                    option.value = label;
                    option.textContent = `Pilihan jawaban ${label}`;
                    if (label === kunciJawaban) {
                        option.selected = true;
                    }
                    kunciJawabanSelect.appendChild(option);
                });

                $(document).on('click', '.removeJawabanButton', function() {
                    $(this).closest('.jawabanRow').remove();
                    updateKunciJawabanOptions();
                    updateRemoveButtonVisibility();
                });

                function updateKunciJawabanOptions() {
                    const jawabanInputs = $('[name="jawaban[]"]').map(function() {
                        return $(this).val();
                    }).get();

                    kunciJawabanSelect.innerHTML = '<option hidden selected disabled>Please select</option>';
                    jawabanInputs.forEach((jawaban, index) => {
                        const label = String.fromCharCode(65 + index);
                        const option = document.createElement('option');
                        option.value = label;
                        option.textContent = `Pilihan jawaban ${label}`;
                        kunciJawabanSelect.appendChild(option);
                    });
                    updateJawabanLabels();
                }

                function updateJawabanLabels() {
                    $('.input-group-text').each(function(index) {
                        const label = String.fromCharCode(65 + index);
                        $(this).text(label);
                    });
                }

                $(document).on('input', '[name="jawaban[]"]', function() {
                    updateKunciJawabanOptions();
                });
            },
            error: function (xhr, status, error) {
                snackBarAlert('Data gagal dimuat', '#e7515a');
            }
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

</script>
