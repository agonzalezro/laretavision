#!/usr/bin/python
# -*- coding: utf-8

import os
from pysqlite2 import dbapi2 as sqlite


class DataBase:
    #Change the path to your database
    db = '../lib/sqlite.db'
    instance = None
    connection = None
    cursor = None


    #Singleton class
    def __new__(cls, *args, **kargs):
        if cls.instance is None:
            cls.instance = object.__new__(cls, *args, **kargs)
        return cls.instance


    #Create the DB if it doesn't exist, if it exists, only connect to it
    def __init__(self):
        #If the file sqlite.db doesn't exist, create the BD
        if (not os.path.exists(self.db)):
            self.createDB()       
        else:
            self.connection = sqlite.connect(self.db)
            self.cursor = self.connection.cursor()


    #Insert into the BD the information about the user
    def insert(self, id, location, avatar):
        actualExist = self.cursor.execute('SELECT COUNT(id) FROM users WHERE id = "' + id + '"')
        actualExist = actualExist.fetchone()[0]
        if (actualExist == 0):
            print id + " location inserted!";
            self.cursor.execute('INSERT INTO users VALUES (\'' + id + '\', \'' + location + '\', \'' + avatar + '\')')
        else:
            print id + " location updated!";
            self.cursor.execute('UPDATE users SET location = \'' + location + '\' WHERE id = \'' + id + '\'')


    #This method is only called when the DB doesn't exist
    def createDB(self):
        self.connection = sqlite.connect(self.db)
        self.cursor = self.connection.cursor()
        self.cursor.execute('CREATE TABLE users (id VARCHAR(50) PRIMARY KEY, location VARCHAR(50), avatar VARCHAR(100))')
        self.connection.commit()


    #Make the commits, and close the connection
    def __del__(self):
        self.connection.commit()
        self.connection.close()
