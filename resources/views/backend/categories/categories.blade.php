@extends('layouts.main')
@section('content')
    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <div class="page-pretitle">Overview</div>
                    <h2 class="page-title">Categories</h2>
                </div>
                @can('add cateory')
                <div class="col-auto ms-auto d-print-none">
                    <div class="btn-list">
                        <a href="#" class="btn btn-primary d-none d-sm-inline-block" data-bs-toggle="modal"
                            data-bs-target="#modal-add-category">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M12 5l0 14" />
                                <path d="M5 12l14 0" />
                            </svg>
                            Add category
                        </a>
                    </div>
                </div>
                @endcan
                @if (Session::has('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img"
                            aria-label="Success:">
                            <use xlink:href="#check-circle-fill" />
                        </svg>
                        <div>{{ Session::get('success') }}</div>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
            </div>
        </div>
    </div>
@can('categories list')
<div class="page-body">
    <div class="container-xl">
        <div class="row row-deck row-cards">
            <div class="col-md-12 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Roles List</h3>
                    </div>
                    <div class="card-table table-responsive">
                        <table class="table table-vcenter">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Created at</th>
                                    <th colspan="2">Action</th>
                                </tr>
                            </thead>
                            @foreach ($categories as $key => $category)
                                <tr>
                                    <td>{{ $category->id }}</td>
                                    <td class="text-secondary">{{ $category->name }}</td><td class="text-secondary">{{ $category->name}}</td>
                                    <td class="text-secondary">{{ $category->created_at->format('m/d/Y') }}</td>
                                    <td class="text-secondary">
                                        @can('edit category')
                                        <a href="#" class="edit-role" data-bs-toggle="modal"
                                            data-bs-target="#modal-edit-category-{{ $key }}"
                                            data-role-name="{{ $category }}"
                                        >
                                            <i class="fa fa-edit text-success"></i>
                                        </a>
                                        @endcan
                                        @can('delete category')

                                        <a href="javascript:void(0);" onClick="deleteCategory({{ $category->id }})">
                                            <i class="fa fa-trash text-danger"></i>
                                        </a>
                                        @endcan

                                        <!-- Edit Modal -->
                                        <div class="modal fade" id="modal-edit-category-{{ $key }}" tabindex="-1"
                                            role="dialog" aria-hidden="true">
                                            <div class="modal-dialog modal-lg" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Edit category</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form action="{{ route('category.update', $category->id) }}"
                                                            method="POST">
                                                            @csrf
                                                            <div class="mb-3">
                                                                <label class="form-label">Category name</label>
                                                                <input type="text" class="form-control"
                                                                    value="{{ $category->name }}" name="name"
                                                                    placeholder="Enter category name" required>
                                                            </div>

                                                            <div class="modal-footer">
                                                                <button type="button"
                                                                    class="btn btn-link link-secondary"
                                                                    data-bs-dismiss="modal">Cancel</button>
                                                                <input type="submit" class="btn btn-primary" value="Update">
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- End Edit Modal -->
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                        <div class="d-flex justify-content-center mt-3">
                            {{ $categories->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endcan

    <script>
        function deleteRole(id) {
            if (confirm("Are you sure you want to delete this role?")) {
                $.ajax({
                    type: "DELETE",
                    url: "{{ route('category.delete') }}",
                    data: {
                        id: id
                    },
                    dataType: 'json',
                    headers: {
                        'x-csrf-token': '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        window.location.href = "{{ route('roles') }}";
                    }
                });
            }
        }
    </script>
    @push('modal')
        <form action="{{ route('category.store') }}" method="Post">
            @csrf
            <div class="modal modal-blur fade" id="modal-add-category" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Add category
                            </h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label class="form-label">Category name</label>
                                <input type="text" class="form-control" name="name" placeholder="Enter your category name" required>
                            </div>
                            <div class="modal-footer">
                                <a href="" class="btn btn-link link-secondary" data-bs-dismiss="modal">
                                    Cancel
                                </a>
                                <input type="submit" class="btn btn-primary ms-auto">
                                </input>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    @endpush
    <script>
         function deleteCategory(id) {
        if (confirm("Are you  sure you want to delete this user?")) {
            $.ajax({
                type: "DELETE",
                url: "{{ route('category.delete') }}",
                data: {id:id},
                dataType: 'json',
                headers: {
                    'x-csrf-token' : '{{ csrf_token()}}'
                },
                success:function(response){
                    window.location.href = "{{ route('categories' )}}";
                }
            });
        }
    }
    </script>
@endsection
