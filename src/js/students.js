document.addEventListener("DOMContentLoaded", function () {
  // Fetch and display students
  function init() {
    // Add event listeners for edit and delete buttons
    document.querySelectorAll(".edit-student").forEach((button) => {
      button.addEventListener("click", handleEditStudent);
    });

    document.querySelectorAll(".delete-student").forEach((button) => {
      button.addEventListener("click", handleDeleteStudent);
    });

    // Add event listener for college change for adding student
    document
      .getElementById("addStudcollid")
      .addEventListener("change", handleCollegeChange);

    // Add event listener for college change for editing student
    document
      .getElementById("editStudcollid")
      .addEventListener("change", handleCollegeChange);
  }

  // Handle college change
  function handleCollegeChange(event) {
    const selectedCollegeId = event.target.value;
    const target = event.target;
    console.log(target);

    if (target.id === "addStudcollid") {
      programSelectId = "#addStudprogid";
    } else {
      programSelectId = "#editStudprogid";
    }

    const programSelect = document.querySelector(programSelectId);
    programSelect.innerHTML = "<option value=''>Select Program</option>";

    if (selectedCollegeId && programSelect) {
      axios
        .get(`api/programs?collid=${selectedCollegeId}`)
        .then((res) => {
          const programs = res.data;
          console.log(programs);
          programs.forEach((program) => {
            const option = document.createElement("option");
            option.value = program.progid;
            option.textContent = program.progfullname;
            programSelect.appendChild(option);
          });
        })
        .catch((error) => console.error("Error fetching programs:", error));
    }
  }

  // function that fetches progid full name
  function fetchProgfullname(progid) {
    axios
      .get(`api/programs.php?progid=${progid}`)
      .then((response) => {
        const program = response.data;
        console.log(program.progfullname);
        return program.progfullname;
      })
      .catch((error) => console.error("Error fetching program:", error));
  }

  // Handle edit student
  function handleEditStudent(event) {
    const studid = event.target.getAttribute("data-id");
    // Fetch student data and populate the form for editing
    axios
      .get(`api/students.php?studid=${studid}`)
      .then((response) => {
        const student = response.data;
        console.log(student);
        // Populate the form with student data
        document.getElementById("editStudid").value = student.studid;
        document.getElementById("editStudfirstname").value =
          student.studfirstname;
        document.getElementById("editStudlastname").value =
          student.studlastname;
        document.getElementById("editStudmidname").value = student.studmidname;
        document.getElementById(
          "editStudprogid"
        ).innerHTML = `<option value="${student.studprogid}">${student.progfullname}</option>`;
        document.getElementById("editStudprogid").value = student.studprogid;
        document.getElementById("editStudcollid").value = student.studcollid;
        document.getElementById("editStudyear").value = student.studyear;
      })
      .catch((error) => alert("Error fetching student:", error.message));
  }

  // Handle delete student
  function handleDeleteStudent(event) {
    const studid = event.target.getAttribute("data-id");
    if (confirm("Are you sure you want to delete this student?")) {
      axios
        .post(
          "api/students.php",
          new URLSearchParams({ action: "remove", studid })
        )
        .then((response) => {
          const data = response.data;
          if (data.status === "success") {
            alert("Student deleted successfully");
            location.reload();
          } else {
            alert("Error deleting student");
          }
        })
        .catch((error) => alert("Error deleting student:", error.message));
    }
  }

  // Handle edit student form submission
  document
    .getElementById("edit-student-form")
    .addEventListener("submit", function (event) {
      event.preventDefault();
      const formData = new FormData(event.target);
      formData.append("action", "update");
      formData.append("studid", document.getElementById("editStudid").value);

      axios
        .post("api/students.php", formData)
        .then((response) => {
          const data = response.data;
          if (data.status === "success") {
            alert("Student updated successfully");
            location.reload();
            // Hide the edit student modal
            const editStudentModal = bootstrap.Modal.getInstance(
              document.getElementById("editStudentModal")
            );
            editStudentModal.hide();
          } else {
            alert("Error updating student");
          }
        })
        .catch((error) => alert("Error updating student:", error.message));
    });

  // Handle add student form submission
  document
    .getElementById("add-student-form")
    .addEventListener("submit", function (event) {
      event.preventDefault();
      const formData = new FormData(event.target);
      formData.append("action", "add");

      axios
        .post("api/students.php", formData)
        .then((response) => {
          const data = response.data;
          if (data.status === "success") {
            alert("Student added successfully");
            // Hide the add student modal
            const addStudentModal = bootstrap.Modal.getInstance(
              document.getElementById("addStudentModal")
            );
            location.reload();
            addStudentModal.hide();
          } else {
            alert("Error adding student");
          }
        })
        .catch((error) => console.error("Error adding student:", error));
    });

  // Fetch students on page load
  init();
});
