<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php')) {
	require SYSTEMPATH . 'Config/Routes.php';
}

/**
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(true);

//------------------------------------register & Login----------------------------------------------

$routes->post('/Verifyregiste', 'UserController/Register/Verifyregiste::Verifyregistre');
$routes->put('/Verifyregiste/(:any)', 'UserController\Register\Verifyregiste::Resetotp/$1');
$routes->get('/selectmajor', 'UserController/Register/Studentregiste::Selectmajor');
$routes->post('/studentregistre', 'UserController/Register/Studentregiste::Register');
$routes->post('/employerregistre', 'UserController/Register/Employerregistre::Register');
$routes->post('/login_user', 'UserController/LoginController::Login');

//-------------------------------------Work--------------------------------------------------------

$routes->post('/postwork', 'WorkController/Postwork::Postwork');
$routes->get('/show_work', 'WorkController/ShowWork::ShowAllWork');
$routes->get('/PIC/(:any)', 'WorkController\ShowWork::showPIC/$1');
$routes->get('/show_workCount', 'WorkController/ShowWork::ShowWorkCount');
$routes->get('/detailpost/(:any)', 'WorkController\ShowWork::getDetailPost/$1');
$routes->post('/search', 'WorkController/SearchPost::searchWork');
$routes->get('/show_comment/(:any)','WorkController\Showcom::showcomment/$1');

//------------------------------------Admin-------------------------------------------

$routes->get('/showpostnotpass', 'AdminController/ManageWork/ManagePost::ShowPostNotpass');
$routes->get('/showpostwait', 'AdminController/ManageWork/ManagePost::ShowWait');
$routes->get('/showpostpass', 'AdminController/ManageWork/ManagePost::ShowPostPass');
$routes->put('/managepost/(:any)', 'AdminController\ManageWork\ManagePost::ManagePost/$1');
$routes->get('/Checkpostbyid/(:any)', 'AdminController\ManageWork\ManagePost::Checkpost/$1');
$routes->get('/report', 'AdminController/ReportControll::showReport');
$routes->put('/report/(:any)', 'AdminController\ReportControll::updateReport/$1');
$routes->get('/Managestudent', 'AdminController/Manageuser/Managemember::getStudent');
$routes->get('/Manageemployer', 'AdminController/Manageuser/Managemember::getEmployer');

//------------------------------------Admin cate------------------------------------------------------

$routes->get('/maincate', 'AdminController/Category/MainCategory::showCate');
$routes->get('/maincate/(:any)', 'AdminController\Category\MainCategory::showCatebyid/$1');
$routes->post('/maincate', 'AdminController/Category/MainCategory::addCategory');
$routes->put('/maincate/(:any)', 'AdminController\Category\MainCategory::editCate/$1');
$routes->get('/subcate', 'AdminController/Category/SubCategoryControl::showSub');
$routes->get('/subcate/(:any)', 'AdminController\Category\SubCategoryControl::showSubcatebyid/$1');
$routes->post('/subcate', 'AdminController/Category/SubCategoryControl::addsubCategory');
$routes->put('/subcate/(:any)', 'AdminController\Category\SubCategoryControl::editSubcate/$1');
$routes->delete('/subcate/(:any)', 'AdminController\Category\SubCategoryControl::deleteSub/$1');
$routes->get('/subcateJoin', 'AdminController/Category/SubCategoryControl::showSubJoin');
$routes->get('/subcatebyid/(:any)', 'AdminController\Category\SubCategoryControl::subcatebyid/$1');
$routes->get('/cate/(:any)', 'AdminController\Category\MainCategory::showWorkbyCate/$1');
$routes->get('/showworkbysubcate/(:any)', 'WorkController\ShowWork::showworkbysubcate/$1');

//-------------------------------------usercontroll------------------------------

$routes->get('/getStudent/(:any)', 'UserController\Studentcontroller::getStudentData/$1');
$routes->put('/getStudent/(:any)', 'UserController\Studentcontroller::editProfileFree/$1');
$routes->get('/getEmp/(:any)', 'UserController\Employercontroller::getEmpData/$1');
$routes->put('/getEmp/(:any)', 'UserController\Employercontroller::editProfileEmp/$1');
$routes->get('/getHistory/(:any)', 'UserController\Studentcontroller::getHistoryFree/$1');
$routes->post('/report', 'UserController/ReportControll::addReport');


//-------------------------chat---------------------------------

$routes->post('/message', 'UserController/MessageController::sendmessage');
$routes->get('/showmessagebyid/(:any)', 'UserController\MessageController::showmessagebyid/$1');
$routes->get('/showlistmessage/(:any)', 'UserController\MessageController::showlistmessage/$1');

//---------------------------------Employment Freeland------------------------------------------------------
$routes->post('/employment', 'WorkController/Employment::addEmployment');
$routes->get('/employmentFlReq/(:any)', 'WorkController\Employment::selectEmploymentForFl/$1');
$routes->get('/employmentFlProgress/(:any)', 'WorkController\Employment::selEmploymentForFltoProgress/$1');
$routes->get('/employmentFlSuc/(:any)', 'WorkController\Employment::selEmploymentForFltoSuccess/$1');

//---------------------------------Employment Employer------------------------------------------------------
$routes->get('/employmentEpyReq/(:any)', 'WorkController\Employment::selectEmploymentForEpy/$1');
$routes->get('/employmentEpyProgress/(:any)', 'WorkController\Employment::selectEmploymentForEpytoProgress/$1');
$routes->get('/employmentEpySuc/(:any)', 'WorkController\Employment::selEmploymentForEpytoSuccess/$1');
$routes->put('/employmentEpyReq/(:any)', 'WorkController\Employment::acceptFromFl/$1');

$routes->delete('/employmentEpyReq/(:any)', 'WorkController\Employment::deleteFromEpy/$1');
$routes->put('/employmentEpySuc/(:any)', 'WorkController\Employment::successFromEpy/$1');
$routes->get('/getHistoryEmp/(:any)', 'UserController\Employercontroller::getHistoryEmp/$1');


if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
	require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
