import requests
import json
import subprocess
from subprocess import call


def wait(jdata):
    wsteps = str(jData['steps'])

    
    t = threading.Timer(1, wait)
    t.start()
    comando = 'indi_getprop "Pegasus DMFC".ABS_FOCUS_POSITION.FOCUS_ABSOLUTE_POSITION"'


    try:
        b_step = subprocess.check_output(comando, shell=True,stderr=subprocess.STDOUT)
        c_step = b_step.decode("utf-8")
        wstep = integer(c_step.split('=',1)[1])
        print(wstep)
    except subprocess.CalledProcessError as e:
        raise RuntimeError("command '{}' return with error (code {}): {}".format(e.cmd, e.returncode, e.output))

    if wstep==wsteps : 
        t.cancel()
        url = 'http://'+ip+'/api/messages/send?sender_id=1&receiver_id=2&message=Enfoque terminado'
        response = requests.post(url, data=data)



ip = '192.168.0.102'
url = 'http://'+ip+'/api/command/focus'
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

        comando = "/usr/bin/indi_setprop 'Pegasus DMFC.ABS_FOCUS_POSITION.FOCUS_ABSOLUTE_POSITION="+steps+"'"


        try:
            url = 'http://'+ip+'/api/messages/send?sender_id=1&receiver_id=2&message=Comenzando Enfoque'
            data = '{}'
            response = requests.post(url, data=data)            
            subprocess.check_output(comando, shell=True,stderr=subprocess.STDOUT)
        except subprocess.CalledProcessError as e:
            raise RuntimeError("command '{}' return with error (code {}): {}".format(e.cmd, e.returncode, e.output))
        wait(jdata)    











import requests
import json
import subprocess
from subprocess import call

ip = '192.168.0.102'
url = 'http://'+ip+'/api/command/focus'
data = '{}'
response = requests.get(url, data=data)

print(response)


if(response.ok):

    jData = json.loads(response.content)


    if(jData['type']=='focuser'):
        steps = jData['steps']
        direction= jData['direction']

    if(direction==1):
            steps=steps+15000
        else:
            steps=steps-15000

        comando = "/usr/bin/indi_setprop 'Pegasus DMFC'.ABS_FOCUS_POSITION.FOCUS_ABSOLUTE_POSITION="+str(steps)

        try:
            subprocess.check_output(comando, shell=True,stderr=subprocess.STDOUT)
        except subprocess.CalledProcessError as e:
            raise RuntimeError("command '{}' return with error (code {}): {}".format(e.cmd, e.returncode, e.output))








