<x-layout>
    <x-slot:title>{{ $title }}</x-slot:title>

    <div class="p-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <a href="{{ route('admin.members.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Back to Members
            </a>
        </div>

        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Member Information</h5>
                    </div>
                    <div class="card-body">
                        <table class="table table-borderless">
                            <tbody>
                                <tr>
                                    <td width="25%" class="fw-bold text-muted">Name:</td>
                                    <td width="75%">{{ $member->name }}</td>
                                </tr>
                                <tr>
                                    <td width="25%" class="fw-bold text-muted">Email:</td>
                                    <td width="75%">{{ $member->email }}</td>
                                </tr>
                                <tr>
                                    <td width="25%" class="fw-bold text-muted">Member Since:</td>
                                    <td width="75%">{{ $member->created_at->format('d F Y') }}</td>
                                </tr>
                                <tr>
                                    <td width="25%" class="fw-bold text-muted">Status:</td>
                                    <td width="75%">
                                        <span class="badge bg-success">Active</span>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <!-- Member Stats -->
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Statistics</h5>
                    </div>
                    <div class="card-body">
                        <div class="text-center mb-4">
                            <h6 class="text-muted mb-2">Books Borrowed</h6>
                            <h2 class="text-primary mb-1">0</h2>
                            <small class="text-muted">Total books</small>
                        </div>
                        <hr>
                        <div class="row text-center">
                            <div class="col-6">
                                <h6 class="text-muted mb-2">Active</h6>
                                <h3 class="text-success mb-0">0</h3>
                            </div>
                            <div class="col-6">
                                <h6 class="text-muted mb-2">Returned</h6>
                                <h3 class="text-info mb-0">0</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            function resetPassword(id) {
                if (confirm('Are you sure you want to reset this member\'s password?')) {
                    // Implement password reset functionality
                    alert('Password reset functionality will be implemented');
                }
            }

            function deleteMember(id) {
                if (confirm('Are you sure you want to delete this member? This action cannot be undone.')) {
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = '/members/' + id;

                    const methodInput = document.createElement('input');
                    methodInput.type = 'hidden';
                    methodInput.name = '_method';
                    methodInput.value = 'DELETE';

                    const tokenInput = document.createElement('input');
                    tokenInput.type = 'hidden';
                    tokenInput.name = '_token';
                    tokenInput.value = '{{ csrf_token() }}';

                    form.appendChild(methodInput);
                    form.appendChild(tokenInput);
                    document.body.appendChild(form);
                    form.submit();
                }
            }
        </script>
    @endpush

    @push('styles')
        <style>
            .table-borderless td {
                padding: 0.75rem 0;
                vertical-align: top;
                border: none;
            }

            .card {
                border: none;
                box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
                border-radius: 10px;
            }

            .card-header {
                background-color: #f8f9fa;
                border-bottom: 2px solid #e9ecef;
                border-radius: 10px 10px 0 0 !important;
            }

            .badge {
                font-size: 0.75em;
                padding: 0.4em 0.8em;
            }

            .col-md-4 .card {
                height: fit-content;
            }

            .text-primary {
                color: #0d6efd !important;
            }

            .text-success {
                color: #198754 !important;
            }

            .text-info {
                color: #0dcaf0 !important;
            }

            hr {
                margin: 1.5rem 0;
                opacity: 0.3;
            }
        </style>
    @endpush
</x-layout>
