<script>
    function handleEdit(elemen) {
        $('#elemen-modal-title').text('Edit Data Elemen');
        $('#btn-form').text('Update');
        const editRoute = elemen.getAttribute('data-route');
        const uuid = elemen.getAttribute('data-uuid');
        const updateRoute = '{{ route("elemen.update", [":uuid"]) }}';
        const form = $('.needs-validation');
        form.attr('action', updateRoute.replace(':uuid', uuid));
        form.attr('data-method','PUT');
        if ($('#_method').length === 0) {
            form.append('<input type="hidden" name="_method" id="_method" value="PUT">');
        }
        $('#modal-elemen').modal('show');
        $.ajax({
            url: editRoute,
            type: 'GET',
            success: function(response) {
                const data = response.data;
                const unitKompetensi = $('#unit_kompetensi_id');

                $('#nama_elemen').val(data.nama_elemen);
                if (unitKompetensi.find("option[value='" + data.unit_kompetensi.judul_unit + "']").length) {
                    unitKompetensi.val(data.unit_kompetensi.judul_unit).trigger('change');
                } else {
                    const newOption = new Option(data.unit_kompetensi.judul_unit, data.unit_kompetensi.uuid, true, true);
                    unitKompetensi.append(newOption).trigger('change');
                }
            },
            error: function(xhr, status, error) {
                snackBarAlert('Data gagal dimuat', '#e7515a');
            }
        });
    }
</script>
