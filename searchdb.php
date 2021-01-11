<?php
    //get the input search text
    $searchText = $_GET["searchKey"];
    
    //access (connect) the database: hwk10_cuny_map_db
    //set up parameters (4)
    $server = "localhost";
    $user = "root";
    $password= "root";
    $database = "cuny_db";
    
    //for later use
    $dbtable = "cuny_table";
    
    //connect to the database: PHP has  a function for it!!
    $mycon = mysqli_connect($server,$user,$password,$database) or die("no connection");
    
    //create a String variable that holds SQL select command that searches the database
    $SQLselect = "select * from " . $dbtable . " where match(collegetype,collegename,url,address,city,state,".
                   "zip,phone,latitude,longitude) against('". $searchText . "' in natural language mode)";
    
    //running above command - PHP has a function for it!!
    $results = mysqli_query($mycon,$SQLselect) or die("query did not run");
    
    //how many matched record(s)
    $numrecs = mysqli_num_rows($results);
    
    if ($numrecs > 0)
    {
        //send start of select element to HTML
        print "<select id='collegeList' style='width:350px;border:none' onchange='getcollegeinfo()' size='10'>";
        print "<option value=''>Select a College</option>";
        
        //let's loop the entire pool of records ($results)
        while($recordArray = mysqli_fetch_array($results))
        {
            //extracting the relevant record's fields
            $collegetype = $recordArray[1];
            $collegename = $recordArray[2];
            $url = $recordArray[3];
            $address = $recordArray[4];
            $city = $recordArray[5];
            $state = $recordArray[6];
            $zip = $recordArray[7];
            $phone = $recordArray[8];
            $latitude = $recordArray[9];
            $longitude = $recordArray[10];
            
            $collegeinfo = $url.",".$address.",".$city.",".$state.",".$zip.",".$phone.",".$latitude.",".$longitude;
            $optionText = $collegename.", ".$collegetype;
            
            //send option to HTML
            print "<option value='".$collegeinfo."'>".$optionText."</option>";
        }//end of loop
        
        //send closing select
        print "</select>";
    }  
    else print "No record(s) found";
