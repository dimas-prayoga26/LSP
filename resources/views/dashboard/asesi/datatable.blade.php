<script>
    function getData() {
        const table = $('#table-asesi');
        const dataRoute = table.data('route');

        $.ajax({
            url: dataRoute,
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                const data = response.data;
                const deleteRoute = '{{ route("asesi.destroy", [":uuid"]) }}';
                const listPersetujuanAssesmenRoute = '{{ route("persetujuanAssesmen.listByAsesiUuid", [":uuid"]) }}';
                const editRoute = '{{ route("asesi.edit", [":uuid"]) }}';

                const eventAdminBaseURL = '{{ route("event-admin.index", [":uuid"]) }}';

                let asesiName = '';
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
                                const daftarEventAdminRendered = eventAdminBaseURL.replace(':uuid', data);

                                return `
                                    <div class="">
                                        <a class="dropdown-toggle" href="javascript:void(0);" role="button" id="dropdownMenuLink10" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" title="More menu">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-horizontal"><circle cx="12" cy="12" r="1"></circle><circle cx="19" cy="12" r="1"></circle><circle cx="5" cy="12" r="1"></circle></svg>
                                        </a>
                                        <div class="dropdown-menu left" aria-labelledby="dropdownMenuLink10" style="will-change: transform; position: absolute; transform: translate3d(-141px, 19px, 0px); top: 0px; left: 0px;" x-placement="bottom-end">
                                            <a class="dropdown-item" href="${daftarEventAdminRendered}" title="Daftar Event">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-3"><path d="M12 20h9"></path><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"></path></svg>
                                                Daftar Event
                                            </a>
                                            <a class="dropdown-item" href="javascript:void(0);" onclick="handleEdit(this)" data-route="${editRouteRendered}" data-uuid="${data}" title="Edit Asesi">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
                                                Edit Asesi
                                            </a>
                                            <a class="dropdown-item" href="javascript:void(0);" onclick="handleDelete(this)" data-route="${deleteRouteRendered}" title="Delete Asesi">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x-square"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><line x1="9" y1="9" x2="15" y2="15"></line><line x1="15" y1="9" x2="9" y2="15"></line></svg>
                                                Delete Asesi
                                            </a>
                                        </div>
                                    </div>`;
                            }
                        },
                        {
                            data: 'nim'
                        },
                        {
                            data: 'user',
                            render: function(data) {
                                let username;
                                asesiName = data.name;
                                if (data.username) {
                                    username = data.username;
                                } else {
                                    username = '<small class="text-muted font-italic">Empty</small>';
                                }
                                $('#modal-title-persetujuanAssesmen').text(`Daftar Persetujuan Assesmen [${asesiName}]`);
                                return `${asesiName} (${username})`;
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
                            data: 'user',
                            render: function(data) {
                                return data ? `<span class="badge ${data.status === 'active' ? 'badge-success' :'badge-danger'}">${data.status}</span>` : 'N/A';
                            }
                        },
                        {
                            data: 'status',
                            render: function(data) {
                                return data ? `<span class="badge ${data === 'active' ? 'badge-success' :'badge-danger'}">${data}</span>` : 'N/A';
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
{{-- <a class="dropdown-item" href="javascript:void(0);" title="Daftar Checklist Observasi">
    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-check-square"><polyline points="9 11 12 14 22 4"></polyline><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"></path></svg>
    Daftar Checklist Observasi
</a>
<a class="dropdown-item" href="javascript:void(0);" title="Daftar FRAPL">
    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-book-open"><path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"></path><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"></path></svg>
    Daftar FRAPL
</a>
<a class="dropdown-item" href="javascript:void(0);" onclick="handleListPersetujuanAssesmen(this)" data-modal="modal-list-persetujuanAssesmen" data-route="${listPersetujuanAssesmenRouteRendered}" title="Daftar Lembar Persetujuan">
    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-file-text"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg>
    Daftar Lembar Persetujuan
</a>
<a class="dropdown-item" href="javascript:void(0);" title="Daftar Rekaman Assesmen">
    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-server"><rect x="2" y="2" width="20" height="8" rx="2" ry="2"></rect><rect x="2" y="14" width="20" height="8" rx="2" ry="2"></rect><line x1="6" y1="6" x2="6.01" y2="6"></line><line x1="6" y1="18" x2="6.01" y2="18"></line></svg>
    Daftar Rekaman Assesmen
</a> --}}
