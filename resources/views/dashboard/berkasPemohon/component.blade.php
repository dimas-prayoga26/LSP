<script>
    document.addEventListener('DOMContentLoaded', function() {
        getData()
    });
    const berkasPemohonModalPath = $('#modal-berkasPemohon > .modal-dialog > .modal-content');

    $(".select-skema").select2({
        dropdownParent: berkasPemohonModalPath,
        tags: true,
        placeholder: "Pilih Unit Kompetensi",
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

    function modalFormCreate(elemen)
    {
        const targetModal = elemen.getAttribute('data-target');
        const form = $('.needs-validation');

        $(`${targetModal}`).modal('show');
        $('#berkasPemohon-modal-title').text('Tambah Data Berkas Pemohon');
        $('#btn-form').text('Simpan');
        form.attr('action','{{ route("berkasPemohon.store") }}');
        form.attr('data-method','POST');
    }

    $('#modal-berkasPemohon').on('hidden.bs.modal', function () {
        $('#form-berkasPemohon').trigger('reset');
        $('#skema_id').val(null).trigger('change');
        $('#_method').remove();
    });
</script>
