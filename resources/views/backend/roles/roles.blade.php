@extends('layouts.main')
@section('content')
    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <!-- Page pre-title -->
                    <div class="page-pretitle">
                        Overview
                    </div>
                    <h2 class="page-title">
                        Roles
                    </h2>
                </div>
                <!-- Page title actions -->
                <div class="col-auto ms-auto d-print-none">
                    <div class="btn-list">

                        <a href="#" class="btn btn-primary d-none d-sm-inline-block" data-bs-toggle="modal"
                            data-bs-target="#modal-add-role">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M12 5l0 14" />
                                <path d="M5 12l14 0" />
                            </svg>
                            Add Role
                        </a>
                        <button id="close-btn" class="btn btn-primary d-sm-none btn-icon" data-bs-toggle="modal"
                            data-bs-target="#modal-add-role" aria-label="Create new report">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M12 5l0 14" />
                                <path d="M5 12l14 0" />
                            </svg>
                        </button>
                    </div>
                </div>
                @if (Session::has('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert" role="alert">
                        <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img"
                            aria-label="Success:">
                            <use xlink:href="#check-circle-fill" />
                        </svg>
                        <div>
                            {{ Session::get('success') }}
                        </div>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                <!-- Page title actions -->
                <div class="col-auto ms-auto d-print-none">
                    <div class="btn-list">

                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Page body -->
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
                                        <th>Permissions</th>
                                        <th>Created at</th>
                                        <th colspan="2">Action</th>
                                    </tr>
                                </thead>
                                @foreach ($roles as $key => $role)
                                    <tr>
                                        <td>
                                            {{ $role->id }}
                                        </td>
                                        <td class="text-secondary">{{ $role->name }}</td>
                                        <td class="text-secondary">{{ $role->permissions->pluck('name')->implode(', ') }}
                                        </td>
                                        <td class="text-secondary">{{ $role->created_at->format('m/d/Y') }}</td>
                                        <td class="text-secondary">
                                            @can('edit role')

                                            <a href="#" class="edit-role" data-bs-toggle="modal"
                                                data-bs-target="#modal-edit-role-{{$key}}" data-role-name="{{ $role->name }}"
                                                data-role-id="{{ $role->id }}">
                                                <i class="fa fa-edit text-success"></i>
                                            </a>
                                            @endcan
                                            @can('delete role')
                                            <a href="javascript:void(0);" onClick="deleteRole({{$role->id}})"> <i class="fa fa-trash text-danger"></i></a>
                                            @endcan


                                            {{-- edit modal --}}

                                            <div class="modal fade" id="modal-edit-role-{{$key}}" tabindex="-1" role="dialog" aria-hidden="true">
                                                <div class="modal-dialog modal-lg" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Add/Edit Role</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form action="{{ route('role.update',$role->id) }}" method="POST">
                                                                @csrf
                                                                <div class="mb-3">
                                                                    <label class="form-label">Role Name</label>
                                                                    <input type="text" class="form-control" value="{{ $role->name }}" name="name"
                                                                        id="role-name" placeholder="Your role name" required>
                                                                </div>
                                                                <div class="container">
                                                                    <div class="row">
                                                                        <div class="col-12">
                                                                            @if ($permissions->isNotEmpty())
                                                                            @foreach ($permissions as $permission)
                                                                                @php
                                                                                    $hasPermissions = $role->permissions->pluck('name');
                                                                                @endphp
                                                                                <input type="checkbox" name="permission[]"
                                                                                    id="permission-{{ $permission->id }}" value="{{ $permission->name }}"
                                                                                    {{ $hasPermissions->contains($permission->name) ? 'checked' : '' }}>
                                                                                <label for="permission-{{ $permission->id }}">{{ $permission->name }}</label>
                                                                            @endforeach
                                                                        @endif

                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-link link-secondary"
                                                                        data-bs-dismiss="modal">Cancel</button>
                                                                    <input type="submit" class="btn btn-primary">
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </table>
                            <div class="d-flex justify-content-center mt-3">
                                {{ $roles->links() }}
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    @push('modal')
        <div class="modal fade" id="modal-add-role" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Add/Edit Role</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('role.store') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label">Name</label>
                                <input type="text" class="form-control" name="name" id="role-name"
                                    placeholder="Your role name">
                                    <div class="pt-2 errors" id="">
                                    @error('name')
                                        <p class="text-danger">{{$message}}</p>
                                    @enderror
                                    </div>
                            </div>
                            <div class="container">
                                <div class="row">
                                    <div class="col-12">
                                        @if ($permissions->isNotEmpty())
                                            @foreach ($permissions as $permission)
                                                <input type="checkbox" name="permission[]"
                                                    id="permission-{{ $permission->id }}" value="{{ $permission->name }}">
                                                <label for="permission-{{ $permission->id }}">{{ $permission->name }}</label>
                                            @endforeach
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-link link-secondary close-btn"
                                  id=""  data-bs-dismiss="modal">Cancel</button>
                                <input type="submit" class="btn btn-primary">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
<script>
    var url = window.location.href;

    $(document).ready(function() {
    // Check for the modal query parameter and show the modal
    if (url.indexOf('?modal=1') != -1) {
        $('#modal-add-role').modal('show');
    }

    // Close button functionality
    $(".close-btn").click(function() {
        $('#modal-add-role').modal('hide');
        // $(".remove-error").text('');
        $(".errors").empty();
    });
});

    function deleteRole(id) {
        if (confirm("Are you  sure you want to delete this role?")) {
            $.ajax({
                type: "DELETE",
                url: "{{ route('role.delete') }}",
                data: {id:id},
                dataType: 'json',
                headers: {
                    'x-csrf-token' : '{{ csrf_token()}}'
                },
                success:function(response){
                    window.location.href = "{{ route('roles' )}}";
                }
            });
        }
    }

</script>
    @endpush

@endsection
