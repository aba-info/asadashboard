<!-- need to remove -->
<li class="nav-item wip">
    <a href="{{ route('home') }}" class="nav-link  {{ Request::is('home*') ? 'active' : '' }}">
        <i class="nav-icon fas fa-home"></i>
        <p>Home</p>
    </a>
</li>

<li class="nav-item">
    <a href="{{ route('projects.index') }}"
       class="nav-link {{ Request::is('projects*') ? 'active' : '' }}">
       <i class="nav-icon fa fa-tasks"></i>
        <p>Projects</p>
    </a>
</li>

<li class="nav-item">
    <a href="{{ route('timesheets.index') }}"
       class="nav-link {{ Request::is('timesheets*') ? 'active' : '' }}">
       <i class="nav-icon fa fa-table"></i>
        <p>Timesheets</p>
    </a>
</li>

<li class="nav-item">
    <a href="{{ route('users.index') }}" class="nav-link {{ Request::is('users*') ? 'active' : '' }}">
        <i class="nav-icon fa fa-user"></i>
        <p>Users</p>
    </a>
</li>