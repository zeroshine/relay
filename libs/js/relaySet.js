function LFZP_2t_p(zone1R,zone1X,zone2R,zone2X,CT,PT){
	var Z1= (zone1X^2+zone1R^2)^0.5;
	var Z2= (zone2R^2+zone2X^2)^0.5;
	var zoneOneSet=0;
	var zoneTwoSet=0;
	var oneBackUpDelay=-1;
	if(Z1>=2){
		zoneOneSet=Z1*0.75;
	}else{
		zoneOneSet=Z1*0.65;
	}

	if(Z1>=0.1){
		oneBackUpDelay=0;
	}else{
		oneBackUpDelay=9;
	}

	var zoneOneSetCP=zoneOneSet*CT/PT;

	if(Z2>=2){
		zoneTwoSet=Z1+Z2*0.5;
	}else{
		zoneTwoSet=Z1+Z2*0.6;
	}

	var zoneTwoSetCP=zoneTwoSet*CT/PT;
	return {"z1s":zoneOneSet,"z1sCP":zoneOneSetCP,"d1":oneBackUpDelay,"z2s":zoneTwoSet,"z2sCP":zoneTwoSetCP,"d2":20};
}

function LFZP_2t_g(zone1R,zone1X,zone2R,zone2X,CT,PT){
	var Z1= (zone1X^2+zone1R^2)^0.5;
	var Z2= (zone2R^2+zone2X^2)^0.5;
	var zoneOneSet=Z1*0.6;
	var zoneTwoSet=0;
	var oneBackUpDelay=-1;
	if(Z1>=0.1){
		oneBackUpDelay=0;
	}else{
		oneBackUpDelay=9;
	}
	var zoneOneSetCP=zoneOneSet*CT/PT;
	if(Z2>=2){
		zoneTwoSet=Z1+Z2*0.5;
	}else{
		zoneTwoSet=Z1+Z2*0.6;
	}
	var zoneTwoSetCP=zoneTwoSet*CT/PT;
	return {"z1s":zoneOneSet,"z1sCP":zoneOneSetCP,"d1":oneBackUpDelay,"z2s":zoneTwoSet,"z2sCP":zoneTwoSetCP,"d2":20};
}


function LFZP_3t_p(zone1R,zone1X,zone2R,zone2X,CT,PT){
	var Z1= (zone1X^2+zone1R^2)^0.5;
	var Z2= (zone2R^2+zone2X^2)^0.5;
	var zoneOneSet=0;
	var zoneTwoSet=0;
	var oneBackUpDelay=-1;
	if(Z1>=2){
		zoneOneSet=Z1*0.75;
	}else{
		zoneOneSet=Z1*0.65;
	}

	if(Z1>=0.1){
		oneBackUpDelay=0;
	}else{
		oneBackUpDelay=9;
	}

	var zoneOneSetCP=zoneOneSet*CT/PT;

	if(Z2>=2){
		zoneTwoSet=Z1+Z2*0.5;
	}else{
		zoneTwoSet=Z1+Z2*0.6;
	}

	var zoneTwoSetCP=zoneTwoSet*CT/PT;
	return {"z1s":zoneOneSet,"z1sCP":zoneOneSetCP,"d1":oneBackUpDelay,"z2s":zoneTwoSet,"z2sCP":zoneTwoSetCP,"d2":20};
}

function LFZP_2t_g(zone1R,zone1X,zone2R,zone2X,CT,PT){
	var Z1= (zone1X^2+zone1R^2)^0.5;
	var Z2= (zone2R^2+zone2X^2)^0.5;
	var zoneOneSet=Z1*0.6;
	var zoneTwoSet=0;
	var oneBackUpDelay=-1;
	if(Z1>=0.1){
		oneBackUpDelay=0;
	}else{
		oneBackUpDelay=9;
	}
	var zoneOneSetCP=zoneOneSet*CT/PT;
	if(Z2>=2){
		zoneTwoSet=Z1+Z2*0.5;
	}else{
		zoneTwoSet=Z1+Z2*0.6;
	}
	var zoneTwoSetCP=zoneTwoSet*CT/PT;
	return {"z1s":zoneOneSet,"z1sCP":zoneOneSetCP,"d1":oneBackUpDelay,"z2s":zoneTwoSet,"z2sCP":zoneTwoSetCP,"d2":20};
}

