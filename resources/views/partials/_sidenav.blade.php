<!-- **********************************************************************************************************************************************************
      MAIN SIDEBAR MENU
      *********************************************************************************************************************************************************** -->
<!--sidebar start-->
<aside>
    <div id="sidebar"  class="nav-collapse ">
        <!-- sidebar menu start-->
        <ul class="sidebar-menu" id="nav-accordion">
            <div class="col-xs-12">
                <p class="pull-left m-l-20"><a href="#"><img src="{{ asset('assets/img/logo.png') }}" class="img-circle" width="60"></a></p>
                <p class="pull-right m-r-20"><a href="#"><img src="{{ asset('assets/img/logo-zip.png') }}" class="img-circle" width="60"></a></p>
            </div>
            <h5 class="centered">{{ Auth::user()->name }}</h5>

        @if(Auth::user()->hasRole('superadmin'))
            <li class="sub-menu">
                <a class="{{ Route::currentRouteNamed('show.employee.profiles') ? 'active' : '' }}" href="{{ route('show.employee.profiles') }}">
                    <i class="fa fa-users"></i>
                    <span>Employees' Profile</span>
                </a>
            </li>

            <li class="sub-menu">
                <a class="{{ Route::currentRouteNamed('show.timekeeping.leave') ? 'active' : '' }}{{ Route::currentRouteNamed('show.timekeeping.overtime') ? 'active' : '' }}{{ Route::currentRouteNamed('show.timekeeping.trip') ? 'active' : '' }}">
                    <i class="fa fa-clock-o"></i>
                    <span>Timekeeping</span>
                </a>
                <ul class="sub">
                    <li class="{{ Route::currentRouteNamed('show.timekeeping.leave') ? 'active' : '' }}"><a href="{{ route('show.timekeeping.leave') }}">Leave Request</a></li>
                    <li class="{{ Route::currentRouteNamed('show.timekeeping.overtime') ? 'active' : '' }}"><a href="{{ route('show.timekeeping.overtime') }}">Overtime Request</a></li>
                    <li class="{{ Route::currentRouteNamed('show.timekeeping.trip') ? 'active' : '' }}"><a href="{{ route('show.timekeeping.trip') }}">Official Business Trip</a></li>
                </ul>
            </li>

            <li class="sub-menu">
                <a class="{{ Route::currentRouteNamed('show.logs') ? 'active' : '' }}" href="{{ route('show.logs') }}"  >
                    <i class="fa fa-book"></i>
                    <span>Logs</span>
                </a>
            </li>

            <li class="sub-menu">
                <a class="{{ Route::currentRouteNamed('show.email-notification') ? 'active' : '' }}{{ Route::currentRouteNamed('show.role') ? 'active' : '' }}{{ (Route::currentRouteNamed('show.department')) ? 'active' : '' }}{{ Route::currentRouteNamed('show.position') ? 'active' : '' }}{{ Route::currentRouteNamed('show.branch') ? 'active' : '' }}" href="#" >
                    <i class="fa fa-gear"></i>
                    <span>Setting</span>
                </a>
                <ul class="sub">
                    <li class="{{ Route::currentRouteNamed('show.role') ? 'active' : '' }}"><a href="{{ route('show.role') }}">Role</a></li>
                    <li class="{{ Route::currentRouteNamed('show.branch') ? 'active' : '' }}"><a href="{{ route('show.branch') }}">Branch</a></li>
                    <li class="{{ Route::currentRouteNamed('show.department') ? 'active' : '' }}"><a href="{{ route('show.department') }}">Department</a></li>
                    <li class="{{ Route::currentRouteNamed('show.position') ? 'active' : '' }}"><a href="{{ route('show.position') }}">Position</a></li>
                </ul>
            </li>
        @endif
        @if(Auth::user()->hasRole('admin'))
            <li class="sub-menu">
                <a class="{{ Route::currentRouteNamed('show.employee.profiles') ? 'active' : '' }}" href="{{ route('show.employee.profiles') }}">
                    <i class="fa fa-users"></i>
                    <span>Employees' Profile</span>
                </a>
            </li>
            <li class="sub-menu">
                <a class="{{ Route::currentRouteNamed('admin.hr.leave') ? 'active' : '' }}{{ Route::currentRouteNamed('admin.hr.overtime') ? 'active' : '' }}{{ Route::currentRouteNamed('admin.hr.trip') ? 'active' : '' }}" href="#">
                    <i class="fa fa-clock-o"></i>
                    <span>HR</span>
                </a>
                <ul class="sub">
                    <li class="{{ Route::currentRouteNamed('admin.hr.leave') ? 'active' : '' }}"><a href="{{ route('admin.hr.leave') }}">Leave Request</a></li>
                    <li class="{{ Route::currentRouteNamed('admin.hr.overtime') ? 'active' : '' }}"><a href="{{ route('admin.hr.overtime') }}">Overtime Request</a></li>
                    <li class="{{ Route::currentRouteNamed('admin.hr.trip') ? 'active' : '' }}"><a href="{{ route('admin.hr.trip') }}">Official Business Trip</a></li>
                </ul>
            </li>
            <li class="sub-menu">
                <a class="{{ Route::currentRouteNamed('admin.supervisor.leave') ? 'active' : '' }}{{ Route::currentRouteNamed('admin.supervisor.overtime') ? 'active' : '' }}{{ Route::currentRouteNamed('admin.supervisor.trip') ? 'active' : '' }}" href="#">
                    <i class="fa fa-clock-o"></i>
                    <span>Supervisor</span><span class="badge pull-right m-r-10" id="sup-pending"></span>
                </a>
                <ul class="sub">
                    <li class="{{ Route::currentRouteNamed('admin.supervisor.leave') ? 'active' : '' }}"><a href="{{ route('admin.supervisor.leave') }}">Leave Request <span class="badge pull-right" style="margin-top: 7px; display: {{ \App\User::join('leaves', 'users.id', '=', 'leaves.user_id')->where('final_approval', 'Pending')->whereRoleIs('supervisor')->count() == 0 ? 'none' : 'block' }}">{{ \App\User::join('leaves', 'users.id', '=', 'leaves.user_id')->where('final_approval', 'Pending')->whereRoleIs('supervisor')->count() > 99 ? '99+' : \App\User::join('leaves', 'users.id', '=', 'leaves.user_id')->where('final_approval', 'Pending')->whereRoleIs('supervisor')->count() }}</span></a></li>
                    <li class="{{ Route::currentRouteNamed('admin.supervisor.overtime') ? 'active' : '' }}"><a href="{{ route('admin.supervisor.overtime') }}">Overtime Request</a></li>
                    <li class="{{ Route::currentRouteNamed('admin.supervisor.trip') ? 'active' : '' }}"><a href="{{ route('admin.supervisor.trip') }}">Official Business Trip</a></li>
                </ul>
            </li>
            <li class="sub-menu">
                <a class="{{ Route::currentRouteNamed('admin.employee.leave') ? 'active' : '' }}{{ Route::currentRouteNamed('admin.employee.overtime') ? 'active' : '' }}{{ Route::currentRouteNamed('admin.employee.trip') ? 'active' : '' }}" href="#">
                    <i class="fa fa-clock-o"></i>
                    <span>Employee</span>
                </a>
                <ul class="sub">
                    <li class="{{ Route::currentRouteNamed('admin.employee.leave') ? 'active' : '' }}"><a href="{{ route('admin.employee.leave') }}">Leave Request</a></li>
                    <li class="{{ Route::currentRouteNamed('admin.employee.overtime') ? 'active' : '' }}"><a href="{{ route('admin.employee.overtime') }}">Overtime Request</a></li>
                    <li class="{{ Route::currentRouteNamed('admin.employee.trip') ? 'active' : '' }}"><a href="{{ route('admin.employee.trip') }}">Official Business Trip</a></li>
                </ul>
            </li>
        @endif
        @if(Auth::user()->hasRole('hr'))
            <!--<li class="sub-menu">
                <a class="{{ Route::currentRouteNamed('show.my.profile') ? 'active' : '' }}" href="{{ route('show.my.profile') }}">
                    <i class="fa fa-user"></i>
                    <span>My Profile</span>
                </a>
            </li> -->
            <li class="sub-menu">
                <a class="{{ Route::currentRouteNamed('show.employee.profiles') ? 'active' : '' }}" href="{{ route('show.employee.profiles') }}">
                    <i class="fa fa-users"></i>
                    <span>Employees' Profile</span>
                </a>
            </li>
            <!--<li class="sub-menu">
                <a class="{{ Route::currentRouteNamed('show.my.leave') ? 'active' : '' }}{{ Route::currentRouteNamed('show.my.overtime') ? 'active' : '' }}{{ Route::currentRouteNamed('show.my.trip') ? 'active' : '' }}" href="#">
                    <i class="fa fa-clock-o"></i>
                    <span>Filing</span>
                </a>
                <ul class="sub">
                    <li class="{{ Route::currentRouteNamed('show.my.leave') ? 'active' : '' }}"><a href="{{ route('show.my.leave') }}">Leave Request</a></li>
                    <li class="{{ Route::currentRouteNamed('show.my.overtime') ? 'active' : '' }}"><a href="{{ route('show.my.overtime') }}">Overtime Request</a></li>
                    <li class="{{ Route::currentRouteNamed('show.my.trip') ? 'active' : '' }}"><a href="{{ route('show.my.trip') }}">Official Business Trip</a></li>
                </ul>
            </li> -->
            <li class="sub-menu">
                <a class="{{ Route::currentRouteNamed('hr.tl.leave.pending') ? 'active' : '' }}{{ Route::currentRouteNamed('hr.tl.leave.approved') ? 'active' : '' }}{{ Route::currentRouteNamed('hr.tl.leave.disapproved') ? 'active' : '' }}" href="#">
                    <i class="fa fa-paper-plane-o"></i>
                    <span>Supervisor Leave Requests</span>
                </a>
                <ul class="sub">
                    <li class="{{ Route::currentRouteNamed('hr.tl.leave.pending') ? 'active' : '' }}"><a href="{{ route('hr.tl.leave.pending') }}">Pending</a></li>
                    <li class="{{ Route::currentRouteNamed('hr.tl.leave.approved') ? 'active' : '' }}"><a href="{{ route('hr.tl.leave.approved') }}">Approved</a></li>
                    <li class="{{ Route::currentRouteNamed('hr.tl.leave.disapproved') ? 'active' : '' }}"><a href="{{ route('hr.tl.leave.disapproved') }}">Disapproved</a></li>
                </ul>
            </li>
            <li class="sub-menu">
                <a class="{{ Route::currentRouteNamed('hr.tl.ot.pending') ? 'active' : '' }}{{ Route::currentRouteNamed('hr.tl.ot.approved') ? 'active' : '' }}{{ Route::currentRouteNamed('hr.tl.ot.disapproved') ? 'active' : '' }}" href="#">
                    <i class="fa fa-clock-o"></i>
                    <span>Supervisor OT Requests</span>
                </a>
                <ul class="sub">
                    <li class="{{ Route::currentRouteNamed('hr.tl.ot.pending') ? 'active' : '' }}"><a href="{{ route('hr.tl.ot.pending') }}">Pending</a></li>
                    <li class="{{ Route::currentRouteNamed('hr.tl.ot.approved') ? 'active' : '' }}"><a href="{{ route('hr.tl.ot.approved') }}">Approved</a></li>
                    <li class="{{ Route::currentRouteNamed('hr.tl.ot.disapproved') ? 'active' : '' }}"><a href="{{ route('hr.tl.ot.disapproved') }}">Disapproved</a></li>
                </ul>
            </li>
            <li class="sub-menu">
                <a class="{{ Route::currentRouteNamed('hr.tl.trip.pending') ? 'active' : '' }}{{ Route::currentRouteNamed('hr.tl.trip.acknowledged') ? 'active' : '' }}" href="#">
                    <i class="fa fa-plane"></i>
                    <span>Supervisor OB Requests</span>
                </a>
                <ul class="sub">
                    <li class="{{ Route::currentRouteNamed('hr.tl.trip.pending') ? 'active' : '' }}"><a href="{{ route('hr.tl.trip.pending') }}">Pending</a></li>
                    <li class="{{ Route::currentRouteNamed('hr.tl.trip.acknowledged') ? 'active' : '' }}"><a href="{{ route('hr.tl.trip.acknowledged') }}">Acknowledged</a></li>
                </ul>
            </li>
            <li class="sub-menu">
                <a href="#" class="{{ Route::currentRouteNamed('hr.tl.notice.pending') ? 'active' : '' }}{{ Route::currentRouteNamed('hr.tl.notice.acknowledged') ? 'active' : '' }}">
                    <i class="fa fa-exclamation-circle"></i>
                    <span>Supervisor Notice Slip</span>
                </a>
                <ul class="sub">
                    <li class="{{ Route::currentRouteNamed('hr.tl.notice.pending') ? 'active' : '' }}"><a href="{{ route('hr.tl.notice.pending') }}">Pending</a></li>
                    <li class="{{ Route::currentRouteNamed('hr.tl.notice.acknowledged') ? 'active' : '' }}"><a href="{{ route('hr.tl.notice.acknowledged') }}">Acknowledged</a></li>
                </ul>
            </li>
            <li class="sub-menu">
                <a class="{{ Route::currentRouteNamed('hr.show.leave.pending') ? 'active' : '' }}{{ Route::currentRouteNamed('hr.show.leave.approved') ? 'active' : '' }}{{ Route::currentRouteNamed('hr.show.leave.disapproved') ? 'active' : '' }}" href="#">
                    <i class="fa fa-paper-plane-o"></i>
                    <span>Employee Leave Requests</span>
                </a>
                <ul class="sub">
                    <li class="{{ Route::currentRouteNamed('hr.show.leave.pending') ? 'active' : '' }}"><a href="{{ route('hr.show.leave.pending') }}">Pending</a></li>
                    <li class="{{ Route::currentRouteNamed('hr.show.leave.approved') ? 'active' : '' }}"><a href="{{ route('hr.show.leave.approved') }}">Approved</a></li>
                    <li class="{{ Route::currentRouteNamed('hr.show.leave.disapproved') ? 'active' : '' }}"><a href="{{ route('hr.show.leave.disapproved') }}">Disapproved</a></li>
                </ul>
            </li>
            <li class="sub-menu">
                <a class="{{ Route::currentRouteNamed('hr.show.ot.pending') ? 'active' : '' }}{{ Route::currentRouteNamed('hr.show.ot.approved') ? 'active' : '' }}{{ Route::currentRouteNamed('hr.show.ot.disapproved') ? 'active' : '' }}" href="#">
                    <i class="fa fa-clock-o"></i>
                    <span>Employee OT Requests</span>
                </a>
                <ul class="sub">
                    <li class="{{ Route::currentRouteNamed('hr.show.ot.pending') ? 'active' : '' }}"><a href="{{ route('hr.show.ot.pending') }}">Pending</a></li>
                    <li class="{{ Route::currentRouteNamed('hr.show.ot.approved') ? 'active' : '' }}"><a href="{{ route('hr.show.ot.approved') }}">Approved</a></li>
                    <li class="{{ Route::currentRouteNamed('hr.show.ot.disapproved') ? 'active' : '' }}"><a href="{{ route('hr.show.ot.disapproved') }}">Disapproved</a></li>
                </ul>
            </li>
            <li class="sub-menu">
                <a class="{{ Route::currentRouteNamed('hr.show.trip.pending') ? 'active' : '' }}{{ Route::currentRouteNamed('hr.show.trip.acknowledged') ? 'active' : '' }}" href="#">
                    <i class="fa fa-plane"></i>
                    <span>Employee OB Requests</span>
                </a>
                <ul class="sub">
                    <li class="{{ Route::currentRouteNamed('hr.show.trip.pending') ? 'active' : '' }}"><a href="{{ route('hr.show.trip.pending') }}">Pending</a></li>
                    <li class="{{ Route::currentRouteNamed('hr.show.trip.acknowledged') ? 'active' : '' }}"><a href="{{ route('hr.show.trip.acknowledged') }}">Acknowledged</a></li>
                </ul>
            </li>
            <li class="sub-menu">
                <a href="#" class="{{ Route::currentRouteNamed('hr.show.notice.pending') ? 'active' : '' }}{{ Route::currentRouteNamed('hr.show.notice.acknowledged') ? 'active' : '' }}">
                    <i class="fa fa-exclamation-circle"></i>
                    <span>Employee Notice Slip</span>
                </a>
                <ul class="sub">
                    <li class="{{ Route::currentRouteNamed('hr.show.notice.pending') ? 'active' : '' }}"><a href="{{ route('hr.show.notice.pending') }}">Pending</a></li>
                    <li class="{{ Route::currentRouteNamed('hr.show.notice.acknowledged') ? 'active' : '' }}"><a href="{{ route('hr.show.notice.acknowledged') }}">Acknowledged</a></li>
                </ul>
            </li>
        @endif
        @if(Auth::user()->hasRole('supervisor'))
            <li class="sub-menu">
                <a class="{{ Route::currentRouteNamed('show.my.profile') ? 'active' : '' }}" href="{{ route('show.my.profile') }}">
                    <i class="fa fa-user"></i>
                    <span>My Profile</span>
                </a>
            </li>
            <li class="sub-menu">
                <a class="{{ Route::currentRouteNamed('show.my.notice') ? 'active' : '' }}{{ Route::currentRouteNamed('show.my.leave') ? 'active' : '' }}{{ Route::currentRouteNamed('show.my.overtime') ? 'active' : '' }}{{ Route::currentRouteNamed('show.my.trip') ? 'active' : '' }}" href="#">
                    <i class="fa fa-clock-o"></i>
                    <span>Filing</span>
                </a>
                <ul class="sub">
                    <li class="{{ Route::currentRouteNamed('show.my.leave') ? 'active' : '' }}"><a href="{{ route('show.my.leave') }}">Leave Request</a></li>
                    <li class="{{ Route::currentRouteNamed('show.my.overtime') ? 'active' : '' }}"><a href="{{ route('show.my.overtime') }}">Overtime Request</a></li>
                    <li class="{{ Route::currentRouteNamed('show.my.trip') ? 'active' : '' }}"><a href="{{ route('show.my.trip') }}">Official Business Trip</a></li>
                    <li class="{{ Route::currentRouteNamed('show.my.notice') ? 'active' : '' }}"><a href="{{ route('show.my.notice') }}">Notice Slip</a></li>
                </ul>
            </li>
            <li class="sub-menu">
                <a class="{{ Route::currentRouteNamed('tl.show.leave.pending') ? 'active' : '' }}{{ Route::currentRouteNamed('tl.show.leave.approved') ? 'active' : '' }}{{ Route::currentRouteNamed('tl.show.leave.disapproved') ? 'active' : '' }}" href="#">
                    <i class="fa fa-clock-o"></i>
                    <span>Leave Requests </span><span class="badge pull-right" id="emp-leave-pending"></span>
                </a>
                <ul class="sub">
                    <li class="{{ Route::currentRouteNamed('tl.show.leave.pending') ? 'active' : '' }}"><a href="{{ route('tl.show.leave.pending') }}">Pending <span class="badge pull-right"></span></a></li>
                    <li class="{{ Route::currentRouteNamed('tl.show.leave.approved') ? 'active' : '' }}"><a href="{{ route('tl.show.leave.approved') }}">Approved</a></li>
                    <li class="{{ Route::currentRouteNamed('tl.show.leave.disapproved') ? 'active' : '' }}"><a href="{{ route('tl.show.leave.disapproved') }}">Disapproved</a></li>
                </ul>
            </li>
            <li class="sub-menu">
                <a class="{{ Route::currentRouteNamed('tl.show.ot.pending') ? 'active' : '' }}{{ Route::currentRouteNamed('tl.show.ot.approved') ? 'active' : '' }}{{ Route::currentRouteNamed('tl.show.ot.disapproved') ? 'active' : '' }}" href="#">
                    <i class="fa fa-clock-o"></i>
                    <span>OT Requests</span><span class="badge pull-right" id="emp-ot-pending"></span>
                </a>
                <ul class="sub">
                    <li class="{{ Route::currentRouteNamed('tl.show.ot.pending') ? 'active' : '' }}"><a href="{{ route('tl.show.ot.pending') }}">Pending</a></li>
                    <li class="{{ Route::currentRouteNamed('tl.show.ot.approved') ? 'active' : '' }}"><a href="{{ route('tl.show.ot.approved') }}">Approved</a></li>
                    <li class="{{ Route::currentRouteNamed('tl.show.ot.disapproved') ? 'active' : '' }}"><a href="{{ route('tl.show.ot.disapproved') }}">Disapproved</a></li>
                </ul>
            </li>
            <li class="sub-menu">
                <a class="{{ Route::currentRouteNamed('show.my.da') ? 'active' : '' }}" href="{{ route('show.my.da') }}">
                    <i class="fa fa-exclamation-circle"></i>
                    <span>Disciplinary Records</span>
                </a>
            </li>

            <li class="sub-menu">
                <a class="#" href="#">
                    <i class="fa fa-book"></i>
                    <span>Training and Development</span>
                </a>
            </li>
        @endif
        @if(Auth::user()->hasRole('accounting'))
            <li class="sub-menu">
                <a class="{{ Route::currentRouteNamed('accnt.sup.ot.pending') ? 'active' : '' }}{{ Route::currentRouteNamed('accnt.sup.ot.approved') ? 'active' : '' }}{{ Route::currentRouteNamed('accnt.sup.ot.disapproved') ? 'active' : '' }}" href="#">
                    <i class="fa fa-user"></i>
                    <span>Supervisor Overtime</span>
                </a>
                <ul class="sub">
                    <li class="{{ Route::currentRouteNamed('accnt.sup.ot.pending') ? 'active' : '' }}"><a href="{{ route('accnt.sup.ot.pending') }}">Pending</a></li>
                    <li class="{{ Route::currentRouteNamed('accnt.sup.ot.approved') ? 'active' : '' }}"><a href="{{ route('accnt.sup.ot.approved') }}">Approved</a></li>
                    <li class="{{ Route::currentRouteNamed('accnt.sup.ot.disapproved') ? 'active' : '' }}"><a href="{{ route('accnt.sup.ot.disapproved') }}">Disapproved</a></li>
                </ul>
            </li>
            <li class="sub-menu">
                <a class="{{ Route::currentRouteNamed('accnt.emp.ot.pending') ? 'active' : '' }}{{ Route::currentRouteNamed('accnt.emp.ot.approved') ? 'active' : '' }}{{ Route::currentRouteNamed('accnt.emp.ot.disapproved') ? 'active' : '' }}" href="#">
                    <i class="fa fa-user"></i>
                    <span>Employee Overtime</span>
                </a>
                <ul class="sub">
                    <li class="{{ Route::currentRouteNamed('accnt.emp.ot.pending') ? 'active' : '' }}"><a href="{{ route('accnt.emp.ot.pending') }}">Pending</a></li>
                    <li class="{{ Route::currentRouteNamed('accnt.emp.ot.approved') ? 'active' : '' }}"><a href="{{ route('accnt.emp.ot.approved') }}">Approved</a></li>
                    <li class="{{ Route::currentRouteNamed('accnt.emp.ot.disapproved') ? 'active' : '' }}"><a href="{{ route('accnt.emp.ot.disapproved') }}">Disapproved</a></li>
                </ul>
            </li>
        @endif
        @if(Auth::user()->hasRole('user'))
            <li class="sub-menu">
                <a class="{{ Route::currentRouteNamed('show.my.profile') ? 'active' : '' }}" href="{{ route('show.my.profile') }}">
                    <i class="fa fa-user"></i>
                    <span>My Profile</span>
                </a>
            </li>
            <li class="sub-menu">
                <a class="{{ Route::currentRouteNamed('show.my.leave') ? 'active' : '' }}{{ Route::currentRouteNamed('show.my.overtime') ? 'active' : '' }}{{ Route::currentRouteNamed('show.my.trip') ? 'active' : '' }}" href="#">
                    <i class="fa fa-clock-o"></i>
                    <span>Filing</span>
                </a>
                <ul class="sub">
                    <li class="{{ Route::currentRouteNamed('show.my.leave') ? 'active' : '' }}"><a href="{{ route('show.my.leave') }}">Leave Request</a></li>
                    <li class="{{ Route::currentRouteNamed('show.my.overtime') ? 'active' : '' }}"><a href="{{ route('show.my.overtime') }}">Overtime Request</a></li>
                    <li class="{{ Route::currentRouteNamed('show.my.trip') ? 'active' : '' }}"><a href="{{ route('show.my.trip') }}">Official Business Trip</a></li>
                    <li class="{{ Route::currentRouteNamed('show.my.notice') ? 'active' : '' }}"><a href="{{ route('show.my.notice') }}">Notice Slip</a></li>
                </ul>
            </li>

            <li class="sub-menu">
                <a class="{{ Route::currentRouteNamed('show.my.da') ? 'active' : '' }}" href="{{ route('show.my.da') }}">
                    <i class="fa fa-exclamation-circle"></i>
                    <span>Disciplinary Records</span>
                </a>
            </li>

            <li class="sub-menu">
                <a class="{{ Route::currentRouteNamed('show.my.td') ? 'active' : '' }}" href="{{ route('show.my.td') }}">
                    <i class="fa fa-book"></i>
                    <span>Training and Development</span>
                </a>
            </li>
        @endif
        </ul>
        <!-- sidebar menu end-->
    </div>
</aside>
<!--sidebar end-->
