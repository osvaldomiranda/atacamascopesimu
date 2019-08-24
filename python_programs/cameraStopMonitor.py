import time
import requests
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


  for x in range(int(command_id)):
	  print(x)
    url = 'http://'+ip+'/api/messages/send?sender_id=1&receiver_id=2&message=Time: '+str(x)+'s'
    data = '{}'
    response = requests.post(url, data=data)
	  time.sleep(1)
  else:
	  print("Finally finished!")


if __name__ == "__main__":
   main(sys.argv[1:])