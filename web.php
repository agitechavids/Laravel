<?php

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
/*Static*/
Route::get('/', function () {
    return view('welcome');
});
Route::get('/home', function () {
    return view('home');
});
Route::get('/about', function () {
    return view('about');
});
Route::get('/contact', function () {
    return view('contact');
});


//text

Route::get('/text', function () {
    return "Hi This is Text";
});
Route::get('/admin/post', function () {
    return "admin class and its post method is hear";
});




//Parameters

Route::get('/admin/post/{id}', function ($id) {
    return "Post no is ".$id;
});
Route::get('name/{name}/mob/{mob}', function ($name, $mob_no) {
    return "Hi This is my name: ".$name." and this is my mobile no: ".$mob_no;
});


//Optional Parameters

//Route::get('user/{name}', function ($name) {
//    return $name;
//});
Route::get('user/{name?}', function ($name = null) {
    return $name;
});










//Route::get('user/{name?}', function ($name = 'Default User') {
//    return $name;
//});


//Redirect Routes
Route::view('/rim','rim');
Route::redirect('request', '/', 301);

//Name Route
Route::get('/admin/post/name/author',array('as'=>'admin.post',function () {
$url=route('admin.post');
    return "This URL is ". $url;
}));


//Regular Expression Constraints
Route::get('rim/{emp_name}', function ($emp_name) {
    return "Welcome To RIM ".$emp_name;
})->where('emp_name', '[A-Z]+');

//Route::get('rim/{emp_name}', function ($emp_name) {
//    return "Welcome To RIM ".$emp_name;
//})->where('emp_name', '[A-Za-z]+');
//Route::get('rim/{emp_id}', function ($emp_id) {
//    return "Welcome To RIM ".$emp_id;
//})->where('emp_id', '[0-9]+');


//Group routing


// routes/web.php

// Route::group([], function () {

//     Route::get('/first', function () {
//         echo "I'm First";
//     });
//     Route::get('/second', function () {

//         echo "I'm Second";
//     });
//     Route::get('/third', function () {
//         echo "I'm Third";
//     });

// });


// routes/web.php
Route::group(['prefix' => 'books'], function () {
// First Route
    Route::get('/first', function () {
        return 'The Colour of Magic';
    });
// Second Route
    Route::get('/second', function () {
        return 'Iron Man';
    });

// Third Route
    Route::get('/third', function () {
        return 'Lord of the Rings';
    });

});

//pass data to view


Route::get('/test', function(){
    return view('test',['name'=>'This is the Test Data coming form Route']);
});










/*dynamic*/

//Route::get('/', function () {
//    return 'Hello, World!';
//});
//Route::post('/', function () {});
//Route::put('/', function () {});
//Route::delete('/', function () {});
//Route::any('/', function () {});
//Route::match(['get', 'post'], '/', function () {});






//For Create an ITEM
Route::post('/admin', function () {
    echo "We just Create an ITEM";
});
//For Create an ITEM
Route::get('/admin', function () {
    echo '<form action="admin" method="POST">';
    echo '<input type="submit">';
echo '<input type="hidden" value="'. csrf_token().'" name="_token">';
    echo '<input type="hidden" name="_method" value="PUT">';
    #echo '<input  type="hidden" name="_method" value="DELETE">';
    echo '</form>';

});
//For Update an ITEM
Route::put('/admin', function () {
    echo "We just Update an ITEM";
});
//For Delete an ITEM
Route::delete('/admin', function () {
    echo "We just Delete an ITEM";
});


//with DB

Route::get('/getData', function()
{
    $fetchData = DB::select('select * from users where id = ?', array(1));
    echo "<pre>";
    print_r($fetchData);
    echo "</pre>";
});

Route::get('getMethod', function () {
    echo 'GET Method';
});


Route::post('postData', function(){
    print_r($_REQUEST);
});

Route::get('postData', function(){
    echo '<form method="POST" action="postData">';
    echo 'Enter Name:<input type="text" name="name">';
    echo '<input type="submit">';
    echo csrf_field();
    echo '</form>';

});


Route::put('update', function()
{
    $name=$_REQUEST['name'];
    $id=$_REQUEST['id'];
    $affected = DB::update("UPDATE users set name='$name' where id = ?", [$id]);
    echo $affected==1?"Successfully Updated":"UPdate Fail";
});

Route::get('update', function(){
    $fetchData = DB::select('select * from users where id = ?', array(1));
    echo '<form method="POST" action="update">';
    echo "Update Name: <input type=\"text\" name=\"name\" value=\"{$fetchData[0]->name}\">";
    echo "<input type=\"hidden\" value=\"{$fetchData[0]->id}\" name=\"id\">";
    echo '<input type="hidden" value="PUT" name="_method">';
    echo '<input type="submit">';
    echo csrf_field();
    echo '</form>';
});


Route::delete('delete', function()
{
    $id=$_REQUEST['id'];
    $affected = DB::update("DELETE FROM users where id = ?", [$id]);
    echo $affected==1?"Successfully Deleted":"Delete Fail";
});

Route::get('delete', function(){
    $fetchData = DB::select('select * from users where id = ?', array(1));
    echo '<form method="POST" action="delete">';
    echo "Enter User Id for Delete: <input type=\"text\" name=\"id\">";
    echo '<input type="hidden" value="DELETE" name="_method">';
    echo '<input type="submit" value="Delete">';
    echo csrf_field();
    echo '</form>';
});

/////////Controller///////
Route::get('/main', 'mainController@index');

