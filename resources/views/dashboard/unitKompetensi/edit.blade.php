<script>
    function handleEdit(elemen) {
        $('#unitKompetensi-modal-title').text('Edit Data Unit Kompetensi');
        $('#btn-form').text('Update');
        const editRoute = elemen.getAttribute('data-route');
        const uuid = elemen.getAttribute('data-uuid');
        const updateRoute = '{{ route("unitKompetensi.update", [":uuid"]) }}';
        const form = $('.needs-validation');
        form.attr('action', updateRoute.replace(':uuid', uuid));
        form.attr('data-method','PUT');

        if ($('#_method').length === 0) {
            form.append('<input type="hidden" name="_method" id="_method" value="PUT">');
        }
        $('#modal-unitKompetensi').modal('show');
        $.ajax({
            url: editRoute,
            type: 'GET',
            success: function(response) {
                const data = response.data;
                const skema = $('#skema_id');

                $('#kode_unit').val(data.kode_unit);
                $('#judul_unit').val(data.judul_unit);
                $('#jenis_standar').val(data.jenis_standar).trigger('change');
                if (skema.find("option[value='" + data.skema.judul_skema + "']").length) {
                    skema.val(data.skema.judul_skema).trigger('change');
                } else {
                    const newOption = new Option(data.skema.judul_skema, data.skema.uuid, true, true);
                    skema.append(newOption).trigger('change');
                }
            },
            error: function(xhr, status, error) {
                snackBarAlert('Data gagal dimuat', '#e7515a');
            }
        });
    }
</script>
