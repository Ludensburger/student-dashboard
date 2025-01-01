<?php
register_script('/src/js/departments.js');

get_header();
require "api/config/db.php";

$departments = $databaseDump["departments"];
$colleges = $databaseDump["colleges"];
?>

<div class="departments p-5">
  <div class="row departments__row">
    <div class="col d-flex align-items-center">
      <h1 class="mb-0">Departments</h1>
      <a class="btn btn-success m-3" href="/">Back to Dashboard</a>
    </div>
    <?php if (isset($_SESSION["user"]["username"])) { ?>
      <div class="col departments__controls">
        <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addDepartmentModal">Add Department</button>
      </div>
    <?php } ?>
  </div>

    <table id="departments__table" class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Department Name</th>
                <th>Short Name</th>
                <th>College</th>
                <?php if (isset($_SESSION["user"]["username"])) { ?>
                    <th>Actions</th>
                <?php } ?>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($departments as $department) { ?>
                <tr>
                    <td><?php echo htmlspecialchars(
                        $department["deptid"] ?? ""
                    ); ?></td>
                    <td><?php echo htmlspecialchars(
                        $department["deptfullname"] ?? "N/A"
                    ); ?></td>
                    <td><?php echo htmlspecialchars(
                        $department["deptshortname"] ?? "N/A"
                    ); ?></td>
                    <td><?php echo htmlspecialchars(
                        $department["deptcollid"] ?? ""
                    ); ?></td>
                    <?php if (isset($_SESSION["user"]["username"])) { ?>
                        <td>
                            <button class="btn btn-primary edit-department"
                                data-id="<?php echo htmlspecialchars(
                                    $department["deptid"] ?? ""
                                ); ?>" data-bs-toggle="modal"
                                data-bs-target="#editDepartmentModal">Edit</button>
                            <button class="btn btn-danger delete-department"
                                data-id="<?php echo htmlspecialchars(
                                    $department["deptid"] ?? ""
                                ); ?>">Delete</button>
                        </td>
                    <?php } ?>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>

<!-- Add Department Modal -->
<div class="modal fade" id="addDepartmentModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Department</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="add-department-form">
                    <div class="mb-3">
                        <label for="addDeptid" class="form-label">Department ID</label>
                        <input type="number" class="form-control" id="addDeptid" name="deptid" required>
                    </div>
                    <div class="mb-3">
                        <label for="addDeptfullname" class="form-label">Department Name</label>
                        <input type="text" class="form-control" id="addDeptfullname" name="deptfullname" required>
                    </div>
                    <div class="mb-3">
                        <label for="addDeptshortname" class="form-label">Short Name</label>
                        <input type="text" class="form-control" id="addDeptshortname" name="deptshortname">
                    </div>
                    <div class="mb-3">
                        <label for="addDeptcollid" class="form-label">College</label>
                        <select class="form-control" id="addDeptcollid" name="deptcollid" required>
                            <?php foreach ($colleges as $college) { ?>
                                <option value="<?php echo htmlspecialchars(
                                    $college["collid"]
                                ); ?>">
                                    <?php echo htmlspecialchars(
                                        $college["collfullname"]
                                    ); ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Add Department</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Edit Department Modal -->
<div class="modal fade" id="editDepartmentModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Department</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="edit-department-form">
                    <input type="hidden" id="editDeptid" name="deptid">
                    <div class="mb-3">
                        <label for="editDeptfullname" class="form-label">Department Name</label>
                        <input type="text" class="form-control" id="editDeptfullname" name="deptfullname" required>
                    </div>
                    <div class="mb-3">
                        <label for="editDeptshortname" class="form-label">Short Name</label>
                        <input type="text" class="form-control" id="editDeptshortname" name="deptshortname">
                    </div>
                    <div class="mb-3">
                        <label for="editDeptcollid" class="form-label">College</label>
                        <select class="form-control" id="editDeptcollid" name="deptcollid" required>
                            <?php foreach ($colleges as $college) { ?>
                                <option value="<?php echo htmlspecialchars(
                                    $college["collid"]
                                ); ?>">
                                    <?php echo htmlspecialchars(
                                        $college["collfullname"]
                                    ); ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Update Department</button>
                </form>
            </div>
        </div>
    </div>
</div>



<?php get_footer();
?>
