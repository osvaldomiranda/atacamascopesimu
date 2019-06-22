
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

def main(argv):
  global p_ra
  global p_dec
  
  try:
    opts, args = getopt.getopt(argv,"hra:dec:",["ra=","dec="])
  except getopt.GetoptError:
    print('planeta.py -ra <2.343> -dec <-80.765>')
    sys.exit(2)
  for opt, arg in opts:
    if opt == '-h':
      print('planeta.py -o <object_solarsistem at format Mars> -d <datetime at 2018/07/05t23:59:59>')
      sys.exit()
    elif opt in ("-ra", "--object_solarsistem"):
      object_solarsistem = arg
    elif opt in ("-dec", "--datetime"):
      datetime = arg
  
printit()

if __name__ == "__main__":
   main(sys.argv[1:])