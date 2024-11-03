<script>
    document.addEventListener('DOMContentLoaded', function() {
        getData()
    });
    const elemenModalPath = $('#modal-kriteriaUnjukKerja > .modal-dialog > .modal-content');

    $(".select-elemen").select2({
        dropdownParent: elemenModalPath,
        tags: true,
        placeholder: "Pilih Elemen",
        allowClear: true,
        ajax: {
        url: '{{ route('elemen.list') }}',
        dataType: 'json',
        delay: 250,
        processResults: function (data) {
                return {
                    results: data.data.map(function (item) {
                        return {
                            id: item.uuid,
                            text: item.nama_elemen
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
        $('#kriteriaUnjukKerja-modal-title').text('Tambah Data Kriteria Unjuk Kerja');
        $('#btn-form').text('Simpan');
        form.attr('action','{{ route("kriteriaUnjukKerja.store") }}');
        form.attr('data-method','POST');
    }

    $('#modal-kriteriaUnjukKerja').on('hidden.bs.modal', function () {
        $('#form-kriteriaUnjukKerja').trigger('reset');
        $('#elemen_id').val(null).trigger('change');
        $('#_method').remove();
    });
</script>
