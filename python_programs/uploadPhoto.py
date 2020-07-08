import glob
import os
import sys, getopt
import requests


def main(argv):
  command_id = ''
  cwd = os.getcwd()
  
  print(cwd)

  # ip='54.70.235.195'
  ip='localhost:8000'
  try:
    opts, args = getopt.getopt(argv,"hc:",["command="])
  except getopt.GetoptError:
    print('uploadPhoto.py -c <command at format 1> ')
    sys.exit(2)
  for opt, arg in opts:
    if opt == '-h':
      print('uploadPhoto.py -c <command at format 1> ')
      sys.exit()
    elif opt in ("-c", "--command"):
      command_id = arg

  

  list_of_files = glob.glob(cwd + '/*.jpg') # * means all if need specific format then *.csv
  latest_file = max(list_of_files, key=os.path.getctime)

  print(list_of_files) 
  
  url = 'http://'+ip+'/api/upload/'+command_id

  file_ = {
    'photo': ('hola.jpeg', open(latest_file, 'rb'), 'image/jpg' )
  }

  r = requests.post(url, files=file_)

  print(r)

  os.rename(cwd +'/capt0000.jpg', cwd + '/jpgimage'+command_id+'.jpeg')
  # os.rename(cwd +'/capt0000.cr2', cwd + '/rwowimage'+command_id+'.cr2')
if __name__ == "__main__":
   main(sys.argv[1:])