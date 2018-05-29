## CS6400 GTBay Project

## Getting Started
These instructions the GTBay project up and running on your local machine for development and testing purposes. 
Updated GTBay Source files to PHP version 7
![ScreenShot](https://github.gatech.edu/gt-omscs-dbscd-spring18/6400Spring18Team010/blob/master/Phase%203/img/gt_bay_php_v7.png)

## Installation
Install XAMPP: [https://www.apachefriends.org/download.html](https://www.apachefriends.org/download.html)

Put the Phase_3 folder into: Applications\XAMPP\htdocs\
![ScreenShot](https://github.gatech.edu/gt-omscs-dbscd-spring18/6400Spring18Team010/blob/master/Phase%203/img/gt_bay_xampp_v7.png)

Now login as ‘root’ to phpMyAdmin: [http://localhost/phpmyadmin/](http://localhost/phpmyadmin/)


## Configuring the application

```
define('DB_HOST', "localhost");
define('DB_PORT', "3306");
define('DB_USER', "gatechUser");
define('DB_PASS', "gatech123");
define('DB_SCHEMA', "cs6400_spr18_team010");
```

Then run the SQL script through phpMyAdmin --> Import to create the DB you need. 
![ScreenShot](https://github.gatech.edu/gt-omscs-dbscd-spring18/6400Spring18Team010/blob/master/Phase%203/img/import_sql.png)

Then restart your Apache server: (here alternative http port 8080 is used)
Now launch the URL: 
[http://localhost/phase%203/login_page.php](http://localhost/phase%203/login_page.php)
 
Lastly, login with username and password below (prefilled): 
```
username: User1
password: 123
```

If needed, read the server logs:
XAMPP Manager Tool --> Manager Server --> Configure --> Open Error Log:

![ScreenShot](https://github.gatech.edu/gt-omscs-dbscd-spring18/6400Spring18Team010/blob/master/Phase%203/img/error_log.png)

### Congratulations!
You've successfully set up the GTBay project on your local development machine!

## Authors
* Zongran Luo  email: [zluo76@gatech.edu](mailto:zluo76@gatech.edu)
* Ruochen Han  email: [rhan47@gatech.edu](mailto:rhan47@gatech.edu)
* Yijing Xiao  email: [yijingxiao@gatech.edu](mailto:yijingxiao@gatech.edu)
* Zhao Huang  email: [zhuang365@gatech.edu](mailto:zhuang365@gatech.edu)

