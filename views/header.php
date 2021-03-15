
    <nav class="navbar navbar-light bg-light justify-content-between">
      <ul class="nav nav-pills">
        <li class="nav-item">
          <a class="nav-link <?php insertActive("persons") ?>" + href="?controller=persons&action=list"> Persons </a>
        </li>

        <li class="nav-item">
          <a class="nav-link <?php insertActive("hospitals") ?>" + href="?controller=hospitals&action=list"> Hopitals </a>
        </li>

        <li class="nav-item">
          <a class="nav-link <?php insertActive("sites") ?>" + href="?controller=sites&action=list"> Sites </a>
        </li>
      </ul>
    </nav>