function MDAR_p(zone1R,zone1X,zone2R,zone2X,CT,PT){
	var Z1= (zone1X^2+zone1R^2)^0.5;
	var Z2= (zone2R^2+zone2X^2)^0.5;
	var zoneOneSet=0;
	var zoneTwoSet=0;
	var oneBackUpDelay=-1;
	if(Z1>=2){
		zoneOneSet=Z1*0.75;
	}else{
		zoneOneSet=Z1*0.65;
	}

	if(Z1>=0.1){
		oneBackUpDelay=0;
	}else{
		oneBackUpDelay=9;
	}

	var zoneOneSetCP=zoneOneSet*CT/PT;

	if(Z2>=2){
		zoneTwoSet=Z1+Z2*0.5;
	}else{
		zoneTwoSet=Z1+Z2*0.6;
	}

	var zoneTwoSetCP=zoneTwoSet*CT/PT;
	return {"z1s":zoneOneSet,"z1sCP":zoneOneSetCP,"d1":oneBackUpDelay,"z2s":zoneTwoSet,"z2sCP":zoneTwoSetCP,"d2":20};
}

function MDAR_g(zone1R,zone1X,zone2R,zone2X,CT,PT){
	var Z1= (zone1X^2+zone1R^2)^0.5;
	var Z2= (zone2R^2+zone2X^2)^0.5;
	var zoneOneSet=Z1*0.6;
	var zoneTwoSet=0;
	var oneBackUpDelay=-1;
	if(Z1>=0.1){
		oneBackUpDelay=0;
	}else{
		oneBackUpDelay=9;
	}
	var zoneOneSetCP=zoneOneSet*CT/PT;
	if(Z2>=2){
		zoneTwoSet=Z1+Z2*0.5;
	}else{
		zoneTwoSet=Z1+Z2*0.6;
	}
	var zoneTwoSetCP=zoneTwoSet*CT/PT;
	return {"z1s":zoneOneSet,"z1sCP":zoneOneSetCP,"d1":oneBackUpDelay,"z2s":zoneTwoSet,"z2sCP":zoneTwoSetCP,"d2":20};
}

function SEL311C_p_161(zone1R,zone1X,zone2R,zone2X,CT,PT){
	var Z1= (zone1X^2+zone1R^2)^0.5;
	var Z2= (zone2R^2+zone2X^2)^0.5;
	var zoneOneSet=0;
	var zoneTwoSet=0;
	var oneBackUpDelay=-1;
	if(Z1>=2){
		zoneOneSet=Z1*0.75;
	}else{
		zoneOneSet=Z1*0.65;
	}

	if(Z1>=0.1){
		oneBackUpDelay=0;
	}else{
		oneBackUpDelay=9;
	}

	var zoneOneSetCP=zoneOneSet*CT/PT;

	if(Z2>=2){
		zoneTwoSet=Z1+Z2*0.5;
	}else{
		zoneTwoSet=Z1+Z2*0.6;
	}

	var zoneTwoSetCP=zoneTwoSet*CT/PT;
	return {"z1s":zoneOneSet,"z1sCP":zoneOneSetCP,"d1":oneBackUpDelay,"z2s":zoneTwoSet,"z2sCP":zoneTwoSetCP,"d2":20};
}

function SEL311C_g_161(zone1R,zone1X,zone2R,zone2X,CT,PT){
	var Z1= (zone1X^2+zone1R^2)^0.5;
	var Z2= (zone2R^2+zone2X^2)^0.5;
	var zoneOneSet=Z1*0.6;
	var zoneTwoSet=0;
	var oneBackUpDelay=-1;
	if(Z1>=0.1){
		oneBackUpDelay=0;
	}else{
		oneBackUpDelay=9;
	}
	var zoneOneSetCP=zoneOneSet*CT/PT;
	if(Z2>=2){
		zoneTwoSet=Z1+Z2*0.5;
	}else{
		zoneTwoSet=Z1+Z2*0.6;
	}
	var zoneTwoSetCP=zoneTwoSet*CT/PT;
	return {"z1s":zoneOneSet,"z1sCP":zoneOneSetCP,"d1":oneBackUpDelay,"z2s":zoneTwoSet,"z2sCP":zoneTwoSetCP,"d2":20};
}

