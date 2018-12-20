<nav class="col-md-2 d-none d-md-block bg-light sidebar">
  <div class="sidebar-sticky">
    <ul class="nav flex-column">
      <li class="nav-item">
        <a class="nav-link <?php if($current_page == 'index') { echo 'active'; } ?>" href="FormTests.php">
          <span data-feather="home"></span>
          API Demo <span class="sr-only">(current)</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link <?php if($current_page == 'cheapest') { echo 'active'; } ?>" href="FormCheapest.php">
          <span data-feather="percent"></span>
          Cheapest Ferry
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="https://github.com/marcosraudkett/tallink">
          <span data-feather="github"></span>
          Fork on GitHub
        </a>
      </li>
    </ul>

    <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
      <span>More Demos</span>
      <a class="d-flex align-items-center text-muted" href="https://github.com/marcosraudkett/tallink">
        <span data-feather="plus-circle"></span>
      </a>
    </h6>
    <ul class="nav flex-column mb-2">
      <li class="nav-item">
        <a class="nav-link" href="#">
          <span data-feather="info"></span>
          Coming soon
        </a>
      </li>
    </ul>
  </div>
</nav>
