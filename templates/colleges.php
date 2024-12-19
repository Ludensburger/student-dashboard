<?php
register_script('/src/js/colleges.js');

get_header();
require "api/config/db.php";

$colleges = $databaseDump["colleges"];
?>

<div class="colleges p-5">
  <div class="row colleges__row">
    <div class="col d-flex align-items-center">
      <h1 class="mb-0">Colleges</h1>
      <a class="btn btn-success m-3" href="/">Back to Dashboard</a>
    </div>
    <?php if (isset($_SESSION["user"]["username"])) { ?>
      <div class="col colleges__controls">
        <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addCollegeModal">Add College</button>
      </div>
    <?php } ?>
  </div>

  <table id="colleges__table" class="table table-striped">
    <thead>
      <tr>
        <th>ID</th>
        <th>College Name</th>
        <th>Short Name</th>
        <?php if (isset($_SESSION["user"]["username"])) { ?>
          <th>Actions</th>
        <?php } ?>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($colleges as $college) { ?>
        <tr>
          <td><?php echo htmlspecialchars($college["collid"] ?? ""); ?></td>
          <td><?php echo htmlspecialchars($college["collfullname"] ?? "N/A"); ?></td>
          <td><?php echo htmlspecialchars($college["collshortname"] ?? "N/A"); ?></td>
          <?php if (isset($_SESSION["user"]["username"])) { ?>
            <td>
              <button class="btn btn-primary edit-college" data-id="<?php echo htmlspecialchars($college["collid"] ?? ""); ?>" data-bs-toggle="modal" data-bs-target="#editCollegeModal">Edit</button>
              <button class="btn btn-danger delete-college" data-id="<?php echo htmlspecialchars($college["collid"] ?? ""); ?>">Delete</button>
            </td>
          <?php } ?>
        </tr>
      <?php } ?>
    </tbody>
  </table>
</div>

<!-- Add College Modal -->
<div class="modal fade" id="addCollegeModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Add College</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <form id="add-college-form">
          <div class="mb-3">
            <label for="addCollid" class="form-label">College ID</label>
            <input type="text" class="form-control" id="addCollid" name="collid" required>
          </div>
          <div class="mb-3">
            <label for="addCollfullname" class="form-label">College Name</label>
            <input type="text" class="form-control" id="addCollfullname" name="collfullname" required>
          </div>
          <div class="mb-3">
            <label for="addCollshortname" class="form-label">Short Name</label>
            <input type="text" class="form-control" id="addCollshortname" name="collshortname" required>
          </div>
          <button type="submit" class="btn btn-primary">Add College</button>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- Edit College Modal -->
<div class="modal fade" id="editCollegeModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Edit College</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <form id="edit-college-form">
          <div class="mb-3">
            <label for="editCollid" class="form-label">College ID</label>
            <input type="text" class="form-control" id="editCollid" name="collid" required>
          </div>
          <div class="mb-3">
            <label for="editCollfullname" class="form-label">College Name</label>
            <input type="text" class="form-control" id="editCollfullname" name="collfullname" required>
          </div>
          <div class="mb-3">
            <label for="editCollshortname" class="form-label">Short Name</label>
            <input type="text" class="form-control" id="editCollshortname" name="collshortname" required>
          </div>
          <button type="submit" class="btn btn-primary">Update College</button>
        </form>
      </div>
    </div>
  </div>
</div>

<?php get_footer(); ?>