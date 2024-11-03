<script>
    document.addEventListener('DOMContentLoaded', function() {
        getData()
    });
    const kelompokAsesorModalPath = $('#modal-kelompokAsesor > .modal-dialog > .modal-content');

    $(".select-event").select2({
        dropdownParent: kelompokAsesorModalPath,
        tags: true,
        placeholder: "Pilih Event",
        allowClear: true,
        ajax: {
        url: '{{ route('event.list') }}',
        dataType: 'json',
        delay: 250,
        processResults: function (data) {
                return {
                    results: data.data.map(function (item) {
                        return {
                            id: item.uuid,
                            text: item.nama_event
                        };
                    })
                };
            },
            cache: true
        }
    });
    $(".select-skema").select2({
        dropdownParent: kelompokAsesorModalPath,
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
    $(".select-kelas").select2({
        dropdownParent: kelompokAsesorModalPath,
        tags: true,
        placeholder: "Pilih Kelas",
        allowClear: true,
        ajax: {
        url: '{{ route('kelas.list') }}',
        dataType: 'json',
        delay: 250,
        processResults: function (data) {
                return {
                    results: data.data.map(function (item) {
                        return {
                            id: item.uuid,
                            text: item.nama_kelas
                        };
                    })
                };
            },
            cache: true
        }
    });
    $(".select-asesor").select2({
        dropdownParent: kelompokAsesorModalPath,
        tags: true,
        placeholder: "Pilih Asesor",
        allowClear: true,
        ajax: {
        url: '{{ route('asesor.list') }}',
        dataType: 'json',
        delay: 250,
        processResults: function (data) {
                return {
                    results: data.data.map(function (item) {
                        return {
                            id: item.uuid,
                            text: item.user.name
                        };
                    })
                };
            },
            cache: true
        }
    });

    function modalFormCreate(elemen)
    {
        const targetModal = elemen.getAttribute('data-target');
        const form = $('.needs-validation');

        $(`${targetModal}`).modal('show');
        $('#kelompokAsesor-modal-title').text('Tambah Data Kelompok Asesor');
        $('#btn-form').text('Simpan');
        form.attr('action','{{ route("kelompokAsesor.store") }}');
        form.attr('data-method','POST');
    }

    $('#modal-kelompokAsesor').on('hidden.bs.modal', function () {
        $('#form-kelompokAsesor').trigger('reset');
        $('#event_id').val(null).trigger('change');
        $('#skema_id').val(null).trigger('change');
        $('#kelas_id').val(null).trigger('change');
        $('#asesor_id').val(null).trigger('change');
        $('#_method').remove();
    });
</script>
