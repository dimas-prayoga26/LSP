<script>
    function handleEdit(elemen) {
        $('#skema-modal-title').text('Edit Data Skema');
        $('#btn-form').text('Update');
        const editRoute = elemen.getAttribute('data-route');
        const uuid = elemen.getAttribute('data-uuid');
        const updateRoute = '{{ route("skema.update", [":uuid"]) }}';
        const form = $('.needs-validation');
        form.attr('action', updateRoute.replace(':uuid', uuid));
        form.attr('data-method','PUT');

        if ($('#_method').length === 0) {
            form.append('<input type="hidden" name="_method" id="_method" value="PUT">');
        }
        $('#modal-skema').modal('show');
        $.ajax({
            url: editRoute,
            type: 'GET',
            success: function(response) {
                const data = response.data;
                const event = $('#event_id');
                $('#no_skema').val(data.no_skema);
                $('#kode_skema').val(data.kode_skema);
                $('#judul_skema').val(data.judul_skema);
                $('#deskripsi').val(data.deskripsi);
                $('#jenis_standar').val(data.jenis_standar).trigger('change');
            },
            error: function(xhr, status, error) {
                snackBarAlert('Data gagal dimuat', '#e7515a');
            }
        });
    }
</script>
