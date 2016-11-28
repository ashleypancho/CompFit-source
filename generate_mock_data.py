import MySQLdb
import random
import string

def randomDateAfter():
    years = [2016]
    months = [4]
    days = range(21,30)

    year = random.choice(years)
    month = 4
    day = random.choice(days)

    return str(year) + "/" + str(month) + "/" + str(day)

def randomDateBefore():
    years = [2016]
    months = [4]
    days = range(10,21)

    year = random.choice(years)
    month = 4
    day = random.choice(days)

    return str(year) + "/" + str(month) + "/" + str(day)
# numberOfCreators = int( raw_input("How many Event Creators do you want? ") )


#create people and events
creators = []

for i in range(numberOfCreators):
    person = EventCreator()
    setRandomPerson(person)
    creators.append(person)


# numberOfEvents = int( raw_input("How many Events (assigned to creators randomly) do you want? ") )


# events = []

# for i in range(numberOfEvents):
#     event = Event()
#     setRandomEvent(event)
#     events.append(event)


db = MySQLdb.connect("localhost","root","root","compfit" )


cursor = db.cursor()

for person in creators:

    sql = "INSERT INTO EventCreators(name,email,password,organization,org_url,bio) \
           VALUES ('%s', '%s', '%s', '%s', '%s', '%s' );" % \
           (person.fName + " " + person.lName, person.email, \
           person.password, person.organization, person.orgURL, person.bio)

    try:
       # Execute the SQL command
       cursor.execute(sql)
       db.commit()
    except:
        db.rollback()
        print "Error: unable to fetch data"
        print sql

for event in events:

    sql = "INSERT INTO Events(event_name,event_creator_id,host_name,date_start,date_end, \
            time_start,time_end,address,description,status,attendance,photo_url) \
           VALUES ('%s', '%d', '%s', '%s', '%s', '%s', '%s','%s','%s','%s','%d','%s');" % \
           (event.name, event.event_creator_id,event.host_name,event.date_start,event.date_end, \
           event.time_start, event.time_end, event.address, event.description,event.status,event.attendance,event.photo_url)

    try:
       # Execute the SQL command
       cursor.execute(sql)
       db.commit()
    except:
        db.rollback()
        print "Error: unable to fetch data"
        print sql





db.close()
