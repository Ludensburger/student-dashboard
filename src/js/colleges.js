document.addEventListener("DOMContentLoaded", function () {
  // Fetch and display colleges
  function init() {
    // Add event listeners for edit and delete buttons
    document.querySelectorAll(".edit-college").forEach((button) => {
      button.addEventListener("click", handleEditCollege);
    });

    document.querySelectorAll(".delete-college").forEach((button) => {
      button.addEventListener("click", handleDeleteCollege);
    });
  }

  // Handle edit college
  function handleEditCollege(event) {
    const collid = event.target.getAttribute("data-id");
    // Fetch college data and populate the form for editing
    axios
      .get(`api/colleges.php?collid=${collid}`)
      .then((response) => {
        const college = response.data;
        // Populate the form with college data
        document.getElementById("editCollid").value = college.collid;
        document.getElementById("editCollfullname").value =
          college.collfullname;
        document.getElementById("editCollshortname").value =
          college.collshortname;
      })
      .catch((error) => alert("Error fetching college:", error.message));
  }

  // Handle delete college
  function handleDeleteCollege(event) {
    const collid = event.target.getAttribute("data-id");
    if (confirm("Are you sure you want to delete this college?")) {
      axios
        .post(
          "api/colleges.php",
          new URLSearchParams({ action: "remove", collid })
        )
        .then((response) => {
          const data = response.data;
          if (data.status === "success") {
            alert("College deleted successfully");
            location.reload();
          } else {
            alert("Error deleting college");
          }
        })
        .catch((error) => alert("Error deleting college:", error.message));
    }
  }

  // Handle edit college form submission
  document
    .getElementById("edit-college-form")
    .addEventListener("submit", function (event) {
      event.preventDefault();
      const formData = new FormData(event.target);
      formData.append("action", "update");
      formData.append("collid", document.getElementById("editCollid").value);

      console.log(formData);

      formData.forEach((value, key) => {
        console.log(key, value);
      });

      axios({
        method: "post",
        url: "api/colleges.php",
        data: formData,
        headers: { "Content-Type": "multipart/form-data" },
      })
        .then((response) => {
          const data = response.data;
          if (data.status === "success") {
            alert("College updated successfully");
            // Hide the edit college modal
            const editCollegeModal = bootstrap.Modal.getInstance(
              document.getElementById("editCollegeModal")
            );
            editCollegeModal.hide();
            location.reload();
          } else {
            alert("Error updating college: " + data.message);
          }
        })
        .catch((error) => alert("Error updating college:", error.message));
    });

  // Handle add college form submission
  document
    .getElementById("add-college-form")
    .addEventListener("submit", function (event) {
      event.preventDefault();
      const formData = new FormData(event.target);
      formData.append("action", "add");

      axios
        .post("api/colleges.php", formData)
        .then((response) => {
          const data = response.data;
          if (data.status === "success") {
            alert("College added successfully");
            // Hide the add college modal
            const addCollegeModal = bootstrap.Modal.getInstance(
              document.getElementById("addCollegeModal")
            );
            addCollegeModal.hide();
            location.reload();
          } else {
            alert("Error adding college: " + data.message);
          }
        })
        .catch((error) => console.error("Error adding college:", error));
    });

  // Fetch colleges on page load
  init();
});
