<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class AllSqlQueryController extends Controller
{
    public function index(){

        $customers = DB::table('customers')->get();
         return view('index', ['customers' => $customers]);

    }
    public function singlerow(){

        $customers = DB::table('customers')
        ->where('first_name', 'Francisco')->first();
        echo "<pre>";
          print_r($customers);
        echo "</pre>";

    }
    public function singlecolumn(){

        $customers = DB::table('customers')
        ->where('first_name', 'Francisco')
        ->value('job_title');
        echo "<pre>";
        print_r($customers);
        echo "</pre>";

    }
    public function pluck1(){

        $names = DB::table('customers')->pluck('first_name');
         foreach ($names as $name) {
             echo $name,"<br>";
         }

    }
    public function pluck2(){
        $names = DB::table('customers')->pluck('first_name','company');
        foreach ($names as $company=>$first_name) {
            echo "Name: ", $first_name,"  ||||  ";
            echo "Company: ", $company,"<br>";
        }
    }
    public function chunk(){

        $customers = DB::table('customers')
        ->orderBy('id')->
        chunk(5, function ($customers) {
            echo "<pre>";
            print_r($customers);
            echo "</pre>";
        });
    }
    public function Aggregates(){

        $customers = DB::table('customers')->count();
        echo "total customers:" ,$customers,"<br>";
        $shipping_fee = DB::table('orders')
        ->max('shipping_fee');
        echo "Shipping fee:",$shipping_fee;
        
        
    }

    public function table(){

        $customers = DB::table('customers')->get();
        $table="<table border='1' width='300'";
        $table.="<tr><th>id</th><th>company</th>
                     <th>last_name</th><th>first_name</th>
                     <th>email_address</th><th>job_title</th>
                     <th>business_phone</th><th>home_phone</th>
                     <th>mobile_phone</th><th>fax_number</th>
                     <th>address</th><th>city</th>
                     <th>state_province</th><th>zip_postal_code</th>
                     <th>country_region</th><th>web_page</th>
                     <th>notes</th><th>attachments</th></tr>";
        foreach($customers as $customer){
 
        $table.="<tr><td>$customer->id</td><td>$customer->company</td>
        <td>$customer->last_name</td><td>$customer->first_name</td><td>$customer->email_address</td>
        <td>$customer->job_title</td><td>$customer->business_phone</td>
        <td>$customer->home_phone</td><td>$customer->mobile_phone</td>
        <td>$customer->fax_number</td><td>$customer->address</td>
        <td>$customer->city</td><td>$customer->state_province</td>
        <td>$customer->zip_postal_code</td><td>$customer->country_region</td>
        <td>$customer->web_page</td><td>$customer->notes</td>
        <td>$customer->attachments</td></tr>";
                 
        }
        $table.="</table>";
        echo $table;
        
        
    }

    public function disttable(){
     
        $customers = DB::table('customers')
        ->distinct()->get(["job_title"]);
        foreach($customers as $customers){
            echo $customers->job_title,"<br>";
        }
    }

    public function addquery(){
     
        $query = DB::table('customers')->select('first_name');
        $customers = $query->addSelect('job_title')->get();
 
        $table="<table border='1' width='300'>";
        $table.="<tr><th>first_name</th><th>job_title</th></tr>";
        foreach($customers as $customer){
 
        $table.="<tr><td>$customer->first_name</td>
        <td>$customer->job_title</td></tr>";
                 
        }
        $table.="</table>";
        echo $table;
    }
///////////////////////////////another DB////////////////////////
    public function getTest()
    {
        $db_ext = DB::connection('mysql_external');
        $students = $db_ext->table('students')->get();

        
        echo "<pre>";
        print_r($students);
        echo "</pre>";
    }





    public function allinnerjoin(){
     
        $db_ext = DB::connection('mysql_external');
        $students =$db_ext->table('students')
            ->join('contacts', 'students.id', '=', 
            'contacts.student_id')
            ->join('course_choice', 'students.id', '=',
             'course_choice.student_id')
            ->join('courses', 'students.id', '=', 
            'course_choice.student_id')
            ->select('students.id','students.name',
            'courses.course_name','contacts.phone','contacts.email')
            ->get();
 
            echo "<pre>";
            print_r($students);
            echo "</pre>";
    }

    public function allleftjoin(){
     
        $db_ext = DB::connection('mysql_external');
        $students =$db_ext->table('students')
            ->leftJoin('contacts', 'students.id', '=', 'contacts.student_id')
            ->select('students.id','students.name','contacts.phone','contacts.email')
            ->get();
 
            echo "<pre>";
            print_r($students);
            echo "</pre>";
    }
    
    public function crossjoin(){
     
        $db_ext = DB::connection('mysql_external');
        $students =$db_ext->table('students')
            ->crossJoin('courses')
            ->get();
 
            echo "<pre>";
            print_r($students);
            echo "</pre>";
    }

    public function advjoin(){
         
        $db_ext = DB::connection('mysql_external');
        $students =$db_ext->table('students')
        ->join('contacts', function ($join) {
            $join->on('students.id', '=', 'contacts.student_id')
                 ->where('contacts.student_id', '>', 3);
        })
        ->get();
 
            echo "<pre>";
            print_r($students);
            echo "</pre>";
    }


    public function unions(){
         
        $db_ext = DB::connection('mysql_external');
        $first =$db_ext->table('contacts')
            ->where('phone','1');
        

        $students = $db_ext->table('contacts')
            ->where('email','@')
            ->union($first)
            ->get();
 
            echo "<pre>";
            print_r($students);
            echo "</pre>";
    }

///////////////////////////////Where Clause //////////////////////////////


public function simplewhere(){
    $db_ext = DB::connection('mysql_external');     
    $students = $db_ext->table('students')->where('id', '=', 5)->get();
    
    foreach($students as $student){
        echo "Id: ",$student->id,"<br>","Name: ",$student->name,"<br>";
      
    }
    echo "------------------------------------------------------------<br>";
    $stds = $db_ext->table('students')->where('id',7)->get();
    foreach($stds as $std){
        echo "Id: ",$std->id,"<br>","Name: ",$std->name,"<br>";
       
    }
    echo "------------------------------------------------------------<br>";  
$students = $db_ext->table('students')->where('id', '=', 5)->get();
foreach($students as $student){
    echo "Id: ",$student->id,"<br>","Name: ",$student->name,"<br>";
   
}
echo "------------------------------------------------------------<br>";
//-------------------------------------------------------------------

$students = $db_ext->table('students')->where('id', '!=', 5)->get();
foreach($students as $student){
    echo "Id: ",$student->id,"<br>","Name: ",$student->name,"<br>";
   
}
echo "------------------------------------------------------------<br>";
//--------------------------------------------------------------------
$students = $db_ext->table('students')->where('id', '<=', 5)->get();
foreach($students as $student){
    echo "Id: ",$student->id,"<br>","Name: ",$student->name,"<br>";
    
}
echo "------------------------------------------------------------<br>";
//---------------------------------------------------------------------
$students = $db_ext->table('students')->where('id', '>=', 5)->get();

foreach($students as $student){
    echo "Id: ",$student->id,"<br>","Name: ",$student->name,"<br>";
   
}
echo "------------------------------------------------------------<br>";
//-----------------------------------------------------------------------
$students = $db_ext->table('students')->where('id', '<>', 5)->get();

foreach($students as $student){
    echo "Id: ",$student->id,"<br>","Name: ",$student->name,"<br>";
    
}
echo "------------------------------------------------------------<br>";
//------------------------------------------------------------------------

$students = $db_ext->table('students')->where('id', 'like', '%S')->get();

foreach($students as $student){
    echo "Id: ",$student->id,"<br>","Name: ",$student->name,"<br>";
    
}
echo "------------------------------------------------------------<br>";
//-------------------------------------------------------------------------


// $students = $db_ext->table('students')->where([
//                                             ['id', '=', '1'],
//                                             ['subscribed', '<>', '1'],
//                                         ])->get();

// foreach($students as $student){
//      echo "Id: ",$student->id,"<br>","Name: ",$student->name,"<br>";
// }
//-------------------------------------------------------------------------









}







    
}
