import json
import subprocess
import requests
import time
import os
import threading
from subprocess import call


comando = 'indi_getprop  "Celestron GPS.CONNECTION.CONNECT"'

try:
    b_conn = subprocess.check_output(comando, shell=True,stderr=subprocess.STDOUT)
    c_conn = b_conn.decode("utf-8")
    conn = c_conn.split('=',1)[1]
    print(c_conn)
    print("***"+conn+"***")
except subprocess.CalledProcessError as e:
    raise RuntimeError("command '{}' return with error (code {}): {}".format(e.cmd, e.returncode, e.output))


if(conn.strip()=="Off"):
    comando = '/usr/bin/indi_setprop  "Celestron GPS".CONNECTION.CONNECT=On'
    print(comando)
    print("comando enviado")
    try:
        b_conn = subprocess.check_output(comando, shell=True,stderr=subprocess.STDOUT)
    except subprocess.CalledProcessError as e:
        raise RuntimeError("command '{}' return with error (code {}): {}".format(e.cmd, e.returncode, e.output))


ip = '192.168.0.102'
cwd = os.getcwd()
url = 'http://'+ip+'/api/command/mountcamera'
data = '{}'
response = requests.get(url, data=data)




if(response.ok):

    jData = json.loads(response.content)

    print( jData)

    if(jData['type']=='mount'):
        ar = str(jData['ar'])
        dec= str(jData['dec'])

        url = 'http://'+ip+'/api/messages/send?sender_id=1&receiver_id=2&message=Comando Montura recibido'
        data = '{}'
        response = requests.post(url, data=data)

        comando = "/usr/bin/indi_setprop 'Celestron GPS.EQUATORIAL_EOD_COORD.RA;DEC="+ar+";"+dec+"'"
        try:
            url = 'http://'+ip+'/api/messages/send?sender_id=1&receiver_id=2&message=Posicionando Montura'
            data = '{}'
            response = requests.post(url, data=data)            
            subprocess.check_output(comando, shell=True,stderr=subprocess.STDOUT)
            wait()
        except subprocess.CalledProcessError as e:
            raise RuntimeError("command '{}' return with error (code {}): {}".format(e.cmd, e.returncode, e.output))

    if(jData['type']=='shoot'):
        data = '{}'
        response = requests.post(url, data=data)
        url = 'http://'+ip+'/api/messages/send?sender_id=1&receiver_id=2&message=Comando Imagen recibido'

        iso = jData['iso']
        exptime = jData['exptime']

        comando = " --set-config eosremoterelease=2 --wait-event="+str(exptime)+"s --set-config eosremoterelease=4 --wait-event-and-download=7s"
        try:
            url = 'http://'+ip+'/api/messages/send?sender_id=1&receiver_id=2&message=Obteniendo Imagen'
            response = requests.post(url, data=data)

            print(comando)
            call(["gphoto2","--set-config","eosremoterelease=2", "--wait-event="+str(exptime)+"s","--set-config", "eosremoterelease=4","--wait-event-and-download=5s"])
        except subprocess.CalledProcessError as e:
            raise RuntimeError("command '{}' return with error (code {}): {}".format(e.cmd, e.returncode, e.output))

        url = 'http://'+ip+'/api/messages/send?sender_id=1&receiver_id=2&message=Subiendo Imagen'
        time.sleep( 5 )
        response = requests.post(url, data=data)
        call(["/usr/bin/python", cwd + "/uploadPhoto.py", "-c", str(jData['id'])])


    if(jData['type']=='pointandshoot'): 
        ar = str(jData['ar'])
        dec= str(jData['dec'])
        iso = jData['iso']
        exptime = jData['exptime']

        url = 'http://'+ip+'/api/messages/send?sender_id=1&receiver_id=2&message=Comando Montura recibido'
        data = '{}'
        response = requests.post(url, data=data)

        comando = "/usr/bin/indi_setprop 'Celestron GPS.EQUATORIAL_EOD_COORD.RA;DEC="+ar+";"+dec+"'"
        try:
            url = 'http://'+ip+'/api/messages/send?sender_id=1&receiver_id=2&message=Posicionando Montura'
            data = '{}'
            response = requests.post(url, data=data)            
            subprocess.check_output(comando, shell=True,stderr=subprocess.STDOUT)
            wait(jData)
        except subprocess.CalledProcessError as e:
            raise RuntimeError("command '{}' return with error (code {}): {}".format(e.cmd, e.returncode, e.output))       

     
