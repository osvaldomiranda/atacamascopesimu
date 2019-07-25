import requests
import glob
import os
import sys, getopt


def main(argv):

  cwd = os.getcwd()
  command_id = ''
  ip='192.168.43.208'


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

  list_of_files = glob.glob(cwd + '/*.jpg') # * means all if need specific format then *.csv
  latest_file = max(list_of_files, key=os.path.getctime)
  
  url = 'http://'+ip+'/api/upload/'+command_id

  file_ = {
      'photo': ('hola.jpg', open(latest_file, 'rb'), 'image/jpeg')
  }

  r = requests.post(url, files=file_)

  print(r)
  os.remove(latest_file)

if __name__ == "__main__":
  main(sys.argv[1:])