<!DOCTYPE html>
<html lang="en">
<head>
  <title>Uplodaed Cv File</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>
<body>

<?php 
   function CleanInputs($input){

    $input = trim($input);
    $input = stripcslashes($input);
    $input = htmlspecialchars($input);

    return $input;
  }

    $errorMessages = array();

    if($_SERVER['REQUEST_METHOD'] == "POST" )
    {

       $email     = CleanInputs($_POST['email']);
       $password  = CleanInputs($_POST['password']); 
       $url       = $_POST['url'];

        if(!empty($email)){
           
           if(!filter_var($email,FILTER_VALIDATE_EMAIL)){
                $errorMessages['email'] = "Invalid Email";
           }

        }else{
            $errorMessages['email'] = "Required";
        }
 
        if(!empty($password)){
             
            if(strlen($password) < 6){

               $errorMessages['Password'] = "Password Length must be > 5 "; 
            }

        }else{

          $errorMessages['Password'] = "Required";

        }

        if(!empty($url)){
          
            if(!filter_var($url,FILTER_VALIDATE_URL)){
               $errorMessages['url'] = " Invalid Url "; 
              }
         }else{
           $errorMessages['url'] = "Required";
         }
         
         if(!empty($_FILES['uploadedFile']['name']) && isset($_FILES['uploadedFile']['name']) ){

          $tmp_path = $_FILES['uploadedFile']['tmp_name'];
          $name     = $_FILES['uploadedFile']['name'];
          $size     = $_FILES['uploadedFile']['size'];
          $type     = $_FILES['uploadedFile']['type'];
     
          $nameArray = explode('.',$name);
          $FileExtension = strtolower($nameArray[1]);
     
          $FinalName = rand().time().'.'.$FileExtension;
     
          $allowedExtension = ['pdf'];    
     
            if(in_array($FileExtension,$allowedExtension)){
           
             $disFolder = './uploads/';
             
             $disPath  = $disFolder.$FinalName;
     
              if(move_uploaded_file($tmp_path,$disPath))
                {
                   echo 'File Uploaded';
     
                }else{
                    $errorMessages['uploadedFile'] = "Please upload file ";
                }
     
            }else{
     
                $errorMessages['uploadedFile'] = " Extension Not Allowed ";            }
            }
        else
    {
        
    }
     
     if(count($errorMessages) == 0){

        echo "Email :".$email.'<br>'."Password :".$password.'<br>'."LinkedInAccount :". $url;

     }else{

     foreach($errorMessages as $key => $value){

        echo '* '.$key.' : '.$value.'<br>';
       } 
     }

    }
?>
<div class="container">
  <h2> CV uploaded Form</h2>
  <form  method="post"  action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>"  enctype ="multipart/form-data">

  <div class="form-group">
    <label for="exampleInputEmail1">Email address</label>
    <input type="email" name="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email">
  </div>

  <div class="form-group">
    <label for="exampleInputPassword1">New Password</label>
    <input type="password"  name="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
  </div>
 
  <div class="form-group">
    <label for="url">LinkedInAccount</label>
    <input type="url"  name="url" class="form-control" id="url" >
  </div>

  <div class="form-group">
    <label for="exampleInputPassword1"> Uplod Your CV</label>
    <input type="file"  name="uploadedFile" >
  </div>


  
  <button type="submit" class="btn btn-primary">Submit</button>
</form>
</div>

</body>
</html>
