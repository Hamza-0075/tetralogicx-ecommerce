@extends('layouts.main')
@section('content')
    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <div class="page-pretitle">Overview</div>
                    <h2 class="page-title">Users</h2>
                </div>
                @can('add user')
                <div class="col-auto ms-auto d-print-none">
                    <div class="btn-list">
                        <a href="#" class="btn btn-primary d-none d-sm-inline-block" data-bs-toggle="modal"
                            data-bs-target="#modal-add-user">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M12 5l0 14" />
                                <path d="M5 12l14 0" />
                            </svg>
                            Add User
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
@can('users list')
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
                                    <th>Email</th>
                                    <th>Roles</th>
                                    <th>Created at</th>
                                    <th colspan="2">Action</th>
                                </tr>
                            </thead>
                            @foreach ($users as $key => $user)
                                <tr>
                                    <td>{{ $user->id }}</td>
                                    <td class="text-secondary">{{ $user->name }}</td>
                                    <td class="text-secondary">{{ $user->email }}</td>
                                    <td class="text-secondary">{{ $user->roles->pluck('name')->implode(', ') }}</td>
                                    <td class="text-secondary">{{ $user->created_at->format('m/d/Y') }}</td>
                                    <td class="text-secondary">
                                        @can('edit user')
                                        <a href="#" class="edit-role" data-bs-toggle="modal"
                                            data-bs-target="#modal-edit-user-{{ $key }}"
                                            data-role-name="{{ $user->name }}" data-user-email="{{ $user->email }}"
                                            data-user-id="{{ $user->id }}"
                                            data-roles='{{ json_encode($roles->pluck('name')) }}'>
                                            <i class="fa fa-edit text-success"></i>
                                        </a>
                                        @endcan
                                        @can('delete user')

                                        <a href="javascript:void(0);" onClick="deleteUser({{ $user->id }})">
                                            <i class="fa fa-trash text-danger"></i>
                                        </a>
                                        @endcan

                                        <!-- Edit Modal -->
                                        <div class="modal fade" id="modal-edit-user-{{ $key }}" tabindex="-1"
                                            role="dialog" aria-hidden="true">
                                            <div class="modal-dialog modal-lg" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Add/Edit Role</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form action="{{ route('user.update', $user->id) }}"
                                                            method="POST">
                                                            @csrf
                                                            <div class="mb-3">
                                                                <label class="form-label">Role Name</label>
                                                                <input type="text" class="form-control"
                                                                    value="{{ $user->name }}" name="name"
                                                                    placeholder="Your role name" required>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label class="form-label">Email</label>
                                                                <input type="email" class="form-control"
                                                                    value="{{ $user->email }}" name="email"
                                                                    placeholder="Your email" required>
                                                            </div>
                                                            <div class="grid grid-cols-4 gap-2 text-sm">
                                                                @foreach ($roles as $role)
                                                                    <div class="form-check" style="font-size: 12px;">
                                                                        <input type="checkbox" class="form-check-input"
                                                                            value="{{ $role->name }}"
                                                                            id="role{{ $role->name }}"
                                                                            name="role[]"
                                                                            @if ($user->hasRole($role->name)) checked @endif>
                                                                        <label class="form-check-label"
                                                                            for="role{{ $role->name }}">{{ $role->name }}</label>
                                                                    </div>
                                                                @endforeach
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
                            {{ $users->links() }}
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
                    url: "{{ route('role.delete') }}",
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
        <form action="{{ route('user.store') }}" method="Post">
            @csrf
            <div class="modal modal-blur fade" id="modal-add-user" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Add User
                            </h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label class="form-label">Name</label>
                                <input type="text" class="form-control" name="name" placeholder="Full name" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Email</label>
                                <input type="email" class="form-control" name="email" placeholder="Your email" required>
                            </div><div class="mb-3">
                                <label class="form-label">Password</label>
                                <input type="password" class="form-control" name="password" placeholder="Password" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Confirm password</label>
                                <input type="password" class="form-control" name="password_confirmation" placeholder="Confirm Passord" required>
                            </div>
                            <div  class="mb-2">
                                <label class="form-label">Status</label>
                            </div>
                            <div class="mb-3">
                                <select name="status" class="form-select form-select-md" aria-label="">
                                    {{-- <option selected>Open this select menu</option> --}}
                                    <option name="status" value="active">Active</option>
                                    <option name="status" value="inactive">Inactive</option>
                                  </select>
                            </div>
                            <div  class="mb-2">
                                <label class="form-label">Roles</label>
                            </div>
                            <div class="grid grid-cols-4 gap-6 text-sm">
                                @foreach ($roles as $role)
                                    <div class="form-check" style="font-size: 12px;">
                                        <input type="checkbox" class="form-check-input"
                                            value="{{ $role->name }}"
                                            id="role{{ $role->name }}"
                                            name="role[]"
                                            >
                                        <label class="form-check-label"
                                            for="role{{ $role->name }}">{{ $role->name }}</label>
                                    </div>
                                @endforeach
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
         function deleteUser(id) {
        if (confirm("Are you  sure you want to delete this user?")) {
            $.ajax({
                type: "DELETE",
                url: "{{ route('user.delete') }}",
                data: {id:id},
                dataType: 'json',
                headers: {
                    'x-csrf-token' : '{{ csrf_token()}}'
                },
                success:function(response){
                    window.location.href = "{{ route('users' )}}";
                }
            });
        }
    }
    </script>
@endsection
