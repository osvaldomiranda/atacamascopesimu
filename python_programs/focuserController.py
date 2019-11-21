import requests
import json
import subprocess
import os
from subprocess import call


ip = '54.70.235.195'
url = 'http://'+ip+'/api/command/focus'
data = '{}'
response = requests.get(url, data=data)
cwd = os.getcwd()

if(response.ok):

    jData = json.loads(response.content)

    print( jData)

    if(jData['type']=='focuser'):
        steps = str(jData['steps'])
        direction= str(jData['direction'])

        comando = '/usr/bin/indi_getprop "Pegasus DMFC.ABS_FOCUS_POSITION.FOCUS_ABSOLUTE_POSITION"'

        try:
            b_ra = subprocess.check_output(comando, shell=True,stderr=subprocess.STDOUT)
            c_ra = b_ra.decode("utf-8")
            ra = round( float(c_ra.split('=',1)[1]),2)
            print(ra)
        except subprocess.CalledProcessError as e:
            raise RuntimeError("command '{}' return with error (code {}): {}".format(e.cmd, e.returncode, e.output))

        s = int(steps)   
        r = int(ra) 
        if(direction=='1'):
            s = s * -1

        focus = r + s   
            

        url = 'http://'+ip+'/api/messages/send?sender_id=1&receiver_id=2&message=Comando Enfocador recibido'
        data = '{}'
        response = requests.post(url, data=data)

        comando = "/usr/bin/indi_setprop 'Pegasus DMFC.ABS_FOCUS_POSITION.FOCUS_ABSOLUTE_POSITION="+str(focus)+"'"
        print(comando)
        try:
            url = 'http://'+ip+'/api/messages/send?sender_id=1&receiver_id=2&message=Comenzando Enfoque'
            data = '{}'
            response = requests.post(url, data=data)            
            subprocess.check_output(comando, shell=True,stderr=subprocess.STDOUT)
            call(["/usr/bin/python3", cwd + "/focuserStopMonitor.py"])
        except subprocess.CalledProcessError as e:
            raise RuntimeError("command '{}' return with error (code {}): {}".format(e.cmd, e.returncode, e.output))