<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/


Route::auth();



//****** Rotas API ****************

Route::get('/api/professionalName/{name}', 'ApiController@professionalName');
Route::get('/api/professionalID/{id}', 'ApiController@professionalID');
Route::get('/api/profDisorder/{disorderName}', 'ApiController@profDisorder');
Route::get('/api/profLoader/{id},{pos}', 'ApiController@profLoader');
Route::get('/api/professionalLocal/{local}', 'ApiController@professionalLocal');
Route::get('/api/professionalSpecialty/{specialtyName}', 'ApiController@professionalSpecialty');


Route::get('/api/disorderID/{id}', 'ApiController@disorderID');
Route::get('/api/disorderName/{name}', 'ApiController@disorderName');
Route::get('/api/disorderBySign/{name},{pos}', 'ApiController@disorderBySign');
Route::get('/api/cidID/{name}', 'ApiController@cidID');


Route::get('/api/centerName/{name}', 'ApiController@centerName');
Route::get('/api/centerID/{id}', 'ApiController@centerID');
Route::get('/api/centerDisorder/{disorderName}', 'ApiController@centerDisorder');
Route::get('/api/centerSpecialty/{specialtyName}', 'ApiController@centerSpecialty');
Route::get('/api/centerLocal/{local}', 'ApiController@centerLocal');

Route::get('/api/signLoader/{id},{pos}', 'ApiController@signLoader');

Route::get('/api/protocolID/{id}', 'ApiController@protocolID');
Route::get('/api/protocolName/{name}', 'ApiController@protocolName');

Route::get('/api/lawID/{id}', 'ApiController@lawID');
Route::get('/api/lawName/{name}', 'ApiController@lawName');




//********* Rotas WEB *********************
Route::get('/home', 'HomeController@index');

Route::get('/charts', 'ChartController@testChart');

