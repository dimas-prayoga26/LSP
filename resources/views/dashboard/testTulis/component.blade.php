<script>
    document.addEventListener('DOMContentLoaded', function() {
        getData();
    });
    const testTulisModalPath = $('#modal-testTulis > .modal-dialog > .modal-content');

    $(".select-skema").select2({
        dropdownParent: testTulisModalPath,
        tags: true,
        placeholder: "Pilih Skema",
        allowClear: true,
        ajax: {
            url: '{{ route('skema.list') }}',
            dataType: 'json',
            delay: 250,
            processResults: function (data) {
                return {
                    results: data.data.map(function (item) {
                        return {
                            id: item.uuid,
                            text: item.judul_skema
                        };
                    })
                };
            },
            cache: true
        }
    });

    var unitKompetensiSelect = $(".select-unitKompetensi").select2({
        dropdownParent: testTulisModalPath,
        tags: true,
        placeholder: "Pilih Unit Kompetensi",
        allowClear: true,
        ajax: {
            url: function() {
                return '{{ route('unitKompetensi.listByUuid', ':id_skema') }}'.replace(':id_skema', $(".select-skema").val());
            },
            dataType: 'json',
            delay: 250,
            processResults: function (data) {
                return {
                    results: data.data.map(function (item) {
                        return {
                            id: item.uuid,
                            text: item.judul_unit
                        };
                    })
                };
            },
            cache: true
        }
    });

    $(".select-skema").on('change', function() {
        var selectedSkemaId = $(this).val();
        unitKompetensiSelect.empty().trigger('change');

        unitKompetensiSelect.select2('destroy').select2({
            dropdownParent: testTulisModalPath,
            tags: true,
            placeholder: "Pilih Unit Kompetensi",
            allowClear: true,
            ajax: {
                url: '{{ route('unitKompetensi.listByUuid', ':id_skema') }}'.replace(':id_skema', selectedSkemaId),
                dataType: 'json',
                delay: 250,
                processResults: function (data) {
                    return {
                        results: data.data.map(function (item) {
                            return {
                                id: item.uuid,
                                text: item.judul_unit
                            };
                        })
                    };
                },
                cache: true
            }
        });
    });

    var unjukKerjaSelect = $(".select-unjukKerja").select2({
        dropdownParent: testTulisModalPath,
        tags: true,
        placeholder: "Pilih Kriteria Unjuk Kerja",
        allowClear: true,
        ajax: {
            url: function() {
                return '{{ route('kriteriaUnjukKerja.listByUnitKompetensi', ':id_unitKompetensi') }}'.replace(':id_unitKompetensi', $(".select-unitKompetensi").val());
            },
            dataType: 'json',
            delay: 250,
            processResults: function (data) {
                return {
                    results: data.data.map(function (item) {
                        return {
                            id: item.uuid,
                            text: item.nama_kriteria_kerja
                        };
                    })
                };
            },
            cache: true
        }
    });

    $(".select-unitKompetensi").on('change', function() {
        var selectedUnitKompetensiId = $(this).val();
        unjukKerjaSelect.empty().trigger('change');

        unjukKerjaSelect.select2('destroy').select2({
            dropdownParent: testTulisModalPath,
            tags: true,
            placeholder: "Pilih Kriteria Unjuk Kerja",
            allowClear: true,
            ajax: {
                url: '{{ route('kriteriaUnjukKerja.listByUnitKompetensi', ':id_unitKompetensi') }}'.replace(':id_unitKompetensi', selectedUnitKompetensiId),
                dataType: 'json',
                delay: 250,
                processResults: function (data) {
                    return {
                        results: data.data.map(function (item) {
                            return {
                                id: item.uuid,
                                text: item.nama_kriteria_kerja
                            };
                        })
                    };
                },
                cache: true
            }
        });
    });

    function modalFormCreate(elemen)
    {
        const targetModal = elemen.getAttribute('data-target');
        const form = $('.needs-validation');

        $(`${targetModal}`).modal('show');
        $('#testTulis-modal-title').text('Tambah Data Test Tulis');
        $('#btn-form').text('Simpan');
        form.attr('action','{{ route("ujianTulis.store") }}');
        form.attr('data-method','POST');

        // Reset jawabanContainer
        const jawabanContainer = $('#jawabanContainer');
        jawabanContainer.empty();
        const defaultJawaban = `
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
        `;
        jawabanContainer.append(defaultJawaban);

        // Reset kunci_jawaban
        const kunciJawabanSelect = document.getElementById('kunci_jawaban');
        kunciJawabanSelect.innerHTML = '<option hidden selected disabled>Please select</option>';

        // Default kunci_jawaban
        const defaultOptions = ['A'];
        defaultOptions.forEach(label => {
            const option = document.createElement('option');
            option.value = label;
            option.textContent = `Pilihan jawaban ${label}`;
            kunciJawabanSelect.appendChild(option);
        });

        document.querySelectorAll('.removeJawabanButton').forEach(button => {
            attachRemoveEvent(button);
        });
        updateRemoveButtonVisibility();
    }

    function attachRemoveEvent(button) {
        button.addEventListener('click', function() {
            button.closest('.jawabanRow').remove();
            updateRemoveButtonVisibility();
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

    $('#modal-testTulis').on('hidden.bs.modal', function () {
        $('#form-testTulis').trigger('reset');
        $('#skema_id').val(null).trigger('change');
        if (window.pertanyaanEditor) {
            window.pertanyaanEditor.setData('');
        }
        $('#unit_kompetensi_id').val(null).trigger('change');
        $('#kriteria_unjuk_kerja_id').val(null).trigger('change');

        $('#_method').remove();
    });
</script>
