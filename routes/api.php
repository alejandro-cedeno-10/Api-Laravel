<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix' => 'oauth/token'], function () {
    
    Route::post( '/','AuthController@login');
    Route::post('/signup', 'AuthController@signup');
  
}); 





 Route::group(['prefix' => 'tamano'], function () {
   Route::get('/', 'TamanoController@index');
   Route::get('/buscar/{id}', 'TamanoController@show');

 });

 Route::group(['prefix' => 'categoria'], function () {
   Route::get('/', 'CategoriaController@index');
   Route::get('/buscar/{id}', 'CategoriaController@show');
 });


 Route::group(['prefix' => 'producto'], function () {
   Route::post('/filter', 'ProductoController@filter_productos');
   Route::get('/', 'ProductoController@index');
   Route::get('/buscar/{id}', 'ProductoController@show');
   Route::get('/productos_categoria/{id}', 'ProductoController@show_Productos');  
 });


 Route::group(['prefix' => 'tamano_producto'], function () {
   Route::get('/', 'TamanoProductoController@index');
   Route::get('/buscar/{id}', 'TamanoProductoController@show');
   Route::get('/lista_tamano/{id}', 'TamanoProductoController@showTamanoProduto');
 });





    Route::group(['middleware' => 'auth:api'], function() {

      Route::group(['prefix' => 'session'], function () {
        Route::get('/logout', 'AuthController@logout');
         Route::get('/user', 'AuthController@user');
       });
    
 
       Route::group(['prefix' => 'users'], function () {  
         Route::put('/actualizar', 'UserController@update'); 
         Route::delete('/eliminar/{id}', 'UserController@destroy'); 
       });
 
       Route::group(['prefix' => 'modo_pago'], function () {
         Route::post('/create', 'ModoPagoController@create');
         Route::get('/buscar/{id}', 'ModoPagoController@show');
         Route::put('/actualizar', 'ModoPagoController@update'); 
         Route::delete('/eliminar/{id}', 'ModoPagoController@destroy'); 
       });
 
       Route::group(['prefix' => 'factura'], function () {
         Route::post('/create', 'FacturaController@create');
         Route::get('/buscar/{id}', 'FacturaController@show');
         Route::get('/facts_user/{id}', 'FacturaController@FacUserOne');
         Route::get('/user_factura/{id}/{id2}', 'FacturaController@showFacturaOne');
         Route::put('/actualizar', 'FacturaController@update'); 
       });
 
       Route::group(['prefix' => 'detalle'], function () {
         Route::post('/create', 'DetalleController@create');
         Route::get('/buscar/{id}', 'DetalleController@show');
         Route::put('/actualizar', 'DetalleController@update'); 
         Route::delete('/eliminar/{id}/{id2}', 'DetalleController@destroy'); 
       });
    






      Route::group(['middleware' => 'admin'], function() {
   
         Route::group(['prefix' => 'users'], function () {
           Route::get('/', 'UserController@index');
           Route::get('/buscar/{id}', 'UserController@show');
         });
   
   
         Route::group(['prefix' => 'tipo_pago'], function () {
           Route::post('/create', 'TipoPagoController@create');
           Route::get('/', 'TipoPagoController@index');
           Route::get('/buscar/{id}', 'TipoPagoController@show');
           Route::put('/actualizar', 'TipoPagoController@update'); 
           Route::delete('/eliminar/{id}', 'TipoPagoController@destroy'); 
         });
   
   
         Route::group(['prefix' => 'modo_pago'], function () {
           Route::get('/', 'ModoPagoController@index');
         });
   
         Route::group(['prefix' => 'tamano'], function () {
           Route::post('/create', 'TamanoController@create');
           Route::put('/actualizar', 'TamanoController@update'); 
           Route::delete('/eliminar/{id}', 'TamanoController@destroy'); 
         });
   
         Route::group(['prefix' => 'categoria'], function () {
          Route::get('/adminCategoria', 'CategoriaController@index_Admin');
           Route::post('/create', 'CategoriaController@create');
           Route::post('/actualizar', 'CategoriaController@update'); 
           Route::put('/actualizar', 'CategoriaController@update'); 
           Route::delete('/eliminar/{id}', 'CategoriaController@destroy'); 
         });
   
   
         Route::group(['prefix' => 'producto'], function () {
           Route::post('/create', 'ProductoController@create');
           Route::post('/actualizar', 'ProductoController@update'); 
           Route::put('/actualizar', 'ProductoController@update'); 
           Route::delete('/eliminar/{id}', 'ProductoController@destroy'); 
           Route::get('/adminProductos_categoria/{id}', 'ProductoController@show_Productos_Admin');  

         });
   
   
         Route::group(['prefix' => 'tamano_producto'], function () {
           Route::post('/create', 'TamanoProductoController@create');
           Route::post('/actualizar', 'TamanoProductoController@update'); 
           Route::put('/actualizar', 'TamanoProductoController@update'); 
           Route::delete('/eliminar/{id}/{id2}', 'TamanoProductoController@destroy'); 
         });
   
         
         Route::group(['prefix' => 'factura'], function () {        
           Route::get('/', 'FacturaController@index');
           Route::delete('/eliminar/{id}', 'FacturaController@destroy'); 
         });
   
         Route::group(['prefix' => 'detalle'], function () {
           Route::get('/', 'DetalleController@index');
         });

      });
      

    
      

    });


