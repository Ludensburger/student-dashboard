document.addEventListener('DOMContentLoaded', function() {
    // Fetch and display students
    function init() {
        // Add event listeners for edit and delete buttons
        document.querySelectorAll('.edit-student').forEach(button => {
            button.addEventListener('click', handleEditStudent);
        });

        document.querySelectorAll('.delete-student').forEach(button => {
            button.addEventListener('click', handleDeleteStudent);
        });
    }

    // Handle edit student
    function handleEditStudent(event) {
        const studid = event.target.getAttribute('data-id');
        console.log(studid);
        // Fetch student data and populate the form for editing
        axios.get(`api/students.php?studid=${studid}`)
            .then(response => {
                const student = response.data;
                console.log(student);
                // Populate the form with student data
                document.getElementById('editStudid').value = student.studid;
                document.getElementById('editStudfirstname').value = student.studfirstname;
                document.getElementById('editStudlastname').value = student.studlastname;
                document.getElementById('editStudmidname').value = student.studmidname;
                document.getElementById('editStudprogid').value = student.studprogid;
                document.getElementById('editStudcollid').value = student.studcollid;
                document.getElementById('editStudyear').value = student.studyear;
            })
            .catch(error => alert('Error fetching student:', error.message));
    }

    // Handle delete student
    function handleDeleteStudent(event) {
        const studid = event.target.getAttribute('data-id');
        if (confirm('Are you sure you want to delete this student?')) {
            axios.post('api/students.php', new URLSearchParams({ action: 'remove', studid }))
                .then(response => {
                    const data = response.data;
                    if (data.status === 'success') {
                        alert('Student deleted successfully');
                        location.reload();
                    } else {
                        alert('Error deleting student');
                    }
                })
                .catch(error => alert('Error deleting student:', error.message));
        }
    }

    // Handle edit student form submission
    document.getElementById('edit-student-form').addEventListener('submit', function(event) {
        event.preventDefault();
        const formData = new FormData(event.target);
        formData.append('action', 'update');
        formData.append('studid', document.getElementById('editStudid').value);

        axios.post('api/students.php', formData)
            .then(response => {
                const data = response.data;
                if (data.status === 'success') {
                    alert('Student updated successfully');
                    location.reload();
                    // Hide the edit student modal
                    const editStudentModal = bootstrap.Modal.getInstance(document.getElementById('editStudentModal'));
                    editStudentModal.hide();
                } else {
                    alert('Error updating student');
                }
            })
            .catch(error => alert('Error updating student:', error.message));
    });

    // Handle add student form submission
    document.getElementById('add-student-form').addEventListener('submit', function(event) {
        event.preventDefault();
        const formData = new FormData(event.target);
        formData.append('action', 'add');

        axios.post('api/students.php', formData)
            .then(response => {
                const data = response.data;
                if (data.status === 'success') {
                    alert('Student added successfully');
                    // Hide the add student modal
                    const addStudentModal = bootstrap.Modal.getInstance(document.getElementById('addStudentModal'));
                    location.reload();
                    addStudentModal.hide();
                } else {
                    alert('Error adding student');
                }
            })
            .catch(error => console.error('Error adding student:', error));
    });

    // Fetch students on page load
    init();
});