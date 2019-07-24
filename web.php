    <?php
use App\Post;
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

    Route::get('/', function () {
        return view('welcome');
    });

    Route::get('/index','home@index');
    Route::get('/get','home@DBALL');
    Route::get('/forelse','home@forelse');
    Route::get('/store','home@store');
    Route::get('/url','home@url');
    Route::get('/seg/{name}/{pass}','home@url_seg');
    Route::get('/cookies','home@cookies');


    /////////////ORM
    Route::get('/read',function(){

        //$post=App\Post;
        $posts=Post::all();
        foreach($posts as $post)
        {
         return $post->title;
        }
    });

    Route::get('/find',function(){

        $posts=Post::find(2);
        return $posts->title;
        
    });
    Route::get('/findwhere',function(){

        //$posts=Post::where('id',2)->orderBy('id','desc')->take(1)->get();
        $posts=Post::where('is_admin',0)
        ->orderBy('id','desc')->get();
        return $posts;
    });

    Route::get('/findmore',function(){

        
        $posts=Post::findOrFail(1);
        //$posts=Post::findOrFail(3);
        return $posts;
    });
    Route::get('/findfist',function(){

        
        $posts=Post::where('is_admin','<',0)
        ->firstOrFail();
        //$posts=Post::where('is_admin','<',1)
        //->firstOrFail();
        
        return $posts;
    });

    ///////ORM CRUD
    Route::get('/basicinsert',function(){

        $post=new Post;
        $post->title='This is ORM'; 
        $post->content='first ORM post based upon LARAVEL';
        $post->created_at=time();
        $post->updated_at=time();
        $post->is_admin=0;
        $post->save();
        echo $post?"Data Insert Success":"Data Insert Fail","<br>";

        if($post->save())
        {
            echo 'Data inserted';
        }
        else
        {
            echo 'Data not inserted';
        }
        
        
    });

    Route::get('/update',function(){

        $post=Post::find(1);
        $post->title='This is Updated  ORM'; 
        $post->content='Updated ORM post based upon LARAVEL';
        $post->created_at=time();
        $post->updated_at=time();
        $post->is_admin=0;
        $post->save();
        echo $post?"Data update Success":"Data update Fail","<br>";
        
        
        
        
    });
    Route::get('/mass',function(){

        //Post::create(['title'=>'title','content'=>'content']);
        for($i=0;$i<=10;$i++)
        {
            Post::create(['title'=>'title','content'=>'content']);
        }

        //now go to post
        
    });

    Route::get('/update2',function(){

        $post=Post::where('id',7)->where('is_admin',0)->update(['title'=>"upadted title",'content'=>'updated content']);
        
        echo $post?"Data update Success":"Data update Fail","<br>";
        
    });

    Route::get('/delete',function(){

        $post=Post::find(13);
        $post->delete();
        //Post::where('is_admin',1)->delete();
        echo $post?"Data delete Success":"Data delete Fail","<br>";

    });

    Route::get('/destroy',function(){
        Post::destroy(21);
       // Post::destroy([13,17]);
    });
    Route::get('/softdelete',function(){
        Post::find(24)->delete();
    });

    Route::get('/readsoftdelete',function(){
       $post=Post::withTrashed()->where('id',22)->get();

       //$post=Post::onlyTrashed()->get();

       
    });

    Route::get('/restore',function(){
        $post=Post::withTrashed()->where('id',23)->restore();
 
        //$post=Post::withTrashed()->restore();
 
      
     });
     Route::get('/forcedelete',function(){
        //$post=Post::withTrashed()->where('id',25)->forcedelete();
 
        $post=Post::onlyTrashed()->forcedelete();
 
      
     });


