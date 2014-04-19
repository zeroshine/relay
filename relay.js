$(window).on('load', function () {

            $('.selectpicker').selectpicker({
                'selectedText': 'cat'
            });

            // $('.selectpicker').selectpicker('hide');
});
var tableArr=[];

$("#navbtm").click(function(event){
	event.preventDefault();
    $.post("getNewData.php", {first:$('#bus').val(),kv:$('#kv').val(),ratio:$('#ratio').val()},
    function(data) {
        console.log(data);
        obj = $.parseJSON(data);
        //console.log(obj[1].name);
        var list="<div class=\"btn-group-vertical btn-block\">";
        var tableArr=[];
        for(var bj in obj){
        	var table="";
            list += "<button type=\"button\" class=\"btn btn-lg btn-default\" id=\"line"+bj+"\">"+ $('#bus').val() +" to "+ obj[bj].name +"</button>";
        	
            table += "<h3>Relay setting value</h3>"
            table += "<table class=\"table table-striped table-bordered table-hover\">";
            table += "<th> Z1 = "+obj[bj].Z1+"</th><tr>";
            table += "<th> Z2 = "+obj[bj].Z2+"</th><tr>";
            table += "<th> Z3 = "+obj[bj].Z3+"</th>";
            table += "</table>";
            
            table += "<h3>Picked Cable</h3>"
            table += "<table class=\"table table-striped table-bordered table-hover\">";
            table += "<th></th><th>來端</th><th>去端</th><th>長度</th><th>正相阻抗R1</th><th>正相阻抗X1</th><th>正相阻抗Z1</th><tr>";
            table += "<td>Minimum Zone1</td><td>"+obj[bj].MinZone0.from+"</td><td>"+obj[bj].MinZone0.to+"</td><td>"+obj[bj].MinZone0.length+"</td><td>";
            table +=obj[bj].MinZone0.r1+"</td><td>"+obj[bj].MinZone0.x1+"</td><td>"+obj[bj].MinZone0.z1+"</td><tr>";
            table += "<td>Maximum Zone1</td><td>"+obj[bj].MaxZone0.from+"</td><td>"+obj[bj].MaxZone0.to+"</td><td>"+obj[bj].MaxZone0.length+"</td><td>";
            table +=obj[bj].MaxZone0.r1+"</td><td>"+obj[bj].MaxZone0.x1+"</td><td>"+obj[bj].MaxZone0.z1+"</td><tr>";
            if(obj[bj].MaxZone1!=null){
                table += "<td>Minimum Zone2</td><td>"+obj[bj].MinZone1.from+"</td><td>"+obj[bj].MinZone1.to+"</td><td>"+obj[bj].MinZone1.length+"</td><td>";
                table +=obj[bj].MinZone1.r1+"</td><td>"+obj[bj].MinZone1.x1+"</td><td>"+obj[bj].MinZone1.z1+"</td><tr>";
                table += "<td>Maximum Zone2</td><td>"+obj[bj].MaxZone1.from+"</td><td>"+obj[bj].MaxZone1.to+"</td><td>"+obj[bj].MaxZone1.length+"</td><td>";
                table +=obj[bj].MaxZone1.r1+"</td><td>"+obj[bj].MaxZone1.x1+"</td><td>"+obj[bj].MaxZone1.z1+"</td><tr>";
            }
            if(obj[bj].MinZone2!=null){
                table += "<td>Minimum Zone3</td><td>"+obj[bj].MinZone2.from+"</td><td>"+obj[bj].MinZone2.to+"</td><td>"+obj[bj].MinZone2.length+"</td><td>";
                table +=obj[bj].MinZone2.r1+"</td><td>"+obj[bj].MinZone2.x1+"</td><td>"+obj[bj].MinZone2.z1+"</td><tr>";
            }
            table += "</table>";

            table += "<h3>All Cable Information</h3>"
            table += "<table class=\"table table-striped table-bordered table-hover\">";
        	table += "<th>來端</th><th>去端</th><th>長度</th><th>正相阻抗R1</th><th>正相阻抗X1</th><th>正相阻抗Z1</th><tr>";
        	table += "<th colspan=19 align=center> Zone1 </th><tr>";

        	for(var c in obj[bj].Zone0Array){
        		var cable=obj[bj].Zone0Array[c];
        		table +="<td>"+cable.from+"</td><td>"+cable.to+"</td><td>"+cable.length+"</td><td>";
        		table +=cable.r1+"</td><td>"+cable.x1+"</td><td>"+cable.z1+"</td><tr>";
        	}
        	table += "<th colspan=19 align=center> Zone2 </th><tr>";
        	for(var c in obj[bj].Zone1Array){
        		var cable=obj[bj].Zone1Array[c];
        		table +="<td>"+cable.from+"</td><td>"+cable.to+"</td><td>"+cable.length+"</td><td>";
        		table +=cable.r1+"</td><td>"+cable.x1+"</td><td>"+cable.z1+"</td><tr>";
        	}
        	table += "<th colspan=19 align=center> Zone3 </th><tr>";
        	for(var c in obj[bj].Zone2Array){
        		var cable=obj[bj].Zone2Array[c];
        		table +="<td>"+cable.from+"</td><td>"+cable.to+"</td><td>"+cable.length+"</td><td>";
        		table +=cable.r1+"</td><td>"+cable.x1+"</td><td>"+cable.z1+"</td><tr>";
        	}
        	
            var s=obj[bj].name;
            tableArr.push(table) ;
        }
        list+="</div>";
        $('#container').html(tableArr[0]);
        $("#leftbar").html(list).delegate('button', 'click', function (e) {
            var i = $(e.currentTarget).index();
            $('#container').html(tableArr[i]);
        });
    });
}); 
