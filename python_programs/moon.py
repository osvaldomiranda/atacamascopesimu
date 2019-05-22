import pylunar
import sys, getopt

def main(argv):
  datetime = ''
  coords = ''
  try:
    opts, args = getopt.getopt(argv,"hd:c",["datetime=","coords="])
  except getopt.GetoptError:
    print('moon.py -d <datetime at 2018/07/05t23:59:59>')
    sys.exit(2)
  for opt, arg in opts:
    if opt == '-h':
      print('moon.py  -d <datetime at 2018/07/05t23:59:59>')
      sys.exit()
    elif opt in ("-d", "--datetime"):
      datetime = arg
    elif opt in ("-c", "--coords"):
      datetime = arg




  # print(datetime)    
  year = int(datetime[:-15])
  month = int(datetime[5:-12])
  day = int(datetime[8:-9])
  hh  = int(datetime[11:-6])
  mm  = int(datetime[14:-3])
  ss  = int(datetime[17:])  

  # print(datetime[:-15] +" "+ datetime[5:-12] + " " + datetime[8:-9])

  mi=pylunar.MoonInfo((33, 00, 00), (-70, 33, 26))
  mi.update((year, month, day, hh, mm, ss))
  phase_name = mi.phase_name()
  percent = mi.fractional_phase()
  age = mi.age()

  print("Phase Name: "+str(phase_name) + " Percent:" + str(percent) +" Age:"+ str(age))

if __name__ == "__main__":
  main(sys.argv[1:])