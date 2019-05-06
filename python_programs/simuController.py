import requests
import json
import subprocess
import time
from subprocess import call

ip = '18.236.139.196'
url = 'http://'+ip+'/api/command/mountcamera'
data = '{}'
response = requests.get(url, data=data)

if(response.ok):

    jData = json.loads(response.content)

    print("llego comando" )
    print(response.content)
    print(jData)
    print(jData['command'] )

    if(jData['command']=='MOUNT'):
        ar = str(jData['command']['ar'])
        dec= str(jData['command']['dec'])
        url = 'http://'+ip+'/api/messages/send?sender_id=1&receiver_id=2&message=Comando Recibido'
        data = '{}'
        response = requests.post(url, data=data)
        time.sleep( 2 )
        url = 'http://'+ip+'/api/messages/send?sender_id=1&receiver_id=2&message=Moviendo Montura AR=' + ar + 'Dec=' + dec
        data = '{}'
        response = requests.post(url, data=data)
        time.sleep( 5 )
        url = 'http://'+ip+'/api/messages/send?sender_id=1&receiver_id=2&message=Montura en posicion'
        data = '{}'
        response = requests.post(url, data=data)
        time.sleep( 5 )

    if(jData['type']=='shoot'):
        response = requests.post(url, data=data)
        url = 'http://'+ip+'/api/messages/send?sender_id=1&receiver_id=2&message=Comando Imagen recibido'
        time.sleep( 5 )
        response = requests.post(url, data=data)
        url = 'http://'+ip+'/api/messages/send?sender_id=1&receiver_id=2&message=Obteniendo Imagen'
        time.sleep( 5 )
        response = requests.post(url, data=data)
        call(["/usr/bin/python","/home/deployer/atacamascope/uploadPhoto.py", "-c", str(jData['id'])])