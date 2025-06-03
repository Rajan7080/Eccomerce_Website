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
        const response = await fetch('http://127.0.0.1:8000/api/product', {
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
                $('#_category_id').val(String(product.category_id)).trigger('change');

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


//update form
$(document).on('submit', '#EditProductsForm', function (e) {
    e.preventDefault();
    const id = $('#product_id').val();
    const formData = new FormData(this);
    formData.append('_method', 'PUT');
    $.ajax({
        url: `/api/product/${id}`,
        method: 'PUT',
        bodydata: formData,
        processData: false,
        contentType: false,
        headers: {
            'Accept': 'application/json'
        },
        success: function (response) {
            if (response.status) {
                info('data updated successfully');
                $('#EditFormModal').modal('hide');
            }
        },
        error: function (response) {
            info('invalid update');
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