# dateTime
A simple application to calculate number of days, weekdays, weeks between two datetime parameter.


# Application functionalities 
This application could calculate - 
1. the number of days between two datetime parameters.
2. the number of weekdays between two datetime parameters.
3. the number of complete weeks between two datetime parameters.

After calculating the days, it then accept a third parameter to convert the result of (1, 2 ,3 or 4) into one of seconds, minutes, hours, years.

It has a provision to get a new Timezone parameter to compare input days in different timezones.



# Process
1. It has 2 files, index.php and action.php.
2. In index.php, it will accept two days as a string. When hit the calculate button it will then go to the different file action.php.
3. In action.php, I have a class to calculate the number of days, weekdays, weeks between two datetime parameter. And accept 3rd parameter to change the days into seconds, minutes, hours and Year(days, months and years).
4. At first it will call the function getInput (). Inside that class it will then call another function validateDate() to validate the input , if it could make a date or not.
5.It will accept the parameter as dd/mm/yyyy . If you put any non integer value it will not accept the input string as a dateTime parameter and will return an error message. 
6. If it's pass the validation then inside the validateDate() function 
            i. it sets session variable $_SESSION['fDate'] and $_SESSION['lDate'] , to check if the input string has correct string to create dateTime.
            ii. If $_SESSION['fDate'] and $_SESSION['lDate'] matches then it will call other function cal()
7. Inside cal() function now i create the 2 datetime obj. 
8. Using PHP's built in function it calculate the number of days between 2 dateTime and then calculate complete weeks.  To calculate the weekdays, call another function weekDays() 
9. Inside this cal() function, calculate the offset between two timezone. 
10. Inside this cal() function, call another function to convert the days into seconds, minutes, hours and years.
