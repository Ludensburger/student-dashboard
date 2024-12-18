document.addEventListener('DOMContentLoaded', function() {
    // Fetch and display programs
    function fetchPrograms() {
        // Add event listeners for edit and delete buttons
        document.querySelectorAll('.edit-program').forEach(button => {
            button.addEventListener('click', handleEditProgram);
        });

        document.querySelectorAll('.delete-program').forEach(button => {
            button.addEventListener('click', handleDeleteProgram);
        });
    }

    // Handle edit program
    function handleEditProgram(event) {
        const progid = event.target.getAttribute('data-id');
        // Fetch program data and populate the form for editing
        axios.get(`api/programs.php?progid=${progid}`)
            .then(response => {
                const program = response.data;
                console.log(program);
                // Populate the form with program data
                document.getElementById('editProgid').value = program.progid;
                document.getElementById('editProgfullname').value = program.progfullname;
                document.getElementById('editProgshortname').value = program.progshortname;
                document.getElementById('editProgcollid').value = program.progcollid;
                document.getElementById('editProgcolldeptid').value = program.progcolldeptid;
            })
            .catch(error => console.error('Error fetching program:', error));
    }

    // Handle delete program
    function handleDeleteProgram(event) {
        const progid = event.target.getAttribute('data-id');
        if (confirm('Are you sure you want to delete this program?')) {
            axios.post('api/programs.php', new URLSearchParams({ action: 'remove', progid }))
                .then(response => {
                    const data = response.data;
                    if (data.status === 'success') {
                        alert('Program deleted successfully');
                        fetchPrograms();
                    } else {
                        alert('Error deleting program');
                    }
                })
                .catch(error => console.error('Error deleting program:', error));
        }
    }

    // Handle edit program form submission
    document.getElementById('edit-program-form').addEventListener('submit', function(event) {
        event.preventDefault();
        const formData = new FormData(event.target);
        formData.append('action', 'update');
        formData.append('progid', document.getElementById('editProgid').value);

        axios.post('api/programs.php', formData)
            .then(response => {
                const data = response.data;
                if (data.status === 'success') {
                    alert('Program updated successfully');
                    // Hide the edit program modal
                    const editProgramModal = bootstrap.Modal.getInstance(document.getElementById('editProgramModal'));
                    editProgramModal.hide();
                    fetchPrograms();
                } else {
                    alert(`Error updating program: ${data.message}`);
                }
            })
            .catch(error => {
                console.error('Error updating program:', error);
                alert(`Error updating program: ${error.response.data.message}`);
            });
    });

    // Handle add program form submission
    document.getElementById('add-program-form').addEventListener('submit', function(event) {
        event.preventDefault();
        const formData = new FormData(event.target);
        formData.append('action', 'add');

        axios.post('api/programs.php', formData)
            .then(response => {
                const data = response.data;
                if (data.status === 'success') {
                    alert('Program added successfully');
                    // Hide the add program modal
                    const addProgramModal = bootstrap.Modal.getInstance(document.getElementById('addProgramModal'));
                    addProgramModal.hide();
                    fetchPrograms();
                } else {
                    alert(`Error adding program: ${data.message}`);
                }
            })
            .catch(error => {
                console.error('Error adding program:', error);
                alert(`Error adding program: ${error.response.data.message}`);
            });
    });

    // Fetch programs on page load
    fetchPrograms();
});