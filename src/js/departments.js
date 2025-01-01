document.addEventListener("DOMContentLoaded", function () {
  // Fetch and display departments
  function init() {
    // Add event listeners for edit and delete buttons
    document.querySelectorAll(".edit-department").forEach((button) => {
      button.addEventListener("click", handleEditDepartment);
    });

    document.querySelectorAll(".delete-department").forEach((button) => {
      button.addEventListener("click", handleDeleteDepartment);
    });
  }

  // Handle edit department
  function handleEditDepartment(event) {
    const deptid = event.target.getAttribute("data-id");
    console.log("Edit button clicked for department ID:", deptid);
    // Fetch department data and populate the form for editing
    axios
      .get(`api/departments.php?deptid=${deptid}`)
      .then((response) => {
        const department = response.data;
        console.log("Fetched department data:", department);
        // Populate the form with department data
        document.getElementById("editDeptid").value = department.deptid;
        document.getElementById("editDeptfullname").value =
          department.deptfullname;
        document.getElementById("editDeptshortname").value =
          department.deptshortname;
        document.getElementById("editDeptcollid").value = department.deptcollid;
      })
      .catch((error) => alert("Error fetching department:", error.message));
  }

  // Handle delete department
  function handleDeleteDepartment(event) {
    const deptid = event.target.getAttribute("data-id");
    if (confirm("Are you sure you want to delete this department?")) {
      axios
        .post(
          "api/departments.php",
          new URLSearchParams({ action: "remove", deptid })
        )
        .then((response) => {
          const data = response.data;
          if (data.status === "success") {
            alert("Department deleted successfully");
            location.reload();
          } else {
            alert("Error deleting department");
          }
        })
        .catch((error) => alert("Error deleting department:", error.message));
    }
  }

  // Handle edit department form submission
  document
    .getElementById("edit-department-form")
    .addEventListener("submit", function (event) {
      event.preventDefault();
      const formData = new FormData(event.target);
      formData.append("action", "update");

      axios
        .post("api/departments.php", formData)
        .then((response) => {
          const data = response.data;
          if (data.status === "success") {
            alert("Department updated successfully");
            location.reload();
            // Hide the edit department modal
            const editDepartmentModal = bootstrap.Modal.getInstance(
              document.getElementById("editDepartmentModal")
            );
            editDepartmentModal.hide();
          } else if (data.message === "Duplicate department") {
            alert("Error: Duplicate department");
          } else {
            alert("Error updating department: " + data.message);
          }
        })
        .catch((error) => {
          console.error("Error updating department:", error);
          alert("Error updating department:", error.message);
        });
    });

  // Handle add department form submission
  document
    .getElementById("add-department-form")
    .addEventListener("submit", function (event) {
      event.preventDefault();
      const formData = new FormData(event.target);
      formData.append("action", "add");

      axios
        .post("api/departments.php", formData)
        .then((response) => {
          const data = response.data;
          if (data.status === "success") {
            alert("Department added successfully");
            // Hide the add department modal
            const addDepartmentModal = bootstrap.Modal.getInstance(
              document.getElementById("addDepartmentModal")
            );
            location.reload();
            addDepartmentModal.hide();
          } else if (data.message === "Duplicate department") {
            alert("Error: Duplicate department");
          } else {
            alert("Error adding department: " + data.message);
          }
        })
        .catch((error) => {
          console.error("Error adding department:", error);
          alert("Error adding department:", error.message);
        });
    });

  // Fetch departments on page load
  init();
});
