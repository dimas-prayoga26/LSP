<script>
    function getData() {
        const table = $('#table-unitKompetensi');
        const dataRoute = table.data('route');

        $.ajax({
            url: dataRoute,
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                const data = response.data;
                const deleteRoute = '{{ route("unitKompetensi.destroy", [":uuid"]) }}';
                const listElemenRoute = '{{ route("elemen.listByUuid", [":uuid"]) }}';
                const editRoute = '{{ route("unitKompetensi.edit", [":uuid"]) }}';

                let unitKompetensiName = '';
                table.DataTable({
                    "dom": "<'dt--top-section'<'row'<'col-12 col-sm-6 d-flex justify-content-sm-start justify-content-center'l><'col-12 col-sm-6 d-flex justify-content-sm-end justify-content-center mt-sm-0 mt-3'f>>>" +
                        "<'table-responsive'tr>" +
                        "<'dt--bottom-section d-sm-flex justify-content-sm-between text-center'<'dt--pages-count  mb-sm-0 mb-3'i><'dt--pagination'p>>",
                    "oLanguage": {
                        "oPaginate": {
                            "sPrevious": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>',
                            "sNext": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-right"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>'
                        },
                        "sInfo": "Showing page _PAGE_ of _PAGES_",
                        "sSearch": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>',
                        "sSearchPlaceholder": "Search...",
                        "sLengthMenu": "Results :  _MENU_",
                    },
                    "stripeClasses": [],
                    "lengthMenu": [5, 10, 20, 50],
                    "pageLength": 5,
                    "destroy": true,
                    "data": data,
                    "columns": [
                        { data: 'kode_unit' },
                        {
                            data: 'judul_unit',
                            render: function(data) {
                                unitKompetensiName = data;
                                return unitKompetensiName;
                            }
                        },
                        { data: 'jenis_standar' },
                        {
                            data: 'skema',
                            render: function(data) {
                                return data ? data.judul_skema : 'N/A';
                            }
                        },
                        {
                            data: 'uuid',
                            render: function(data) {
                                const deleteRouteRendered = deleteRoute.replace(':uuid', data);
                                const listElemenRouteRendered = listElemenRoute.replace(':uuid', data);
                                const editRouteRendered = editRoute.replace(':uuid', data);

                                return `
                                    <ul class="table-controls">
                                        <li onclick="handleListElemen(this)" data-modal="modal-list-elemen" data-route="${listElemenRouteRendered}" data-unitKompetensiName="${unitKompetensiName}">
                                            <a href="javascript:void(0);" class="bs-tooltip" data-toggle="tooltip" data-placement="top" title="List Elemen">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-menu p-1 br-6 mb-1"><line x1="3" y1="12" x2="21" y2="12"></line><line x1="3" y1="6" x2="21" y2="6"></line><line x1="3" y1="18" x2="21" y2="18"></line></svg>
                                            </a>
                                        </li>
                                        <li onclick="handleEdit(this)" data-route="${editRouteRendered}" data-uuid="${data}">
                                            <a href="javascript:void(0);" class="bs-tooltip" data-toggle="tooltip" data-placement="top" title="Edit Unit Kompetensi">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-2 p-1 br-6 mb-1"><path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path></svg>
                                            </a>
                                        </li>
                                        <li onclick="handleDelete(this)" data-route="${deleteRouteRendered}">
                                            <a href="javascript:void(0);" class="bs-tooltip" data-toggle="tooltip" data-placement="top" title="Delete Unit Kompetensi">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash p-1 br-6 mb-1"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg>
                                            </a>
                                        </li>
                                    </ul>`;
                            }
                        },
                    ]
                });
            },
            error: function(xhr, status, error) {
                snackBarAlert('Data gagal termuat', '#e7515a');
            }
        });

    }
</script>
