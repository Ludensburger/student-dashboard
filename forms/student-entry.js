document.addEventListener("DOMContentLoaded", function () {
    const collegeSelect = document.getElementById("studcollid");
    const programSelect = document.getElementById("studprogid");

    // Fetch colleges
    axios
        .get("http://localhost:8080/final-project/api/crud.php/colleges")
        .then((response) => {
            let colleges = response.data;
            colleges.forEach((college) => {
                let option = document.createElement("option");
                option.value = college.collid;
                option.textContent = college.collfullname;
                collegeSelect.appendChild(option);
            });
        })
        .catch((error) => {
            console.log("There was an error fetching the colleges! ", error);
        });

    // Handle college selection
    collegeSelect.addEventListener("change", function () {
        const selectedCollegeId = collegeSelect.value;
        if (selectedCollegeId) {
            axios
                .get(`http://localhost:8080/final-project/api/crud.php/programs?collid=${selectedCollegeId}`)
                .then((response) => {
                    console.log("Response from server:", response.data); // Log the response
                    let programs = response.data;
                    if (Array.isArray(programs)) {
                        programSelect.innerHTML = ''; // Clear existing options
                        programs.forEach((program) => {
                            let option = document.createElement("option");
                            option.value = program.progid;
                            option.textContent = program.progfullname;
                            programSelect.appendChild(option);
                        });
                    } else {
                        console.error("Expected an array of programs but got:", programs);
                    }
                })
                .catch((error) => {
                    console.log("There was an error fetching the programs! ", error);
                });
        }
    });

    const studentForm = document.getElementById("student-form");

    if (studentForm) {
        studentForm.addEventListener("submit", function (event) {
            event.preventDefault();

            const studid = document.getElementById("studid").value;
            const studfirstname = document.getElementById("studfirstname").value;
            const studmidname = document.getElementById("studmidname").value;
            const studlastname = document.getElementById("studlastname").value;
            const studcollid = document.getElementById("studcollid").value;
            const studprogid = document.getElementById("studprogid").value;
            const studyear = document.getElementById("studyear").value;

            axios
                .post("http://localhost:8080/final-project/api/crud.php/students", {
                    studid: studid,
                    studfirstname: studfirstname,
                    studmidname: studmidname,
                    studlastname: studlastname,
                    studcollid: studcollid,
                    studprogid: studprogid,
                    studyear: studyear,
                })
                .then((response) => {
                    console.log(response.data);
                    alert("Student created successfully!");
                    studentForm.reset();
                })
                .catch((error) => {
                    console.log("There was an error saving the student! ", error);
                });
        });

        document
            .getElementById("clear-entries")
            .addEventListener("click", function () {
                studentForm.reset();
            });

        document.getElementById("cancel").addEventListener("click", function () {
            window.location.href = "index.php";
        });
    }
});
