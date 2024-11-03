<script>
    document.addEventListener('DOMContentLoaded', function() {
        getData()
    });
    function modalFormCreate(elemen)
    {
        const targetModal = elemen.getAttribute('data-target');
        const form = $('.needs-validation');

        $(`${targetModal}`).modal('show');
        $('#jurusan-modal-title').text('Tambah Data Jurusan');
        $('#btn-form').text('Simpan');
        form.attr('action','{{ route("jurusan.store") }}');
        form.attr('data-method','POST');
    }

    $('#modal-jurusan').on('hidden.bs.modal', function () {
        $('#form-jurusan').trigger('reset');
        $('#_method').remove();
    });
</script>
