<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <div class="container-fluid">
      <!-- Toggle sidebar button -->
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav ml-auto">
            <li class="nav-item sidebar-link ">
                <a class="nav-link"  href="{{route('admin.dashboard')}}">Dashoboard</a>
            </li>
            <li class="nav-item sidebar-link">
                <a href="{{ route('maincategories.index') }}" class="nav-link">Categories</a>
            </li>
            <li class="nav-item sidebar-link">
                <a class="nav-link" href="{{ route('categories.index') }}">Sub Categories</a>
            </li>
            <li class="nav-item sidebar-link">
                <a class="nav-link"  href="{{ route('products.index') }}">Products</a>
            </li>
            <li class="nav-item sidebar-link">
                <a class="nav-link"  href="{{ route('nurses.index') }}">Nurse</a>
            </li>
            <li class="nav-item">
                <a href="{{ route('pres.index') }}" class="nav-link">Prescription Request</a>
            </li>
            <li class="nav-item">
                <a href="{{ route('nursesrequest') }}" class="nav-link">Nurse Request</a>
            </li>
            <li class="nav-item">
                <a href="{{ route('all.user') }}" class="nav-link">Users</a>
            </li>
            <li class="nav-item">
                <a href="{{ route('contactus.show') }}" class="nav-link">Contact User</a>
            </li>
            <li class="nav-item">
                  <a class="nav-link" href="{{ route('admin.edit') }}">Profile</a>
              </li>
              <li class="nav-item">
                  <!-- Authentication -->
                  <form method="POST" action="{{ route('logout') }}" x-data>
                    @csrf
                        <input type="submit" class="btn btn-outline-danger" value="logout">
                </form>
              </li>
          </ul>
      </div>
  </div>
</nav>