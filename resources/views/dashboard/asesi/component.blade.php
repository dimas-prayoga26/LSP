<script>
    document.addEventListener('DOMContentLoaded', function() {
        getData()
    });

    const kelasModalPath = $('#modal-asesi > .modal-dialog > .modal-content');

    $(".select-kelas").select2({
        dropdownParent: kelasModalPath,
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

    function modalFormCreate(elemen)
    {
        const targetModal = elemen.getAttribute('data-target');
        const form = $('.needs-validation');

        $('#container-file-photo-show').addClass('d-none');
        $('#editForm-container').addClass('d-none');
        $('#editForm-status').addClass('d-none');
        $('#editForm-status-assesmen').addClass('d-none');
        $(`${targetModal}`).modal('show');
        $('#asesi-modal-title').text('Tambah Asesi');
        $('#btn-form').text('Simpan');
        form.attr('action','{{ route("asesi.store") }}');
        form.attr('data-method','POST');
    }

    $('#modal-asesi').on('hidden.bs.modal', function () {
        $('#form-asesi').trigger('reset');
        $('#kelas_id').val(null).trigger('change');
        $('#_method').remove();
    });
</script>
