<script>
    function handleEdit(elemen) {
        $('#event-modal-title').text('Edit Data Event');
        $('#btn-form').text('Update');
        const editRoute = elemen.getAttribute('data-route');
        const uuid = elemen.getAttribute('data-uuid');
        const updateRoute = '{{ route("event.update", [":uuid"]) }}';
        const form = $('.needs-validation');
        form.attr('action', updateRoute.replace(':uuid', uuid));
        form.attr('data-method','PUT');

        if ($('#_method').length === 0) {
            form.append('<input type="hidden" name="_method" id="_method" value="PUT">');
        }
        $('#modal-event').modal('show');
        $.ajax({
            url: editRoute,
            type: 'GET',
            success: function(response) {
                const data = response.data;

                $('#event_mulai').val(data.event_mulai);
                $('#event_selesai').val(data.event_selesai);
                $('#nama_event').val(data.nama_event);
                $('#tuk').val(data.tuk).trigger('change');
                $('#keterangan').val(data.keterangan);
            },
            error: function(xhr, status, error) {
                snackBarAlert('Data gagal dimuat', '#e7515a');
            }
        });
    }
</script>
