<?php

?>
<header class="header">
    <div class="logo-container">
        <a href="../4.0.0" class="logo">

            <img src="{{ asset('public/photo/samplelogo.png') }}" alt="" height="45" width="50" style="padding-bottom: 10px;">

        </a>

        <div class="d-md-none toggle-sidebar-left" data-toggle-class="sidebar-left-opened" data-target="html" data-fire-event="sidebar-left-opened">
            <i class="fas fa-bars" aria-label="Toggle sidebar"></i>
        </div>

    </div>

    <!-- start: search & user box -->
    <div class="header-right">
        <span class="separator"></span>

        <div id="userbox" class="userbox">
            <a href="#" data-bs-toggle="dropdown">
                <figure class="profile-picture">
                    <img src="{{ asset('public/assets/img/!logged-user.jpg') }}" alt="Joseph Doe" class="rounded-circle" data-lock-picture="{{ asset('public/assets/img/!logged-user.jpg') }}" />
                </figure>
                <div class="profile-info" data-lock-name="John Doe" data-lock-email="johndoe@okler.com">
                    <span class="name">{{ (Auth::user() != NULL) ? Auth::user()->name : 'USER' }}</span>
                    <span class="name">{{ (Auth::user() != NULL) ? Auth::user()->usertype->name: 'USERTYPE' }}</span>
                </div>
                <i class="fa custom-caret"></i>
            </a>

            <div class="dropdown-menu">
                <ul class="list-unstyled mb-2">
                    <li class="divider"></li>
                    <li>
                        <a role="menuitem" tabindex="-1" href="#"><i class="fa fa-key"></i> Change Password</a>
                        <a role="menuitem" tabindex="-1" href="{{ route('gawas') }}"><i class="bx bx-power-off"></i> Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <!-- end: search & user box -->
</header>