function Block_p(zone1R,zone1X,zone2R,zone2X,CT,PT){
	var Z1= (zone1X^2+zone1R^2)^0.5;
	var Z2= (zone2R^2+zone2X^2)^0.5;
	var zoneOneSet=0;
	var zoneTwoSet=0;
	var oneBackUpDelay=-1;
	if(Z1>=2){
		zoneOneSet=Z1*0.75;
	}else{
		zoneOneSet=Z1*0.65;
	}

	if(Z1>=0.1){
		oneBackUpDelay=0;
	}else{
		oneBackUpDelay=9;
	}

	var zoneOneSetCP=zoneOneSet*CT/PT;

	if(Z2>=2){
		zoneTwoSet=Z1+Z2*0.5;
	}else{
		zoneTwoSet=Z1+Z2*0.6;
	}

	var zoneTwoSetCP=zoneTwoSet*CT/PT;
	return {"z1s":zoneOneSet,"z1sCP":zoneOneSetCP,"d1":oneBackUpDelay,"z2s":zoneTwoSet,"z2sCP":zoneTwoSetCP,"d2":20};
}

function Block_g(zone1R,zone1X,zone2R,zone2X,CT,PT){
	var Z1= (zone1X^2+zone1R^2)^0.5;
	var Z2= (zone2R^2+zone2X^2)^0.5;
	var zoneOneSet=Z1*0.6;
	var zoneTwoSet=0;
	var oneBackUpDelay=-1;
	if(Z1>=0.1){
		oneBackUpDelay=0;
	}else{
		oneBackUpDelay=9;
	}
	var zoneOneSetCP=zoneOneSet*CT/PT;
	if(Z2>=2){
		zoneTwoSet=Z1+Z2*0.5;
	}else{
		zoneTwoSet=Z1+Z2*0.6;
	}
	var zoneTwoSetCP=zoneTwoSet*CT/PT;
	return {"z1s":zoneOneSet,"z1sCP":zoneOneSetCP,"d1":oneBackUpDelay,"z2s":zoneTwoSet,"z2sCP":zoneTwoSetCP,"d2":20};
}

function threeZone_p(zone1R,zone1X,zone2R,zone2X,CT,PT){
	var Z1= (zone1X^2+zone1R^2)^0.5;
	var Z2= (zone2R^2+zone2X^2)^0.5;
	var zoneOneSet=0;
	var zoneTwoSet=0;
	var oneBackUpDelay=-1;
	if(Z1>=2){
		zoneOneSet=Z1*0.75;
	}else{
		zoneOneSet=Z1*0.65;
	}

	if(Z1>=0.1){
		oneBackUpDelay=0;
	}else{
		oneBackUpDelay=9;
	}

	var zoneOneSetCP=zoneOneSet*CT/PT;

	if(Z2>=2){
		zoneTwoSet=Z1+Z2*0.5;
	}else{
		zoneTwoSet=Z1+Z2*0.6;
	}

	var zoneTwoSetCP=zoneTwoSet*CT/PT;
	return {"z1s":zoneOneSet,"z1sCP":zoneOneSetCP,"d1":oneBackUpDelay,"z2s":zoneTwoSet,"z2sCP":zoneTwoSetCP,"d2":20};
}

