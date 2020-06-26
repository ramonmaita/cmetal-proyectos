<div class="main-menu menu-fixed  menu-light  menu-accordion menu-shadow" data-scroll-to-active="true">
    <div class="navbar-header">
        <ul class="nav navbar-nav flex-row">
            <li class="nav-item mr-auto">
                <a class="navbar-brand" href="{{ url('panel') }}">
                  	<div class="brand-logo">
                    	<img src="{{ asset('images/logo/logo-cmetal-2.png') }}" class="logo" alt="">
                  	</div>
                  	<h2 class="brand-text mb-0">
                        FINALBIM
                    </h2>
                </a>
            </li>
            <li class="nav-item nav-toggle">
            	<a class="nav-link modern-nav-toggle pr-0" data-toggle="collapse">
              		<i class="bx bx-x d-block d-xl-none font-medium-4 cmetal"></i>
              		<i class="toggle-icon bx bx-disc font-medium-4 d-none d-xl-block cmetal" data-ticon="bx-disc"></i>
            	</a>
            </li>
		</ul>
	</div>
<div class="shadow-bottom"></div>
<div class="main-menu-content">
  	<ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation" data-icon-style="lines">
  		@if(Auth::user()->tipo == 1)
		<li class="nav-item @yield('inicio')">
			<a href="# " >
				<i class="menu-livicon" data-icon="desktop"></i>
				<span class="menu-title">{{ __('messages.home') }}</span>
            </a>
		</li>
		@endif
    	<li class="navigation-header"><span>Modulos {{ (Auth::user()->empresa_id != null) ? Auth::user()->Empresa->nombre : '' }}</span></li>
        <li class="nav-item @yield('proyectos')">
		    <a href="{{ route('proyectos.index') }}" >
                <i class="menu-livicon" data-icon="notebook"></i>
                <span class="menu-title">{{ __('messages.projects') }}</span>
            </a>
        </li>
        @if(Auth::user()->tipo == 0)
        <li class="nav-item @yield('empresas')">
		    <a href="{{ route('empresas.index') }}" >
                <i class="menu-livicon" data-icon="wrench" data-options="size: 20px;" style=""></i>
                <span class="menu-title">{{ __('messages.empresas') }}</span>
            </a>
        </li>
        @endif
        @if(Auth::user()->tipo == 1 || Auth::user()->tipo == 0)
       {{--  <li class="nav-item @yield('metrados')">
		    <a href="{{ route('metrados.index') }}" >
                <i class="menu-livicon" data-icon="morph-map" data-options="size: 20px;" style=""></i>
                <span class="menu-title">{{ __('messages.metrados') }}</span>
            </a>
        </li> --}}

         <li class="nav-item @yield('usuarios')">
		    <a href="{{ route('usuarios.index') }}" >
                <i class="menu-livicon" data-icon="users"></i>
                <span class="menu-title">{{ __('messages.usuarios') }}</span>
            </a>
        </li>
        @endif
        {{-- <li class="nav-item ">
            <a href="app-chat.html" >
                <i class="menu-livicon" data-icon="comments"></i>
                <span class="menu-title">Chat</span>
	        </a>
        </li>
        <li class="nav-item ">
            <a href="app-todo.html" >
                <i class="menu-livicon" data-icon="check-alt"></i>
                    <span class="menu-title">Todo</span>
            </a>
        </li>
        <li class="nav-item ">
         	<a href="app-calendar.html" >
                <i class="menu-livicon" data-icon="calendar"></i>
                <span class="menu-title">Calendar</span>
            </a>
        </li>
        <li class="nav-item ">
          	<a href="app-kanban.html" >
                <i class="menu-livicon" data-icon="grid"></i>
                <span class="menu-title">Kanban</span>
            </a>
        </li>
        <li class="nav-item ">
          	<a href="# " >
                <i class="menu-livicon" data-icon="notebook"></i>
                <span class="menu-title">Invoice</span>
            </a>
        	<ul class="menu-content">
                <li >
		            <a href="app-invoice-list.html" >
		              	<i class="bx bx-right-arrow-alt"></i>
		            	<span class="menu-item">Invoice List</span>
		            </a>
                  </li>
              	<li >
            		<a href="app-invoice-view.html" >
	              		<i class="bx bx-right-arrow-alt"></i>
	            		<span class="menu-item">Invoice</span>
	            	</a>
                </li>
              	<li >
		            <a href="app-invoice-edit.html" >
		              	<i class="bx bx-right-arrow-alt"></i>
			            <span class="menu-item">Invoice Edit</span>
		            </a>
              	</li>
              	<li >
		            <a href="app-invoice-add.html" >
	            		<i class="bx bx-right-arrow-alt"></i>
		            	<span class="menu-item">Invoice Add</span>
	            	</a>
              	</li>
            </ul>
			</li>
        <li class="nav-item ">
        	<a href="app-file-manager.html" >
                <i class="menu-livicon" data-icon="save"></i>
                <span class="menu-title">File Manager</span>
            </a>
        </li> --}}



        
        {{-- <li class="navigation-header"><span>UI Elements</span></li>
        <li class="nav-item ">
          	<a href="# " >
                <i class="menu-livicon" data-icon="retweet"></i>
                <span class="menu-title">Content</span>
            </a>
            <ul class="menu-content">
                <li >
		            <a href="content-grid.html" >
		              	<i class="bx bx-right-arrow-alt"></i>
		            	<span class="menu-item">Grid</span>
		            </a>
                </li>
              	<li >
		            <a href="content-typography.html" >
		              	<i class="bx bx-right-arrow-alt"></i>
		            	<span class="menu-item">Typography</span>
		            </a>
                  </li>
              	<li >
		            <a href="content-text-utilities.html" >
		              	<i class="bx bx-right-arrow-alt"></i>
		            	<span class="menu-item">Text Utilities</span>
		            </a>
                  </li>
              	<li >
		            <a href="content-syntax-highlighter.html" >
		              	<i class="bx bx-right-arrow-alt"></i>
		            	<span class="menu-item">Syntax Highlighter</span>
		            </a>
              	</li>
              	<li >
		            <a href="content-helper-classes.html" >
		              	<i class="bx bx-right-arrow-alt"></i>
		            	<span class="menu-item">Helper Classes</span>
		            </a>
              	</li>
            </ul>
			</li>
		<li class="nav-item ">
			<a href="colors.html" >
				<i class="menu-livicon" data-icon="drop"></i>
				<span class="menu-title">Colors</span>
			</a>
		</li>
		<li class="nav-item ">
			<a href="# " >
				<i class="menu-livicon" data-icon="bulb"></i>
				<span class="menu-title">Icons</span>
			</a>
			<ul class="menu-content">
                <li >
        			<a href="icons-livicons.html" >
          				<i class="bx bx-right-arrow-alt"></i>
        				<span class="menu-item">LivIcons</span>
        			</a>
                </li>
      			<li >
        			<a href="icons-boxicons.html" >
          				<i class="bx bx-right-arrow-alt"></i>
        				<span class="menu-item">BoxIcons</span>
        			</a>
                </li>
            </ul>
			</li>
		<li class="nav-item ">
			<a href="# " >
				<i class="menu-livicon" data-icon="square"></i>
				<span class="menu-title">Card</span>
			</a>
			<ul class="menu-content">
				<li >
            		<a href="card-basic.html" >
	              		<i class="bx bx-right-arrow-alt"></i>
	            		<span class="menu-item">Basic</span>
	            	</a>
   	            </li>
				<li >
            		<a href="card-actions.html" >
	              		<i class="bx bx-right-arrow-alt"></i>
	            		<span class="menu-item">Card Actions</span>
	            	</a>
                </li>
            </ul>
			</li>
		<li class="nav-item ">
			<a href="widgets.html" >
				<i class="menu-livicon" data-icon="thumbnails-small"></i>
				<span class="menu-title">Widgets</span>
				<span class="badge badge-light-primary badge-pill badge-round float-right">New</span>
            </a>
        </li>
		<li class="nav-item ">
			<a href="# " >
				<i class="menu-livicon" data-icon="box-add"></i>
				<span class="menu-title">Components</span>
			</a>
			<ul class="menu-content">
				<li >
        			<a href="component-alerts.html" >
		              	<i class="bx bx-right-arrow-alt"></i>
		            	<span class="menu-item">Alerts</span>
		            </a>
				</li>
				<li >
        			<a href="component-buttons-basic.html" >
		              	<i class="bx bx-right-arrow-alt"></i>
		            	<span class="menu-item">Buttons</span>
		            </a>
				</li>
				<li >
        			<a href="component-breadcrumbs.html" >
		              	<i class="bx bx-right-arrow-alt"></i>
		            	<span class="menu-item">Breadcrumbs</span>
		            </a>
				</li>
				<li >
        			<a href="component-carousel.html" >
		              	<i class="bx bx-right-arrow-alt"></i>
		            	<span class="menu-item">Carousel</span>
		            </a>
				</li>
				<li >
        			<a href="component-collapse.html" >
		              	<i class="bx bx-right-arrow-alt"></i>
		            	<span class="menu-item">Collapse</span>
		            </a>
				</li>
				<li >
        			<a href="component-dropdowns.html" >
		              	<i class="bx bx-right-arrow-alt"></i>
		            	<span class="menu-item">Dropdowns</span>
		            </a>
				</li>
				<li >
        			<a href="component-list-group.html" >
		              	<i class="bx bx-right-arrow-alt"></i>
		            	<span class="menu-item">List Group</span>
		            </a>
				</li>
				<li >
        			<a href="component-modals.html" >
		              	<i class="bx bx-right-arrow-alt"></i>
		            	<span class="menu-item">Modals</span>
		            </a>
				</li>
				<li >
        			<a href="component-pagination.html" >
		              	<i class="bx bx-right-arrow-alt"></i>
		            	<span class="menu-item">Pagination</span>
		            </a>
				</li>
				<li >
        			<a href="component-navbar.html" >
		              	<i class="bx bx-right-arrow-alt"></i>
		            	<span class="menu-item">Navbar</span>
		            </a>
				</li>
				<li >
        			<a href="component-tabs-component.html" >
		              	<i class="bx bx-right-arrow-alt"></i>
		            	<span class="menu-item">Tabs Component</span>
		            </a>
				</li>
				<li >
        			<a href="component-pills-component.html" >
		              	<i class="bx bx-right-arrow-alt"></i>
		            	<span class="menu-item">Pills Component</span>
		            </a>
				</li>
				<li >
        			<a href="component-tooltips.html" >
		              	<i class="bx bx-right-arrow-alt"></i>
		            	<span class="menu-item">Tooltips</span>
		            </a>
				</li>
				<li >
        			<a href="component-popovers.html" >
		              	<i class="bx bx-right-arrow-alt"></i>
		            	<span class="menu-item">Popovers</span>
		            </a>
				</li>
				<li >
        			<a href="component-badges.html" >
		              	<i class="bx bx-right-arrow-alt"></i>
		            	<span class="menu-item">Badges</span>
		            </a>
				</li>
				<li >
        			<a href="component-pill-badges.html" >
		              	<i class="bx bx-right-arrow-alt"></i>
		            	<span class="menu-item">Pill Badges</span>
		            </a>
				</li>
				<li >
        			<a href="component-progress.html" >
		              	<i class="bx bx-right-arrow-alt"></i>
		            	<span class="menu-item">Progress</span>
		            </a>
				</li>
				<li >
        			<a href="component-media-objects.html" >
		              	<i class="bx bx-right-arrow-alt"></i>
		            	<span class="menu-item">Media Objects</span>
		            </a>
				</li>
				<li >
        			<a href="component-spinner.html" >
		              	<i class="bx bx-right-arrow-alt"></i>
		            	<span class="menu-item">Spinner</span>
		            </a>
				</li>
				<li >
        			<a href="component-bs-toast.html" >
		              	<i class="bx bx-right-arrow-alt"></i>
		            	<span class="menu-item">Toasts</span>
		            </a>
				</li>
            </ul>
			</li>
		<li class="nav-item ">
			<a href="# " >
				<i class="menu-livicon" data-icon="briefcase"></i>
				<span class="menu-title">Extra Components</span>
			</a>
			<ul class="menu-content">
				<li >
        			<a href="ex-component-avatar.html" >
			          	<i class="bx bx-right-arrow-alt"></i>
			        	<span class="menu-item">Avatar</span>
			        </a>
              	</li>
				<li >
        			<a href="ex-component-chips.html" >
			          	<i class="bx bx-right-arrow-alt"></i>
			        	<span class="menu-item">Chips</span>
			        </a>
              	</li>
				<li >
        			<a href="ex-component-divider.html" >
			          	<i class="bx bx-right-arrow-alt"></i>
			        	<span class="menu-item">Divider</span>
			        </a>
              	</li>
            </ul>
        </li>
        <li class="navigation-header"><span>Forms &amp; Tables</span></li>
		<li class="nav-item ">
			<a href="# " >
				<i class="menu-livicon" data-icon="check"></i>
				<span class="menu-title">Form Elements</span>
			</a>
			<ul class="menu-content">
				<li >
		            <a href="form-inputs.html" >
	              		<i class="bx bx-right-arrow-alt"></i>
		            	<span class="menu-item">Input</span>
		            </a>
              	</li>
				<li >
		            <a href="form-input-groups.html" >
	              		<i class="bx bx-right-arrow-alt"></i>
		            	<span class="menu-item">Input Groups</span>
		            </a>
              	</li>
				<li >
		            <a href="form-number-input.html" >
	              		<i class="bx bx-right-arrow-alt"></i>
		            	<span class="menu-item">Number Input</span>
		            </a>
              	</li>
				<li >
		            <a href="form-select.html" >
	              		<i class="bx bx-right-arrow-alt"></i>
		            	<span class="menu-item">Select</span>
		            </a>
              	</li>
				<li >
		            <a href="form-radio.html" >
	              		<i class="bx bx-right-arrow-alt"></i>
		            	<span class="menu-item">Radio</span>
		            </a>
              	</li>
				<li >
		            <a href="form-checkbox.html" >
	              		<i class="bx bx-right-arrow-alt"></i>
		            	<span class="menu-item">Checkbox</span>
		            </a>
              	</li>
				<li >
		            <a href="form-switch.html" >
	              		<i class="bx bx-right-arrow-alt"></i>
		            	<span class="menu-item">Switch</span>
		            </a>
              	</li>
				<li >
		            <a href="form-textarea.html" >
	              		<i class="bx bx-right-arrow-alt"></i>
		            	<span class="menu-item">Textarea</span>
		            </a>
              	</li>
				<li >
		            <a href="form-quill-editor.html" >
	              		<i class="bx bx-right-arrow-alt"></i>
		            	<span class="menu-item">Quill Editor</span>
		            </a>
              	</li>
				<li >
		            <a href="form-file-uploader.html" >
	              		<i class="bx bx-right-arrow-alt"></i>
		            	<span class="menu-item">File Uploader</span>
		            </a>
              	</li>
				<li >
		            <a href="form-date-time-picker.html" >
	              		<i class="bx bx-right-arrow-alt"></i>
		            	<span class="menu-item">Date &amp; Time Picker</span>
		            </a>
              	</li>
            </ul>
		</li>
		<li class="nav-item ">
			<a href="form-layout.html" >
				<i class="menu-livicon" data-icon="settings"></i>
				<span class="menu-title">Form Layout</span>
			</a>
		</li>
		<li class="nav-item ">
			<a href="form-wizard.html" >
				<i class="menu-livicon" data-icon="priority-low"></i>
				<span class="menu-title">Form Wizard</span>
			</a>
		</li>
		<li class="nav-item ">
			<a href="form-validation.html" >
				<i class="menu-livicon" data-icon="check-alt"></i>
				<span class="menu-title">Form Validation</span>
			</a>
		</li>
		<li class="nav-item ">
			<a href="form-repeater.html" >
				<i class="menu-livicon" data-icon="priority-low"></i>
				<span class="menu-title">Form Repeater</span>
			</a>
		</li>
		<li class="nav-item ">
			<a href="table.html" >
				<i class="menu-livicon" data-icon="thumbnails-big"></i>
				<span class="menu-title">Table</span>
			</a>
		</li>
		<li class="nav-item ">
			<a href="extended.html" >
				<i class="menu-livicon" data-icon="thumbnails-small"></i>
				<span class="menu-title">Table extended</span>
			</a>
		</li>
		<li class="nav-item ">
			<a href="datatable.html" >
				<i class="menu-livicon" data-icon="morph-map"></i>
				<span class="menu-title">Datatable</span>
			</a>
		</li>
        <li class="navigation-header"><span>Pages</span></li>
		<li class="nav-item ">
			<a href="page-user-profile.html" >
				<i class="menu-livicon" data-icon="user"></i>
				<span class="menu-title">User Profile</span>
			</a>
		</li>
		<li class="nav-item ">
			<a href="page-faq.html" >
				<i class="menu-livicon" data-icon="question-alt"></i>
				<span class="menu-title">FAQ</span>
			</a>
		</li>
		<li class="nav-item ">
			<a href="page-knowledge-base.html" >
				<i class="menu-livicon" data-icon="info-alt"></i>
				<span class="menu-title">Knowledge Base</span>
			</a>
		</li>
		<li class="nav-item ">
			<a href="page-search.html" >
				<i class="menu-livicon" data-icon="search"></i>
				<span class="menu-title">Search</span>
			</a>
		</li>
		<li class="nav-item ">
			<a href="page-account-settings.html" >
				<i class="menu-livicon" data-icon="wrench"></i>
				<span class="menu-title">Account Settings</span>
			</a>
		</li>
		<li class="nav-item ">
			<a href="# " >
				<i class="menu-livicon" data-icon="users"></i>
				<span class="menu-title">User</span>
			</a>
			<ul class="menu-content">
                <li >
		            <a href="page-users-list.html" >
		              	<i class="bx bx-right-arrow-alt"></i>
		            	<span class="menu-item">List</span>
		            </a>
              	</li>
          		<li >
		            <a href="page-users-view.html" >
		              	<i class="bx bx-right-arrow-alt"></i>
		            	<span class="menu-item">View</span>
		            </a>
              	</li>
          		<li >
		            <a href="page-users-edit.html" >
		              	<i class="bx bx-right-arrow-alt"></i>
		            	<span class="menu-item">Edit</span>
		            </a>
              	</li>
           	</ul>
		</li>
		<li class="nav-item ">
			<a href="# " >
				<i class="menu-livicon" data-icon="unlock"></i>
				<span class="menu-title">Authentication</span>
			</a>
			<ul class="menu-content">
				<li >
		            <a href="auth-login.html" target=_blank>
		              	<i class="bx bx-right-arrow-alt"></i>
		            	<span class="menu-item">Login</span>
		            </a>
				</li>
				<li >
		            <a href="auth-register.html" target=_blank>
		              	<i class="bx bx-right-arrow-alt"></i>
		            	<span class="menu-item">Register</span>
		            </a>
				</li>
				<li >
		            <a href="auth-forgot-password.html" target=_blank>
		              	<i class="bx bx-right-arrow-alt"></i>
		            	<span class="menu-item">Forgot Password</span>
		            </a>
				</li>
				<li >
		            <a href="auth-reset-password.html" target=_blank>
		              	<i class="bx bx-right-arrow-alt"></i>
		            	<span class="menu-item">Reset Password</span>
		            </a>
				</li>
				<li >
		            <a href="auth-lock-screen.html" target=_blank>
		              	<i class="bx bx-right-arrow-alt"></i>
		            	<span class="menu-item">Lock Screen</span>
		            </a>
				</li>
            </ul>
		</li>
		<li class="nav-item ">
			<a href="# " >
				<i class="menu-livicon" data-icon="share"></i>
				<span class="menu-title">Miscellaneous</span>
			</a>
			<ul class="menu-content">
				<li >
		            <a href="page-coming-soon.html" target=_blank>
		              	<i class="bx bx-right-arrow-alt"></i>
		            	<span class="menu-item">Coming Soon</span>
		            </a>
				</li>
				<li >
		            <a href=" # " >
		              	<i class="bx bx-right-arrow-alt"></i>
		            	<span class="menu-item">Error</span>
		            </a>
				   <ul class="menu-content">
						<li >
				            <a href="error-404.html" target=_blank>
				              	<i class="bx bx-right-arrow-alt"></i>
				            	<span class="menu-item">404</span>
				            </a>
						</li>
						<li >
				            <a href="error-500.html" target=_blank>
				              	<i class="bx bx-right-arrow-alt"></i>
				            	<span class="menu-item">500</span>
				            </a>
						</li>
	                </ul>
	  			</li>
	            <li >
		            <a href="page-not-authorized.html" target=_blank>
		              	<i class="bx bx-right-arrow-alt"></i>
		            	<span class="menu-item">Not Authorized</span>
		            </a>
			    </li>
	            <li >
		            <a href="page-maintenance.html" target=_blank>
		              	<i class="bx bx-right-arrow-alt"></i>
		            	<span class="menu-item">Maintenance</span>
		            </a>
			    </li>
            </ul>
		</li>
        <li class="navigation-header"><span>Charts &amp; Maps</span></li>
		<li class="nav-item ">
			<a href="# " >
				<i class="menu-livicon" data-icon="pie-chart"></i>
				<span class="menu-title">Charts</span><span class="badge badge-pill badge-round badge-light-info float-right mr-2">3</span>
            </a>
            <ul class="menu-content">
				<li >
		            <a href="chart-apex.html" >
		              	<i class="bx bx-right-arrow-alt"></i>
		            	<span class="menu-item">Apex</span>
		            </a>
                </li>
				<li >
		            <a href="chart-chartjs.html" >
		              	<i class="bx bx-right-arrow-alt"></i>
		            	<span class="menu-item">Chartjs</span>
		            </a>
                </li>
				<li >
		            <a href="chart-chartist.html" >
		              	<i class="bx bx-right-arrow-alt"></i>
		            	<span class="menu-item">Chartist</span>
		            </a>
                </li>
            </ul>
			</li>
		<li class="nav-item ">
			<a href="maps-google.html" >
				<i class="menu-livicon" data-icon="globe"></i>
				<span class="menu-title">Google Maps</span>
			</a>
		</li>
        <li class="navigation-header"><span>Extensions</span></li>
		<li class="nav-item ">
			<a href="ext-component-sweet-alerts.html" >
				<i class="menu-livicon" data-icon="warning-alt"></i>
				<span class="menu-title">Sweet Alert</span>
			</a>
		</li>
		<li class="nav-item ">
			<a href="ext-component-toastr.html" >
				<i class="menu-livicon" data-icon="morph-map"></i>
				<span class="menu-title">Toastr</span>
			</a>
		</li>
		<li class="nav-item ">
			<a href="ext-component-noui-slider.html" >
				<i class="menu-livicon" data-icon="settings"></i>
				<span class="menu-title">NoUi Slider</span>
			</a>
		</li>
		<li class="nav-item ">
			<a href="ext-component-drag-drop.html" >
				<i class="menu-livicon" data-icon="priority-high"></i>
				<span class="menu-title">Drag &amp; Drop</span>
			</a>
		</li>
		<li class="nav-item ">
			<a href="ext-component-tour.html" >
				<i class="menu-livicon" data-icon="paper-plane"></i>
				<span class="menu-title">Tour</span>
			</a>
		</li>
		<li class="nav-item ">
			<a href="ext-component-swiper.html" >
				<i class="menu-livicon" data-icon="morph-orientation-tablet"></i>
				 <span class="menu-title">Swiper</span>
				</a>
			</li>
		<li class="nav-item ">
			<a href="ext-component-treeview.html" >
				<i class="menu-livicon" data-icon="morph-sort-alt"></i>
				<span class="menu-title">Treeview</span>
			</a>
		</li>
		<li class="nav-item ">
			<a href="ext-component-block-ui.html" >
				<i class="menu-livicon" data-icon="expand"></i>
				<span class="menu-title">Block-UI</span>
			</a>
		</li>
		<li class="nav-item ">
			<a href="ext-component-media-player.html" >
				<i class="menu-livicon" data-icon="music"></i>
				<span class="menu-title">Media Player</span>
			</a>
		</li>
		<li class="nav-item ">
			<a href="ext-component-miscellaneous.html" >
				<i class="menu-livicon" data-icon="loader-10"></i>
				<span class="menu-title">Miscellaneous</span>
			</a>
		</li>
		<li class="nav-item ">
			<a href="ext-component-i18n.html" >
				<i class="menu-livicon" data-icon="globe"></i>
				<span class="menu-title">i18n</span>
			</a>
		</li>
        <li class="navigation-header"><span>Others</span></li>
		<li class="nav-item ">
			<a href="# " >
				<i class="menu-livicon" data-icon="morph-menu-arrow-bottom"></i>
				<span class="menu-title">Menu Levels</span>
			</a>
			<ul class="menu-content">
				<li >
		            <a href=" # " >
		              	<i class="bx bx-right-arrow-alt"></i>
		            	<span class="menu-item">Second Level</span>
		            </a>
                </li>
				<li >
		            <a href=" # " >
		              	<i class="bx bx-right-arrow-alt"></i>
		            	<span class="menu-item">Second Level</span>
		            </a>
                  	<ul class="menu-content">
                    	<li >
				            <a href=" # " >
				              	<i class="bx bx-right-arrow-alt"></i>
				            	<span class="menu-item">Third Level</span>
				            </a>
                  		</li>
             			 <li >
				            <a href=" # " >
				              	<i class="bx bx-right-arrow-alt"></i>
				            	<span class="menu-item">Third Level</span>
				            </a>
                      </li>
            		</ul>
				</li>
            </ul>
		</li>
		<li class="nav-item ">
			<a href="# " >
				<i class="menu-livicon" data-icon="morph-preview"></i>
				<span class="menu-title">Disabled Menu</span>
			</a>
		</li>
        <li class="navigation-header"><span>Support</span></li>
		<li class="nav-item ">
			<a href="../../../../external.html?link=https://pixinvent.com/demo/
			an-bootstrap-admin-dashboard-template/documentation" target=_blank>
				<i class=" menu-livicon" data-icon="morph-folder"></i>
				<span class="menu-title">Documentation</span>
          	</a>
        </li>
		<li class="nav-item ">
			<a href="../../../../external.html?link=https://pixinvent.ticksy.com/" target=_blank>
				<i class="menu-livicon" data-icon="help"></i>
				<span class="menu-title">Raise Support</span>
			</a>
		</li> --}}
    </ul>
</div>
</div>