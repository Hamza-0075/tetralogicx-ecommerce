@extends('layouts.main')
@section('content')
    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <div class="page-pretitle">Overview</div>
                    <h2 class="page-title">Products</h2>
                </div>
                @can('add user')
                    <div class="col-auto ms-auto d-print-none">
                        <div class="btn-list">
                            <a href="{{ route('product.add') }}" class="btn btn-primary d-none d-sm-inline-block">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                    viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                    stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path d="M12 5l0 14" />
                                    <path d="M5 12l14 0" />
                                </svg>
                                Add product
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

    <div class="container-xl mt-3">
        <div class="card">
            <div class="table-responsive">
                <table class="table table-bordered table-hover" id="products-table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Product Name</th>
                            <th>Category</th>
                            {{-- <th>Base Price</th> --}}
                            <th>Stock</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Data will be loaded here via AJAX -->
                    </tbody>
                </table>
                <div class="d-flex justify-content-center mt-3" id="pagination-links">
                    <!-- Pagination links will be loaded here via AJAX -->
                </div>
            </div>
        </div>
    </div>

    <script>
        // Load the products when the document is ready
        $(document).ready(function() {
            loadProducts();
        });

        // Define loadProducts in the global scope
        window.loadProducts = function(page = 1) {
            $.ajax({
                url: "{{ route('products.data') }}?page=" + page,
                type: "GET",
                success: function(response) {
                    console.log(response.data)
                    var tbody = '';
                    var products = response.data;
                    $.each(products, function(index, product) {
                        tbody += '<tr>';
                        tbody += '<td>' + (response.from + index) + '</td>'; // Adjust for pagination
                        tbody += '<td>' + (product.name ? product.name : ' ') + '</td>';
                        tbody += '<td>' + (product.categories ?  product.categories.map(cat=>cat.name).join(', ') : ' ') + '</td>';
                        // tbody += '<td>$' + (product.price ? parseFloat(product.price).toFixed(2) : ' ') + '</td>';
                        tbody += '<td>' + (product.stock > 0 ? '<span class="text-success">' + product.stock + ' in stock</span>' : '<span class="text-danger">0 in Stock</span>') + '</td>';
                        tbody += '<td>' + (product.is_active === 1 ? '<span class="badge bg-success text-white">Active</span>' : '<span class="badge bg-danger text-white">Draft</span>') + '</td>';
                        tbody += '<td>';
                        tbody += '<div class="btn-group">';
                            tbody += '<a href="/product/edit/' + product.id + '" class="btn btn-sm btn-warning" title="Edit"><i class="fa fa-edit"></i></a>';
                            tbody += '<button class="btn btn-sm btn-danger" title="Delete" onclick="deleteProduct(' + product.id + ')"><i class="fa fa-trash"></i></button>';
                        tbody += '</div>';
                        tbody += '</td>';
                        tbody += '</tr>';
                    });
                    $('#products-table tbody').html(tbody);

                    // Handle pagination links
                    var paginationHtml = '<ul class="pagination">'; // Start pagination
                    $.each(response.links, function(index, link) {
                        if (link.url) { // If there is a URL, create a link
                            paginationHtml += `
                                <li class="page-item ${link.active ? 'active' : ''}">
                                    <a class="page-link" href="#" onclick="loadProducts(${link.url.split('page=')[1]}); return false;">
                                        ${link.label}
                                    </a>
                                </li>`;
                        } else {
                            paginationHtml += `
                                <li class="page-item disabled">
                                    <span class="page-link">${link.label}</span>
                                </li>`;
                        }
                    });
                    paginationHtml += '</ul>'; // Close the unordered list
                    $('#pagination-links').html(paginationHtml); // Update pagination HTML
                },
                error: function() {
                    alert('Unable to load products.');
                }
            });
        };

        // Define the deleteProduct function in the global scope
        window.deleteProduct = function(id) {
            console.log(id)
            if (confirm("Are you sure you want to delete this product?")) {
                $.ajax({
                    type: "DELETE",
                    url: "{{route('product.delete')}}",
                    data: {id:id},
                    headers: {
                        'x-CSRF-token' : '{{ csrf_token() }}'
                    },
                    success: function() {
                        loadProducts(); // Reload the products list
                    },
                    error: function() {
                        alert("An error occurred while deleting the product.");
                    }
                });
            }
        };
    </script>

@endsection
