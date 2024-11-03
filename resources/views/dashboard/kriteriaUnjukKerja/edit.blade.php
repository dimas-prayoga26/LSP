<script>
    function handleEdit(elemen) {
        $('#kriteriaUnjukKerja-modal-title').text('Edit Data Kriteria Unjuk Kerja');
        $('#btn-form').text('Update');
        const editRoute = elemen.getAttribute('data-route');
        const uuid = elemen.getAttribute('data-uuid');
        const updateRoute = '{{ route("kriteriaUnjukKerja.update", [":uuid"]) }}';
        const form = $('.needs-validation');
        form.attr('action', updateRoute.replace(':uuid', uuid));
        form.attr('data-method','PUT');

        if ($('#_method').length === 0) {
            form.append('<input type="hidden" name="_method" id="_method" value="PUT">');
        }
        $('#modal-kriteriaUnjukKerja').modal('show');
        $.ajax({
            url: editRoute,
            type: 'GET',
            success: function(response) {
                const data = response.data;
                const elemen = $('#elemen_id');

                $('#nama_kriteria_kerja').val(data.nama_kriteria_kerja);
                if (elemen.find("option[value='" + data.elemen.nama_elemen + "']").length) {
                    elemen.val(data.elemen.nama_elemen).trigger('change');
                } else {
                    const newOption = new Option(data.elemen.nama_elemen, data.elemenelemen, true, true);
                    elemen.append(newOption).trigger('change');
                }
            },
            error: function(xhr, status, error) {
                snackBarAlert('Data gagal dimuat', '#e7515a');
            }
        });
    }
</script>
