<!-- Sidebar -->
@php
    $pendingRequestsCount = App\Models\PrescriptionRequest::where('status', 'pending')->count();
        $nurseRequestsCount = App\Models\NurseHire::where('status', 'requested')->count();
@endphp

<div class="sidebar">
    <h5 class="text-light text-center">Admin Dashboard</h5>
    <hr class="bg-light font-weight-bold">

    <ul class="nav flex-column mt-5">
        <li class="nav-item">
            <a href="{{ route('admin.dashboard') }}" class="btn  nav-link {{ request()->routeIs('admin.dashboard') ? 'btn-outline-success active' : 'btn-outline-info' }}">Dashboard</a>
        </li>
        <li class="nav-item">
            <a href="{{ route('maincategories.index') }}" class="btn  nav-link {{ request()->routeIs('maincategories.index') ? 'btn-outline-success active' : 'btn-outline-info' }}">Categories</a>
        </li>
        <li class="nav-item">
            <a href="{{ route('categories.index') }}" class="btn  nav-link {{ request()->routeIs('categories.index') ? 'btn-outline-success active' : 'btn-outline-info' }}">Sub Categories</a>
        </li>
        <li class="nav-item">
            <a href="{{ route('products.index') }}" class="btn  nav-link {{ request()->routeIs('products.index', 'products.create', 'products.edit', 'products.show') ? 'btn-outline-success active' : 'btn-outline-info' }}">Products</a>
        </li>
        <li class="nav-item">
            <a href="{{ route('products.trash') }}" class="btn  nav-link {{ request()->routeIs('products.trash') ? 'btn-outline-success active' : 'btn-outline-info' }}">Trash Products</a>
        </li>
        <li class="nav-item">
            <a href="{{ route('nurses.index') }}" class="btn  nav-link {{ request()->routeIs('nurses.*') ? 'btn-outline-success active' : 'btn-outline-info' }}">Nurse</a>
        </li>
        <li class="nav-item">
            <a href="{{ route('pres.index') }}" class="btn  nav-link {{ request()->routeIs('pres.index') ? 'btn-outline-success active' : 'btn-outline-info' }}">Prescription Request {!! $pendingRequestsCount > 0 ? '<span class="badge badge-primary">' . $pendingRequestsCount . '</span>' : '' !!}
 
</a>
        </li>
        <li class="nav-item">
            <a href="{{ route('nursesrequest') }}" class="btn  nav-link {{ request()->routeIs('nursesrequest') ? 'btn-outline-success active' : 'btn-outline-info' }}">Nurse Request {!! $nurseRequestsCount > 0 ? '<span class="badge badge-primary">' . $nurseRequestsCount . '</span>' : '' !!}</a>
        </li>
        <li class="nav-item">
            <a href="{{ route('all.user') }}" class="btn  nav-link {{ request()->routeIs('all.user') ? 'btn-outline-success active' : 'btn-outline-info' }}">Users</a>
        </li>
        <li class="nav-item">
            <a href="{{ route('contactus.show') }}" class="btn  nav-link {{ request()->routeIs('contactus.show') ? ' btn-outline-danger active' : 'btn-outline-info' }}">Contact User</a>
        </li>
        <!-- Add more sidebar items as needed -->
    </ul>
    
    
</div>
