import requests
import json
import subprocess
import time
from subprocess import call

ip = '34.216.200.165'
# ip = 'localhost:8000'

url = 'http://'+ip+'/api/command/mountcamera'
data = '{}'
response = requests.get(url, data=data)

if(response.ok):

    jData = json.loads(response.content)

    print("llego comando" )
    print(response.content)
    print(jData)
    print(jData['command'] )

    if(jData['command']=='MONTURA'):
        ar = str(jData['ar'])
        dec= str(jData['dec'])
        url = 'http://'+ip+'/api/messages/send?sender_id=1&receiver_id=2&message=Comando Recibido'
        data = '{}'
        response = requests.post(url, data=data)
        time.sleep( 2 )
        url = 'http://'+ip+'/api/messages/send?sender_id=1&receiver_id=2&message=Moviendo Telescopio AR=' + ar + 'Dec=' + dec
        data = '{}'
        response = requests.post(url, data=data)
        time.sleep( 2 )
        url = 'http://'+ip+'/api/messages/send?sender_id=1&receiver_id=2&message=Telescopio en posicion'
        data = '{}'
        response = requests.post(url, data=data)
        time.sleep( 2 )

    if(jData['type']=='shoot'):
        response = requests.post(url, data=data)
        url = 'http://'+ip+'/api/messages/send?sender_id=1&receiver_id=2&message=Comando Imagen recibido'
        time.sleep( 2 )
        response = requests.post(url, data=data)


        url = 'http://'+ip+'/api/messages/send?sender_id=1&receiver_id=2&message=Obteniendo Imagen'
        time.sleep( 2 )
        response = requests.post(url, data=data)
        
        url = 'http://'+ip+'/api/messages/send?sender_id=1&receiver_id=2&message=Subiendo Imagen'
        time.sleep( 2 )
        response = requests.post(url, data=data)

        url = 'http://'+ip+'/api/upload/'+str(jData['id'])
        response = requests.post(url, data=data)
          
        


