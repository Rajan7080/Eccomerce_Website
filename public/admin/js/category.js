const fetchData = async () => {
  try {
    const response = await fetch("/api/category");

    if (!response.ok) {
      throw new Error(`HTTP error! Status: ${response.status}`);
    }

    const result = await response.json();

    if (!result.status || !Array.isArray(result.data)) {
      throw new Error("Invalid API response format");
    }

    const flattenCategories = (categories, parentName = "Root") => {
      let flatData = [];

      categories.forEach(category => {
        flatData.push({
          id: category.id,
          name: category.name,
          parent_id: category.parent_id,
        });

        if (category.children && category.children.length > 0) {
          flatData = flatData.concat(flattenCategories(category.children, category.name));
        }
      });

      return flatData;
    };

    const data = flattenCategories(result.data);

    $("#datatable").DataTable({
      data,
      destroy: true,
      columns: [
        { data: "id" },
        { data: "name" },
        { data: "parent_id" },
        {
          data: "image",
          render: (data, type, row) => {
            return `<img src="${data}" alt="${row.name}" style="width: 50px; height: 50px;">`;
          }
        },
        {
          data: null,
          render: (row) => `
                        <button class="btn btn-sm btn-primary edit-category-btn" data-id="${row.id}">Edit</button>
                        <button class="btn btn-sm btn-danger delete-category-btn" data-id="${row.id}">Delete</button>
                    `,
        },
      ],
    });

  } catch (error) {
    console.error("Error fetching data:", error);
  }
};

fetchData();


// Add Category Form
document.getElementById('createCategoryForm').addEventListener('submit', function (e) {
  e.preventDefault();
  const formData = new FormData(this);

  fetch('/api/category', {
    method: 'POST',
    body: formData,
    headers: { 'Accept': 'application/json' }
  })
    .then(response => {
      if (!response.ok) {
        throw new Error('Network response was not ok ' + response.statusText);
      }
      return response.json();
    })
    .then(data => {

      const modalElement = document.getElementById('createFormModal');
      const modalInstance = bootstrap.Modal.getInstance(modalElement) || new bootstrap.Modal(modalElement);
      modalInstance.hide();
      document.getElementById('createCategoryForm').reset();
      fetchData(); // Refresh DataTable
    })
    .catch(error => {
      console.error('Error:', error);
    });
});

$(document).on('click', '.edit-category-btn', function () {
  let id = $(this).data('id');
  $.ajax({
    url: `/api/category/${id}`,
    type: 'GET',
    success: function (response) {
      if (response.status) {
        let category = response.data;
        $("#id").val(category.id);
        $("#_categoryName").val(category.name || "");
        $('select[name="_parentCategory"]').val(category.parent_id || "");
        $("#createFormModalLabel").text("Edit Category");
        $('#EditCategoryModal').modal('show');
      } else {
        console.error("Invalid response format:", response);
      }

    }
  })
})
// Update Category Form Submission

$(document).on('submit', '#editCategoryForm', function (e) {
  e.preventDefault();
  let id = $("#id").val();

  let formdata = new FormData(this);
  $.ajax({
    url: `/api/category/${id}`,
    type: 'POST',
    data: formdata,
    processData: false,
    contentType: false,
    headers: {
      'X-HTTP-Method-Override': 'PUT'
    },
    success: function (response) {
      if (response.status) {
        const product = response.product;

        alert('Product updated successfully!');
        const modalElement = document.getElementById('EditCategoryModel');
        const modalInstance = bootstrap.Modal.getInstance(modalElement);
        modalInstance?.hide();
        $('#editCategoryForm')[0].reset();
        fetchData();
      } else {
        alert('Update failed.');
      }
    },
    error: function (xhr) {
      alert('An error occurred while updating the product.');
    }


  })
})

$(document).on('click', '.delete-category-btn', function () {
  const id = $(this).data('id');
  $.ajax({
    url: `/api/category/${id}`,
    method: 'DELETE',
    headers: {
      'Accept': 'application/json'
    },
    success: function (response) {
      alert('data deleted successfully');
      fetchData();
    },
    error: function (response) {
      alert('invalid successfully');
    }
  })
})


$.ajax({
  url: '/api/categories',
  type: 'GET',
  success: function (response) {
    if (response.status) {
      const categories = response.data;
      console.log(categories)
      categories.forEach(category => {
        $('.category-carousel .swiper-wrapper').append(`
          <a href="#" class="nav-link swiper-slide text-center">
            <img src="${category.image}" class="image rounded-circle" alt="Category Thumbnail">
            <h4 class="name fs-6 mt-3 fw-normal category-title">${category.name}</h4>
          </a>
        `);
      });
    } else {
      console.error("Invalid response format:", response);
    }
  }
})


