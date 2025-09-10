<x-layout>
    <x-slot:title>{{ $title }}</x-slot:title>

    @push('styles')
        <style>
            .card {
                transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
            }

            .card:hover {
                transform: translateY(-2px);
                box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1) !important;
            }

            .table th {
                border-bottom: 2px solid #dee2e6;
                font-weight: 600;
                color: #495057;
                background-color: #f8f9fa !important;
            }

            .table td {
                vertical-align: middle;
                border-bottom: 1px solid #dee2e6;
            }

            .btn-group .btn {
                border: 1px solid;
            }

            .dataTables_wrapper .dataTables_filter {
                margin-bottom: 1rem;
                text-align: right;
            }

            .dataTables_wrapper .dataTables_filter label {
                display: flex;
                align-items: center;
                justify-content: flex-end;
                margin-bottom: 0;
            }

            .dataTables_wrapper .dataTables_filter input {
                margin-left: 0.5rem;
                width: 200px;
            }

            .dataTables_wrapper .dataTables_length {
                margin-bottom: 1rem;
            }

            .dataTables_wrapper .dataTables_paginate .paginate_button {
                padding: 0.375rem 0.75rem;
                margin: 0 0.125rem;
                border-radius: 0.375rem;
                border: 1px solid #dee2e6;
                color: #6c757d;
            }

            .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
                background: #e9ecef;
                border-color: #adb5bd;
                color: #495057;
            }

            .dataTables_wrapper .dataTables_paginate .paginate_button.current {
                background: #0d6efd;
                border-color: #0d6efd;
                color: white;
            }

            .dataTables_wrapper .dataTables_info {
                color: #6c757d;
                font-size: 0.875rem;
            }
        </style>
    @endpush

    <div class="container-fluid px-4">
        <!-- Statistics Cards -->
        <div class="row mb-4">
            <div class="col-xl-3 col-md-6">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <div class="text-muted small">Total Members</div>
                                <div class="h4 mb-0 text-primary fw-bold" id="totalMembers">-</div>
                            </div>
                            <div class="text-primary">
                                <i class="bi bi-people fs-2"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Table Card -->
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white border-bottom-0 py-3">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 text-dark fw-semibold">
                        <i class="bi bi-table me-2"></i>Members List
                    </h5>
                    <div class="d-flex gap-2">
                        <button class="btn btn-sm btn-outline-secondary" onclick="refreshTable()">
                            <i class="bi bi-arrow-clockwise"></i> Refresh
                        </button>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="membersTable" class="table table-hover">
                        <thead class="table-light">
                            <tr>
                                <th width="50">No</th>
                                <th width="60">Avatar</th>
                                <th>Member Information</th>
                                <th width="150">Registration Date</th>
                                <th width="120" class="text-center">Actions</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
        <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>

        <script>
            let table;

            $(document).ready(function() {
                table = $('#membersTable').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: '{{ route('admin.members.index') }}',
                    columns: [{
                            data: 'DT_RowIndex',
                            orderable: false,
                            searchable: false,
                            className: 'text-center'
                        },
                        {
                            data: 'avatar',
                            orderable: false,
                            searchable: false,
                            className: 'text-center'
                        },
                        {
                            data: 'name_email'
                        },
                        {
                            data: 'registered_date'
                        },
                        {
                            data: 'action',
                            orderable: false,
                            searchable: false,
                            className: 'text-center'
                        }
                    ],
                    pageLength: 10,
                    lengthMenu: [
                        [10, 25, 50, 100],
                        [10, 25, 50, 100]
                    ],
                    dom: '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6 d-flex justify-content-end"f>>rtip',
                    initComplete: function(settings, json) {
                        updateStatistics(json);
                    },
                    drawCallback: function(settings) {
                        // Initialize tooltips
                        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[title]'));
                        var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
                            return new bootstrap.Tooltip(tooltipTriggerEl);
                        });
                    }
                });

                // Custom search styling
                $('.dataTables_filter input').addClass('form-control form-control-sm').attr('placeholder',
                    'Search members...');
                $('.dataTables_length select').addClass('form-select form-select-sm');
            });

            function updateStatistics(json) {
                // Update total members count
                $('#totalMembers').text(json.recordsTotal || 0);
            }

            function refreshTable() {
                table.ajax.reload(function(json) {
                    updateStatistics(json);
                });
            }

            function viewMember(id) {
                window.location.href = '/members/' + id;
            }

            function deleteMember(id) {
                if (confirm('Are you sure you want to delete this member? This action cannot be undone.')) {
                    $.post('/members/' + id, {
                        _method: 'DELETE',
                        _token: '{{ csrf_token() }}'
                    }).done(function(response) {
                        table.ajax.reload(function(json) {
                            updateStatistics(json);
                        });

                        // Show success message
                        if (response.success) {
                            showAlert('success', response.success);
                        }
                    }).fail(function(xhr) {
                        // Show error message
                        const response = xhr.responseJSON;
                        if (response && response.error) {
                            showAlert('danger', response.error);
                        } else {
                            showAlert('danger', 'Failed to delete member');
                        }
                    });
                }
            }

            function showAlert(type, message) {
                const alert = `
                    <div class="alert alert-${type} alert-dismissible fade show" role="alert">
                        ${message}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                `;

                // Remove existing alerts
                $('.alert').remove();

                // Add new alert at the top of the container
                $('.container-fluid').prepend(alert);

                // Auto-dismiss after 5 seconds
                setTimeout(function() {
                    $('.alert').alert('close');
                }, 5000);
            }
        </script>
    @endpush

</x-layout>
