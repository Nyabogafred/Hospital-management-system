<?php
  ob_start();
  session_start();
  require_once 'dbconnect.php';
  
  // if session is not set this will redirect to login page
  if( !isset($_SESSION['user']) ) {
    header("Location: login.php");
    exit;
  }
  // select loggedin users detail
  $res=mysql_query("SELECT * FROM doctors WHERE userId=".$_SESSION['user']);
  $userRow=mysql_fetch_array($res);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
<title>Home</title>

<!-- Bootstrap -->
<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="css/styles.css">

<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/bootstrap.min.js"></script>


	

</head>
<body>
 
<nav class="navbar navbar-default navbar-static-top">
  <div class="container">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar"> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </button>
       </div>
    <div class="collapse navbar-collapse" id="myNavbar">
      <ul class="nav navbar-nav navbar-left">
        <li><a href="index.php">Home</a></li>
       
      </ul>
          <ul class="nav navbar-nav navbar-right">
            
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
        <span class="glyphicon glyphicon-user"></span>&nbsp;Hi' <?php echo $userRow['fname']; ?>&nbsp;<span class="caret"></span></a>
              <ul class="dropdown-menu">
                <li><a href="logout.php?logout"><span class="glyphicon glyphicon-log-out"></span>&nbsp;Sign Out</a></li>
              </ul>
            </li>
          </ul>
    </div>
  </div>
</nav>

<div class="container-fluid">
<!--search begin-->
<div class="col-xs-12">
    
         <div class="padding-top-10">
            <div class="x_panel">
      <div class="x_title">
        <div class="row">

          <div class="col-sm-6">
        <h2>Searched Records</h2>
        <div class="col-md-4">
      
       <button type="button" class="btn btn-success"> Entries found <span class="badge">  </span></button>
       </div>
      </div>
      <form action="" method="post" name="search">
      <div class="col-sm-4">
<input name="searchID" class="form-control input-sm" placeholder="Search by Email"  type="search"> 
      </div>
      <div class="col-sm-2">
<input name="go" type="submit" value="Go" class="btn btn-primary"/>
      </div>

      </form>
     







    </div>
        <ul class="nav navbar-right panel_toolbox">
          <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a> </li>
          </li>
        </ul>
        <div class="clearfix"></div>
      </div>
      <div class="x_content">
        <table class="table table-hover">
          <thead>
            <tr>
                <th>#</th>
              <th>First Name</th>
              <th>Last Name</th>
              <th>Email</th>
              <th>Phone Number</th>
              <th>Address</th>
              <th>Date of Birth</th>
               <th>Gender</th>
                <th>Blood Group</th>
                <th>Diagnosis</th>

            </tr>
          </thead>
          <tbody>
         
              <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                
              </tr>
          
          </tbody>
        </table>
        

     
    </div>
  </div>
</div>
<!--search end-->










  
  <div class="col-xs-12">
    
        <h2>Patients' Details</h2>
        <ul class="nav navbar-right panel_toolbox">
          <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a> </li>
          </li>
        </ul>
        <div class="clearfix"></div>
      </div>
      <div class="x_content">
        <table class="table table-hover">
          <thead>
            <tr>
              <th>#</th>
              <th>First Name</th>
              <th>Last Name</th>
              <th>Email</th>
              <th>Phone Number</th>
              <th>Address</th>
              <th>Date of Birth</th>
               <th>Gender</th>
                <th>Blood Group</th>
                <th>Diagnosis</th>

            </tr>
          </thead>
          <tbody>
         
              <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
              </tr>
             
          </tbody>
        </table>
        

        <!--paging-->
        <div class="row">
          <div class="col-sm-5"> Showing  to  of  entries </div>
          <div class="col-sm-7">
            <div class="dataTables_paginate ">
              <ul class="pagination">
              
  Previous

    Next

  
              </ul>
            </div>
          </div>
        </div>
      <!--end of paging-->


      </div>
    </div>
  </div>
</div>
</div>
</div>
</body>
</html>