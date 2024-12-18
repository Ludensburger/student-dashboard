<?php enqueue_scripts(); ?>

<!-- login modal -->
<div class="modal fade" id="login" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content p-3">
      <form id="login-form">
        <div class="mb-3">
          <label for="usernamelogin" class="form-label">Username</label>
          <input type="text" class="form-control" id="usernamelogin" name="username" required>
        </div>
        <div class="mb-3">
          <label for="passwordlogin" class="form-label">Password</label>
          <input type="password" class="form-control" id="passwordlogin" name="password" required>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
      </form>
    </div>
  </div>
</div>

<!-- register modal -->
<div class="modal fade" id="register" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content p-3">
      <form id="register-form">
        <div class="mb-3">
          <label for="usernameregister" class="form-label">Username</label>
          <input type="text" class="form-control" id="usernameregister" name="username" required>
        </div>
        <div class="mb-3">
          <label for="passwordregister" class="form-label">Password</label>
          <input type="password" class="form-control" id="passwordregister" name="password" required>
        </div>
        <div class="mb-3">
          <label for="passwordregisterconfirm" class="form-label">Confirm Password</label>
          <input type="password" class="form-control" id="passwordregisterconfirm" name="confirm_password" required>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
      </form>
    </div>
  </div>
</div>

</body>
</html>