function threeZone_g(zone1R,zone1X,zone2R,zone2X,CT,PT){
	var Z1= (zone1X^2+zone1R^2)^0.5;
	var Z2= (zone2R^2+zone2X^2)^0.5;
	var zoneOneSet=Z1*0.6;
	var zoneTwoSet=0;
	var oneBackUpDelay=-1;
	if(Z1>=0.1){
		oneBackUpDelay=0;
	}else{
		oneBackUpDelay=9;
	}
	var zoneOneSetCP=zoneOneSet*CT/PT;
	if(Z2>=2){
		zoneTwoSet=Z1+Z2*0.5;
	}else{
		zoneTwoSet=Z1+Z2*0.6;
	}
	var zoneTwoSetCP=zoneTwoSet*CT/PT;
	return {"z1s":zoneOneSet,"z1sCP":zoneOneSetCP,"d1":oneBackUpDelay,"z2s":zoneTwoSet,"z2sCP":zoneTwoSetCP,"d2":20};
}

function oneCircuit_p(zone1R,zone1X,zone2R,zone2X,CT,PT){
	var Z1= (zone1X^2+zone1R^2)^0.5;
	var Z2= (zone2R^2+zone2X^2)^0.5;
	var zoneOneSet=0;
	var zoneTwoSet=0;
	var oneBackUpDelay=-1;
	if(Z1>=2){
		zoneOneSet=Z1*0.75;
	}else{
		zoneOneSet=Z1*0.65;
	}

	if(Z1>=0.1){
		oneBackUpDelay=0;
	}else{
		oneBackUpDelay=9;
	}

	var zoneOneSetCP=zoneOneSet*CT/PT;

	if(Z2>=2){
		zoneTwoSet=Z1+Z2*0.5;
	}else{
		zoneTwoSet=Z1+Z2*0.6;
	}

	var zoneTwoSetCP=zoneTwoSet*CT/PT;
	return {"z1s":zoneOneSet,"z1sCP":zoneOneSetCP,"d1":oneBackUpDelay,"z2s":zoneTwoSet,"z2sCP":zoneTwoSetCP,"d2":20};
}

function oneCircuit_g(zone1R,zone1X,zone2R,zone2X,CT,PT){
	var Z1= (zone1X^2+zone1R^2)^0.5;
	var Z2= (zone2R^2+zone2X^2)^0.5;
	var zoneOneSet=Z1*0.6;
	var zoneTwoSet=0;
	var oneBackUpDelay=-1;
	if(Z1>=0.1){
		oneBackUpDelay=0;
	}else{
		oneBackUpDelay=9;
	}
	var zoneOneSetCP=zoneOneSet*CT/PT;
	if(Z2>=2){
		zoneTwoSet=Z1+Z2*0.5;
	}else{
		zoneTwoSet=Z1+Z2*0.6;
	}
	var zoneTwoSetCP=zoneTwoSet*CT/PT;
	return {"z1s":zoneOneSet,"z1sCP":zoneOneSetCP,"1d":oneBackUpDelay,"z2s":zoneTwoSet,"z2sCP":zoneTwoSetCP,"2ds":20};
}

function SEL311C_p_345(zone1R,zone1X,zone2R,zone2X,CT,PT){
	var Z1= (zone1X^2+zone1R^2)^0.5;
	var Z2= (zone2R^2+zone2X^2)^0.5;
	var zoneOneSet=0;
	var zoneTwoSet=0;
	var oneBackUpDelay=-1;
	if(Z1>=5){
		zoneOneSet=Z1*0.85;
	}else{
		zoneOneSet=Z1*0.8;
	}

	var zoneOneSetCP=zoneOneSet*CT/PT;

	zoneTwoSet=Z1+Z2*0.5;

	var zoneTwoSetCP=zoneTwoSet*CT/PT;
	return {"z1s":zoneOneSet,"z1sCP":zoneOneSetCP,"d1":oneBackUpDelay,"z2s":zoneTwoSet,"z2sCP":zoneTwoSetCP,"d2":20};
}

