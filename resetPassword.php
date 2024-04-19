<!DOCTYPE html>
<html>
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link
      href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500&display=swap"
      rel="stylesheet"
    />
    <link rel="icon" type="image/x-icon" href="favicon.png">
    
    <title>Balance Buddy</title>
    <style>
    
    input{
      width: 100%;
      padding: 12px 20px;
      margin: 8px 0;
      display: inline-block;
      border: 1px solid #ccc;
      border-radius: 4px;
      box-sizing: border-box;
      font-family: "Poppins", sans-serif;
 
      display: block;
      width: 100%;
      padding: 0.6em 0.3em;
      border: 1px solid #d0d0d0;
      border-radius: 0.3em;
      color: #414a67;
      outline: none;
      font-weight: 400;
      margin-bottom: 0.6em;
  
    }
    
    label, a,h4{
    	font-family: "Poppins", sans-serif;
    }

    input[type=submit] {
      width: 100%;
      background-color: #587ef4;
      color: white;
      padding: 14px 20px;
      margin: 8px 0;
      border: none;
      border-radius: 4px;
      cursor: pointer;
    }
    div {
        border-radius: 5px;
        background-color: #f2f2f2;
        padding: 20px;
        zoom: 1.3;
        width: 50%;
        height:50%;
    }
     #container{
      position: absolute;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      padding: 20px;
    }
    
    a{
     text-decoration:none;
     color:black;
     font-size:15px;
    }
    
    h4{
    	font-size:45px;
        color:black;
        margin-top: 15px; 
    }
    
   .submit {
    font-size: 1em;
    margin-top: 0.8em;
    background-color: #587ef4;
    border: none;
    outline: none;
    color: #ffffff;
    padding: 0.6em 1.2em;
    border-radius: 0.3em;
    cursor: pointer;
  }
    
    /*Per smartphone*/
    @media screen and (max-width: 600px) {
      #container {
        width: 80%;
        height: 38%;
      }
      
      h4{
    	font-size:55px;
        color:black;
         margin-top: 9px;
    	}
    }
    
    /*Per Tablet*/
    @media only screen and (max-width:800px) {
    	#container {
        width: 80%;
        height: 38%;
      }
      
      h4{
    	font-size:55px;
        color:black;
         margin-top: 9px;
    	}
    }
    </style>
    
   </head> 
    
<body>

	<center>
    <h4><b>Reset Password</b></h4><br>
      <div id="container">
        <form action="sendReset_link.php" method="POST">
          <label for="email">Email</label>
          <input type="email" id="email" name="email" placeholder="Email" required>
		  <label for="password">Nuova Password</label>
          <input type="password" id="password" name="password" placeholder="Nuova Password" required>
          <input type="submit" class="submit" value="Reimposta Password">
        </form>
        
      </div>
	</center>
</body>
</html>