import datetime
import sys, getopt
import astropy.units as u
from astropy.time import Time
from astropy.coordinates import SkyCoord, EarthLocation, AltAz


def main(argv):
  command_id = ''
  try:
    opts, args = getopt.getopt(argv,"hc:",["command="])
  except getopt.GetoptError:
    print('horizon.py -c <command at format 1> ')
    sys.exit(2)
  for opt, arg in opts:
    if opt == '-h':
      print('horizon.py -c <command at format 1> ')
      sys.exit()
    elif opt in ("-c", "--command"):
      command_id = arg


    santiago = EarthLocation(lat= -22.96*u.deg, lon= 68.24*u.deg, height=300*u.m)

	#-22.96, 68.24

    utcoffset = -4*u.hour
    hoy = Time(datetime.datetime.now()) - utcoffset


    astronomical_object = SkyCoord.from_name(command_id)
    alt_az = astronomical_object.transform_to(AltAz(obstime=hoy,location=santiago))


    print(alt_az.alt)

if __name__ == "__main__":
   main(sys.argv[1:])