
<aside id="sc-sidebar-main">
    <div class="uk-offcanvas-bar">
	    <div data-sc-scrollbar="visible-y">
	        <ul class="sc-sidebar-menu uk-nav">
				<li class="sc-sidebar-menu-heading"><span>Menu</span></li>
				<li>
	                <a href="#">
	                   <span class="uk-nav-icon"><span data-uk-icon="icon: file"></span>
	                    </span><span class="uk-nav-title">File Management</span>
	                </a>
	                <ul class="sc-sidebar-menu-sub">
						<li id="link.dashboard.file.create" @if(url()->current() == route('dashboard.file.create')) class="sc-page-active" @endif>
							<a href="{{route('dashboard.file.create')}}"  > Home </a>
						</li>				
						<li id="link.dashboard.file.index" @if(url()->current() == route('dashboard.file.index')) class="sc-page-active" @endif>
							<a href="{{route('dashboard.file.index')}}" > History </a>
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