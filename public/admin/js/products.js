const tableId = "#productTable";

// Fetch and initialize DataTable
const fetchProductData = async () => {
    try {
        const response = await fetch("/api/product");
        const json = await response.json();
        const data = json.data || [];

        const table = $(tableId).DataTable({
            data,
            destroy: true,
            responsive: true,
            autoWidth: false,
            order: [[0, 'desc']],
            columnDefs: [
                { searchable: false, orderable: false, targets: 0 }
            ],
            columns: [
                { data: "id" },
                { data: "name", render: (data) => data },
                {
                    data: 'categories',
                    render: function (data) {
                        return data && data.name ? data.name : 'N/A';
                    }
                },

                {
                    data: "price",
                    render: (data) => data ? `${parseFloat(data).toFixed(2)}` : "N/A"
                },
                {
                    data: "image",
                    render: function (data, type, row) {
                        return data
                            ? `<img src="${data}" alt="Product Image" class="img-thumbnail" style="width: 100px;">`
                            : "No Image";
                    }
                },
                {
                    data: "description",
                    render: (data) => data ? `${data.slice(0, 30)}...` : "No description"
                },
                {
                    data: null,
                    orderable: false,
                    render: (row) => `
                         <button
                            class="btn btn-sm btn-primary edit-product-btn"
                            data-id="${row.id}" 
                            data-name="${row.name}" 
                            data-price="${row.price}" 
                            data-description="${row.description}">
                            Edit
                        </button>
                        <button class="btn btn-sm btn-danger delete-product-btn" data-id="${row.id}">Delete</button>
                    `
                }
            ]
        });
    } catch (error) {
        console.error("Error fetching data:", error);
        showToast('error', 'Error fetching product data.');
    }
};
fetchProductData();

// Form submission handler
document.getElementById('createProductsForm').addEventListener('submit', async function (e) {
    e.preventDefault();

    const form = new FormData(this);
    try {
        const response = await fetch('/api/product', {
            method: 'POST',
            body: form,
            headers: {
                'Accept': 'application/json'
            }
        });

        if (!response.ok) {
            throw new Error('Validation failed');
        }

        const data = await response.json();
        console.log('Success:', data);

        // Close modal (Bootstrap 5)
        const modalElement = document.getElementById('createFormModal');
        const modalInstance = bootstrap.Modal.getInstance(modalElement);
        modalInstance?.hide();
        this.reset();
        fetchProductData();

        showToast('success', 'Product created successfully!');
    } catch (error) {
        console.error('Error:', error);
        showToast('error', 'Product creation failed.');
    }
});

////edit the products
$(document).on('click', '.edit-product-btn', function () {
    const id = $(this).data('id');

    $.ajax({
        url: `/api/product/${id}`,
        type: 'GET',
        success: function (response) {
            if (response.status) {
                const product = response.data;
                $('#product_id').val(product.id);
                $('#_name').val(product.name);
                $('#_price').val(product.price);
                $('#_description').val(product.description);
                $('select[name="category_id"]').val(product?.category_id);
                $('#_current_image_preview').attr('src', product.image);
                $('#EditFormModal').modal('show');
            } else {
                console.error('Error fetching product:', response.message);
            }
        },
        error: function (xhr, status, error) {
            console.error('AJAX error:', error);
        }
    });
});





$('#EditProductsForm').on('submit', function (e) {
    e.preventDefault();

    const id = $('#product_id').val();
    const formData = new FormData(this);

    $.ajax({
        url: `/api/product/${id}`,
        type: 'POST',
        data: formData,
        contentType: false,
        processData: false,
        headers: {
            'X-HTTP-Method-Override': 'PUT'
        },
        success: function (response) {
            if (response.status) {
                const product = response.product;

                alert('Product updated successfully!');
                const modalElement = document.getElementById('EditFormModal');
                const modalInstance = bootstrap.Modal.getInstance(modalElement);
                modalInstance?.hide();
                $('#EditProductsForm')[0].reset();
                fetchProductData()
            } else {
                alert('Update failed.');
            }
        },
        error: function (xhr) {
            // Optional: log errors or show messages
            console.error(xhr.responseText);
            alert('An error occurred while updating the product.');
        }
    });
});














$(document).on('click', '.delete-product-btn', function () {
    const id = $(this).data('id');
    $.ajax({
        url: `/api/product/${id}`,
        method: 'DELETE',
        headers: {
            'Accept': 'application/json'
        },
        success: function (response) {
            alert('data deleted successfully');
            fetchProductData();
        },
        error: function (response) {
            alert('invalid successfully');
        }
    })
})