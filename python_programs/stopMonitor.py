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

    comando = 'indi_getprop "Celestron GPS.EQUATORIAL_EOD_COORD.RA"'
    try:
        b_ra = subprocess.check_output(comando, shell=True,stderr=subprocess.STDOUT)
        c_ra = b_ra.decode("utf-8")
        ra = round( float(c_ra.split('=',1)[1]),2)
        print(ra)
    except subprocess.CalledProcessError as e:
        raise RuntimeError("command '{}' return with error (code {}): {}".format(e.cmd, e.returncode, e.output))

    comando = 'indi_getprop "Celestron GPS.EQUATORIAL_EOD_COORD.DEC"'

    try:
        b_dec = subprocess.check_output(comando, shell=True,stderr=subprocess.STDOUT)
        c_dec = b_dec.decode("utf-8")
        dec = round( float(c_dec.split('=',1)[1]),2)
        print(dec)

    except subprocess.CalledProcessError as e:
        raise RuntimeError("command '{}' return with error (code {}): {}".format(e.cmd, e.returncode, e.output))

    global ra_ant
    global dec_ant
    if ra==ra_ant and dec==dec_ant : 
        t.cancel()
        print('listo')    
        url = 'http://'+ip+'/api/messages/send?sender_id=1&receiver_id=2&message=Montura OK '
        global data 
        data = '{}'
        response = requests.post(url, data=data)
    else :
        ra_ant  = ra
        dec_ant = dec   
        url = 'http://'+ip+'/api/messages/send?sender_id=1&receiver_id=2&message= AR:' + str(ra) + ' DEC:'+ str(dec)
        global data 
        data = '{}'
        response = requests.post(url, data=data)


comando = 'indi_getprop "Celestron GPS.EQUATORIAL_EOD_COORD.RA"'
try:
    b_ra = subprocess.check_output(comando, shell=True,stderr=subprocess.STDOUT)
    c_ra = b_ra.decode("utf-8")
    ra_ant = round( float(c_ra.split('=',1)[1]),2)
    # print(ra_ant)
except subprocess.CalledProcessError as e:
    raise RuntimeError("command '{}' return with error (code {}): {}".format(e.cmd, e.returncode, e.output))
comando = 'indi_getprop "Celestron GPS.EQUATORIAL_EOD_COORD.DEC"'
try:
    b_dec = subprocess.check_output(comando, shell=True,stderr=subprocess.STDOUT)
    c_dec = b_dec.decode("utf-8")
    dec_ant = round( float(c_dec.split('=',1)[1]),2)
    # print(dec_ant)
except subprocess.CalledProcessError as e:
    raise RuntimeError("command '{}' return with error (code {}): {}".format(e.cmd, e.returncode, e.output))

print("valores de RA - DEC")
print(ra_ant)
print(dec_ant)
time.sleep(3) 
printit()