<?php

Route::get('/', 'Auth\LoginController@showLoginForm')->name('show.login');

Route::get('/register', 'Auth\RegisterController@showRegistrationForm')->name('show.register');
Route::post('/register', 'Auth\RegisterController@register')->name('register');

Route::get('/logout', 'Auth\LoginController@logout')->name('logout');
Route::post('/login', 'Auth\LoginController@login')->name('login');

Route::view('/welcome', 'pages.welcome')->name('home');

Route::prefix('/employee')->group(function() {
    Route::view('/profiles', 'pages.employee.employee-profile')->name('show.employee.profiles');
});

Route::prefix('/my')->group(function() {
    Route::view('/profile', 'pages.employee.my-profile')->name('show.my.profile');

    Route::view('/da', 'pages.disciplinary.da-records')->name('show.my.da');
    Route::view('/td', 'pages.training.training-dev')->name('show.my.td');

    Route::view('/filing/leave', 'pages.e-filing.leave-request')->name('show.my.leave');
    Route::view('/filing/overtime', 'pages.e-filing.overtime-request')->name('show.my.overtime');
    Route::view('/filing/trip', 'pages.e-filing.trip-request')->name('show.my.trip');


});

Route::prefix('/acl')->group(function() {
    Route::view('/userControlManagement', 'pages.acl.user-control-management')->name('show.acl');
});

Route::prefix('/setting')->group(function() {
    Route::view('/role', 'pages.settings.role')->name('show.role');
    Route::view('/department', 'pages.settings.department')->name('show.department');
    Route::view('/position', 'pages.settings.position')->name('show.position');
    Route::view('/branch', 'pages.settings.branch')->name('show.branch');
});

Route::prefix('/superadmin')->group(function() {
   Route::view('/timekeeping/leave', 'pages.superadmin.Timekeeping.leave')->name('show.timekeeping.leave');
   Route::view('/timekeeping/overtime', 'pages.superadmin.Timekeeping.overtime')->name('show.timekeeping.overtime');
   Route::view('/timekeeping/trip', 'pages.superadmin.Timekeeping.ob')->name('show.timekeeping.trip');

   Route::view('/logs', 'pages.superadmin.logs.logs')->name('show.logs');
});

Route::prefix('/admin')->group(function() {
    Route::view('/hr/leave', 'pages.admin.hr.leave')->name('admin.hr.leave');
    Route::view('/hr/overtime', 'pages.admin.hr.overtime')->name('admin.hr.overtime');
    Route::view('/hr/trip', 'pages.admin.hr.trip')->name('admin.hr.trip');

    Route::view('/supervisor/leave', 'pages.admin.supervisor.leave')->name('admin.supervisor.leave');
    Route::view('/supervisor/overtime', 'pages.admin.supervisor.overtime')->name('admin.supervisor.overtime');
    Route::view('/supervisor/trip', 'pages.admin.supervisor.trip')->name('admin.supervisor.trip');

    Route::view('/employee/leave', 'pages.admin.employee.leave')->name('admin.employee.leave');
    Route::view('/employee/overtime', 'pages.admin.employee.overtime')->name('admin.employee.overtime');
    Route::view('/employee/trip', 'pages.admin.employee.trip')->name('admin.employee.trip');
});

Route::prefix('/tl')->group(function() {
    Route::view('/leave/pending', 'pages.tl-leave-requests.leave-pending')->name('tl.show.leave.pending');
    Route::view('/leave/approved', 'pages.tl-leave-requests.leave-approved')->name('tl.show.leave.approved');
    Route::view('/leave/disapproved', 'pages.tl-leave-requests.leave-disapproved')->name('tl.show.leave.disapproved');

    Route::view('/ot/pending', 'pages.tl-ot-requests.ot-pending')->name('tl.show.ot.pending');
    Route::view('/ot/approved', 'pages.tl-ot-requests.ot-approved')->name('tl.show.ot.approved');
    Route::view('/ot/disapproved', 'pages.tl-ot-requests.ot-disapproved')->name('tl.show.ot.disapproved');
});

