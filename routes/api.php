<?php
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Api\Admin\DivisionController;
use App\Http\Controllers\Api\Admin\DistrictController;
use App\Http\Controllers\Api\Admin\UpozillaController;
use App\Http\Controllers\Api\Admin\UnionController;
use App\Http\Controllers\Api\DashboardController;
use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\Api\Admin\OrganizationTypeController;
use App\Http\Controllers\Api\Admin\EducationTypeController;
use App\Http\Controllers\Api\HelperController;
use App\Http\Controllers\Api\Organization\ParaController;
use App\Http\Controllers\Api\Organization\PeopleController;
use App\Http\Controllers\Api\Organization\ProjectController;
use App\Http\Controllers\Api\Organization\AccountController;
use App\Http\Controllers\Api\Organization\CommitteeDesignationController;
use App\Http\Controllers\Api\Organization\CommitteeController;
use App\Http\Controllers\Api\Organization\MemberTypeController;
use App\Http\Controllers\Api\Organization\MemberController;
use App\Http\Controllers\Api\Organization\CommitteeDetailsController;
use App\Http\Controllers\Api\Organization\DonationController;
use App\Http\Controllers\Api\Organization\EducationHistoryController;
use App\Http\Controllers\Api\Organization\MedicalHistoryController;
use App\Http\Controllers\Api\Organization\AchievementController;
use App\Http\Controllers\Api\Organization\IncomeTypeController;
use App\Http\Controllers\Api\Organization\ExpenseTypeController;
use App\Http\Controllers\Api\Organization\IncomeController;
use App\Http\Controllers\Api\Organization\ExpenseController;
use App\Http\Controllers\Api\Organization\InvestmentController;
use App\Http\Controllers\Api\Organization\CitizenCharterController;

Route::group([

    'middleware' => 'api',
    'prefix' => 'auth'

], function ($router) {

    Route::post('login', [AuthController::class, 'login']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('refresh', [AuthController::class, 'refresh']);
    Route::post('me', [AuthController::class, 'me']);


});
    Route::apiResource('/division', DivisionController::class);
    Route::apiResource('/district', DistrictController::class);
    Route::apiResource('/upozilla', UpozillaController::class);
    Route::apiResource('/union', UnionController::class);
    Route::apiResource('/organization-type', OrganizationTypeController::class);
    Route::apiResource('/education-type', EducationTypeController::class);


    Route::get('/loadDistrict/{id}', [HelperController::class, 'loadDistrict']);
    Route::get('/loadUpozilla/{id}', [HelperController::class, 'loadUpozilla']);
    Route::get('/user/{id}', [HelperController::class, 'user']);
    Route::get('/unionLoad/{id}', [HelperController::class, 'unionLoad']);
    Route::get('/village', [HelperController::class, 'village']);
    Route::get('/organization-type', [HelperController::class, 'organizationType']);
    Route::post('/organization/register', [HelperController::class, 'organizationRegister']);

    Route::apiResource('/para', ParaController::class);

    Route::apiResource('/project', ProjectController::class);
    Route::get('projects/active', [ProjectController::class,'activeProjects']);
    Route::apiResource('/donation', DonationController::class);


    Route::get('/admin/dashboard',[DashboardController::class, 'index']);
    Route::post('/profile/{id}',[ProfileController::class, 'profile']);
    Route::apiResource('/people', PeopleController::class);
    Route::apiResource('/education-history', EducationHistoryController::class);
    Route::apiResource('/medical-history', MedicalHistoryController::class);
    Route::apiResource('/achievement', AchievementController::class);
    Route::apiResource('/committee/designation', CommitteeDesignationController::class);
    Route::apiResource('/committee', CommitteeController::class);

    Route::apiResource('/member/type', MemberTypeController::class);
    Route::apiResource('/member', MemberController::class);
    Route::get('/committee-details/{id}', [CommitteeController::class,'showCommitteeDetails']);
    Route::post('/committee-member-store',[CommitteeController::class, 'storeCommitteeDetails']);
    Route::post('/committee-member-delete/{id}',[CommitteeController::class, 'deleteCommitteeDetails']);
    Route::get('/get-peoples/{id}',[PeopleController::class, 'getPeople']);
    Route::get('/peoples/list',[PeopleController::class, 'getPeoples']);
    Route::apiResource('/account', AccountController::class);

    Route::apiResource('/income-type', IncomeTypeController::class);
    Route::apiResource('/expense-type', ExpenseTypeController::class);
    Route::apiResource('/expense', ExpenseController::class);
    Route::apiResource('/investment', InvestmentController::class);
    Route::get('investments/active', [InvestmentController::class,'activeInvestments']);
    Route::apiResource('/income', IncomeController::class);

    Route::apiResource('/citizen-charter', CitizenCharterController::class);



