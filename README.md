# Octagon Vue and Slim System

# USER MANUAL – HOW TO LOG IN THE SYSTEM

This manual explains how to log in/out of the system. This manual is described for the external test users corresponding to the functions as of 11/07/2022.

The functions of the system will be modified and updated after the external test. \* The figures of displays in this document were captured from the system under development.

## How to log in the System

The default page is the login page. If you have an account with the system already created, please put in your phone(registered) and the correct password.

### Steps

1. After your account is registered, you can log in the system as follows.
2. Load the default system URL (localhost:3000)
3. Please input your accountphone and password to log in.
4. You can log in and use this system. You will be directed to the profile page. You can see your first name, last name and phone.

## How to register to the System

### User registration

The user registration mechanism provides a form that allows new users to register themselves on the system. It can be reached by clicking the &quot;Sign in&quot; link if you do not have an account on the login page. In order to register, the user must fill out the fields which are marked required and click the &quot;OK&quot; button. The following (Fig4) shows a filled-out version of the registration form.

**First name field**

This is where the user must enter his/her first name (for example &quot;Atwine&quot;).

**Last name field**

This is where the user must enter his/her last name (for example &quot;Nickson&quot;).

**Phone**

This number reveals the phone number of the user account that will be created.

**Password field**

This is where the user must enter a desired password (for example &quot;T-1000&quot;). The password must be at least three characters long. This field is case sensitive, in other words &quot;t-1000&quot; is not the same as &quot;T-1000&quot;.

Submit button

This button allows the user to submit the registration form. Once the button is clicked, the system will attempt to register the user.

**Successful registration**

If all fields have been filled out correctly, the &quot;Sign Up&quot; button is clicked and the system is able to register the new user account, the user will be redirected to the login page to enter the right details.

# HOW TO RUN THE SYSTEM

## FRONTEND

Run command npm install

Then run command npm run dev

## BACKEND

cd slimbackend

Run command compose update

cd src

cd public

Run command php -s localhost 8080
