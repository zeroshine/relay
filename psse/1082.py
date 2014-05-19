#!C:/Python25/python
import os,sys
sys.path.append(r"C:\Program Files (x86)\PTI\PSSE32\PSSBIN")
os.environ['PATH'] = (r"C:\Program Files (x86)\PTI\PSSE32\PSSBIN;"
                      + os.environ['PATH'])

import psspy
import redirect
_i=psspy.getdefaultint()
_f=psspy.getdefaultreal()
_s=psspy.getdefaultchar()
redirect.psse2py()
import pssdb
psspy.psseinit(80000)
psspy.case(r"""10207Pm-32v.sav""")
psspy.resq(r"""10207Pm.seq""")
psspy.lines_per_page_one_device(1,60)
psspy.report_output(2,r"""report.txt""",[0,0])
psspy.flat([1,1,1,0],[0.0,0.0])
psspy.seqd([0,0])
psspy.sequence_network_setup(0)
psspy.scmu(1,[0,0,0,0,0,0,0],[0.0,0.0,0.0,0.0,0.0],"")
psspy.scmu(2,[7,1082,0,0,0,0,0],[0.0,0.0,0.0,0.0,0.0],"")
psspy.scmu(3,[7,1082,0,0,0,0,0],[0.0,0.0,0.0,0.0,0.0],"")
psspy.sequence_network_setup(0)
