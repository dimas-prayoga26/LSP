<script>
    function handleEdit(elemen) {
        $('#testWawancara-modal-title').text('Edit Data Test Wawancara');
        $('#btn-form').text('Update');
        const editRoute = elemen.getAttribute('data-route');
        const uuid = elemen.getAttribute('data-uuid');
        const updateRoute = '{{ route("ujianWawancara.update", [":uuid"]) }}';
        const form = $('.needs-validation');
        form.attr('action', updateRoute.replace(':uuid', uuid));
        form.attr('data-method', 'PUT');

        if ($('#_method').length === 0) {
            form.append('<input type="hidden" name="_method" id="_method" value="PUT">');
        }
        $('#modal-testWawancara').modal('show');

        $.ajax({
            url: editRoute,
            type: 'GET',
            success: function (response) {
                const data = response.data;
                const unitKompetensiSelect = $('#unit_kompetensi_id');
                const kriteriaKerjaSelect = $('#kriteria_unjuk_kerja_id');

                if (window.pertanyaanEditor) {
                    window.pertanyaanEditor.setData(data.pertanyaan);
                }

                if (unitKompetensiSelect.find("option[value='" + data.unit_kompetensi.judul_unit + "']").length) {
                    unitKompetensiSelect.val(data.unit_kompetensi.judul_unit).trigger('change');
                } else {
                    const newOption = new Option(data.unit_kompetensi.judul_unit, data.unit_kompetensi.uuid, true, true);
                    unitKompetensiSelect.append(newOption).trigger('change');
                }

                if (kriteriaKerjaSelect.find("option[value='" + data.kriteria_unjuk_kerja.nama_kriteria_kerja + "']").length) {
                    kriteriaKerjaSelect.val(data.kriteria_unjuk_kerja.nama_kriteria_kerja).trigger('change');
                } else {
                    const newOption = new Option(data.kriteria_unjuk_kerja.nama_kriteria_kerja, data.kriteria_unjuk_kerja.uuid, true, true);
                    kriteriaKerjaSelect.append(newOption).trigger('change');
                }
            },
            error: function (xhr, status, error) {
                snackBarAlert('Data gagal dimuat', '#e7515a');
            }
        });
    }
</script>
