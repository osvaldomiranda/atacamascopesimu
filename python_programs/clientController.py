import requests
import json
import subprocess
from subprocess import call

ip = '18.236.139.196'
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
        except subprocess.CalledProcessError as e:
            raise RuntimeError("command '{}' return with error (code {}): {}".format(e.cmd, e.returncode, e.output))

    if(jData['type']=='shoot'):
        data = '{}'
        response = requests.post(url, data=data)
        url = 'http://'+ip+'/api/messages/send?sender_id=1&receiver_id=2&message=Comando Imagen recibido'

        iso = jData['iso']
        exptime = jData['exptime']

        comando = " --set-config eosremoterelease=2 --wait-event="+str(exptime)+"s --set-config eosremoterelease=4 --wait-event-and-download=2s"
        try:
            url = 'http://'+ip+'/api/messages/send?sender_id=1&receiver_id=2&message=Obteniendo Imagen'
            response = requests.post(url, data=data)

            print(comando)
            call(["gphoto2","--set-config","eosremoterelease=2", "--wait-event="+str(exptime)+"s","--set-config", "eosremoterelease=4","--wait-event-and-download=5s"])
        except subprocess.CalledProcessError as e:
            raise RuntimeError("command '{}' return with error (code {}): {}".format(e.cmd, e.returncode, e.output))


            