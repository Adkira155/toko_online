@extends('admin.layout.main')

{{-- @section('title', 'Dashboard') --}}

@section('header_title', 'Dashboard Overview')
@section('header_subtitle', 'Monitor your store performance')

@section('content')
    <div class="container-fluid">
        <!-- Header Section -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3">Products List</h1>
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addProductModal">
                <i class="bi bi-plus-circle me-2"></i>Tambah Pengguna
            </button>
        </div>

        <!-- Products Table -->
        <div class="card shadow">
            <div class="card-body">
                <div class="table-responsive">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div class="d-flex align-items-center">
                            <input type="text" id="searchInput" class="form-control form-control-sm"
                                placeholder="Search products...">
                        </div>
                    </div>

                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Gambar</th>
                                <th>Username</th>
                                <th>Email</th>
                                <th>Nomor Telepon</th>
                                <th>Tanggal Bergabung</th>
                                <th>role</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            {{-- @forelse($produks as $produks) --}}
                                <tr>
                                    <td>1</td>
                                    <td>
                                        <img src="" alt=""
                                            class="img-thumbnail" style="max-width: 50px;">
                                    </td>
                                    <td>Orang</td>
                                    <td>orang@gmail.com</td>
                                    <td>0812345678</td>
                                    <td>01/01/2025</td>
                                    <td>Buyer</td>
                                    <td>
                                        <div class="btn-group">
                                            {{-- <button type="button" class="btn btn-sm btn-info" data-bs-toggle="modal"
                                                data-bs-target="#editProductModal{{ $produk['id'] }}">
                                                <i class="bi bi-pencil"></i>
                                            </button> --}}
                                            <button type="button" class="btn btn-sm btn-info">
                                                <i class="bi bi-pencil"></i>
                                            </button>
                                            <form action="" method="POST" class="d-inline delete-form">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            {{-- @empty --}}
                                {{-- <tr>
                                    <td colspan="7" class="text-center">No products found</td>
                                </tr> --}}
                            {{-- @endforelse --}}
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        
    </div>
@endsection

@push('styles')
    <style>
        .img-thumbnail {
            object-fit: cover;
        }
    </style>
@endpush

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // Search functionality
        document.getElementById('searchInput').addEventListener('keyup', function() {
            let input = this.value.toLowerCase();
            let rows = document.querySelectorAll('tbody tr');

            rows.forEach(row => {
                let text = row.textContent.toLowerCase();
                row.style.display = text.includes(input) ? '' : 'none';
            });
        });

        // Show success message
        @if (session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: "{{ session('success') }}",
                showConfirmButton: false,
                timer: 3000
            });
        @endif

        // Show error message
        @if (session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: "{{ session('error') }}",
                showConfirmButton: true
            });
        @endif

        // Delete confirmation
        document.querySelectorAll('.delete-form').forEach(form => {
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        this.submit();
                    }
                });
            });
        });
    </script>
@endpush