<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Information Entry</title>
    <script src="axios\axios.min.js"></script>
</head>

<body>
    <h1>Student Information Entry</h1>

    <form id="student-form">
        <label for="studid">Student ID:</label>
        <input type="text" id="studid" placeholder="Student ID" required><br>

        <label for="studfirstname">First Name:</label>
        <input type="text" id="studfirstname" placeholder="First Name" required><br>

        <label for="studmidname">Middle Name:</label>
        <input type="text" id="studmidname" placeholder="Middle Name"><br>

        <label for="studlastname">Last Name:</label>
        <input type="text" id="studlastname" placeholder="Last Name" required><br>

        <label for="studcollid">College:</label>
        <select id="studcollid" required>
            <option value="">Select College</option>
            <!-- Add options dynamically -->
        </select><br>

        <label for="studprogid">Program:</label>
        <select id="studprogid" required>
            <option value="">Select Program</option>
            <!-- Add options dynamically -->
        </select><br>

        <label for="studyear">Year:</label>
        <input type="text" id="studyear" placeholder="Year" required><br>

        <button type="submit">Save</button>
        <button type="button" id="clear-entries">Clear Entries</button>
        <button type="button" id="cancel">Cancel</button>
    </form>

    <script src="forms/student-entry.js"></script>
</body>
</html>

