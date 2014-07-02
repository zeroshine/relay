$(window).on('load', function () {

            $('.selectpicker').selectpicker({
                'selectedText': 'cat'
            });

            // $('.selectpicker').selectpicker('hide');
});

var postgetnewdata= function(pkv,relay,ratio,data){
            obj = $.parseJSON(data);
            //console.log(obj[1].name);
            var list=[];
            var tableArr=[];
            for(var bj in obj){
                var table="";
                list.push("<button type=\"button\" class=\"btn btn-lg btn-default\" id=\"line"+bj+"\">"+ obj[bj].from+" to "+ obj[bj].name +"</button>");
                table += "<h2>"+ obj[bj].from+" to "+ obj[bj].name +"</h2>"
                table += "<h3>Relay setting value</h3>"
                table += "<table class=\"table table-striped table-bordered table-hover\">";
                table += "<th> Z1 = "+obj[bj].Z1+"</th><tr>";
                table += "<th> Z2 = "+obj[bj].Z2+"</th><tr>";
                table += "<th> Z3 = "+obj[bj].Z3+"</th><tr>";
                table += "<th> Zs = "+obj[bj].Zs+"</th><tr>";
                var kv=0;
                var fac=0;
                if(pkv=="161kv" || pkv=="161kv_new" ){
                    kv=161;
                    fac=0.9;
                }
                if(pkv=="345kv"){
                    kv=345;
                    fac=0.78;
                }
                if(($('#relay').val())=="SEL311(L)"){            
                    table += "<th> Z1P=Z1MG=XG1= "+obj[bj].Z1+"</th><tr>";
                    table += "<th> Z2P=Z2MG=XG2=XG3= "+obj[bj].Z2+"</th><tr>";
                    table += "<th> Z4P=Z4MG=XG4= "+obj[bj].Z3+"</th><tr>";
                    table += "<th> ZLF=ZLR = "+kv*kv/parseFloat(obj[bj].cap)*parseFloat(ratio)*fac+"</th><tr>";
                    table += "<th> RG1 = "+10*0.8*parseFloat(ratio)+"</th><tr>";
                    table += "<th> RG2 = "+10*parseFloat(ratio)+"</th><tr>";
                    table += "<th> RG2 = "+10*1.2*parseFloat(ratio)+"</th><tr>";
                    table += "<th> RG2 = "+10*1.5*parseFloat(ratio)+"</th><tr>";
                    var r1,x1,r0,x0;
                    r1=parseFloat(obj[bj].MinZone0.r1);
                    x1=parseFloat(obj[bj].MinZone0.x1);
                    r0=parseFloat(obj[bj].MinZone0.r0);
                    x0=parseFloat(obj[bj].MinZone0.x0);
                    table += "<th> Z1MAG = "+parseFloat(obj[bj].MinZone0.z1)*parseFloat(ratio)+"</th><tr>";
                    table += "<th> Z1ANG = "+Math.atan(x1/r1)*180/3.14159265359+"</th><tr>";
                    table += "<th> Z0MAG = "+parseFloat(obj[bj].MinZone0.z0)*parseFloat(ratio)+"</th><tr>";
                    table += "<th> Z0ANG = "+Math.atan(x0/r0)*180/3.14159265359+"</th><tr>";
                    var kom1 =(Math.sqrt((r0-r1)*(r0-r1)+(x0-x1)*(x0-x1)))/(3*parseFloat(obj[bj].MinZone0.z1));
                    var koa1 =(Math.atan((x0-x1)/(r0-r1))*180/3.14159265359)-(Math.atan(x1/r1)*180/3.14159265359);
                    table+= "<th> KOM1 = "+kom1+"</th><tr>";
                    table+= "<th> KOA1 = "+koa1+"</th><tr>";
                }else if(($('#relay').val())=="MDAR"){
                    table += "<th> Z1P=Z1G= "+obj[bj].Z1+"</th><tr>";
                    table += "<th> Z2P=Z2G= "+obj[bj].Z2+"</th><tr>";
                    table += "<th> Z3P=Z3G= "+obj[bj].Z3+"</th><tr>";
                    table += "<th> IL = 1.0</th><tr>";
                    table += "<th> IM = 5</th><tr>";
                    table += "<th> IOM = 1</th><tr>";
                    var r1,x1,r0,x0;
                    r1=parseFloat(obj[bj].MinZone0.r1);
                    x1=parseFloat(obj[bj].MinZone0.x1);
                    r0=parseFloat(obj[bj].MinZone0.r0);
                    x0=parseFloat(obj[bj].MinZone0.x0);
                    var gang=(Math.atan(x0/r0)*180/3.14159265359);
                    var pang=(Math.atan(x1/r1)*180/3.14159265359);
                    if (gang<40){
                        gang=40;
                    }
                    var z01=parseFloat(obj[bj].MinZone0.z0)/parseFloat(obj[bj].MinZone0.z1);
                    table += "<th> PANG ="+pang+"</th><tr>";
                    table += "<th> GANG ="+gang+"</th><tr>";
                    table += "<th> Z0/Z1 ="+z01+"</th><tr>";
                }else if(($('#relay').val())=="GRZ100"){
                    table += "<th> Z1S = "+obj[bj].Z1+"</th><tr>";
                    table += "<th> Z2S = "+obj[bj].Z2+"</th><tr>";
                    table += "<th> Z3S = "+obj[bj].Z3+"</th><tr>";
                    table += "<th> KRS = "+100*parseFloat(obj[bj].MaxZone0.r0)/parseFloat(obj[bj].MaxZone0.r1)+"</th><tr>";
                    table += "<th> KRM = "+100*parseFloat(obj[bj].MaxZone0.rm)/parseFloat(obj[bj].MaxZone0.r1)+"</th><tr>";
                    table += "<th> KXS = "+100*parseFloat(obj[bj].MaxZone0.x0)/parseFloat(obj[bj].MaxZone0.x1)+"</th><tr>";
                    table += "<th> KXM = "+100*parseFloat(obj[bj].MaxZone0.xm)/parseFloat(obj[bj].MaxZone0.x1)+"</th><tr>";
                    table += "<th> EF  = "+943/400*0.5+"</th><tr>";
                    table += "<th> OCH = "+1646/400*0.8+"</th><tr>";
                    var Z3FL=358.613/(1000*parseFloat(obj[bj].l3s))*259.21;
                    var Z1FL=3*358.613/(1000*parseFloat(obj[bj].l1g))*259.21;
                    table += "<th> Z3FL = "+Z3FL+"</th><tr>";
                    table += "<th> Z1FL = "+Z1FL+"</th><tr>";
                    table += "<th> SO1  = "+(Z1FL-2*Z3FL)*parseFloat(ratio)+"</th><tr>";
                    var Z3FR=358.613/(1000*parseFloat(obj[bj].r3s))*259.21;
                    var Z1FR=3*358.613/(1000*parseFloat(obj[bj].r1g))*259.21;
                    table += "<th> Z3FR = "+Z3FR+"</th><tr>";
                    table += "<th> Z1FR = "+Z1FR+"</th><tr>";
                    table += "<th> SO2  = "+(Z1FR-2*Z3FR)*parseFloat(ratio)+"</th><tr>";
                }
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
                if(obj[bj].MaxZoneb1!=null){
                    table += "<td>Maximum Zoneb1</td><td>"+obj[bj].MaxZoneb1.from+"</td><td>"+obj[bj].MaxZoneb1.to+"</td><td>"+obj[bj].MaxZoneb1.length+"</td><td>";
                    table +=obj[bj].MaxZoneb1.r1+"</td><td>"+obj[bj].MaxZoneb1.x1+"</td><td>"+obj[bj].MaxZoneb1.z1+"</td><tr>";
                }
                if(obj[bj].MaxZoneb2!=null){
                    table += "<td>Maximum Zoneb2</td><td>"+obj[bj].MaxZoneb2.from+"</td><td>"+obj[bj].MaxZoneb2.to+"</td><td>"+obj[bj].MaxZoneb2.length+"</td><td>";
                    table +=obj[bj].MaxZoneb2.r1+"</td><td>"+obj[bj].MaxZoneb2.x1+"</td><td>"+obj[bj].MaxZoneb2.z1+"</td><tr>";
                }
                table += "</table>";

                table += "<h3>All Cable Information</h3>"
                table += "<table class=\"table table-striped table-bordered table-hover\">";
                table += "<th>來端</th><th>去端</th><th>長度</th><th>正相阻抗R1</th><th>正相阻抗X1</th><th>正相阻抗Z1</th><th>搭接點</th><tr>";
                table += "<th colspan=19 align=center> Zone1 </th><tr>";
                for(var c in obj[bj].Zone0Array){
                    var cable=obj[bj].Zone0Array[c];
                    table +="<td>"+cable.from+"</td><td>"+cable.to+"</td><td>"+cable.length+"</td><td>";
                    table +=cable.r1+"</td><td>"+cable.x1+"</td><td>"+cable.z1+"</td>";
                    table+='<td>'
                    for(var t in cable.ta){
                        var ta=cable.ta[t];
                        table+=ta+','
                    }
                    table+='</td>'
                    table+="</tr>";
                }
                table += "<th colspan=19 align=center> Zone2 </th><tr>";
                for(var c in obj[bj].Zone1Array){
                    var cable=obj[bj].Zone1Array[c];
                    table +="<td>"+cable.from+"</td><td>"+cable.to+"</td><td>"+cable.length+"</td><td>";
                    table +=cable.r1+"</td><td>"+cable.x1+"</td><td>"+cable.z1+"</td>";
                    table+='<td>'
                    for(var t in cable.ta){
                        var ta=cable.ta[t];
                        table+=ta+','
                    }
                    table+='</td>'
                    table+="</tr>";
                }
                table += "<th colspan=19 align=center> Zone3 </th><tr>";
                for(var c in obj[bj].Zone2Array){
                    var cable=obj[bj].Zone2Array[c];
                    table +="<td>"+cable.from+"</td><td>"+cable.to+"</td><td>"+cable.length+"</td><td>";
                    table +=cable.r1+"</td><td>"+cable.x1+"</td><td>"+cable.z1+"</td>";
                    table+='<td>'
                    for(var t in cable.ta){
                        var ta=cable.ta[t];
                        table+=ta+','
                    }
                    table+='</td>'
                    table+="</tr>";
                }
                table += "<th colspan=19 align=center> Zoneb1 </th><tr>";
                for(var c in obj[bj].Zoneb1Array){
                    var cable=obj[bj].Zoneb1Array[c];
                    table +="<td>"+cable.from+"</td><td>"+cable.to+"</td><td>"+cable.length+"</td><td>";
                    table +=cable.r1+"</td><td>"+cable.x1+"</td><td>"+cable.z1+"</td>";
                    table+='<td>'
                    for(var t in cable.ta){
                        var ta=cable.ta[t];
                        table+=ta+','
                    }
                    table+='</td>'
                    table+="</tr>";
                }
                table += "<th colspan=19 align=center> Zoneb2 </th><tr>";
                for(var c in obj[bj].Zoneb2Array){
                    var cable=obj[bj].Zoneb2Array[c];
                    table +="<td>"+cable.from+"</td><td>"+cable.to+"</td><td>"+cable.length+"</td><td>";
                    table +=cable.r1+"</td><td>"+cable.x1+"</td><td>"+cable.z1+"</td>";
                    table+='<td>'
                    for(var t in cable.ta){
                        var ta=cable.ta[t];
                        table+=ta+','
                    }
                    table+='</td>'
                    table+="</tr>";
                }
                tableArr.push(table) ;
            }
            
            return [tableArr,list];
};
function insert(tableArr,list){
    $('#container').html("");
    var btnlist="<div class=\"btn-group-vertical btn-block\">";
    for(var btn in list){
        btnlist+=list[btn];
    }
    btnlist+="</div>";
    $("#rightitem").html(btnlist).delegate('button', 'click', function (e) {
        var i = $(e.currentTarget).index();
        $('#container').html(tableArr[i]);
    });
    $('#container').html(tableArr[0]);

}
$("#navbtm").click(function(event){
	event.preventDefault();
    $.post("getNewData.php", {first:$('#bus').val(),kv:$('#kv').val(),relay:$('#relay').val(),ratio:$('#ratio').val()},
        function(data) {
            //console.log($('#kv').val()+"\n");
            console.log(data);
            var insertelement=postgetnewdata($('#kv').val(),$('#relay').val(),$('#ratio').val(),data);
            insert(insertelement[0],insertelement[1]);
        });
});
$("#diff").click(function(event){
    event.preventDefault();
    $.post("getbus.php",{kv:$('#kv').val()},function(data){
        console.log(data);
        obj = $.parseJSON(data);
        var table_need=[];
        var list=[];
        var str=$('#kv').val()+"_new";
        console.log(obj)
        for (var bus in obj) {
            var insertelement=[];
            var insertelement_new=[];
            var begin=obj[bus];
            $.ajax({
                type:"POST",
                url:"getNewData.php", 
                data:{first:begin,kv:$('#kv').val(),relay:$('#relay').val(),ratio:$('#ratio').val()},
                async:false,
                success:function(data) {
                    //console.log(data);
                    insertelement=postgetnewdata($('#kv').val(),$('#relay').val(),$('#ratio').val(),data);
                    //console.log(insertelement_new);
                }        
            });
            $.ajax({
                type:"POST",
                url:"getNewData.php", 
                data:{first:begin,kv:str,relay:$('#relay').val(),ratio:$('#ratio').val()},
                async:false,
                success:function(data) {
                    //console.log(data);
                    insertelement_new=postgetnewdata($('#kv').val(),$('#relay').val(),$('#ratio').val(),data);
                    //console.log(insertelement_new);
                }        
            });
            var asize=insertelement_new[0];
            var bsize=insertelement[0];
            var newlist=insertelement_new[1];
            var asize_l=asize.length;
            for(var i=0 ; i<asize_l;++i){
                var a=asize[i].split("Picked Cable");
                console.log(a[0]);
                var b=bsize[i].split("Picked Cable");
                console.log(b[0]);
                if(i>bsize.length){
                    table_need.push(asize[i]);
                }else if(a[0]!=b[0]){
                    table_need.push(asize[i]);
                    list.push(newlist[i]);
                }
            }    
        }
        insert(table_need,list);
    });   
}); 
$("#pyupload").click(function(event){
    event.preventDefault();
    console.log("click");
    var file =$("#pyfile").get(0).files[0];
    var formData = new FormData();
    formData.append("pyfile", file);
    $.ajax({
        url: "py/pyupload.py",
        type: "POST",
        data: formData,
        processData: false,
        contentType: false,
        success: function (res) {
            console.log(res)
        }
    });
});
$("#savupload").click(function(event){
    event.preventDefault();
    console.log("click");
    var file =$("#savfile").get(0).files[0];
    var formData = new FormData();
    formData.append("savfile", file);
    $.ajax({
        url: "py/savupload.py",
        type: "POST",
        data: formData,
        processData: false,
        contentType: false,
        success: function (res) {
            console.log(res)
        }
    });
});
$("#sequpload").click(function(event){
    event.preventDefault();
    console.log("click");
    var file =$("#seqfile").get(0).files[0];
    var formData = new FormData();
    formData.append("seqfile", file);
    $.ajax({
        url: "py/sequpload.py",
        type: "POST",
        data: formData,
        processData: false,
        contentType: false,
        success: function (res) {
            console.log(res)
        }
    });
});
$("#runpsse").click(function(event){
    event.preventDefault();
    var url=window.location.toString();
    window.open(url+"psse/psse.py");
});
$("#locate").click(function(event){
    event.preventDefault();
    var v_r=parseFloat($("#busvr").val());
    var v_i=parseFloat($("#busvi").val());
    var i_r=parseFloat($("#busir").val());
    var i_i=parseFloat($("#busii").val());
    var z_r=parseFloat($("#zr").val());
    var z_i=parseFloat($("#zi").val());
    document.getElementById("result").innerHTML =v_r/(Math.sqrt(z_r*z_r+z_i*z_i))/i_r*100+"%";
});