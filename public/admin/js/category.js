const fetchData = async () => {
  try {
    const response = await fetch("http://127.0.0.1:8000/api/category");

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

// fetchData();

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
      console.log('Success:', data);
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

// Edit Button Click
$(document).ready(function () {
  $(document).on('click', '.edit-category-btn', function () {
    let id = $(this).data('id');
    $.ajax({
      url: `/api/category / ${id}`,
      type: 'GET',
      success: function (response) {
        if (response.status) {
          let category = response.data;
          $("#id").val(category.id);
          $("#_categoryName").val(category.name || "");
          $("#_parentCategory").val(category.parent_id || "");
          $("#createFormModalLabel").text("Edit Category");
          $("#EditCategoryModel").modal('show');
        } else {
          console.error("Invalid response format:", response);
        }

      }
    })
  })


});
// Update Category Form Submission
$("#editCategoryForm").on("submit", async function (e) {
  e.preventDefault();
  let form = e.target

  const formData = new FormData(form);
  formData.append('_method', 'PUT');
  const id = $(form).find("#_id").val();
  try {

    let response = await postApi(`http://127.0.0.1:8000/api/category/${id}`, formData, "POST",);
    if (response.status) {
      showToast('success', response.message);
    }
    $("#EditCategoryModel").modal("hide");
    fetch();
  } catch (error) {
    showToast('error', "Error updating project:", error);
  }

  ///

  $(document).on('submit', '##editCategoryForm', function (e) {
    e.preventDefault();

    let formdata = new FormData(this);
    $.ajax({
      url: `http://127.0.0.1:8000/api/category`,
      type: 'POST',
      data: formdata,
      processData: false,
      contentType: false,
      success: function () {
        info('data updated')
        $("#EditCategoryModel").modal("hide");

      }

    })
  })



});







// Delete Category
$(document).off("click", ".delete-category-btn").on("click", ".delete-category-btn", async function () {
  const id = $(this).data("id");
  let button = $(this);

  if (!confirm("Are you sure you want to delete this category?")) {
    return; // Exit if user cancels
  }

  try {
    await fetch(`http://127.0.0.1:8000/api/category/${id}`, {
      method: "DELETE",
      headers: {
        "Content-Type": "application/json",
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
      }
    });

    // ✅ Remove Row from DataTable
    $(button).closest("tr").remove();
    fetchData(); // Refresh DataTable

    showToast('success', "Category deleted successfully.");
  } catch (error) {
    console.error("Error deleting category:", error);
    showToast('error', "Error deleting category.");
  }
});

// ✅ Simple Toast Notification Function
function showToast(type, message) {
  let bgColor = type === "success" ? "green" : "red";
  $("body").append(`<div class="toast-notification" style="position: fixed; bottom: 20px; right: 20px; background: ${bgColor}; color: white; padding: 10px 20px; border-radius: 5px; z-index: 1000;">${message}</div>`);

  setTimeout(() => {
    $(".toast-notification").fadeOut(500, function () { $(this).remove(); });
  }, 3000);
}



fetchData();
