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
                        Permissions
                    </h2>
                </div>
                <!-- Page title actions -->
                <div class="col-auto ms-auto d-print-none">
                    <div class="btn-list">

                        <a href="#" class="btn btn-primary d-none d-sm-inline-block" data-bs-toggle="modal"
                            data-bs-target="#modal-ad-permission">
                            <!-- Download SVG icon from http://tabler-icons.io/i/plus -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M12 5l0 14" />
                                <path d="M5 12l14 0" />
                            </svg>
                            Add permission
                        </a>
                        <a href="#" class="btn btn-primary d-sm-none btn-icon" data-bs-toggle="modal"
                            data-bs-target="#modal-ad-permission" aria-label="Create new report">
                            <!-- Download SVG icon from http://tabler-icons.io/i/plus -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M12 5l0 14" />
                                <path d="M5 12l14 0" />
                            </svg>
                        </a>
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
                            <h3 class="card-title">Permissions List</h3>
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
                                @foreach ($permissions as $key => $permission)
                                    <tr>
                                        <td>
                                            {{ $permission->id }}
                                        </td>
                                        <td class="text-secondary">{{ $permission->name }}</td>
                                        <td class="text-secondary">{{ $permission->created_at->format('m/d/Y') }}</td>
                                        <td class="text-secondary">
                                            <a href="#" class="" data-permission-name="{{ $permission->name }}"
                                                data-bs-toggle="modal" data-permission-id="{{ $permission->id }}"
                                                data-bs-target="#modal-edit-permission-{{ $key }}"><i
                                                    class="fa fa-edit text-success"></i></a>
                                            <a href="{{ route('permission.destroy', $permission->id) }}"><i
                                                    class="fa fa-trash text-danger"></i></a>
                                            <form action="{{ route('permissions.update', $permission->id) }}"
                                                method="Post">
                                                @csrf
                                                <div class="modal modal-blur fade"
                                                    id="modal-edit-permission-{{ $key }}" tabindex="-1"
                                                    role="dialog" aria-hidden="true">
                                                    <div class="modal-dialog modal-lg" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">
                                                                    {{ Route::is('permissions') ? 'Add Permission' : 'Edit Permission' }}
                                                                </h5>
                                                                <button type="button" class="btn-close"
                                                                    data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <div class="mb-3">
                                                                    <label class="form-label">Name</label>
                                                                    <input type="text" value="{{ $permission->name }}"
                                                                        class="form-control" name="name"
                                                                        placeholder="Your report name">
                                                                </div>

                                                                <div class="modal-footer">
                                                                    <a href="" class="btn btn-link link-secondary"
                                                                        data-bs-dismiss="modal">
                                                                        Cancel
                                                                    </a>
                                                                    <input type="submit" value="Update"
                                                                        class="btn btn-primary ms-auto">

                                                                    </input>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </table>
                            <div class="d-flex justify-content-center mt-3">
                                {{ $permissions->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @push('modal')
        <form action="{{ route('permissions.store') }}" method="Post">
            @csrf
            <div class="modal modal-blur fade" id="modal-ad-permission" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">{{ Route::is('permissions') ? 'Add Permission' : 'Edit Permission' }}
                            </h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label class="form-label">Name</label>
                                <input type="text" class="form-control" name="name" placeholder="Your report name">
                            </div>

                            <div class="modal-footer">
                                <a href="" class="btn btn-link link-secondary" data-bs-dismiss="modal">
                                    Cancel
                                </a>
                                <input type="submit" class="btn btn-primary ms-auto">
                                <!-- Download SVG icon from http://tabler-icons.io/i/plus -->
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                    viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                    stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path d="M12 5l0 14" />
                                    <path d="M5 12l14 0" />
                                </svg>
                                submit
                                </input>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    @endpush
@endsection
