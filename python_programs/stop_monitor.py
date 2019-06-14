
import subprocess
import threading
from subprocess import call


def printit():
    t = threading.Timer(1, printit)
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

    if ra>=8 : 
        t.cancel()
        print('listo')    

printit()
