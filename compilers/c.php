<?php
header('Access-Control-Allow-Origin: *');  

    try {
        $postdata = file_get_contents("php://input");
        $request = json_decode($postdata,True);
        @$email = $request->email;
        echo $email;

        $mng = new MongoDB\Driver\Manager("mongodb://localhost:27017");
        
        $filter = [ 'email' => 12345]; 
        $query = new MongoDB\Driver\Query($filter);     
        
        $res = $mng->executeQuery("TestR.OnlineCompiler", $query);
        
		$car = current($res->toArray());
		
		if (!empty($car)) {
    
			putenv("PATH=C:\Program Files (x86)\CodeBlocks\MinGW\bin");
			$CC="gcc";
	$out="a.exe";
	$code=$car->code;
	$input="";
	$filename_code="main.c";
	$filename_in="input.txt";
	$filename_error="error.txt";
	$executable="a.exe";
	$command=$CC." -lm ".$filename_code;	
	$command_error=$command." 2>".$filename_error;

	//if(trim($code)=="")
	//die("The code area is empty");
	
	$file_code=fopen($filename_code,"w+");
	fwrite($file_code,$code);
	fclose($file_code);
	$file_in=fopen($filename_in,"w+");
	fwrite($file_in,$input);
	fclose($file_in);
	exec("cacls  $executable /g everyone:f"); 
	exec("cacls  $filename_error /g everyone:f");	

	shell_exec($command_error);
	$error=file_get_contents($filename_error);

	if(trim($error)=="")
	{
		if(trim($input)=="")
		{
			$output=shell_exec($out);
		}
		else
		{
			$out=$out." < ".$filename_in;
			$output=shell_exec($out);
		}
		//echo "<pre>$output</pre>";

		$request1 = json_decode($output,True);
		echo $request1;
		$bulk = new MongoDB\Driver\BulkWrite;
    
				try {
     
					$mng = new MongoDB\Driver\Manager("mongodb://localhost:27017");
					
					$bulk = new MongoDB\Driver\BulkWrite;
					
					$doc = [ 'output' => $output, 'email' => 'lobopranayk9@gmail.com'];
					$bulk->insert($doc);
					
					
					$mng->executeBulkWrite('TestR.OnlineCompiler', $bulk);
						
				} catch (MongoDB\Driver\Exception\Exception $e) {
				
					$filename = basename(__FILE__);
					
					echo "The $filename script has experienced an error.\n"; 
					echo "It failed with the following exception:\n";
					
					echo "Exception:", $e->getMessage(), "\n";
					echo "In file:", $e->getFile(), "\n";
					echo "On line:", $e->getLine(), "\n";    
				}
        //echo "<textarea id='div' class=\"form-control\" name=\"output\" rows=\"10\" cols=\"50\">$output</textarea><br><br>";
	}
	else if(!strpos($error,"error"))
	{
		echo "<pre>$error</pre>";
		if(trim($input)=="")
		{
			$output=shell_exec($out);
		}
		else
		{
			$out=$out." < ".$filename_in;
			$output=shell_exec($out);
		}
		//echo "<pre>$output</pre>";
		// echo "$output";
		$request1 = json_decode($output,True);
		echo $request1;
		$bulk = new MongoDB\Driver\BulkWrite;
    
				try {
     
					$mng = new MongoDB\Driver\Manager("mongodb://localhost:27017");
					
					$bulk = new MongoDB\Driver\BulkWrite;
					
					$doc = [ 'output' => $output, 'email' => 'lobopranayk9@gmail.com'];
					$bulk->insert($doc);
					
					
					$mng->executeBulkWrite('TestR.OnlineCompiler', $bulk);
						
				} catch (MongoDB\Driver\Exception\Exception $e) {
				
					$filename = basename(__FILE__);
					
					echo "The $filename script has experienced an error.\n"; 
					echo "It failed with the following exception:\n";
					
					echo "Exception:", $e->getMessage(), "\n";
					echo "In file:", $e->getFile(), "\n";
					echo "On line:", $e->getLine(), "\n";    
				}
                //echo "<textarea id='div' class=\"form-control\" name=\"output\" rows=\"10\" cols=\"50\">$output</textarea><br><br>";
	}
	else
	{
		// echo "<pre>$error</pre>";

		$bulk = new MongoDB\Driver\BulkWrite;
    
				try {
     
					$mng = new MongoDB\Driver\Manager("mongodb://localhost:27017");
					
					$bulk = new MongoDB\Driver\BulkWrite;
					
					$doc = [ 'output' => $error, 'email' => 'lobopranayk9@gmail.com'];
					$bulk->insert($doc);
					
					
					$mng->executeBulkWrite('TestR.OnlineCompiler', $bulk);
						
				} catch (MongoDB\Driver\Exception\Exception $e) {
				
					$filename = basename(__FILE__);
					
					echo "The $filename script has experienced an error.\n"; 
					echo "It failed with the following exception:\n";
					
					echo "Exception:", $e->getMessage(), "\n";
					echo "In file:", $e->getFile(), "\n";
					echo "On line:", $e->getLine(), "\n";    
				}
	}
	exec("del $filename_code");
	exec("del *.o");
	exec("del *.txt");
	exec("del $executable");
		} else {
		
			echo "No match found\n";
		}
       
        
    } catch (MongoDB\Driver\Exception\Exception $e) {
    
        $filename = basename(__FILE__);
        
        echo "The $filename script has experienced an error.\n"; 
        echo "It failed with the following exception:\n";
        
        echo "Exception:", $e->getMessage(), "\n";
        echo "In file:", $e->getFile(), "\n";
        echo "On line:", $e->getLine(), "\n";    
    }
    
    
    
?>
