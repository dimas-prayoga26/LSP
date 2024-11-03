<script>
    document.addEventListener('DOMContentLoaded', function() {
        getData()
    });
    function modalFormCreate(elemen)
    {
        const targetModal = elemen.getAttribute('data-target');
        const form = $('.needs-validation');

        $('#container-file-photo-show').addClass('d-none');
        $('#container-file-suratTugas-show').addClass('d-none');
        $('#editForm-container').addClass('d-none');
        $('#editForm-status').addClass('d-none');
        $(`${targetModal}`).modal('show');
        $('#asesor-modal-title').text('Tambah Asesor');
        $('#btn-form').text('Simpan');
        form.attr('action','{{ route("asesor.store") }}');
        form.attr('data-method','POST');
    }

    $('#modal-asesor').on('hidden.bs.modal', function () {
        $('#form-asesor').trigger('reset');
        $('#_method').remove();
    });
</script>