Route::prefix('/hr')->group(function() {
    Route::view('/tl/leave/pending', 'pages.hr.sup-leave.pending')->name('hr.tl.leave.pending');
    Route::view('/tl/leave/approved', 'pages.hr.sup-leave.approved')->name('hr.tl.leave.approved');
    Route::view('/tl/leave/disapproved', 'pages.hr.sup-leave.disapproved')->name('hr.tl.leave.disapproved');

    Route::view('/tl/ot/pending', 'pages.hr.sup-overtime.pending')->name('hr.tl.ot.pending');
    Route::view('/tl/ot/approved', 'pages.hr.sup-overtime.approved')->name('hr.tl.ot.approved');
    Route::view('/tl/ot/disapproved', 'pages.hr.sup-overtime.disapproved')->name('hr.tl.ot.disapproved');

    Route::view('/tl/ob/pending', 'pages.hr.sup-trip.pending')->name('hr.tl.trip.pending');
    Route::view('/tl/ob/acknowledged', 'pages.hr.sup-trip.acknowledged')->name('hr.tl.trip.acknowledged');

    Route::view('/leave/pending', 'pages.hr.leave.pending')->name('hr.show.leave.pending');
    Route::view('/leave/approved', 'pages.hr.leave.approved')->name('hr.show.leave.approved');
    Route::view('/leave/disapproved', 'pages.hr.leave.disapproved')->name('hr.show.leave.disapproved');

    Route::view('/ot/pending', 'pages.hr.overtime.pending')->name('hr.show.ot.pending');
    Route::view('/ot/approved', 'pages.hr.overtime.approved')->name('hr.show.ot.approved');
    Route::view('/ot/disapproved', 'pages.hr.overtime.disapproved')->name('hr.show.ot.disapproved');

    Route::view('/trip/pending', 'pages.hr.trip.pending')->name('hr.show.trip.pending');
    Route::view('/trip/acknowledged', 'pages.hr.trip.acknowledge')->name('hr.show.trip.acknowledged');
});

Route::get('/branchLoad', 'BranchController@loadBranch')->name('load.branch');
Route::post('/branchStore', 'BranchController@storeBranch')->name('store.branch');
Route::get('/branchEdit/{id}', 'BranchController@editBranch')->name('edit.branch');
Route::post('/branchUpdate/{id}', 'BranchController@updateBranch')->name('update.branch');
Route::post('/branchDelete/{id}', 'BranchController@deleteBranch')->name('delete.branch');

Route::get('/departmentLoad', 'DepartmentController@loadDepartment')->name('load.department');
Route::post('/departmentStore', 'DepartmentController@storeDepartment')->name('store.department');
Route::get('/departmentEdit/{id}', 'DepartmentController@editDepartment')->name('edit.department');
Route::post('/departmentUpdate/{id}', 'DepartmentController@updateDepartment')->name('update.department');
Route::post('/departmentDelete/{id}', 'DepartmentController@deleteDepartment')->name('delete.department');

Route::get('/positionLoad', 'PositionController@loadPosition')->name('load.position');
Route::post('/positionStore', 'PositionController@storePosition')->name('store.position');
Route::get('/positionEdit/{id}', 'PositionController@editPosition')->name('edit.position');
Route::post('/positionUpdate/{id}', 'PositionController@updatePosition')->name('update.position');
Route::post('/positionDelete/{id}', 'PositionController@deletePosition')->name('delete.position');

Route::get('/leaveLoad', 'LeaveController@loadLeave')->name('load.leave');
Route::post('/leaveStore', 'LeaveController@storeLeave')->name('store.leave');
Route::get('/leaveEdit/{id}', 'LeaveController@editLeave')->name('edit.leave');
Route::post('/leaveUpdate/{id}', 'LeaveController@updateLeave')->name('update.leave');
Route::post('/leaveDelete/{id}', 'LeaveController@deleteLeave')->name('delete.leave');

Route::get('/overtimeLoad', 'OvertimeController@loadOvertime')->name('load.overtime');
Route::post('/overtimeStore', 'OvertimeController@storeOvertime')->name('store.overtime');
Route::get('/overtimeEdit/{id}', 'OvertimeController@editOvertime')->name('edit.overtime');
Route::post('/overtimeUpdate/{id}', 'OvertimeController@updateOvertime')->name('update.overtime');
Route::post('/overtimeDelete/{id}', 'OvertimeController@deleteOvertime')->name('delete.overtime');

Route::get('/tripLoad', 'TripController@loadTrip')->name('load.trip');
Route::post('/tripStore', 'TripController@storeTrip')->name('store.trip');
Route::get('/tripEdit/{id}', 'TripController@editTrip')->name('edit.trip');
Route::post('/tripUpdate/{id}', 'TripController@updateTrip')->name('update.trip');
Route::post('/tripDelete/{id}', 'TripController@deleteTrip')->name('delete.trip');