function SEL311C_g_345(zone1R,zone1X,zone2R,zone2X,CT,PT){
	var Z1= (zone1X^2+zone1R^2)^0.5;
	var Z2= (zone2R^2+zone2X^2)^0.5;
	var zoneOneSet=0;
	var zoneTwoSet=0;
	var oneBackUpDelay=-1;
	if(Z1>=5){
		zoneOneSet=Z1*0.75;
	}else{
		zoneOneSet=Z1*0.7;
	}
	var zoneOneSetCP=zoneOneSet*CT/PT;
	zoneTwoSet=Z1+Z2*0.5;
	var zoneTwoSetCP=zoneTwoSet*CT/PT;
	return {"z1s":zoneOneSet,"z1sCP":zoneOneSetCP,"1d":oneBackUpDelay,"z2s":zoneTwoSet,"z2sCP":zoneTwoSetCP,"2ds":20};
}

function SEL321_p_345(zone1R,zone1X,zone2R,zone2X,CT,PT){
	var Z1= (zone1X^2+zone1R^2)^0.5;
	var Z2= (zone2R^2+zone2X^2)^0.5;
	var zoneOneSet=0;
	var zoneTwoSet=0;
	var oneBackUpDelay=-1;
	if(Z1>=5){
		zoneOneSet=Z1*0.85;
	}else{
		zoneOneSet=Z1*0.8;
	}

	var zoneOneSetCP=zoneOneSet*CT/PT;

	zoneTwoSet=Z1+Z2*0.5;

	var zoneTwoSetCP=zoneTwoSet*CT/PT;
	return {"z1s":zoneOneSet,"z1sCP":zoneOneSetCP,"d1":oneBackUpDelay,"z2s":zoneTwoSet,"z2sCP":zoneTwoSetCP,"d2":20};
}

function SEL321_g_345(zone1R,zone1X,zone2R,zone2X,CT,PT){
	var Z1= (zone1X^2+zone1R^2)^0.5;
	var Z2= (zone2R^2+zone2X^2)^0.5;
	var zoneOneSet=0;
	var zoneTwoSet=0;
	var oneBackUpDelay=-1;
	if(Z1>=5){
		zoneOneSet=Z1*0.75;
	}else{
		zoneOneSet=Z1*0.7;
	}
	var zoneOneSetCP=zoneOneSet*CT/PT;
	zoneTwoSet=Z1+Z2*0.5;
	var zoneTwoSetCP=zoneTwoSet*CT/PT;
	return {"z1s":zoneOneSet,"z1sCP":zoneOneSetCP,"1d":oneBackUpDelay,"z2s":zoneTwoSet,"z2sCP":zoneTwoSetCP,"2ds":20};
}

function LGRZ_p(zone1R,zone1X,zone2R,zone2X,CT,PT){
	var Z1= (zone1X^2+zone1R^2)^0.5;
	var Z2= (zone2R^2+zone2X^2)^0.5;
	var zoneOneSet=0;
	var zoneTwoSet=0;
	var oneBackUpDelay=-1;
	if(Z1>=5){
		zoneOneSet=Z1*0.85;
	}else{
		zoneOneSet=Z1*0.8;
	}

	var zoneOneSetCP=zoneOneSet*CT/PT;

	zoneTwoSet=Z1+Z2*0.5;

	var zoneTwoSetCP=zoneTwoSet*CT/PT;
	return {"z1s":zoneOneSet,"z1sCP":zoneOneSetCP,"d1":oneBackUpDelay,"z2s":zoneTwoSet,"z2sCP":zoneTwoSetCP,"d2":20};
}

function LGRZ_g(zone1R,zone1X,zone2R,zone2X,CT,PT){
	var Z1= (zone1X^2+zone1R^2)^0.5;
	var Z2= (zone2R^2+zone2X^2)^0.5;
	var zoneOneSet=0;
	var zoneTwoSet=0;
	var oneBackUpDelay=-1;
	if(Z1>=5){
		zoneOneSet=Z1*0.75;
	}else{
		zoneOneSet=Z1*0.7;
	}
	var zoneOneSetCP=zoneOneSet*CT/PT;
	zoneTwoSet=Z1+Z2*0.5;
	var zoneTwoSetCP=zoneTwoSet*CT/PT;
	return {"z1s":zoneOneSet,"z1sCP":zoneOneSetCP,"1d":oneBackUpDelay,"z2s":zoneTwoSet,"z2sCP":zoneTwoSetCP,"2ds":20};
}

