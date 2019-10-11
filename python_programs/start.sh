#!/bin/bash
sudo indiserver -vv indi_dmfc_focus &
sleep 15
indi_setprop "Pegasus DMFC".SYSTEM_PORTS./dev/ttyUSB0=On
sleep 15
indi_setprop "Pegasus DMFC".CONNECTION.CONNECT=On



sudo indiserver -vv indi_celestron_gps
sleep 15
indi_setprop "Celestron GPS".CONNECTION.CONNECT=On