Route::get('/employeeLoad', 'EmployeeController@loadEmployee')->name('load.employee');
Route::get('/employeeShow/{id}', 'EmployeeController@showEmployee')->name('show.employee');
Route::post('/reset/password/{id}', 'EmployeeController@resetPassword')->name('reset.password');
Route::post('/upload/photo', 'EmployeeController@uploadPhoto')->name('upload.photo');
Route::post('/update/employeeNo/{id}', 'EmployeeController@updateEmpNumber')->name('update.empNumber');
Route::post('/update/fullName/{id}', 'EmployeeController@updateFullName')->name('update.fullname');
Route::post('/update/birthdate/{id}', 'EmployeeController@updateBirthdate')->name('update.birthdate');
Route::post('/update/department/{id}', 'EmployeeController@updateDepartment')->name('update.department');
Route::post('/update/branch/{id}', 'EmployeeController@updateBranch')->name('update.branch');
Route::post('/update/status/{id}', 'EmployeeController@updateStatus')->name('update.status');
Route::post('/update/contact1/{id}', 'EmployeeController@updateContact1')->name('update.contact1');
Route::post('/update/contact2/{id}', 'EmployeeController@updateContact2')->name('update.contact2');
Route::post('/update/datehired/{id}', 'EmployeeController@updateDatehired')->name('update.datehired');
Route::post('/update/preAddress/{id}', 'EmployeeController@updatePreAddress')->name('update.preAddress');
Route::post('/update/permAddress/{id}', 'EmployeeController@updatePerAddress')->name('update.permAddress');
Route::post('/update/skype/{id}', 'EmployeeController@updateSkype')->name('update.skype');
Route::post('/update/email/{id}', 'EmployeeController@updateEmail')->name('update.email');
Route::post('/update/tin/{id}', 'EmployeeController@updateTIN')->name('update.tin');
Route::post('/update/sss/{id}', 'EmployeeController@updateSSS')->name('update.sss');
Route::post('/update/hdmf/{id}', 'EmployeeController@updateHDMF')->name('update.hdmf');
Route::post('/update/phic/{id}', 'EmployeeController@updatePHIC')->name('update.phic');

#Single User
Route::get('/employeeProfile', 'EmployeeController@showEmployeeProfile')->name('show.profile');

Route::get('/superadmin/leave', 'SuperadminController@loadLeaves')->name('show.all.leave');
Route::get('/superadmin/leave/single/{id}', 'SuperadminController@loadSingleLeave')->name('show.single.leave');
Route::get('/superadmin/overtime', 'SuperadminController@loadOvertimes')->name('show.all.ot');
Route::get('/superadmin/overtime/single/{id}', 'SuperadminController@loadSingleOvertime')->name('show.single.ot');
Route::get('/superadmin/trip', 'SuperadminController@loadTrips')->name('show.all.trip');
Route::get('/superadmin/trip/single/{id}', 'SuperadminController@loadSingleTrip')->name('show.single.trip');
Route::get('/superadmin/load/logs', 'SuperadminController@loadActivityLogs')->name('show.activity.logs');
Route::post('/superadmin/delete/log/{id}', 'SuperadminController@deleteLog')->name('delete.log');

Route::get('/admin/leaveRequests/{role}/{status}', 'AdminController@loadLeaveRequests')->name('admin.load.leave');
Route::get('/admin/leaveRequest/view/{id}', 'AdminController@viewLeaveRequest')->name('admin.view.leave');
Route::post('/admin/leaveRequest/approved/{id}', 'AdminController@leaveRequestApproved')->name('admin.leave.approved');
Route::post('/admin/leaveRequest/disapproved/{id}', 'AdminController@leaveRequestDisapproved')->name('admin.leave.disapproved');

Route::get('/admin/otRequests/{role}/{status}', 'AdminController@loadOvertimeRequests')->name('admin.load.overtime');
Route::get('/admin/otRequest/view/{id}', 'AdminController@viewOvertimeRequest')->name('admin.view.overtime');

Route::get('/admin/tripRequests/{role}/{status?}', 'AdminController@loadTripRequests')->name('admin.load.trip');
Route::get('/admin/tripRequest/view/{id}', 'AdminController@viewTripRequest')->name('admin.view.trip');

Route::post('/tl/assign', 'SupervisorController@assignSupervisor')->name('tl.assign');

