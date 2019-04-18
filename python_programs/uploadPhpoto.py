import requests
import glob
import os


list_of_files = glob.glob('/home/deployer/atacamascope/*.jpg') # * means all if need specific format then *.csv
latest_file = max(list_of_files, key=os.path.getctime)

url = 'http://10.200.113.74/api/upload'

file_ = {
    'photo': ('hola.jpg', open(latest_file, 'rb'), 'image/jpeg')
}

r = requests.post(url, files=file_)

os.remove(latest_file)