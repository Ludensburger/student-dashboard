<?php
get_header();
?>

<section class="home">
  <div class="container">
    <div class="row home__wrapper">
      <h1 class="home__title">Welcome to the Student Dashboard</h1>
      <div class="col-sm-3">
        <div class="home__card card">
          <div class="card-body home__card-body">
            <h2 class="card-title home__card-title">Students</h2>
            <a href="/students" class="btn btn-primary">Click Here</a>
          </div>
        </div>
      </div>
      <div class="col-sm-3">
        <div class="home__card card">
          <div class="card-body home__card-body">
            <h2 class="card-title home__card-title">Colleges</h2>
            <a href="/colleges" class="btn btn-primary">Click Here</a>
          </div>
        </div>
      </div>
      <div class="col-sm-3">
        <div class="home__card card">
          <div class="card-body home__card-body">
            <h2 class="card-title home__card-title">Departments</h2>
            <a href="/departments" class="btn btn-primary">Click Here</a>
          </div>
        </div>
      </div>
      <div class="col-md-3">
        <div class="home__card card">
          <div class="card-body home__card-body">
            <h2 class="card-title home__card-title">Programs</h2>
            <a href="/programs" class="btn btn-primary">Click Here</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<?php
get_footer();