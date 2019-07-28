import requests
import glob
import os
import sys, getopt


def main(argv):
  command_id = ''
  try:
    opts, args = getopt.getopt(argv,"hc:",["command="])
  except getopt.GetoptError:
    print('planeta.py -c <command at format 1> ')
    sys.exit(2)
  for opt, arg in opts:
    if opt == '-h':
      print('planeta.py -c <command at format 1> ')
      sys.exit()
    elif opt in ("-c", "--command"):
      command_id = arg

  list_of_files = glob.glob('/home/felipe/*.jpg') # * means all if need specific format then *.csv
  latest_file = max(list_of_files, key=os.path.getctime)

  ip='54.70.235.195'
  url = 'http://'+ip+'/api/upload/'+command_id

  file_ = {
      'photo': ('hola.jpg', open(latest_file, 'rb'), 'image/jpeg')
  }

  r = requests.post(url, files=file_)

  print(r)

  os.rename('/home/felipe/capt0001.jpg','/home/felipe/jpgimage'+command_id+'.jpg')
  os.rename('/home/felipe/capt0000.cr2','/home/felipe/rwowimage'+command_id+'.cr2')
if __name__ == "__main__":
   main(sys.argv[1:])