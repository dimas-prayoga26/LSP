<script>
    document.addEventListener('DOMContentLoaded', function() {
        getData()
    });
    const kelasModal = $('#modal-event > .modal-dialog > .modal-content');
    $(".select-tuk").select2({
        dropdownParent: kelasModal,
        tags: true,
        placeholder: "Pilih TUK",
        allowClear: true
    });

    function modalFormCreate(elemen)
    {
        const targetModal = elemen.getAttribute('data-target');
        const form = $('.needs-validation');

        $(`${targetModal}`).modal('show');
        $('#event-modal-title').text('Tambah Data Event');
        $('#btn-form').text('Simpan');
        form.attr('action','{{ route("event.store") }}');
        form.attr('data-method','POST');

        flatpickr(document.getElementById('event_mulai'), {
            enableTime: true,
            dateFormat: "Y-m-d H:i",
            time_24hr: true
        });
        flatpickr(document.getElementById('event_selesai'), {
            enableTime: true,
            dateFormat: "Y-m-d H:i",
            time_24hr: true
        });
    }

    $('#modal-event').on('hidden.bs.modal', function () {
        $('#form-event').trigger('reset');
        $('#tuk').val(null).trigger('change');
        $('#_method').remove();
    });
</script>
