<html>

<head>
	<title>
		Relay 
	</title>
	  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	  <link rel="stylesheet" type="text/css" href="style.css"></style>
	  <script src="jquery.js"></script>
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
			table{
				border: 1px solid #000;
			}
			td {
				border: 1px solid #666;
				padding: 2px;
			}
		</style>
</head>
<body>

<div id="header" align="center">
    <h1>Taipower Relay Setting Platform</h1>
</div>

<img class="pg" src="powergrid.jpg" align='center'>
 
<div align="center">
	<form id="inputForm">
		<h1>輸電網路標置程式</h1>
		<table>
		<tr>
			<td><label>日期</label><input type ="text" name="date"/></td>
			<td>基準電壓值
				<select name="kv">
					<option value="161kv">161kv</option>
					<option value="345kv">345kv</option>
				</select>
			</td>
		</tr>
		<tr>
			<td>送電端匯流排名稱<input type="text" name="from" /> </td>
			<td>受電端匯流排名稱<input type="text" name="to" /></td>
		</tr>
		<tr>
			<td>送電端測距電驛型式
				<select name="from-relay">
					<option value="SEL-311C">SEL-331C</option>
				</select>
			</td>
			<td>
			受電端測距電驛型式
			<select name="to-relay">
				<option value="SEL-311C">SEL-331C</option>
			</select>
			</td>
		</tr>
		<tr>
			<td>			
				保護電驛比流器匝比
				<input type="text" name="from-cp" />
			</td>
			<td>
				保護電驛比流器匝比
				<input type="text" name="to-cp" />
			</td>
		</tr>
		</table>

		
		
		
        
         
          
		  <button id="submitBtn">送出</button>
	</form>
</div>


<div id="result"></div>

<script>
$(function(){
	$('#submitBtn').click(function(){
		$.ajax({
			type: 'POST',
			url: 'test1.php',
			data: {},
		}).done().fail(function(){
			alert('hi');
		});
		
	});
});
</script>

</body>
</html>