Route::group(['middleware'=> [],'web'], function(){

    Route::get('admin/permissions', 'PermissionController@index');
    Route::get('admin/permissions/create', 'PermissionController@create');
    Route::post('admin/permissions/store', 'PermissionController@store');
    Route::get('admin/permissions/delete/{id}', 'PermissionController@delete');
    Route::get('admin/permissions/show/{id}', 'PermissionController@show');
    Route::get('admin/permissions/edit/{id}', 'PermissionController@edit');
    Route::put('admin/permissions/update/{id}', 'PermissionController@update');
    Route::get('admin/permissions/search', 'PermissionController@search');
    Route::get('admin/permissions/{id}/roles', 'PermissionController@roles');

    Route::get('admin/roles', 'RoleController@index');
    Route::get('admin/roles/create', 'RoleController@create');
    Route::post('admin/roles/store', 'RoleController@store');
    Route::get('admin/roles/delete/{id}', 'RoleController@delete');
    Route::get('admin/roles/show/{id}', 'RoleController@show');
    Route::get('admin/roles/edit/{id}', 'RoleController@edit');
    Route::put('admin/roles/update/{id}', 'RoleController@update');
    Route::get('admin/roles/search', 'RoleController@search');
    Route::get('admin/roles/{id}/permissions', 'RoleController@permissions');



    Route::get('admin/users', 'UserController@index');
    Route::get('admin/users/create', 'UserController@create');
    Route::post('admin/users/store', 'UserController@store');
    Route::get('admin/users/delete/{id}', 'UserController@delete');
    Route::get('admin/users/show/{id}', 'UserController@show');
    Route::get('admin/users/edit/{id}', 'UserController@edit');
    Route::put('admin/users/update/{id}', 'UserController@update');
    Route::get('admin/users/search', 'UserController@search');
    Route::get('admin/users/{id}/roles', 'UserController@roles');


    Route::get('/', 'MainController@main');
    Route::get('/disorders/search', 'MainController@search');
    Route::get('/disorders/show/{id}', 'MainController@showDisorders');
    Route::get('/synonyms/show/{id}', 'MainController@showSynonimous');
    Route::get('/specialties/show/{id}', 'MainController@showSpecialties');
    Route::get('/signs/show/{id}', 'MainController@showSigns');
    Route::get('/references/show/{id}', 'MainController@showReferences');
    Route::get('/indicators/show/{id}', 'MainController@showIndicators');
    Route::get('/professionals/show/{id}', 'MainController@showProfessionals');
    Route::get('/treatmentCenters/show/{id}', 'MainController@showTreatmentCenters');

    Route::get('admin', 'MainAdminController@index');

    Route::get('admin/import/disorders', 'ImportXMLController@disorders');
    Route::get('admin/import/signs', 'ImportXMLController@signs');
    Route::get('admin/import/genes', 'ImportXMLController@genes');
    Route::get('admin/import/protocols', 'ImportXMLController@protocols');
    Route::get('admin/import/disesp', 'ImportXMLController@disEsp');

    Route::get('admin/disorders', 'DisorderController@index');
    Route::get('admin/disorders/create', 'DisorderController@create');
    Route::post('admin/disorders/store', 'DisorderController@store');
    Route::get('admin/disorders/delete/{id}', 'DisorderController@delete');
    Route::get('admin/disorders/show/{id}', 'DisorderController@show');
    Route::get('admin/disorders/edit/{id}', 'DisorderController@edit');
    Route::put('admin/disorders/update/{id}', 'DisorderController@update');
    Route::get('admin/disorders/search', 'DisorderController@search');

    Route::get('admin/disordertypes', 'DisorderTypeController@index');
    Route::get('admin/disordertypes/create', 'DisorderTypeController@create');
    Route::post('admin/disordertypes/store', 'DisorderTypeController@store');
    Route::get('admin/disordertypes/delete/{id}', 'DisorderTypeController@delete');
    Route::get('admin/disordertypes/show/{id}', 'DisorderTypeController@show');
    Route::get('admin/disordertypes/edit/{id}', 'DisorderTypeController@edit');
    Route::put('admin/disordertypes/update/{id}', 'DisorderTypeController@update');
    Route::get('admin/disordertypes/search', 'DisorderTypeController@search');

    Route::get('admin/protocols', 'ProtocolController@index');
    Route::get('admin/protocols/create', 'ProtocolController@create');
    Route::post('admin/protocols/store', 'ProtocolController@store');
    Route::get('admin/protocols/delete/{id}', 'ProtocolController@delete');
    Route::get('admin/protocols/show/{id}', 'ProtocolController@show');
    Route::get('admin/protocols/edit/{id}', 'ProtocolController@edit');
    Route::put('admin/protocols/update/{id}', 'ProtocolController@update');
    Route::get('admin/protocols/search', 'ProtocolController@search');

    Route::get('admin/laws', 'LawController@index');
    Route::get('admin/laws/create', 'LawController@create');
    Route::post('admin/laws/store', 'LawController@store');
    Route::get('admin/laws/delete/{id}', 'LawController@delete');
    Route::get('admin/laws/show/{id}', 'LawController@show');
    Route::get('admin/laws/edit/{id}', 'LawController@edit');
    Route::put('admin/laws/update/{id}', 'LawController@update');
    Route::get('admin/laws/search', 'LawController@search');

    Route::get('admin/synonyms', 'SynonymousController@index');
    Route::get('admin/synonyms/create', 'SynonymousController@create');
    Route::post('admin/synonyms/store', 'SynonymousController@store');
    Route::get('admin/synonyms/delete/{id}', 'SynonymousController@delete');
    Route::get('admin/synonyms/show/{id}', 'SynonymousController@show');
    Route::get('admin/synonyms/edit/{id}', 'SynonymousController@edit');
    Route::put('admin/synonyms/update/{id}', 'SynonymousController@update');
    Route::get('admin/synonyms/search', 'SynonymousController@search');

    Route::get('admin/specialties', 'SpecialtyController@index');
    Route::get('admin/specialties/create', 'SpecialtyController@create');
    Route::post('admin/specialties/store', 'SpecialtyController@store');
    Route::get('admin/specialties/delete/{id}', 'SpecialtyController@delete');
    Route::get('admin/specialties/show/{id}', 'SpecialtyController@show');
    Route::get('admin/specialties/edit/{id}', 'SpecialtyController@edit');
    Route::put('admin/specialties/update/{id}', 'SpecialtyController@update');
    Route::get('admin/specialties/search', 'SpecialtyController@search');

    Route::get('admin/signs', 'SignController@index');
    Route::get('admin/signs/create', 'SignController@create');
    Route::post('admin/signs/store', 'SignController@store');
    Route::get('admin/signs/delete/{id}', 'SignController@delete');
    Route::get('admin/signs/show/{id}', 'SignController@show');
    Route::get('admin/signs/edit/{id}', 'SignController@edit');
    Route::put('admin/signs/update/{id}', 'SignController@update');
    Route::get('admin/signs/search', 'SignController@search');

    Route::get('admin/references', 'ReferenceController@index');
    Route::get('admin/references/create', 'ReferenceController@create');
    Route::post('admin/references/store', 'ReferenceController@store');
    Route::get('admin/references/delete/{id}', 'ReferenceController@delete');
    Route::get('admin/references/show/{id}', 'ReferenceController@show');
    Route::get('admin/references/edit/{id}', 'ReferenceController@edit');
    Route::put('admin/references/update/{id}', 'ReferenceController@update');
    Route::get('admin/references/search', 'ReferenceController@search');

    Route::get('admin/indicatorTypes', 'IndicatorTypeController@index');
    Route::get('admin/indicatorTypes/create', 'IndicatorTypeController@create');
    Route::post('admin/indicatorTypes/store', 'IndicatorTypeController@store');
    Route::get('admin/indicatorTypes/delete/{id}', 'IndicatorTypeController@delete');
    Route::get('admin/indicatorTypes/show/{id}', 'IndicatorTypeController@show');
    Route::get('admin/indicatorTypes/edit/{id}', 'IndicatorTypeController@edit');
    Route::put('admin/indicatorTypes/update/{id}', 'IndicatorTypeController@update');
    Route::get('admin/indicatorTypes/search', 'IndicatorTypeController@search');

    Route::get('admin/indicatorSources', 'IndicatorSourceController@index');
    Route::get('admin/indicatorSources/create', 'IndicatorSourceController@create');
    Route::post('admin/indicatorSources/store', 'IndicatorSourceController@store');
    Route::get('admin/indicatorSources/delete/{id}', 'IndicatorSourceController@delete');
    Route::get('admin/indicatorSources/show/{id}', 'IndicatorSourceController@show');
    Route::get('admin/indicatorSources/edit/{id}', 'IndicatorSourceController@edit');
    Route::put('admin/indicatorSources/update/{id}', 'IndicatorSourceController@update');
    Route::get('admin/indicatorSources/search', 'IndicatorSourceController@search');

    Route::get('admin/indicators', 'IndicatorController@index');
    Route::get('admin/indicators/create', 'IndicatorController@create');
    Route::post('admin/indicators/store', 'IndicatorController@store');
    Route::get('admin/indicators/delete/{id}', 'IndicatorController@delete');
    Route::get('admin/indicators/show/{id}', 'IndicatorController@show');
    Route::get('admin/indicators/edit/{id}', 'IndicatorController@edit');
    Route::put('admin/indicators/update/{id}', 'IndicatorController@update');
    Route::get('admin/indicators/search', 'IndicatorController@search');

    Route::get('admin/professionals', 'ProfessionalController@index');
    Route::get('admin/professionals/create', 'ProfessionalController@create');
    Route::post('admin/professionals/store', 'ProfessionalController@store');
    Route::get('admin/professionals/delete/{id}', 'ProfessionalController@delete');
    Route::get('admin/professionals/show/{id}', 'ProfessionalController@show');
    Route::get('admin/professionals/edit/{id}', 'ProfessionalController@edit');
    Route::put('admin/professionals/update/{id}', 'ProfessionalController@update');
    Route::get('admin/professionals/search', 'ProfessionalController@search');

    Route::get('admin/treatmentCenters', 'TreatmentCenterController@index');
    Route::get('admin/treatmentCenters/create', 'TreatmentCenterController@create');
    Route::post('admin/treatmentCenters/store', 'TreatmentCenterController@store');
    Route::get('admin/treatmentCenters/delete/{id}', 'TreatmentCenterController@delete');
    Route::get('admin/treatmentCenters/show/{id}', 'TreatmentCenterController@show');
    Route::get('admin/treatmentCenters/edit/{id}', 'TreatmentCenterController@edit');
    Route::put('admin/treatmentCenters/update/{id}', 'TreatmentCenterController@update');
    Route::get('admin/treatmentCenters/search', 'TreatmentCenterController@search');
});
