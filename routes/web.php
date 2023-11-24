<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Artisan;

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\UsersController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\GeneralSettingsController;
use App\Http\Controllers\Admin\LogController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\MediaUploadController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\RoomController;
use App\Http\Controllers\Admin\CourseController;
use App\Http\Controllers\Admin\ProfessorController;
use App\Http\Controllers\Admin\TimeSlotController;
use App\Http\Controllers\Admin\ClassController;
use App\Http\Controllers\Admin\TimetableController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/clear', function () {
    Artisan::call('config:clear');
    Artisan::call('cache:clear');
    Artisan::call('config:cache');
    Artisan::call('view:clear');
    dd("cache cleared");
});


Route::get('/', function () {
    return redirect(route('login'));
});

Auth::routes();

Route::group([
    'middleware'    => ['auth'],
    'prefix'        => 'admin',
], function () {
    Route::get('/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');

    //Users Controller
    Route::resource('users', UsersController::class);
    Route::post('get-users',  [UsersController::class, 'getUsers'])->name('admin.getUsers');
    Route::post('get-user', [UsersController::class, 'userDetail'])->name('admin.getUser');
    Route::get('users/delete/{id}',  [UsersController::class, 'destroy'])->name('user-delete');
    Route::post('delete-selected-users',  [UsersController::class, 'DeleteSelectedUsers'])->name('delete-selected-users');
    Route::get('edit-profile/{id}',  [UsersController::class, 'show'])->name('edit-profile');
    Route::get('/profile-setting', [UsersController::class, 'profileSetting'])->name('user.profile');
    Route::post('/profile-setting', [UsersController::class, 'updateProfile'])->name('user.profile');

    //Rooms Controller
    Route::resource('rooms', RoomController::class);
    Route::post('get-rooms',  [RoomController::class, 'getRooms'])->name('admin.getRooms');
    Route::post('get-room', [RoomController::class, 'roomDetail'])->name('admin.getRoom');
    Route::get('rooms/delete/{id}',  [RoomController::class, 'destroy'])->name('room-delete');
    Route::post('delete-selected-rooms',  [RoomController::class, 'DeleteSelectedRooms'])->name('delete-selected-rooms');

    //Courses Controller
    Route::resource('courses', CourseController::class);
    Route::post('get-courses',  [CourseController::class, 'getCourses'])->name('admin.getCourses');
    Route::post('get-course', [CourseController::class, 'courseDetail'])->name('admin.getCourse');
    Route::get('courses/delete/{id}',  [CourseController::class, 'destroy'])->name('course-delete');
    Route::post('delete-selected-courses',  [CourseController::class, 'DeleteSelectedCourses'])->name('delete-selected-courses');

    //Professors Controller
    Route::resource('professors', ProfessorController::class);
    Route::post('get-professors',  [ProfessorController::class, 'getProfessors'])->name('admin.getProfessors');
    Route::post('get-professor', [ProfessorController::class, 'professorDetail'])->name('admin.getProfessor');
    Route::get('professors/delete/{id}',  [ProfessorController::class, 'destroy'])->name('professor-delete');
    Route::post('delete-selected-professors',  [ProfessorController::class, 'DeleteSelectedProfessors'])->name('delete-selected-professors');

    //Timeslots Controller
    Route::resource('time-slots', TimeSlotController::class);
    Route::post('get-time-slots',  [TimeSlotController::class, 'getTimeSlots'])->name('admin.getTimeslots');
    Route::post('get-time-slot', [TimeSlotController::class, 'timeSlotDetail'])->name('admin.getTimeslot');
    Route::get('time-slots/delete/{id}',  [TimeSlotController::class, 'destroy'])->name('time-slot-delete');
    Route::post('delete-selected-time-slots',  [TimeSlotController::class, 'DeleteSelectedTimeSlots'])->name('delete-selected-time-slots');

    //Classes Controller
    Route::resource('classes', ClassController::class);
    Route::post('get-classes',  [ClassController::class, 'getTimeSlots'])->name('admin.getClasses');
    Route::post('get-class', [ClassController::class, 'timeSlotDetail'])->name('admin.getClass');
    Route::get('class/delete/{id}',  [ClassController::class, 'destroy'])->name('class-delete');
    Route::post('delete-selected-classes',  [ClassController::class, 'DeleteSelectedClasses'])->name('delete-selected-classes');

     //Timetable Controller
     Route::resource('timetables', TimetableController::class);
     Route::post('get-timetables',  [TimetableController::class, 'getTimetable'])->name('admin.getTimetables');
     Route::post('get-timetable', [TimetableController::class, 'timetableDetail'])->name('admin.getTimetable');
     Route::get('timetables/delete/{id}',  [TimetableController::class, 'destroy'])->name('timetable-delete');
     Route::post('delete-selected-timetables',  [TimetableController::class, 'DeleteSelectedTimeTables'])->name('delete-selected-timetables');
     Route::get('timetables/view/{id}', [TimetableController::class, 'view'])->name('timetables.view');

    //Roles Controller
    Route::resource('roles', RoleController::class);
    Route::post('get-roles',  [RoleController::class, 'getRoles'])->name('admin.getRoles');
    Route::post('get-role', [RoleController::class, 'roleDetail'])->name('admin.getRole');
    Route::get('roles/delete/{id}',  [RoleController::class, 'destroy'])->name('role-delete');
    Route::post('delete-selected-roles',  [RoleController::class, 'DeleteSelectedRoles'])->name('delete-selected-roles');

    //Permission Controller
    Route::resource('permissions', PermissionController::class);
    Route::post('get-permissions',  [PermissionController::class, 'getPermissions'])->name('admin.getPermissions');
    Route::post('get-permission', [PermissionController::class, 'permissionDetail'])->name('admin.getPermission');
    Route::get('permissions/delete/{id}',  [PermissionController::class, 'destroy'])->name('permission-delete');
    Route::post('delete-selected-permissions',  [PermissionController::class, 'DeleteSelectedPermissions'])->name('delete-selected-permissions');

    //Logs Controller
    Route::resource('logs', LogController::class);
    Route::post('get-log', [LogController::class, 'logDetail'])->name('admin.getLog');
    Route::get('log/delete/{id}',  [LogController::class, 'destroy'])->name('log-delete');
    Route::post('delete-selected-logs',  [LogController::class, 'DeleteSelectedLogs'])->name('delete-selected-logs');

    //general settings
    Route::get('/general-settings/site-identity', [GeneralSettingsController::class, 'site_identity'])->name('admin.general.site.identity');
    Route::post('/general-settings/site-identity', [GeneralSettingsController::class, 'update_site_identity']);

    Route::get('/general-settings/basic-settings', [GeneralSettingsController::class, 'basic_settings'])->name('admin.general.basic.settings');
    Route::post('/general-settings/basic-settings', [GeneralSettingsController::class, 'update_basic_settings']);
    //smtp settings
    Route::get('/general-settings/smtp-settings', [GeneralSettingsController::class, 'smtp_settings'])->name('admin.general.smtp.settings');
    Route::post('/general-settings/smtp-settings', [GeneralSettingsController::class, 'update_smtp_settings']);

    /* media upload routes */
    Route::post('/media-upload/all', [MediaUploadController::class, 'all_upload_media_file'])->name('admin.upload.media.file.all');
    Route::post('/media-upload', [MediaUploadController::class, 'upload_media_file'])->name('admin.upload.media.file');
    Route::post('/media-upload/delete', [MediaUploadController::class, 'delete_upload_media_file'])->name('admin.upload.media.file.delete');

});
