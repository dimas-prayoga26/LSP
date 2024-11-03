<script>
    document.addEventListener('DOMContentLoaded', function() {
        getData()
    });
    function modalFormCreate(elemen)
    {
        const targetModal = elemen.getAttribute('data-target');
        const form = $('.needs-validation');

        $(`${targetModal}`).modal('show');
        $('#kelas-modal-title').text('Tambah Data Kelas');
        $('#btn-form').text('Simpan');
        form.attr('action','{{ route("kelas.store") }}');
        form.attr('data-method','POST');
    }

    $('#modal-kelas').on('hidden.bs.modal', function () {
        $('#form-kelas').trigger('reset');
        $('#jurusan_id').val(null).trigger('change');
        $('#_method').remove();
    });
</script>
