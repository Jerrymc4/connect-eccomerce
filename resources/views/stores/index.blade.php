<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Stores - Connect Ecommerce</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container py-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1>Manage Your Stores</h1>
            <a href="{{ route('stores.create') }}" class="btn btn-primary">Create New Store</a>
        </div>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <div class="card">
            <div class="card-header bg-light">
                <h5 class="mb-0">Your Stores</h5>
            </div>
            <div class="card-body p-0">
                <table class="table table-striped mb-0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Store Name</th>
                            <th>Domain</th>
                            <th>Created</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($stores as $store)
                            <tr>
                                <td>{{ $store->id }}</td>
                                <td>{{ $store->getStoreName() }}</td>
                                <td>
                                    @if($store->domains->first())
                                        <a href="{{ $store->getStoreUrl() }}" target="_blank">
                                            {{ $store->domains->first()->domain }}
                                        </a>
                                    @else
                                        <span class="text-muted">No domain</span>
                                    @endif
                                </td>
                                <td>{{ $store->created_at->format('M d, Y') }}</td>
                                <td>
                                    <div class="btn-group">
                                        <a href="#" class="btn btn-sm btn-outline-secondary">View</a>
                                        <a href="#" class="btn btn-sm btn-outline-primary">Edit</a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-4">
                                    <div class="d-flex flex-column align-items-center">
                                        <p class="text-muted mb-3">You haven't created any stores yet.</p>
                                        <a href="{{ route('stores.create') }}" class="btn btn-primary">Create Your First Store</a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
 