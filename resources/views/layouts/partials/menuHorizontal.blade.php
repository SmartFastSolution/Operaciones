<li class="dropdown{{ activeAll($menu->submenu) }}">
    <a href="#" class="nav-link has-dropdown "><i class="{{ $menu->icon }}"></i><span>{{ $menu->name }}</span></a>
    <ul class="dropdown-menu  ">
        @foreach ($menu->submenu as $submenu)
            <li class="{{ active($submenu->url) }}"><a class="nav-link"
                    href="{{ route($submenu->route) }}">{{ $submenu->name }}</a></li>
        @endforeach
    </ul>
</li>
