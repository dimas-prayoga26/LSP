<script>
    document.addEventListener('DOMContentLoaded', function() {
        getData()
    });
    const skemaModalPath = $('#modal-skema > .modal-dialog > .modal-content');
    $(".select-standar").select2({
        dropdownParent: skemaModalPath,
        tags: true,
        placeholder: "Pilih Jenis Standar",
        allowClear: true
    });

    $(".select-event").select2({
        dropdownParent: skemaModalPath,
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

    function modalFormCreate(elemen)
    {
        const targetModal = elemen.getAttribute('data-target');
        const form = $('.needs-validation');

        $(`${targetModal}`).modal('show');
        $('#skema-modal-title').text('Tambah Data Skema');
        $('#btn-form').text('Simpan');
        form.attr('action','{{ route("skema.store") }}');
        form.attr('data-method','POST');
    }

    $('#modal-skema').on('hidden.bs.modal', function () {
        $('#form-skema').trigger('reset');
        $('#event_id').val(null).trigger('change');
        $('#jenis_standar').val(null).trigger('change');
        $('#_method').remove();
    });
</script>
