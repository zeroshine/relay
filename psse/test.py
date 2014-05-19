# File:"C:\Users\user\Desktop\10.py", generated on TUE, MAY 06 2014  22:15, release 32.00.02
import os,sys
sys.path.append(r"C:\Program Files (x86)\PTI\PSSE32\PSSBIN")
os.environ['PATH'] = (r"C:\Program Files (x86)\PTI\PSSE32\PSSBIN;"
                      + os.environ['PATH'])
import psspy
def silence(file_object=None):
    """
    Discard stdout (i.e. write to null device) or
    optionally write to given file-like object.
    """
    if file_object is None:
        file_object = open(os.devnull, 'w')

    old_stdout = sys.stdout
    try:
        sys.stdout = file_object
        yield
    finally:
        sys.stdout = old_stdout
with silence():
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
