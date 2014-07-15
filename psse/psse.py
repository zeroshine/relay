#!C:/Python25/python
import os,sys
sys.path.append(r"C:\Program Files (x86)\PTI\PSSE32\PSSBIN")
os.environ['PATH'] = (r"C:\Program Files (x86)\PTI\PSSE32\PSSBIN;"
                      + os.environ['PATH'])

#add the the above line 


#Here is the macro script
import psspy
import redirect
_i=psspy.getdefaultint()
_f=psspy.getdefaultreal()
_s=psspy.getdefaultchar()
redirect.psse2py()
import pssdb
psspy.psseinit(80000)
psspy.case(r"""psse.sav""")
psspy.resq(r""" psse.seq""")
psspy.lines_per_page_one_device(1,60)
psspy.report_output(2,r"""report.txt""",[0,0])
psspy.flat([1,1,1,0],[0.0,0.0])
psspy.seqd([0,0])
psspy.sequence_network_setup(0)
psspy.scmu(1,[0,0,0,0,0,0,0],[0.0,0.0,0.0,0.0,0.0],"")
psspy.scmu(2,[7,1082,0,0,0,0,0],[0.0,0.0,0.0,0.0,0.0],"")
psspy.scmu(3,[7,1082,0,0,0,0,0],[0.0,0.0,0.0,0.0,0.0],"")
psspy.sequence_network_setup(0)
#end of script

# add below line to show the report
f=open("report.txt",'r')
for line in f.readlines():
	print line
