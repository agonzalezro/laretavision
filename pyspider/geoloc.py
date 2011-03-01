#!/usr/bin/python
# -*- coding: utf-8
#Version 0.1 by Alexandre González <alex _at_ rianxosencabos _dot_ com>
#All the bugs reserved ;)


import urllib
from BeautifulSoup import BeautifulSoup
import database

class GeoLocation:

    #Gets the profile complete URL, example: http://lareta.net/alex
    def getLocation(self, profileWeb):
        if profileWeb.split('/')[2] != 'lareta.net':
            return

        htmlCode = urllib.urlopen(profileWeb)
        soup = BeautifulSoup(htmlCode)
        location = soup.find('p', 'location')
        #If the user doesn't have a location Galicia is the default location
        if not location:
            location = u'Galicia'
            #print profileWeb.strip('\n') + ': ' + location.string
        else:
            location = location.string
        avatar = soup.find('img', 'avatar profile photo').attrs[0][1]
        id = profileWeb.split('/')[-1]
        bd = database.DataBase()
        bd.insert(id, location, avatar)


    #Get all the user from http://lareta.net/users
    #FIXME: The users showed are random users, so they aren't all the users
    def getAllUsers(self):
        htmlCode = urllib.urlopen('http://lareta.net/users')
        soup = BeautifulSoup(htmlCode)
        #Get all the <a href... elements with a <img />
        for user in soup.findAll('a'):
            if user.find('img'):
                for attr in user.attrs:
                    if attr[0] == 'href':
                        self.getLocation(attr[1])


    #Main method
    def __init__(self):
        self.getAllUsers()


GeoLocation()
