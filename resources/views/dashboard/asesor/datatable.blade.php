<script>
    function getData() {
        const table = $('#table-asesor');
        const dataRoute = table.data('route');

        $.ajax({
            url: dataRoute,
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                const data = response.data;
                const deleteRoute = '{{ route("asesor.destroy", [":uuid"]) }}';
                const listPersetujuanAssesmenRoute = '{{ route("persetujuanAssesmen.listByAsesorUuid", [":uuid"]) }}';
                const editRoute = '{{ route("asesor.edit", [":uuid"]) }}';

                let asesorName = '';
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
                        {
                            data: 'uuid',
                            render: function(data) {
                                const deleteRouteRendered = deleteRoute.replace(':uuid', data);
                                const listPersetujuanAssesmenRouteRendered = listPersetujuanAssesmenRoute.replace(':uuid', data);
                                const editRouteRendered = editRoute.replace(':uuid', data);

                                return `
                                    <div class="">
                                        <a class="dropdown-toggle" href="javascript:void(0);" role="button" id="dropdownMenuLink10" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" title="More menu">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-horizontal"><circle cx="12" cy="12" r="1"></circle><circle cx="19" cy="12" r="1"></circle><circle cx="5" cy="12" r="1"></circle></svg>
                                        </a>
                                        <div class="dropdown-menu left" aria-labelledby="dropdownMenuLink10" style="will-change: transform; position: absolute; transform: translate3d(-141px, 19px, 0px); top: 0px; left: 0px;" x-placement="bottom-end">
                                            <a class="dropdown-item" href="javascript:void(0);" onclick="handleEdit(this)" data-route="${editRouteRendered}" data-uuid="${data}" title="Edit Asesor">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
                                                Edit Asesor
                                            </a>
                                            <a class="dropdown-item" href="javascript:void(0);" onclick="handleDelete(this)" data-route="${deleteRouteRendered}" title="Delete Asesor">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x-square"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><line x1="9" y1="9" x2="15" y2="15"></line><line x1="15" y1="9" x2="9" y2="15"></line></svg>
                                                Delete Asesor
                                            </a>
                                        </div>
                                    </div>`;
                            }
                        },
                        {
                            data: 'nip'
                        },
                        {
                            data: 'user',
                            render: function(data) {
                                let username;
                                asesorName = data.name;
                                if (data.username) {
                                    username = data.username;
                                } else {
                                    username = '<small class="text-muted font-italic">Empty</small>';
                                }
                                $('#modal-title-persetujuanAssesmen').text(`Daftar Persetujuan Assesmen [${asesorName}]`);
                                return `${asesorName} (${username})`;
                            }
                        },
                        {
                            data: 'user',
                            render: function(data) {
                                return data ? data.email : 'N/A';
                            }
                        },
                        {
                            data: 'user',
                            render: function(data) {
                                let result;
                                if (data.phone) {
                                    result = data.phone;
                                } else {
                                    result = '<small class="text-muted font-italic">Empty</small>';
                                }
                                return result;
                            }
                        },
                        {
                            data: 'user',
                            render: function(data) {
                                let result;
                                if (data.jenis_kelamin) {
                                    result = data.jenis_kelamin;
                                } else {
                                    result = '<small class="text-muted font-italic">Empty</small>';
                                }
                                return result;
                            }
                        },
                        {
                            data: 'surat_tugas',
                            render: function(data) {
                                if (data) {
                                    const url = `{{ asset('storage/${data}') }}`;
                                    return `<a href="${url}" download="Surat Tugas ${asesorName}.pdf" class="text-primary">Download berkas</a>`;
                                } else {
                                    return '<small class="text-muted font-italic">Empty</small>';
                                }
                            }
                        },
                        {
                            data: 'user',
                            render: function(data) {
                                return data ? `<span class="badge ${data.status === 'active' ? 'badge-success' :'badge-danger'}">${data.status}</span>` : 'N/A';
                            }
                        }
                    ]
                });
            },
            error: function(xhr, status, error) {
                snackBarAlert('Data gagal termuat', '#e7515a');
            }
        });

    }
</script>
