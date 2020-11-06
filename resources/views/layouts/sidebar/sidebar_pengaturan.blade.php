
<aside id="sc-sidebar-main">
    <div class="uk-offcanvas-bar">
	    <div data-sc-scrollbar="visible-y">
	        <ul class="sc-sidebar-menu uk-nav">
				<li class="sc-sidebar-menu-heading"><span>Menu</span></li>
				<li>
	                <a href="#">
	                   <span class="uk-nav-icon"><i class="mdi mdi-view-dashboard-variant"></i>
	                    </span><span class="uk-nav-title">User Management</span>
	                </a>
	                <ul class="sc-sidebar-menu-sub">
						<li id="link.dashboard.user.create" @if(url()->current() == route('dashboard.user.create')) class="sc-page-active" @endif>
							<a href="{{route('dashboard.user.create')}}"  > Create New </a>
						</li>				
						<li id="link.dashboard.user.index" @if(url()->current() == route('dashboard.user.index')) class="sc-page-active" @endif>
							<a href="{{route('dashboard.user.index')}}" > Lists </a>
						</li>	
					</ul>
	            </li>
	            <li>
	                <a href="#">
	                   <span class="uk-nav-icon"><i class="mdi mdi-account"></i>
	                    </span><span class="uk-nav-title">My Profile</span>
	                </a>
	                <ul class="sc-sidebar-menu-sub">
						<li id="link.dashboard.profil.index" @if(url()->current() == route('dashboard.profil.index')) class="sc-page-active" @endif>
							<a href="{{route('dashboard.profil.index')}}" >Detail </a>
						</li>					
						<li id="link.dashboard.profil.edit" @if(url()->current() == route('dashboard.profil.edit')) class="sc-page-active" @endif>
							<a href="{{route('dashboard.profil.edit')}}" >Edit</a>
						</li>
						<li id="link.dashboard.profil.change-password" @if(url()->current() == route('dashboard.profil.change-password')) class="sc-page-active" @endif>
							<a href="{{route('dashboard.profil.change-password')}}">Change Password </a>
						</li>	
					</ul>
				</li>
				<li>
	                <a href="#">
	                   <span class="uk-nav-icon"><i class="mdi mdi-alpha-p-circle-outline"></i>
	                    </span><span class="uk-nav-title">Permission</span>
	                </a>
	                <ul class="sc-sidebar-menu-sub">
						<li id="link.dashboard.master.permission.create" @if(url()->current() == route('dashboard.master.permission.create')) class="sc-page-active" @endif>
							<a href="{{route('dashboard.master.permission.create')}}"> Create New </a>
						</li>				
						<li id="link.dashboard.master.permission.index" @if(url()->current() == route('dashboard.master.permission.index')) class="sc-page-active" @endif>
							<a href="{{route('dashboard.master.permission.index')}}"> Lists </a>
						</li>	
					</ul>
				</li>
				<li>
	                <a href="#">
					
	                   <span class="uk-nav-icon">	<i class="mdi mdi-account-supervisor-circle"></i>
	                    </span><span class="uk-nav-title">Role</span>
	                </a>
	                <ul class="sc-sidebar-menu-sub">
						<li id="link.dashboard.master.role.create" @if(url()->current() == route('dashboard.master.role.create')) class="sc-page-active" @endif>
							<a href="{{route('dashboard.master.role.create')}}"> Create New </a>
						</li>				
						<li id="link.dashboard.master.role.index" @if(url()->current() == route('dashboard.master.role.index')) class="sc-page-active" @endif>
							<a href="{{route('dashboard.master.role.index')}}"> Lists </a>
						</li>	
					</ul>
	            </li>
				<li>
	                <a href="#">
					
	                   <span class="uk-nav-icon">	<i class="mdi mdi-account-supervisor-circle"></i>
	                    </span><span class="uk-nav-title">Configuration</span>
	                </a>
	                <ul class="sc-sidebar-menu-sub">
						<li>
							
								<a id="link." href="{{route('dashboard.config.log')}}" target="_blank">
									{{-- <i class="mdi mdi-account-supervisor-circle"></i> --}}
									Error Log
								</a>
							</span>
						</li>					
					</ul>
	            </li>
	        </ul>
	    </div>
    </div>
	<div class="sc-sidebar-info">
        version: 2.1.0
	</div>
</aside>