Route::get('/tl/leaveRequests/{status}', 'SupervisorController@loadLeaveRequests')->name('tl.leave.requests.load');
Route::get('/tl/leaveRequests/view/{id}', 'SupervisorController@viewLeaveRequests')->name('tl.leave.requests.view');
Route::post('/tl/leaveRequests/approved/{id}', 'SupervisorController@LeaveRequestApproved')->name('tl.leave.requests.approved');
Route::post('/tl/leaveRequests/disapproved/{id}', 'SupervisorController@LeaveRequestDisapproved')->name('tl.leave.requests.disapproved');

Route::get('/tl/otRequests/{status}', 'SupervisorController@loadOTRequests')->name('tl.ot.requests.load');
Route::get('/tl/otRequests/view/{id}', 'SupervisorController@viewOTRequests')->name('tl.ot.requests.view');
Route::post('/tl/otRequests/approved/{id}', 'SupervisorController@OTRequestApproved')->name('tl.ot.requests.approved');
Route::post('/tl/otRequests/disapproved/{id}', 'SupervisorController@OTRequestDisapproved')->name('tl.ot.requests.disapproved');

Route::get('/hr/leaveRequests/{status}/{role}', 'HRController@loadLeaveRequests')->name('hr.leave.requests.load');
Route::get('/hr/leaveRequest/view/{id}', 'HRController@viewLeaveRequests')->name('hr.leave.requests.view');
Route::post('/hr/leaveRequests/approved/{id}', 'HRController@FinalLeaveApproved')->name('hr.leave.requests.approved');
Route::post('/hr/leaveRequests/disapproved/{id}', 'HRController@FinalLeaveDisapproved')->name('hr.leave.requests.disapproved');

Route::get('/hr/otRequests/{status}/{role}', 'HRController@loadOTRequests')->name('hr.ot.requests.load');
Route::get('/hr/otRequest/view/{id}', 'HRController@viewOTRequests')->name('hr.ot.requests.view');
Route::post('/hr/otRequest/approved/{id}', 'HRController@overtimeRequestApproved')->name('hr.ot.request.approved');
Route::post('/hr/otRequest/disapproved/{id}', 'HRController@overtimeRequestDisapproved')->name('hr.ot.request.disapproved');

Route::get('/hr/tripRequests/{status}/{role}', 'HRController@loadTripRequests')->name('hr.trip.requests.load');
Route::get('/hr/tripRequests/view/{id}', 'HRController@viewTripRequests')->name('hr.trip.requests.view');
Route::post('/hr/tripRequests/acknowledged/{id}', 'HRController@TripRequestsAcknowledged')->name('hr.trip.requests.acknowledged');

Route::get('/accessLoad', 'AccessController@loadAccessControl')->name('load.access');
Route::post('/accessAssign/{id}', 'AccessController@assignAccess')->name('assign.access');

Route::get('/roleLoad', 'RoleController@loadRoles')->name('load.roles');
Route::post('/roleStore', 'RoleController@storeRole')->name('store.role');
Route::get('/roleEdit/{id}', 'RoleController@editRole')->name('edit.role');
Route::post('/roleUpdate/{id}', 'RoleController@updateRole')->name('update.role');
Route::post('/roleDelete/{id}', 'RoleController@deleteRole')->name('delete.role');

Route::get('/helper/department', 'HelperController@comboDepartment')->name('helper.department');
Route::get('/helper/position/{id}', 'HelperController@comboPosition')->name('helper.position');
Route::get('/helper/branch', 'HelperController@comboBranch')->name('helper.branch');
Route::get('/helper/role', 'HelperController@comboRole')->name('helper.role');
Route::get('/helper/sup', 'HelperController@comboSupervisor')->name('helper.supervisor');

Route::get('/filter/otRequest/{role}/{start}/{end}/{status}/{branch}', 'FilterController@filterOTRequests')->name('filter.ot.requests');

Route::get('/test', function() {
    $user = \App\User::join('employees', 'employees.user_id', '=', 'users.id')
        ->where('users.id', \Illuminate\Support\Facades\Auth::user()->id)
        ->first();

    $leaves = \App\User::join('employees', 'employees.user_id', '=', 'users.id')
        ->join('leaves', 'leaves.user_id', '=', 'users.id')
        ->join('positions', 'positions.id', '=', 'employees.position_id')
        ->join('departments', 'departments.id', '=', 'employees.department_id')
        ->join('branches', 'branches.id', '=', 'employees.branch_id')
        ->select(['employees.full_name as employee', 'positions.name as position', 'departments.name as department', 'branches.name as branch', 'leaves.*'])
        ->where('departments.id', $user->department_id)
        ->where('leaves.recommending_approval', 'Approved')
        ->whereRoleIs('user')
        ->get();

    return $leaves;
});