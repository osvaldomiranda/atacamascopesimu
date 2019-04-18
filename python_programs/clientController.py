import requests
import json
import subprocess
from subprocess import call

url = 'http://192.168.0.100:3000/api/v1/command/getcommand.json'
data = '{}'
response = requests.get(url, data=data)

if(response.ok):

    jData = json.loads(response.content)

    print( jData['command'])
    print( jData['command']['ar'])
    print( jData['command']['dec'])
    if(jData['command']['command']=='MOUNT'):
        ar = str(jData['command']['ar'])
        dec= str(jData['command']['dec'])

        comando = "/usr/bin/indi_setprop 'Celestron GPS.EQUATORIAL_EOD_COORD.RA;DEC="+ar+";"+dec+"'"
        try:
            subprocess.check_output(comando, shell=True,stderr=subprocess.STDOUT)
        except subprocess.CalledProcessError as e:
            raise RuntimeError("command '{}' return with error (code {}): {}".format(e.cmd, e.returncode, e.output))

    if(jData['command']['command']=='CAMERA'):
        iso = jData['command']['iso']
        exptime = jData['command']['exptime']

        comando = " --set-config eosremoterelease=2 --wait-event="+str(exptime)+"s --set-config eosremoterelease=4 --wait-event-and-download=2s"
        try:
            print(comando)
            call(["gphoto2","--set-config","eosremoterelease=2", "--wait-event="+str(exptime)+"s","--set-config", "eosremoterelease=4","--wait-event-and-download=5s"])
        except subprocess.CalledProcessError as e:
            raise RuntimeError("command '{}' return with error (code {}): {}".format(e.cmd, e.returncode, e.output))