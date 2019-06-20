import requests
import json
import subprocess
import time
import threading
from subprocess import call


ip = '54.70.235.195'
url = 'http://'+ip+'/api/command/mountcamera'
data = '{}'
response = requests.get(url, data=data)


def wait(jdata):
    p_ar = str(jData['ar'])
    p_dec= str(jData['dec'])
    iso = jData['iso']
    exptime = jData['exptime']
    
    t = threading.Timer(1, wait)
    t.start()
    comando = 'indi_getprop "Celestron GPS.EQUATORIAL_EOD_COORD.RA"'


    try:
        b_ra = subprocess.check_output(comando, shell=True,stderr=subprocess.STDOUT)
        c_ra = b_ra.decode("utf-8")
        ra = round( float(c_ra.split('=',1)[1]),2)
        print(ra)
    except subprocess.CalledProcessError as e:
        raise RuntimeError("command '{}' return with error (code {}): {}".format(e.cmd, e.returncode, e.output))

    comando = 'indi_getprop "Celestron GPS.EQUATORIAL_EOD_COORD.DEC"'


    try:
        b_dec = subprocess.check_output(comando, shell=True,stderr=subprocess.STDOUT)
        c_dec = b_dec.decode("utf-8")
        dec = round( float(c_dec.split('=',1)[1]),2)
        print(dec)

    except subprocess.CalledProcessError as e:
        raise RuntimeError("command '{}' return with error (code {}): {}".format(e.cmd, e.returncode, e.output))

    if ra>=p_ar-1 and ra<=p_ar+1 and dec>=p_dec-1 and dec<=p_dec+1 : 
        t.cancel()
        time.sleep( 5 )
        comando = " --set-config eosremoterelease=2 --wait-event="+str(exptime)+"s --set-config eosremoterelease=4 --wait-event-and-download=2s"
        try:
            url = 'http://'+ip+'/api/messages/send?sender_id=1&receiver_id=2&message=Obteniendo Imagen'
            response = requests.post(url, data=data)

            print(comando)
            call(["gphoto2","--set-config","eosremoterelease=2", "--wait-event="+str(exptime)+"s","--set-config", "eosremoterelease=4","--wait-event-and-download=5s"])
        except subprocess.CalledProcessError as e:
            raise RuntimeError("command '{}' return with error (code {}): {}".format(e.cmd, e.returncode, e.output))
 

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

            