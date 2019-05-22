import astropy.units as u
from astropy.time import Time
from astropy.coordinates import SkyCoord, EarthLocation, AltAz

santiago = EarthLocation(lat= -33.4434*u.deg, lon= -70*u.deg, height=33*u.m)

utcoffset = -4*u.hour
hoy = Time('2019-05-15 18:32:00') - utcoffset


astronomical_object = SkyCoord.from_name('M43')
alt_az = astronomical_object.transform_to(AltAz(obstime=hoy,location=santiago))

print("*********  Coordenadas Ecuatoriales ***********")
print(astronomical_object)
print(astronomical_object.to_string('dms'))

print(astronomical_object.ra.hms)
print(astronomical_object.dec.hms)

print("********* Coordenadas AltAz ***********")
print(alt_az)
print("********************")
