# -*- coding: utf-8 -*-
f=open('psse.raw','r')
wf=open('psse.csv','w')
lines=f.readlines()
dic={}
bus_flag=True
line_flag=False
for line in lines:
	words=line.split(',')
	if len(words)<=1:
			continue 
	if words[0]==" 0 / END OF BUS DATA":
		bus_flag=False
		continue
	if bus_flag:
		word=words[1]
		word=word[1:-1]
		word=word.strip()
		dic[words[0].strip()]=word
	if words[0]==" 0 / END OF GENERATOR DATA":
		line_flag=True
		print dic
		continue
	if words[0]==" 0 / END OF BRANCH DATA":
		line_flag=False
		continue
	if line_flag:
		wordf=words[0].strip()
		wordt=words[1].strip()
		f=dic[wordf]
		t=dic[wordt]
		r1=words[3]
		x1=words[4]
		length=words[15]
		wf.write('0,'+f+','+t+','+length+',1,'+r1+","+x1+"\n")

