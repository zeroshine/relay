<html>

<title>
	Relay 
</title>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <link rel="stylesheet" type="text/css" href="style.css"></style>
  <script src="jquery.js"></script>
  <script src="jsDraw2D.js"></script>
  <script src="jsPlumb.js"></script>
  <script src="sigma.min.js"></script>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<style type="text/css">
		img.pg
		{
			height: 260px;
			width: 75%;
			vertical-align: middle;
			display:block;
  			margin: auto;
		}
	</style>
</head>
<body>

<div id="header" align="center">
    <h1>Taipower Relay Setting Platform</h1>
</div>

<img class="pg" src="assets/imgs/powergrid.jpg" align='center'>
 
<div align="center">
	<form name ="input" action="getNewData.php" method="post">
		查詢輸電線參數
	     </br>
	     起點:
         <input type="text" name="first" > 
         </br>
		終點: 
		<input type="text" name="to" >
          </br>
          <select name="kv">
              <option value="161kv">161kv
              <option value="345kv">345kv
          </select>
          <select name="relay">
          	<option value="SEL-311C">SEL-331C
          </selecr>
		  <input type="submit" value="送出" />
	</form>
</div>


<div id="myCanvas" ></div>
<script>

</script>


</body>
</html>