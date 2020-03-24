import subprocess
import threading
import time
import requests
import os
from subprocess import call

global i
ip = '54.70.235.195'
cwd = os.getcwd()
def printit():
    t = threading.Timer(2, printit)
    t.start()

    comando = '/usr/bin/indi_getprop "Pegasus DMFC.ABS_FOCUS_POSITION.FOCUS_ABSOLUTE_POSITION"'

    try:
        b_ra = subprocess.check_output(comando, shell=True,stderr=subprocess.STDOUT)
        c_ra = b_ra.decode("utf-8")
        ra = round( float(c_ra.split('=',1)[1]),2)
        print(ra)
    except subprocess.CalledProcessError as e:
        raise RuntimeError("command '{}' return with error (code {}): {}".format(e.cmd, e.returncode, e.output))


    global ra_ant
    global data 
    if ra==ra_ant :
        t.cancel()
        print('listo')   

        url = 'http://'+ip+'/api/messages/send?sender_id=1&receiver_id=2&message=Pos.Actual :' + str(ra)
        data = '{}'
        response = requests.post(url, data=data)


        url = 'http://'+ip+'/api/messages/send?sender_id=1&receiver_id=2&message=Enfocador OK'
        data = '{}'
        response = requests.post(url, data=data)
    else :
        ra_ant  = ra
        url = 'http://'+ip+'/api/messages/send?sender_id=1&receiver_id=2&message=Pos.Actual :' + str(ra)
        data = '{}'
        response = requests.post(url, data=data)


comando = '/usr/bin/indi_getprop "Pegasus DMFC.ABS_FOCUS_POSITION.FOCUS_ABSOLUTE_POSITION"'
try:
    b_ra = subprocess.check_output(comando, shell=True,stderr=subprocess.STDOUT)
    c_ra = b_ra.decode("utf-8")
    ra_ant = round( float(c_ra.split('=',1)[1]),2)
    # print(ra_ant)
except subprocess.CalledProcessError as e:
    raise RuntimeError("command '{}' return with error (code {}): {}".format(e.cmd, e.returncode, e.output))


print("valores de RA ")
print(ra_ant)
time.sleep(3) 
printit()