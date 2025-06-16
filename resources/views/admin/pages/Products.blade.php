@extends('admin.layouts.master')

@section('content')
<div class="main-content mt-5">
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center      justify-content-between">
                        <h4 class="mb-sm-0">Products</h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboards</a></li>
                                <li class="breadcrumb-item active">Products</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <!---->
            <div class="row">
                <div class="col-lg-8">
                    <div class="card" id="orderList">
                        <div class="card-header border-0">
                            <div class="row align-items-center gy-3">
                                <div class="col-sm">
                                    <h5 class="card-title mb-0">Product List</h5>
                                </div>
                                <div class="container mt-5">
                                    <!-- Button to Open Modal -->
                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                        data-bs-target="#createFormModal">
                                        Create Products
                                    </button>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="card-body pt-0">
                        <div class="table-responsive table-card mb-1">
                            <table id="productTable" class="table table-striped table-bordered nowrap"
                                style="width:100%">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>category</th>
                                        <th>price</th>
                                        <th>image</th>
                                        <th>description</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody></tbody> <!-- DataTable will populate this -->
                            </table>
                        </div>
                    </div>
                    <!-- #region add_form-->
                    <!-- Create Product Modal -->
                    <div class="modal fade" id="createFormModal" tabindex="-1" aria-labelledby="createFormModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form id="createProductsForm" method="post" enctype="multipart/form-data">
                                    @csrf
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="createFormModalLabel">Create New Product</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>

                                    <div class="modal-body">
                                        @csrf



                                        <div class="mb-3">
                                            <label for="name" class="form-label">Product Name</label>
                                            <input type="text" class="form-control" id="name" name="name" placeholder="Enter product name" required>
                                        </div>

                                        <div class="mb-3">
                                            <label for="price" class="form-label">Price</label>
                                            <input type="string" class="form-control" id="price" name="price" placeholder="Enter price" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="price" class="form-label">description</label>
                                            <input type="string" class="form-control" id="description" name="description" placeholder="" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="price" class="form-label">image</label>
                                            <input type="file" class="form-control" id="image" name="image" accept="image/jpeg,image/png,image/jpg,image/gif" required>
                                        </div>
                                        @php
                                        $categories = categoriesget();
                                        @endphp

                                        <div class="mb-3">
                                            <label for="category_id" class="form-label">Category</label>
                                            <select class="form-control" id="_category_id" name="category_id" required>
                                                <option value="">Select Category</option>

                                                @foreach($categories as $category)
                                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                                                @endforeach

                                            </select>
                                        </div>

                                    </div>

                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                        <button type="submit" id="add-btn" class="btn btn-primary">Create Product</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>


                    <!-- Edit model of products-->
                    <div class="modal fade" id="EditFormModal" tabindex="-1" aria-labelledby="_createFormModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form id="EditProductsForm" enctype="multipart/form-data">
                                    @csrf
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="_createFormModalLabel">Edit Product</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>

                                    <div class="modal-body">
                                        <input type="hidden" id="product_id" name="id">

                                        <div class="mb-3">
                                            <label for="_name" class="form-label">Product Name</label>
                                            <input type="text" class="form-control" id="_name" name="name" placeholder="Enter product name" required>
                                        </div>

                                        <div class="mb-3">
                                            <label for="_price" class="form-label">Price</label>
                                            <input type="text" class="form-control" id="_price" name="price" placeholder="Enter price" required>
                                        </div>

                                        <div class="mb-3">
                                            <label for="_description" class="form-label">Description</label>
                                            <input type="text" class="form-control" id="_description" name="description" placeholder="Enter description" required>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">Current Image</label>
                                            <div>
                                                <img id="_current_image_preview" src="" width="100" height="100" alt="Current Product Image"
                                                    style="object-fit: cover; border-radius: 8px; border: 1px solid #ddd;">
                                            </div>
                                        </div>

                                        <div class="mb-3">
                                            <label for="_image" class="form-label">Upload New Image</label>
                                            <input type="file" class="form-control" id="_image" name="image" accept="image/*">
                                        </div>

                                        <div class="mb-3">
                                            <label for="category_id" class="form-label">Category</label>
                                            <select class="form-control" id="_category_id" name="category_id" required>
                                                <option value="">Select Category</option>

                                                @foreach(categoriesget() as $category)
                                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                                                @endforeach

                                            </select>
                                        </div>
                                    </div>

                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                        <button type="submit" id="_add-btn" class="btn btn-primary">Update Product</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>


                    <!-- #region -->
                </div>
            </div>
        </div>

    </div>
</div>
@push('script')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script type="text/javascript" src="{{ asset('admin/js/products.js') }}"></script>


@endpush
@endsection