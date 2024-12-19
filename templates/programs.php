<?php
register_script('/src/js/programs.js');

get_header();
require 'api/config/db.php';

// Fetch programs data
$programs = $databaseDump['programs'];
$colleges = $databaseDump['colleges'];
$departments = $databaseDump['departments'];
?>

<div class="programs p-5">
    <div class="row programs__row">
    <div class="col d-flex align-items-center">
            <h1>Programs</h1>
            <a class="btn btn-success m-3" href="/">Back to Dashboard</a>


        </div>
        <?php if (isset($_SESSION['user']['username'])) { ?>
            <div class="col programs__controls">
                <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addProgramModal">Add Program</button>
            </div>
        <?php } ?>
    </div>

    <table id="programs__table" class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Full Name</th>
                <th>Short Name</th>
                <th>College ID</th>
                <th>Department ID</th>
                <?php if (isset($_SESSION['user']['username'])) { ?>
                    <th>Actions</th>
                <?php } ?>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($programs as $program) { ?>
                <tr>
                    <td><?php echo htmlspecialchars($program['progid']); ?></td>
                    <td><?php echo htmlspecialchars($program['progfullname']); ?></td>
                    <td><?php echo htmlspecialchars($program['progshortname']); ?></td>
                    <td><?php echo htmlspecialchars($program['progcollid']); ?></td>
                    <td><?php echo htmlspecialchars($program['progcolldeptid']); ?></td>
                    <?php if (isset($_SESSION['user']['username'])) { ?>
                        <td>
                            <button class="btn btn-primary edit-program" data-id="<?php echo $program['progid']; ?>" data-bs-toggle="modal" data-bs-target="#editProgramModal">Edit</button>
                            <button class="btn btn-danger delete-program" data-id="<?php echo $program['progid']; ?>">Delete</button>
                        </td>
                    <?php } ?>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>

<!-- Add Program Modal -->
<div class="modal fade" id="addProgramModal" tabindex="-1" aria-labelledby="addProgramModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addProgramModalLabel">Add Program</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="add-program-form">
        <div class="mb-3">
            <label for="addprogid" class="form-label">Program ID</label>
            <input type="text" class="form-control" id="addprogid" name="progid" required>
          </div>  
        <div class="mb-3">
            <label for="addProgfullname" class="form-label">Full Name</label>
            <input type="text" class="form-control" id="addProgfullname" name="progfullname" required>
          </div>
          <div class="mb-3">
            <label for="addProgshortname" class="form-label">Short Name</label>
            <input type="text" class="form-control" id="addProgshortname" name="progshortname" required>
          </div>

          <div class="mb-3">
            <label for="addProgcolldeptid" class="form-label">Department ID</label>
            <select class="form-control" id="addProgcolldeptid" name="progcolldeptid" required>
              <?php foreach ($departments as $department) { ?>
                <option value="<?php echo htmlspecialchars($department['deptid']); ?>"><?php echo htmlspecialchars($department['deptfullname']); ?></option>
              <?php } ?>
            </select>
          </div>

          <div class="mb-3">
            <label for="addProgcollid" class="form-label">College ID</label>
            <select class="form-control" id="addProgcollid" name="progcollid" required>
              <?php foreach ($colleges as $college) { ?>
                <option value="<?php echo htmlspecialchars($college['collid']); ?>"><?php echo htmlspecialchars($college['collfullname']); ?></option>
              <?php } ?>
            </select>
          </div>
          
          <button type="submit" class="btn btn-primary">Add Program</button>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- Edit Program Modal -->
<div class="modal fade" id="editProgramModal" tabindex="-1" aria-labelledby="editProgramModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editProgramModalLabel">Edit Program</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="edit-program-form">
          <input type="hidden" id="editProgid" name="progid">
          <div class="mb-3">
            <label for="editProgfullname" class="form-label">Full Name</label>
            <input type="text" class="form-control" id="editProgfullname" name="progfullname" required>
          </div>
          <div class="mb-3">
            <label for="editProgshortname" class="form-label">Short Name</label>
            <input type="text" class="form-control" id="editProgshortname" name="progshortname" required>
          </div>


          <div class="mb-3">
            <label for="editProgcolldeptid" class="form-label">Department ID</label>
            <select class="form-control" id="editProgcolldeptid" name="progcolldeptid" required>
              <?php foreach ($departments as $department) { ?>
                <option value="<?php echo htmlspecialchars($department['deptid']); ?>"><?php echo htmlspecialchars($department['deptfullname']); ?></option>
              <?php } ?>
            </select>
          </div>


          <div class="mb-3">
            <label for="editProgcollid" class="form-label">College ID</label>
            <select class="form-control" id="editProgcollid" name="progcollid" required>
              <?php foreach ($colleges as $college) { ?>
                <option value="<?php echo htmlspecialchars($college['collid']); ?>"><?php echo htmlspecialchars($college['collfullname']); ?></option>
              <?php } ?>
            </select>
          </div>

   
          
          
          <button type="submit" class="btn btn-primary">Update Program</button>
        </form>
      </div>
    </div>
  </div>
</div>

<?php
get_footer();