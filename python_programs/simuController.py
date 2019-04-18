import requests
import json
import subprocess
import time
from subprocess import call

url = 'http://192.168.0.100:3000/api/v1/command/getcommand.json'
data = '{}'
response = requests.get(url, data=data)

if(response.ok):

    jData = json.loads(response.content)

    print("llego comando" )
    print(jData['command']['command'] )

    if(jData['command']['command']=='MOUNT'):
        ar = str(jData['command']['ar'])
        dec= str(jData['command']['dec'])
        url = 'http://192.168.0.100:3000/api/v1/telescopestatus/changestatus.json?status=Comando Recibido'
        data = '{}'
        response = requests.post(url, data=data)
        time.sleep( 2 )
        url = 'http://192.168.0.100:3000/api/v1/telescopestatus/changestatus.json?status=Moviendo Montura AR=' + ar + 'Dec=' + dec
        data = '{}'
        response = requests.post(url, data=data)
        time.sleep( 5 )
        url = 'http://192.168.0.100:3000/api/v1/telescopestatus/changestatus.json?status=Montura en posicion'
        data = '{}'
        response = requests.post(url, data=data)
        time.sleep( 5 )

    if(jData['command']['command']=='CAMERA'):
        response = requests.post(url, data=data)
        url = 'http://192.168.0.100:3000/api/v1/telescopestatus/changestatus.json?status=Comando Imagen recibido'
        time.sleep( 5 )
        response = requests.post(url, data=data)
        url = 'http://192.168.0.100:3000/api/v1/telescopestatus/changestatus.json?status=Obteniendo Imagen'
        time.sleep( 5 )
        call(["/usr/bin/python","/home/deployer/atacamascope/uploadPhoto.py"])