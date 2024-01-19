# Work-Together Meeting Management System
 Work-Together Meeting Management System (WMMS) is a project for the final exam of Advanced 
Management of Data. This project is targeted for the online student meeting system arranged by the 
“Fachschaftsrat Informatik – FSR:IF” during the COVID-19 pandemic. In this project, A simple system 
is developed where FSR:IF and student can arrange and manage work together meetings.

## Relational Schema
Relational schema denotes to the meta-data that describes the erection of data within a convinced 
domain. A relational schema for a database is the framework of how data is prearranged. It typically 
stipulates which columns in which tables comprise orientations to data in other tables, frequently by 
comprising primary keys from other table so that rows can be easily joined.
![image](https://github.com/ArafatTheGoldenBoy/Work-Together-Meeting-Management-System/assets/8183410/dc3f7e9b-647e-4e09-979b-cfeb543a7202)
Figure-1: Relational Schema

## Uml diagram
UML stands for Unified Modeling Language which is used for specifying, visualizing, constructing, and 
documenting the artifacts of the systems. The bellow UML diagram represents the database tables 
of the system and their attributes as well as the methods.
![image](https://github.com/ArafatTheGoldenBoy/Work-Together-Meeting-Management-System/assets/8183410/7ac79d57-9280-4582-8fb8-717e16fec528)
Figure-2: UML Diagram

## Functional requirement Requirements
The system mainly has two users. Both student and admin panel have their separate tasks to handle. They perform different tasks according to their role and requirements

![1](https://github.com/ArafatTheGoldenBoy/Work-Together-Meeting-Management-System/assets/8183410/cee69bb9-b857-4ae7-926a-96754cca7cc8)

Table-1: UI – Functional requirements


## Project operations
This project is mainly consisting of two user interfaces. One for the admin FSR:IF and the other is for student. All the major operation is conducted by linking and fetching data from the database using PL/pgSQL. The FSR:IF admin can create, edit, delete meeting. Also they can see all the activities happening in the system. The students can find, select meetings to create study groups. They can also join other study groups or modify the group activities and so forth.

## Prerequisites
The zip file needs to extract at the server’s htdocs directory (for local server) or public_html directory (for remote server).


## How to Run
After starting the server (XAMPP/MAMP), we just need to hit the URL (directory of our app at the server) at the browser. In our environment the URL was like:
http://localhost:8888/WMMS	

## Distributed database with this project
This WMMS is not a big project or database to be used as a distributed database. But a bigger picture can also be seen where group of university’s working together to create a platform for students. A platform where students from different universities can come online and share their knowledge together. For a project something like that, a bigger and spread network is required where different universities will have their own shared databases to create a combination of distributed database system.

Distribution of a database can be done in some ways like,

### Data fragmentation:
It is the process of dividing a table into smaller tables. This fragmentation has to be done in a way that from the fragments, the original table can be reconstructed. The fragmentation technique,
-	Increases efficiency because irrelevant data is not available in all sites.
*	Increases efficiency because data is stored close to the site of usage.
+	Local query optimization technique is also becomes efficient.

### Data Replication:
It is the process of storing copies of database in different sites. If we store the database of our system in different sites,
-	Even if one site is down, the system will not collapse since there is another copy is existed in another site which increases reliability.
*	Query processing can be done with less bandwidth usage because of local database.
+	Local database ensures quicker response which increases speed.

## Conclusion
This project “Work-Together Meeting Management System” is a PostgreSQL based project where most of the functional logic was implemented inside a database. Working on this project was entirely a new experience for both of us. Implementing logics directly on the database and fetching them to cast on the interface was a bit challenging at start. But day by day, we learned and things got easier. Under the situations of COVID-19 pandemic, this project was cordially created to help the great cause to support the FSR:IF team to create an online environment for already a great initiative of arranging meetings for students.
Now the application will run and is ready for showing the functionalities of our Student Meeting Management System (WMMS).
