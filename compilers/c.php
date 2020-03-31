<?php
header('Access-Control-Allow-Origin: http://localhost:4200/editor');  
        
    
        $postdata = file_get_contents("php://input");
        $request = json_decode($postdata);
        @$email = $request->email;
		// echo $email;

		$decode =urldecode($email);
		
		$CC="gcc";
	$out="timeout 5s ./a.out";
	$code=$decode;
	$input="";
	$filename_code="main.c";
	$filename_in="input.txt";
	$filename_error="error.txt";
	$executable="a.out";
	$command=$CC." -lm ".$filename_code;	
	$command_error=$command." 2>".$filename_error;
	$check=0;

	//if(trim($code)=="")
	//die("The code area is empty");
	
	$file_code=fopen($filename_code,"w+");
	fwrite($file_code,$code);
	fclose($file_code);
	$file_in=fopen($filename_in,"w+");
	fwrite($file_in,$input);
	fclose($file_in);
	exec("chmod 777 $executable"); 
	exec("chmod 777 $filename_error");	

	shell_exec($command_error);
	$error=file_get_contents($filename_error);
	$executionStartTime = microtime(true);

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
		@$myObj->name = $output;
		$myJSON = json_encode($myObj);
		echo $myJSON;	}
	else if(!strpos($error,"error"))
	{
		// echo "<pre>$error</pre>";
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
		@$myObj->name = $output;
		$myJSON = json_encode($myObj);
		echo $myJSON;	}
	else
	{
		@$myObj->name = $error;
		$myJSON = json_encode($myObj);
		echo $myJSON;		
		
		$check=1;
	}
	$executionEndTime = microtime(true);
	$seconds = $executionEndTime - $executionStartTime;
	// $seconds = sprintf('%0.2f', $seconds);
	// echo "<pre>Compiled And Executed In: $seconds s</pre>";
	if($check==1)
	{
		// echo "<pre>Verdict : CE</pre>";
	}
	else if($check==0 && $seconds>3)
	{
		// echo "<pre>Verdict : TLE</pre>";
	}
	else if(trim($output)=="")
	{
		// echo "<pre>Verdict : WA</pre>";
	}
	else if($check==0)
	{
		// echo "<pre>Verdict : AC</pre>";
	}
	exec("rm $filename_code");
	exec("rm *.o");
	exec("rm *.txt");
	exec("rm $executable");
    
?>
