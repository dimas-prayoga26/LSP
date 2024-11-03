<script>
    document.addEventListener('DOMContentLoaded', function() {
        getData()
    });
    const elemenModalPath = $('#modal-elemen > .modal-dialog > .modal-content');

    $(".select-unitKompetensi").select2({
        dropdownParent: elemenModalPath,
        tags: true,
        placeholder: "Pilih Unit Kompetensi",
        allowClear: true,
        ajax: {
        url: '{{ route('unitKompetensi.list') }}',
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

    function modalFormCreate(elemen)
    {
        const targetModal = elemen.getAttribute('data-target');
        const form = $('.needs-validation');

        $(`${targetModal}`).modal('show');
        $('#elemen-modal-title').text('Tambah Data Elemen');
        $('#btn-form').text('Simpan');
        form.attr('action','{{ route("elemen.store") }}');
        form.attr('data-method','POST');
    }

    $('#modal-elemen').on('hidden.bs.modal', function () {
        $('#form-elemen').trigger('reset');
        $('#unit_kompetensi_id').val(null).trigger('change');
        $('#_method').remove();
    });
</script>
