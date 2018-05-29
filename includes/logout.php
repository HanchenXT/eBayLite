
<?php session_start();?>


<?php

        $_SESSION['username'] = null;
        $_SESSION['firstname'] = null;
        $_SESSION['lastname'] = null;
        $_SESSION['admin'] = null;
        

        session_destroy();
    header("Location: ". "../login_page.php");



//                                
//                                if(isset($_POST['username']) && isset($_POST['password'])) {
//                                    
//                                    login_user($_POST['username'], $_POST['password']);
//                                } else {
//                                    redirect('login.php');
//                                }
//                            
                            ?>