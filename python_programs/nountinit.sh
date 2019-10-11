#!/bin/bash
sudo indiserver -vv indi_celestron_gps &
sleep 15
indi_setprop "Celestron GPS".CONNECTION.CONNECT=On