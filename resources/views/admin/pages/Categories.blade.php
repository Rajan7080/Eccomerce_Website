@extends('admin.layouts.master')

@section('content')

<div class="main-content mt-5">

    <div class="page-content">
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">CMS</h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboards</a></li>
                                <li class="breadcrumb-item active">CMS</li>
                            </ol>
                        </div>

                    </div>
                </div>
            </div>
            <!-- end page title -->

            <div class="row">
                <div class="col-lg-8">
                    <div class="card" id="orderList">
                        <div class="card-header border-0">
                            <div class="row align-items-center gy-3">
                                <div class="col-sm">
                                    <h5 class="card-title mb-0">CMS List</h5>
                                </div>
                                <div class="container mt-5">
                                    <!-- Button to Open Modal -->
                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                        data-bs-target="#createFormModal">
                                        Create Category
                                    </button>
                                </div>

                            </div>
                        </div>

                        <div class="card-body pt-0">
                            <div class="modal-header bg-light p-3">
                                <h5 class="modal-title" id="addCategoriesModalLabel">Add Category</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="table-responsive table-card mb-1">
                                <table id="datatable" class="table table-striped table-bordered nowrap"
                                    style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Name</th>
                                            <th>Parent Category</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody> <!-- DataTable will populate this -->
                                </table>
                            </div>
                            <div class="modal fade" id="createFormModal" tabindex="-1"
                                aria-labelledby="createFormModalLabel" aria-hidden="true">
                                <div class="modal-dialog" style="max-width: 800px;">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="createFormModalLabel">Add Category</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form id="createCategoryForm" method="post" autocomplete="off">
                                                @csrf
                                                <!-- Category Name Field -->
                                                <div class="mb-3">
                                                    <label for="categoryName" class="form-label">Category Name</label>
                                                    <input type="text" id="categoryName" class="form-control"
                                                        name="name" placeholder="Enter category name" required />
                                                    <div class="invalid-feedback">
                                                        Please enter a category name.
                                                    </div>
                                                </div>
                                                <!-- Parent Category Field -->
                                                <div class="mb-3">
                                                    <label for="parentCategory" class="form-label">Parent
                                                        Category</label>
                                                    <select id="parentCategory" class="form-select" name="parent_id">
                                                        <option value="">None</option>
                                                        @if(!empty($data))
                                                        @foreach ($data as $category)
                                                        <option value="{{ $category->id }}" {{ (isset($parent_id) && $parent_id == $category->id) ? 'selected' : '' }}>
                                                            {{ $category->name }}
                                                        </option>
                                                        @endforeach
                                                        @endif
                                                    </select>
                                                </div>

                                                <!-- Submit Button -->
                                                <button type="submit" class="btn btn-success">
                                                    Add Category
                                                </button>
                                            </form>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                                Close
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--editform-->
                            <!-- Edit Category Modal -->
                            <div class="modal fade" id="EditCategoryModel" tabindex="-1"
                                aria-labelledby="createFormModalLabel" aria-hidden="true">
                                <div class="modal-dialog" style="max-width: 800px;">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="createFormModalLabel">Edit Category</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form id="editCategoryForm" method="post" autocomplete="off">
                                                @csrf
                                                <input type="hidden" id="id" name="id" />

                                                <!-- Category Name Field -->
                                                <div class="mb-3">
                                                    <label for="categoryName" class="form-label">Category Name</label>
                                                    <input type="text" id="_categoryName" class="form-control"
                                                        name="name" placeholder="Enter category name" />
                                                    <div class="invalid-feedback">
                                                        Please enter a category name.
                                                    </div>
                                                </div>

                                                <!-- Parent Category Field -->
                                                <div class="mb-3">
                                                    <label for="_parentCategory" class="form-label">Parent Category</label>
                                                    <select id="_parentCategory" class="form-select" name="parent_id">
                                                        <option value="">None</option>
                                                        @if(!empty($data))
                                                        @foreach ($data as $category)
                                                        <option value="{{ $category->id }}">
                                                            {{ $category->name }}
                                                        </option>
                                                        @endforeach
                                                        @endif
                                                    </select>
                                                </div>

                                                <!-- Submit Button -->
                                                <button type="submit" class="btn btn-success">Update Category</button>
                                            </form>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div><!---->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



@endsection

@push('script')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script type="text/javascript" src="{{ asset('admin/js/category.js') }}"></script>


@endpush