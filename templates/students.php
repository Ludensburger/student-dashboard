<?php

register_script('/src/js/students.js');

get_header();



require "api/config/db.php";

// Fetch programs and colleges data
$programs = $databaseDump["programs"];
$colleges = $databaseDump["colleges"];
?>



<div class="students p-5">
  <div class="row students__row">
    <div class="col d-flex align-items-center">
      <h1 class="mb-0">Students</h1>
      <a class="btn btn-success m-3" href="/">Back to Dashboard</a>
    </div>
    <?php if (isset($_SESSION["user"]["username"])) { ?>
      <div class="col students__controls">
        <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addStudentModal">Add Student</button>
      </div>
    <?php } ?>
  </div>

  <table id="students__table" class="table table-striped">
    <thead>
      <tr>
        <th>ID</th>
        <th>First Name</th>
        <th>Last Name</th>
        <th>Middle Name</th>
        <th>Program ID</th>
        <th>College ID</th>
        <th>Year</th>
        <?php if (isset($_SESSION["user"]["username"])) { ?>
          <th>Actions</th>
        <?php } ?>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($databaseDump["students"] as $student) { ?>
        <tr>
          <td><?php echo htmlspecialchars($student["studid"]); ?></td>
          <td><?php echo htmlspecialchars($student["studfirstname"]); ?></td>
          <td><?php echo htmlspecialchars($student["studlastname"]); ?></td>
          <td><?php echo htmlspecialchars($student["studmidname"]); ?></td>
          <td><?php echo htmlspecialchars($student["studprogid"]); ?></td>
          <td><?php echo htmlspecialchars($student["studcollid"]); ?></td>
          <td><?php echo htmlspecialchars($student["studyear"]); ?></td>
          <?php if (isset($_SESSION["user"]["username"])) { ?>
            <td>
              <button class="btn btn-primary edit-student" data-id="<?php echo $student[
                  "studid"
              ]; ?>"
                data-bs-toggle="modal" data-bs-target="#editStudentModal">Edit</button>
              <button class="btn btn-danger delete-student" data-id="<?php echo $student[
                  "studid"
              ]; ?>">Delete</button>
            </td>
          <?php } ?>
        </tr>
      <?php } ?>
    </tbody>
  </table>
</div>

<!-- Add Student Modal -->
<div class="modal fade" id="addStudentModal" tabindex="-1" aria-labelledby="addStudentModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addStudentModalLabel">Add Student</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="add-student-form">
          <div class="mb-3">
            <label for="addStudid" class="form-label">Student ID</label>
            <input type="text" class="form-control" id="addStudid" name="studid" required>
          </div>
          <div class="mb-3">
            <label for="addStudfirstname" class="form-label">First Name</label>
            <input type="text" class="form-control" id="addStudfirstname" name="studfirstname" required>
          </div>
          <div class="mb-3">
            <label for="addStudlastname" class="form-label">Last Name</label>
            <input type="text" class="form-control" id="addStudlastname" name="studlastname" required>
          </div>
          <div class="mb-3">
            <label for="addStudmidname" class="form-label">Middle Name</label>
            <input type="text" class="form-control" id="addStudmidname" name="studmidname">
          </div>

          <div class="mb-3">
            <label for="addStudcollid" class="form-label">College</label>
            <select class="form-control" id="addStudcollid" name="studcollid" required default="">
                <option value="">Select College</option>
              <?php foreach ($colleges as $college) { ?>
                <option value="<?php echo htmlspecialchars($college['collid']); ?>"><?php echo htmlspecialchars($college['collfullname']); ?></option>
              <?php } ?>
            </select>
          </div>

          <div class="mb-3">
            <label for="addStudprogid" class="form-label">Program</label>
            <select class="form-control" id="addStudprogid" name="studprogid" required default="">
                <option value="">Select Program</option>
            </select>
          </div>

        

          <div class="mb-3">
            <label for="addStudyear" class="form-label">Year</label>
            <input type="number" class="form-control" id="addStudyear" name="studyear" required>
          </div>
          <button type="submit" class="btn btn-primary">Add Student</button>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- Edit Student Modal -->
<div class="modal fade" id="editStudentModal" tabindex="-1" aria-labelledby="editStudentModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editStudentModalLabel">Edit Student</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="edit-student-form">
          <input type="hidden" id="editStudid" name="studid">
          <div class="mb-3">
            <label for="editStudfirstname" class="form-label">First Name</label>
            <input type="text" class="form-control" id="editStudfirstname" name="studfirstname" required>
          </div>
          <div class="mb-3">
            <label for="editStudlastname" class="form-label">Last Name</label>
            <input type="text" class="form-control" id="editStudlastname" name="studlastname" required>
          </div>
          <div class="mb-3">
            <label for="editStudmidname" class="form-label">Middle Name</label>
            <input type="text" class="form-control" id="editStudmidname" name="studmidname">
          </div>
          <div class="mb-3">
            <label for="editStudcollid" class="form-label">College</label>
            <select class="form-control" id="editStudcollid" name="studcollid" required default="">
              <option value="">Select College</option>
              <?php foreach ($colleges as $college) { ?>
                <option value="<?php echo htmlspecialchars($college['collid']); ?>"><?php echo htmlspecialchars($college['collfullname']); ?></option>
              <?php } ?>
            </select>
          </div>
          <div class="mb-3">
            <label for="editStudprogid" class="form-label">Program</label>
            <select class="form-control" id="editStudprogid" name="studprogid" required default="">
              <option value="">Select Program</option>
            </select>
          </div>
          <div class="mb-3">
            <label for="editStudyear" class="form-label">Year</label>
            <input type="number" class="form-control" id="editStudyear" name="studyear" required>
          </div>
          <button type="submit" class="btn btn-primary">Update Student</button>
        </form>
      </div>
    </div>
  </div>
</div>

<?php get_footer();
