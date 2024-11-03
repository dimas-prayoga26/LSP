<script>
    document.addEventListener('DOMContentLoaded', function() {
        getData();
    });
    const testWawancaraModalPath = $('#modal-testWawancara > .modal-dialog > .modal-content');

    $(".select-skema").select2({
        dropdownParent: testWawancaraModalPath,
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
        dropdownParent: testWawancaraModalPath,
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
            dropdownParent: testWawancaraModalPath,
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
        dropdownParent: testWawancaraModalPath,
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
            dropdownParent: testWawancaraModalPath,
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
        $('#testWawancara-modal-title').text('Tambah Data Test Wawancara');
        $('#btn-form').text('Simpan');
        form.attr('action','{{ route("ujianWawancara.store") }}');
        form.attr('data-method','POST');
    }

    $('#modal-testWawancara').on('hidden.bs.modal', function () {
        $('#form-testWawancara').trigger('reset');
        $('#skema_id').val(null).trigger('change');
        if (window.pertanyaanEditor) {
            window.pertanyaanEditor.setData('');
        }
        $('#unit_kompetensi_id').val(null).trigger('change');
        $('#kriteria_unjuk_kerja_id').val(null).trigger('change');

        $('#_method').remove();
    });
</script>
