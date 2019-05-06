import requests
import json
import subprocess
from subprocess import call

ip = '18.236.139.196'
url = 'http://'+ip+'/api/command/focuser'
data = '{}'
response = requests.get(url, data=data)


if(response.ok):

    jData = json.loads(response.content)

    print( jData['command'])

    if(jData['type']=='focuser'):
        steps = str(['steps'])
        direction= str(['direction'])

        url = 'http://'+ip+'/api/messages/send?sender_id=1&receiver_id=2&message=Comando Enfocador recibido'
        data = '{}'
        response = requests.post(url, data=data)

        comando = "/usr/bin/indi_setprop 'Pegasus DMFC.ABS_FOCUS_POSITION.FOCUS_ABSOLUTE_POSITION="+'1000'+"'"


        try:
            url = 'http://'+ip+'/api/messages/send?sender_id=1&receiver_id=2&message=Enfocando'
            data = '{}'
            response = requests.post(url, data=data)            
            subprocess.check_output(comando, shell=True,stderr=subprocess.STDOUT)
        except subprocess.CalledProcessError as e:
            raise RuntimeError("command '{}' return with error (code {}): {}".format(e.cmd, e.returncode, e.output))

