<script>
    function handleEdit(elemen) {
        $('#kelompokAsesor-modal-title').text('Edit Data Kelompok Asesor');
        $('#btn-form').text('Update');
        const editRoute = elemen.getAttribute('data-route');
        const uuid = elemen.getAttribute('data-uuid');
        const updateRoute = '{{ route("kelompokAsesor.update", [":uuid"]) }}';
        const form = $('.needs-validation');
        form.attr('action', updateRoute.replace(':uuid', uuid));
        form.attr('data-method','PUT');

        if ($('#_method').length === 0) {
            form.append('<input type="hidden" name="_method" id="_method" value="PUT">');
        }
        $('#modal-kelompokAsesor').modal('show');
        $.ajax({
            url: editRoute,
            type: 'GET',
            success: function(response) {
                const data = response.data;
                const eventSelect = $('#event_id');
                const skemaSelect = $('#skema_id');
                const kelasSelect = $('#kelas_id');
                const asesorSelect = $('#asesor_id');
                // Event
                if (eventSelect.find("option[value='" + data.event.nama_event + "']").length) {
                    eventSelect.val(data.event.nama_event).trigger('change');
                } else {
                    const newOption = new Option(data.event.nama_event, data.event.uuid, true, true);
                    eventSelect.append(newOption).trigger('change');
                }
                // Skema
                if (skemaSelect.find("option[value='" + data.skema.judul_skema + "']").length) {
                    skemaSelect.val(data.skema.judul_skema).trigger('change');
                } else {
                    const newOption = new Option(data.skema.judul_skema, data.skema.uuid, true, true);
                    skemaSelect.append(newOption).trigger('change');
                }
                // Kelas
                if (kelasSelect.find("option[value='" + data.kelas.nama_kelas + "']").length) {
                    kelasSelect.val(data.kelas.nama_kelas).trigger('change');
                } else {
                    const newOption = new Option(data.kelas.nama_kelas, data.kelas.uuid, true, true);
                    kelasSelect.append(newOption).trigger('change');
                }
                // Asesor
                if (asesorSelect.find("option[value='" + data.asesor.user.name + "']").length) {
                    asesorSelect.val(data.asesor.user.name).trigger('change');
                } else {
                    const newOption = new Option(data.asesor.user.name, data.asesor.uuid, true, true);
                    asesorSelect.append(newOption).trigger('change');
                }
            },
            error: function(xhr, status, error) {
                snackBarAlert('Data gagal dimuat', '#e7515a');
            }
        });
    }
</script>
