set htaccess RewriteBase /nameOfAppFolder/ and 
#then 
the base tag in public/index href="/nameOfAppFolder/" 
and call FJTee's router class
#To include file:
#Slave::section('Folder/fileName');


$p->render($total,$data['per_page']);//for paging;

#Welcome to MariaDb
to insert to a table
$db->insert('mytable',
	[
		'first_name' => 'Marei',
		'last_name' => 'Morsy',
		'age'	=> 22
	]);
And here is how to use lastId() after using update() method :
$db->lastId();

to update
$db->update('mytable',
	[
		'first_name' => 'Mohammed',
		'last_name' => 'Gharib',
		'age'	=> 24
	],1); //or ['age','>',22]) in place or 1 //['id',1] will mean id = 1 //[ ['age',18], [1] ] will mean table.age = 18 AND table.id = 1

#Another way to update using where() method
$db->update('mytable',
	[
		'first_name' => 'Ashraf',
		'last_name' => 'Hefny',
		'age'	=> 28
	])->where(1)->exec(); //->where(1)->where('first_name','Ashraf')->exec(); or ->where(1)->where('age','>',20)->exec();

#Now what if we wanted to add OR to our where clause?
->where('age','<=',20)->orWhere(1)->exec();
UPDATE `mytable` SET `first_name` = ?, `last_name` = ?, `age` = ? WHERE `mytable`.`age` <= ? OR `mytable`.`id` = ?

#And also you can pass an array of where clauses to where() or orWhere() method like this :
->where([ ['first_name', 'Marei'], ['age >=', 18], [1] ])->exec();
->where([ ['first_name', 'Marei'], ['age >=', 18]])->where(1)->orWhere([ [5], ['last_name', 'Morsy'] ])->exec();

#delete
$db->delete('mytable',1);
$db->delete('mytable', ['first_name', 'Marei']); // mean where first_name = Marei
$db->delete('mytable', ['age', '<', 18]);
$db->delete('mytable', [ ['age', '<', 18], [1] ]);
$db->delete('mytable')->where(1)->exec();
To delete all rows from table :
	$db->delete('mytable')->exec();

#Qget() method
 works exactly like get method but without all MareiCollecton functionality like print the result as JSON and other methods like toArray(), toJSON(), first(), last() and item(). if you really care about performance Qget() is what you need to use. And you can use it like this :
$users = $db->table("users")->Qget();

#select Method
$rows = $db->table('mytable')->select('first_name, last_name')->get(); //selects colomns in mytable

#limit() Method 
$rows = $db->table('mytable')->limit(10)->get();//SELECT * FROM `mytable` LIMIT 10
$rows = $db->table('mytable')->limit(10, 20)->get();//SELECT * FROM `mytable` LIMIT 10 OFFSET 20 returning 10 records starting from 21

#paginate() method
You can use paginate() method with all selection methods like table() and select() instead of get(), it takes two parameters : the first one is page number starting from 1 as integer and the second one is used to specify the number of records to return paginate($page, $limit) and you can use it exactly like get() method and here is an example of how you can use it
$rows = $db->table('mytable')->paginate(2, 5);

#Qpaginate() Method
Qpaginate() method works exactly like paginate() method but without all MareiCollecton functionality like print the result as JSON and other methods like toArray(), toJSON(), first(), last() and item(). if you really care about performance Qget() is what you need to use. And you can use it like this
$rows = $db->table('mytable')->paginate(2, 5);
$rows = $db->table('mytable')->where(1)->get();//using where statement
To get more information about what is going on behind the scenes, use PaginationInfo() method for more details like this:

print_r( $db->paginationInfo() );

#Order method
Order the result set you can use orderBy() method to order the result set by a column name, orderBy($column_name, $order) takes two parameters, the first one is the column name as string and the second one is optional and it takes only two values ASC which is the default value to order the result set by asccending order, or DESC to order the result set by descending order like this
$rows = $db->table('mytable')->orderBy('id', 'DESC')->get();
$rows = $db->table('mytable')->orderBy('id', 'DESC')->orderBy('age', 'ASC')->get();

#Using Raw Queries 
$sql = "SELECT * FROM mytable WHERE id = ?";
$rows = $db->query($sql, [1]);
if you want to get rid of all Fjt_MareiCollection functionally just pass true as a third parameter like this :
$sql = "SELECT * FROM mytable WHERE id = ?";
$rows = $db->query($sql, [1], true);